<?php

declare(strict_types=1);

namespace ElementO\Domain\Attack;

use ElementO\Domain\Category\AttackCategory;
use ElementO\Domain\Category\DetectionDifficulty;
use ElementO\Domain\Category\DifficultyLevel;
use ElementO\Domain\Category\ImpactType;
use ElementO\Domain\Category\KillChainPhase;
use ElementO\Domain\Category\PrivilegeLevel;
use ElementO\Domain\RealWorldCase\BrandImpersonation;
use ElementO\Domain\RealWorldCase\CaseStudy;
use InvalidArgumentException;

final class AttackAggregate
{

    // Properties

    public readonly AttackId            $id;
    public readonly string              $name;
    public readonly MitreId             $mitreId;
    public readonly AttackCategory      $category;
    public readonly DifficultyLevel     $difficulty;
    public readonly string              $attackVector;
    public readonly string              $targetProfile;
    public readonly SuccessRate         $successRate;
    public readonly string              $averageImpact;
    public readonly string              $deliveryMethod;
    public readonly DetectionDifficulty $detectionDifficulty;

    /** @var list<string> */
    public readonly array               $preventionMeasures;

    public readonly ?CaseStudy          $realWorldCase;
    public readonly ?BrandImpersonation $brandImpersonation;
    public readonly ?CapecId            $capecId;
    public readonly ?KillChainPhase     $killChainPhase;
    public readonly ?ImpactType         $impactType;
    public readonly ?PrivilegeLevel     $privilegeRequired;
    public readonly ?string             $attribution;
    public readonly ?string             $notes;

    /** @var list<string>  */
    public readonly array               $cveReferences;

    /** @var list<string>  */
    public readonly array               $toolsUsed;

    /** @var list<string>  */
    public readonly array               $mitigations;

    /** @var list<string>  */
    public readonly array               $platforms;

    /** @var list<string>  */
    public readonly array               $dataSources;


    // Constructor 


    private function __construct(
        AttackId            $id,
        string              $name,
        MitreId             $mitreId,
        AttackCategory      $category,
        DifficultyLevel     $difficulty,
        string              $attackVector,
        string              $targetProfile,
        SuccessRate         $successRate,
        string              $averageImpact,
        string              $deliveryMethod,
        DetectionDifficulty $detectionDifficulty,
        array               $preventionMeasures,
        ?CaseStudy          $realWorldCase      = null,
        ?BrandImpersonation $brandImpersonation = null,
        ?CapecId            $capecId            = null,
        ?KillChainPhase     $killChainPhase     = null,
        ?ImpactType         $impactType         = null,
        ?PrivilegeLevel     $privilegeRequired  = null,
        ?string             $attribution        = null,
        ?string             $notes              = null,
        array               $cveReferences      = [],
        array               $toolsUsed          = [],
        array               $mitigations        = [],
        array               $platforms          = [],
        array               $dataSources        = [],
    ) {
       
        $this->assertNotBlank($name,           'name');
        $this->assertNotBlank($attackVector,   'attack_vector');
        $this->assertNotBlank($targetProfile,  'target_profile');
        $this->assertNotBlank($averageImpact,  'average_impact');
        $this->assertNotBlank($deliveryMethod, 'delivery_method');

        
        if (empty($preventionMeasures)) {
            throw new InvalidArgumentException(
                'AttackAggregate requires at least one prevention measure.'
            );
        }

        
        if ($brandImpersonation !== null && $category !== AttackCategory::SocialEngineering) {
            throw new InvalidArgumentException(
                sprintf(
                    'brand_impersonation is only valid for the SocialEngineering category; got "%s".',
                    $category->name
                )
            );
        }

        
        if ($difficulty === DifficultyLevel::NationState && empty(trim((string) $attribution))) {
            throw new InvalidArgumentException(
                'Attacks with NationState difficulty must include a non-empty attribution.'
            );
        }

        $this->id                  = $id;
        $this->name                = $name;
        $this->mitreId             = $mitreId;
        $this->category            = $category;
        $this->difficulty          = $difficulty;
        $this->attackVector        = $attackVector;
        $this->targetProfile       = $targetProfile;
        $this->successRate         = $successRate;
        $this->averageImpact       = $averageImpact;
        $this->deliveryMethod      = $deliveryMethod;
        $this->detectionDifficulty = $detectionDifficulty;
        $this->preventionMeasures  = array_values($preventionMeasures);
        $this->realWorldCase       = $realWorldCase;
        $this->brandImpersonation  = $brandImpersonation;
        $this->capecId             = $capecId;
        $this->killChainPhase      = $killChainPhase;
        $this->impactType          = $impactType;
        $this->privilegeRequired   = $privilegeRequired;
        $this->attribution         = $attribution;
        $this->notes               = $notes;
        $this->cveReferences       = array_values($cveReferences);
        $this->toolsUsed           = array_values($toolsUsed);
        $this->mitigations         = array_values($mitigations);
        $this->platforms           = array_values($platforms);
        $this->dataSources         = array_values($dataSources);
    }
   
    // Named constructors
    
    public static function create(
        string              $name,
        MitreId             $mitreId,
        AttackCategory      $category,
        DifficultyLevel     $difficulty,
        string              $attackVector,
        string              $targetProfile,
        SuccessRate         $successRate,
        string              $averageImpact,
        string              $deliveryMethod,
        DetectionDifficulty $detectionDifficulty,
        array               $preventionMeasures,
        ?CaseStudy          $realWorldCase      = null,
        ?BrandImpersonation $brandImpersonation = null,
        ?CapecId            $capecId            = null,
        ?KillChainPhase     $killChainPhase     = null,
        ?ImpactType         $impactType         = null,
        ?PrivilegeLevel     $privilegeRequired  = null,
        ?string             $attribution        = null,
        ?string             $notes              = null,
        array               $cveReferences      = [],
        array               $toolsUsed          = [],
        array               $mitigations        = [],
        array               $platforms          = [],
        array               $dataSources        = [],
    ): self {
        return new self(
            id:                  AttackId::generate(),
            name:                $name,
            mitreId:             $mitreId,
            category:            $category,
            difficulty:          $difficulty,
            attackVector:        $attackVector,
            targetProfile:       $targetProfile,
            successRate:         $successRate,
            averageImpact:       $averageImpact,
            deliveryMethod:      $deliveryMethod,
            detectionDifficulty: $detectionDifficulty,
            preventionMeasures:  $preventionMeasures,
            realWorldCase:       $realWorldCase,
            brandImpersonation:  $brandImpersonation,
            capecId:             $capecId,
            killChainPhase:      $killChainPhase,
            impactType:          $impactType,
            privilegeRequired:   $privilegeRequired,
            attribution:         $attribution,
            notes:               $notes,
            cveReferences:       $cveReferences,
            toolsUsed:           $toolsUsed,
            mitigations:         $mitigations,
            platforms:           $platforms,
            dataSources:         $dataSources,
        );
    }

    public static function reconstruct(
        AttackId            $id,
        string              $name,
        MitreId             $mitreId,
        AttackCategory      $category,
        DifficultyLevel     $difficulty,
        string              $attackVector,
        string              $targetProfile,
        SuccessRate         $successRate,
        string              $averageImpact,
        string              $deliveryMethod,
        DetectionDifficulty $detectionDifficulty,
        array               $preventionMeasures,
        ?CaseStudy          $realWorldCase      = null,
        ?BrandImpersonation $brandImpersonation = null,
        ?CapecId            $capecId            = null,
        ?KillChainPhase     $killChainPhase     = null,
        ?ImpactType         $impactType         = null,
        ?PrivilegeLevel     $privilegeRequired  = null,
        ?string             $attribution        = null,
        ?string             $notes              = null,
        array               $cveReferences      = [],
        array               $toolsUsed          = [],
        array               $mitigations        = [],
        array               $platforms          = [],
        array               $dataSources        = [],
    ): self {
        return new self(
            id:                  $id,
            name:                $name,
            mitreId:             $mitreId,
            category:            $category,
            difficulty:          $difficulty,
            attackVector:        $attackVector,
            targetProfile:       $targetProfile,
            successRate:         $successRate,
            averageImpact:       $averageImpact,
            deliveryMethod:      $deliveryMethod,
            detectionDifficulty: $detectionDifficulty,
            preventionMeasures:  $preventionMeasures,
            realWorldCase:       $realWorldCase,
            brandImpersonation:  $brandImpersonation,
            capecId:             $capecId,
            killChainPhase:      $killChainPhase,
            impactType:          $impactType,
            privilegeRequired:   $privilegeRequired,
            attribution:         $attribution,
            notes:               $notes,
            cveReferences:       $cveReferences,
            toolsUsed:           $toolsUsed,
            mitigations:         $mitigations,
            platforms:           $platforms,
            dataSources:         $dataSources,
        );
    }

    
    // Serialisation


    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id'                   => $this->id->value,
            'slug'                 => $this->slug(),
            'name'                 => $this->name,
            'mitre_id'             => $this->mitreId->value,
            'category'             => $this->category->name,
            'difficulty'           => $this->difficulty->name,
            'attack_vector'        => $this->attackVector,
            'target_profile'       => $this->targetProfile,
            'success_rate'         => $this->successRate->formatted(),
            'average_impact'       => $this->averageImpact,
            'delivery_method'      => $this->deliveryMethod,
            'detection_difficulty' => $this->detectionDifficulty->name,
            'prevention_measures'  => $this->preventionMeasures,
            'real_world_case'      => $this->realWorldCase?->toArray(),
            'brand_impersonation'  => $this->brandImpersonation?->toArray(),
            'capec_id'             => $this->capecId?->value,
            'kill_chain_phase'     => $this->killChainPhase?->name,
            'impact_type'          => $this->impactType?->name,
            'privilege_required'   => $this->privilegeRequired?->name,
            'attribution'          => $this->attribution,
            'notes'                => $this->notes,
            'cve_references'       => $this->cveReferences,
            'tools_used'           => $this->toolsUsed,
            'mitigations'          => $this->mitigations,
            'platforms'            => $this->platforms,
            'data_sources'         => $this->dataSources,
            'risk_score'           => $this->riskScore(),
        ];
    }

   
    // Domain queries


    public function hasRealWorldCase(): bool
    {
        return $this->realWorldCase !== null;
    }

    public function isBrandImpersonation(): bool
    {
        return $this->brandImpersonation !== null;
    }

    public function hasAttribution(): bool
    {
        return $this->attribution !== null && trim($this->attribution) !== '';
    }

    public function targetsPlatform(string $platform): bool
    {
        return in_array($platform, $this->platforms, strict: true);
    }

    public function hasCveReferences(): bool
    {
        return count($this->cveReferences) > 0;
    }

    public function riskScore(): int
    {
        $successScore   = $this->successRate->average();                    
        $detectionScore = $this->detectionDifficulty->score() * 20;       
        $difficultyScore = (7 - $this->difficulty->score()) * 10;         

        return (int) round(
            ($successScore   * 0.50)
            + ($detectionScore  * 0.30)
            + ($difficultyScore * 0.20)
        );
    }

    public function slug(): string
    {
        return strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($this->name)) ?? '');
    }

    public function equals(self $other): bool
    {
        return $this->id->equals($other->id);
    }

    // Guards


    private function assertNotBlank(string $value, string $field): void
    {
        if (trim($value) === '') {
            throw new InvalidArgumentException(
                sprintf('AttackAggregate field "%s" must not be blank.', $field)
            );
        }
    }
}
