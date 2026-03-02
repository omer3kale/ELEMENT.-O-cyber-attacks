<?php

declare(strict_types=1);

namespace ElementO\SecurityTasks\Application;

use DateTimeImmutable;
use ElementO\Domain\Attack\AttackAggregate;
use ElementO\Domain\Attack\AttackRepository;
use ElementO\Domain\Category\AttackCategory;
use ElementO\ProcessableItems\Application\ProcessableItemsService;
use ElementO\ProcessableItems\Domain\DistributionStrategy;
use ElementO\ProcessableItems\Domain\ProcessableItem;
use ElementO\ProcessableItems\Domain\User;
use ElementO\ProcessableItems\Infrastructure\Database\UserRepository;
use ElementO\SecurityTasks\Domain\BrandAwareTaskTemplates;

/**
 * Bridges the cyber-attack catalog with the processable-items scheduler.
 *
 * For each attack in the catalog it derives one or more security task
 * templates (strings).  Those templates are then scheduled as
 * ProcessableItems for the supplied users via ProcessableItemsService,
 * respecting office hours, German holidays, and per-user minimum spacing.
 *
 * Design decision: task names are assigned to users in round-robin order
 * so every user receives a representative spread of the catalog.
 *
 * Brand awareness:
 *   Pass a `BrandAwareTaskTemplates` instance to the constructor to:
 *     1. Use fully custom per-attack task names for the named brand.
 *     2. Automatically prepend "[{BrandName}]" to all generic task names
 *        that do not have an explicit override, e.g.:
 *        "[ACME Bank] [SOCIAL-ENG] Run phishing simulation for …"
 */
final class SecurityTaskGenerator
{
    public function __construct(
        private readonly AttackRepository        $attackRepository,
        private readonly ProcessableItemsService $itemsService,
        private readonly ?BrandAwareTaskTemplates $brandTemplates = null,
    ) {}

    /**
     * Generate and schedule security tasks derived from all catalog attacks.
     *
     * @param  User[]              $users
     * @param  int                 $tasksPerUser
     * @return ProcessableItem[]
     */
    public function generateAndSchedule(
        array                $users,
        int                  $tasksPerUser,
        DateTimeImmutable    $start,
        DateTimeImmutable    $end,
        int                  $minDistanceMinutes,
        DistributionStrategy $strategy,
    ): array {
        if (empty($users) || $tasksPerUser <= 0) {
            return [];
        }

        $attacks   = $this->attackRepository->findAll();
        $templates = $this->buildTemplates($attacks);

        if (empty($templates)) {
            return [];
        }

        // Assign task names to each user in round-robin so every user
        // gets a varied sample from across the full threat catalog.
        $allItems = [];

        foreach ($users as $user) {
            $names = $this->roundRobinPick($templates, $tasksPerUser, $user->id());

            // Temporarily wrap names in the item names by overriding the
            // service's default pattern through a per-user single-user call.
            $items = $this->itemsService->scheduleItems(
                users:              [$user],
                amountPerUser:      $tasksPerUser,
                start:              $start,
                end:                $end,
                minDistanceMinutes: $minDistanceMinutes,
                strategy:           $strategy,
            );

            // Re-label the items with the task-derived names (same count order).
            foreach ($items as $i => $item) {
                $label       = $names[$i] ?? $item->name();
                $allItems[]  = new ProcessableItem(
                    id:            $item->id(),
                    name:          $label,
                    userId:        $item->userId(),
                    scheduledAt:   $item->scheduledAt(),
                    processedAt:   $item->processedAt(),
                    status:        $item->status(),
                    statusMessage: $item->statusMessage(),
                );
            }
        }

        return $allItems;
    }

    // -------------------------------------------------------------------------
    // Public – exposed so it can be tested without touching the service
    // -------------------------------------------------------------------------

    /**
     * Map a single attack to a list of human-readable security task names.
     * Every task name is prefixed with a category tag, e.g. [SOCIAL-ENG],
     * so operators can filter or triage tasks by threat domain at a glance.
     *
     * When a `BrandAwareTaskTemplates` instance is configured:
     *   - If the brand defines an explicit override for this attack name,
     *     those strings are returned verbatim.
     *   - Otherwise, the generic task names are generated and each receives
     *     the brand name as a leading secondary tag, e.g.:
     *     "[ACME Bank] [SOCIAL-ENG] Run phishing simulation for …"
     *
     * @param  AttackAggregate $attack
     * @return string[]
     */
    public function taskNamesForAttack(AttackAggregate $attack): array
    {
        // --- Brand-aware: explicit override takes full precedence ---
        if ($this->brandTemplates !== null) {
            $override = $this->brandTemplates->overridesFor($attack->name);
            if ($override !== null) {
                return $override;
            }
        }

        $tag = $this->categoryTag($attack);
        $n   = $attack->name;

        // --- Brand name prefix (no override, but brand context is set) ---
        $brandPrefix = $this->brandTemplates !== null
            ? '[' . $this->brandTemplates->brandName() . '] '
            : '';

        // --- Social engineering ---
        if ($attack->category === AttackCategory::SocialEngineering
            || str_contains($n, 'Phishing')
            || str_contains($n, 'Deepfake')
            || str_contains($n, 'Vishing')
        ) {
            return [
                "{$brandPrefix}{$tag} Run phishing simulation for {$n}",
                "{$brandPrefix}{$tag} Review security-awareness training content for {$n}",
            ];
        }

        // --- API / BOLA / IDOR ---
        if (str_contains($n, 'ApiBola') || str_contains($n, 'Idor')) {
            return [
                "{$brandPrefix}{$tag} Review API for BOLA/IDOR exposures ({$n})",
                "{$brandPrefix}{$tag} Validate object-level authorization on all REST endpoints ({$n})",
            ];
        }

        // --- SQL injection ---
        if (str_contains($n, 'SqlInjection')) {
            return [
                "{$brandPrefix}{$tag} Run SQL injection tests against critical endpoints ({$n})",
                "{$brandPrefix}{$tag} Verify parameterised queries and ORM usage for {$n}",
            ];
        }

        // --- Cloud misconfiguration ---
        if (str_contains($n, 'CloudMisconfiguration') || str_contains($n, 'Cloud')) {
            return [
                "{$brandPrefix}{$tag} Audit cloud storage and IAM roles for misconfigurations ({$n})",
                "{$brandPrefix}{$tag} Review public bucket ACLs and signed-URL policies for {$n}",
            ];
        }

        // --- MitM / network sniffing ---
        if (str_contains($n, 'Mitm') || str_contains($n, 'Network')) {
            return [
                "{$brandPrefix}{$tag} Review network encryption and HSTS against MitM ({$n})",
                "{$brandPrefix}{$tag} Verify TLS certificate pinning and CSP headers for {$n}",
            ];
        }

        // --- Ransomware ---
        if (str_contains($n, 'Ransomware') || str_contains($n, 'DataExtortion')) {
            return [
                "{$brandPrefix}{$tag} Test backup and restore procedures against {$n}",
                "{$brandPrefix}{$tag} Verify EDR alerting thresholds for encryption spikes ({$n})",
            ];
        }

        // --- Supply chain / APT ---
        if ($attack->category === AttackCategory::SupplyChain
            || str_contains($n, 'Solarwinds')
            || str_contains($n, 'Kaseya')
            || str_contains($n, 'SupplyChain')
        ) {
            return [
                "{$brandPrefix}{$tag} Review third-party dependency trust for {$n}",
                "{$brandPrefix}{$tag} Verify software bill-of-materials (SBOM) and signing policy ({$n})",
            ];
        }

        // --- Credential stuffing / infostealer ---
        if (str_contains($n, 'CredentialStuffing')
            || str_contains($n, 'Infostealer')
            || str_contains($n, 'PasswordStealer')
        ) {
            return [
                "{$brandPrefix}{$tag} Review MFA enforcement and breach-credential monitoring ({$n})",
                "{$brandPrefix}{$tag} Validate rate-limiting and account-lockout controls for {$n}",
            ];
        }

        // --- Malware / exploitation (catch-all for Malware category) ---
        if ($attack->category === AttackCategory::Malware) {
            return [
                "{$brandPrefix}{$tag} Verify EDR coverage and patch status against {$n}",
                "{$brandPrefix}{$tag} Review privilege separation controls for {$n}",
            ];
        }

        // --- IoT ---
        if ($attack->category === AttackCategory::Iot) {
            return [
                "{$brandPrefix}{$tag} Audit IoT device firmware versions and network segmentation ({$n})",
            ];
        }

        // --- Mobile ---
        if ($attack->category === AttackCategory::Mobile) {
            return [
                "{$brandPrefix}{$tag} Review mobile app code signing and certificate validation ({$n})",
            ];
        }

        // --- AI/ML ---
        if ($attack->category === AttackCategory::AiMl
            || str_contains($n, 'PromptInjection')
        ) {
            return [
                "{$brandPrefix}{$tag} Review LLM input sanitisation and system-prompt isolation ({$n})",
                "{$brandPrefix}{$tag} Test agent tool permissions and output filtering for {$n}",
            ];
        }

        // --- Insider threat ---
        if (str_contains($n, 'Insider')) {
            return [
                "{$brandPrefix}{$tag} Review privileged-access monitoring and DLP controls ({$n})",
            ];
        }

        // Default
        return ["{$brandPrefix}{$tag} Review security controls for {$n}"];
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Returns a short uppercase tag for the attack's threat category,
     * e.g. "[SOCIAL-ENG]", "[MALWARE]", "[CLOUD]".
     * Displayed as a prefix on every task name so operators can quickly
     * filter or sort tasks by threat domain.
     */
    private function categoryTag(AttackAggregate $attack): string
    {
        return '[' . match ($attack->category) {
            AttackCategory::SocialEngineering => 'SOCIAL-ENG',
            AttackCategory::Malware           => 'MALWARE',
            AttackCategory::Network           => 'NETWORK',
            AttackCategory::Application       => 'APP',
            AttackCategory::Cloud             => 'CLOUD',
            AttackCategory::Iot               => 'IOT',
            AttackCategory::Mobile            => 'MOBILE',
            AttackCategory::SupplyChain       => 'SUPPLY-CHAIN',
            AttackCategory::Physical          => 'PHYSICAL',
            AttackCategory::Cryptographic     => 'CRYPTO',
            AttackCategory::AiMl              => 'AI-ML',
            AttackCategory::Quantum           => 'QUANTUM',
        } . ']';
    }

    /**
     * Build a flat list of unique task templates from all attacks.
     * Duplicates are removed (same string from different attacks).
     *
     * @param  AttackAggregate[] $attacks
     * @return string[]
     */
    private function buildTemplates(array $attacks): array
    {
        $seen      = [];
        $templates = [];
        foreach ($attacks as $attack) {
            foreach ($this->taskNamesForAttack($attack) as $name) {
                if (!isset($seen[$name])) {
                    $seen[$name]   = true;
                    $templates[]   = $name;
                }
            }
        }
        return $templates;
    }

    /**
     * Picks $count templates for a given user, starting at an offset derived
     * from the user id so different users get different leading tasks.
     *
     * @param  string[] $templates
     * @return string[]
     */
    private function roundRobinPick(array $templates, int $count, int $userId): array
    {
        $total  = count($templates);
        $offset = ($userId - 1) % $total;
        $result = [];

        for ($i = 0; $i < $count; $i++) {
            $result[] = $templates[($offset + $i) % $total];
        }

        return $result;
    }
}
