<?php

declare(strict_types=1);

namespace ElementO\Infrastructure\Parser;

use ElementO\Domain\Attack\AttackAggregate;
use ElementO\Domain\Attack\CapecId;
use ElementO\Domain\Attack\MitreId;
use ElementO\Domain\Attack\SuccessRate;
use ElementO\Domain\Category\AttackCategory;
use ElementO\Domain\Category\DetectionDifficulty;
use ElementO\Domain\Category\DifficultyLevel;
use ElementO\Domain\Category\ImpactType;
use ElementO\Domain\Category\KillChainPhase;
use ElementO\Domain\Category\PrivilegeLevel;
use ElementO\Domain\RealWorldCase\BrandImpersonation;
use ElementO\Domain\RealWorldCase\CaseStudy;


final class AttackDslVisitor extends \AttackDSLBaseVisitor
{
    // Collection


    /**
     * @return list<AttackAggregate>
     */
    public function visitAttackCollection(\Context\AttackCollectionContext $context): mixed
    {
        $attacks = [];

        foreach ($context->attackDefinition() as $definition) {
            $attacks[] = $this->visit($definition);
        }

        return $attacks;
    }


    // Attack definition


    public function visitAttackDefinition(\Context\AttackDefinitionContext $context): mixed
    {
        
        $props = [];

        foreach ($context->attackProperty() as $property) {
            $result = $this->visit($property);

            if (is_array($result)) {
                $props = array_merge($props, $result);
            }
        }

       
        $realWorldCase = null;

        if ($context->realWorldCase() !== null) {
            $realWorldCase = $this->visit($context->realWorldCase());
        }

        return AttackAggregate::create(
            name:                $context->IDENTIFIER()->getText(),
            mitreId:             $this->visit($context->mitreId()),
            category:            $this->visit($context->category()),
            difficulty:          $this->visit($context->difficulty()),
            attackVector:        $props['attack_vector']        ?? '',
            targetProfile:       $props['target_profile']       ?? '',
            successRate:         $props['success_rate']         ?? SuccessRate::fromRange(0, 0),
            averageImpact:       $props['average_impact']       ?? '',
            deliveryMethod:      $props['delivery_method']      ?? '',
            detectionDifficulty: $props['detection_difficulty'] ?? DetectionDifficulty::Low,
            preventionMeasures:  $props['prevention_measures']  ?? [],
            realWorldCase:       $realWorldCase,
            brandImpersonation:  $props['brand_impersonation']  ?? null,
            capecId:             $props['capec_id']             ?? null,
            killChainPhase:      $props['kill_chain_phase']     ?? null,
            impactType:          $props['impact_type']          ?? null,
            privilegeRequired:   $props['privilege_required']   ?? null,
            attribution:         $props['attribution']          ?? null,
            notes:               $props['notes']                ?? null,
            cveReferences:       $props['cve_references']       ?? [],
            toolsUsed:           $props['tools_used']           ?? [],
            mitigations:         $props['mitigations']          ?? [],
            platforms:           $props['platforms']            ?? [],
            dataSources:         $props['data_sources']         ?? [],
        );
    }

    // Required top-level sub-rules


    public function visitMitreId(\Context\MitreIdContext $context): mixed
    {
        return MitreId::fromString($this->unquoteString($context->STRING()->getText()));
    }

    public function visitCategory(\Context\CategoryContext $context): mixed
    {
        return $this->visit($context->categoryValue());
    }

    public function visitCategoryValue(\Context\CategoryValueContext $context): mixed
    {
        return AttackCategory::fromDsl($context->getText());
    }

    public function visitDifficulty(\Context\DifficultyContext $context): mixed
    {
        return $this->visit($context->difficultyValue());
    }

    public function visitDifficultyValue(\Context\DifficultyValueContext $context): mixed
    {
        return DifficultyLevel::fromDsl($context->getText());
    }


    // Optional real_world_case block


    public function visitRealWorldCase(\Context\RealWorldCaseContext $context): mixed
    {
        $year        = (int) $context->realWorldYear()->INTEGER()->getText();
        $victim      = $this->unquoteString($context->realWorldVictim()->STRING()->getText());
        $impact      = $this->unquoteString($context->realWorldImpact()->STRING()->getText());
        $attribution = null;

        if ($context->realWorldAttribution() !== null) {
            $attribution = $this->unquoteString(
                $context->realWorldAttribution()->STRING()->getText()
            );
        }

        return $attribution !== null
            ? CaseStudy::create($year, $victim, $impact, $attribution)
            : CaseStudy::withUnknownAttribution($year, $victim, $impact);
    }

    // Individual realWorld sub-rules 
    public function visitRealWorldYear(\Context\RealWorldYearContext $context): mixed
    {
        return (int) $context->INTEGER()->getText();
    }

    public function visitRealWorldVictim(\Context\RealWorldVictimContext $context): mixed
    {
        return $this->unquoteString($context->STRING()->getText());
    }

    public function visitRealWorldImpact(\Context\RealWorldImpactContext $context): mixed
    {
        return $this->unquoteString($context->STRING()->getText());
    }

    public function visitRealWorldAttribution(\Context\RealWorldAttributionContext $context): mixed
    {
        return $this->unquoteString($context->STRING()->getText());
    }

    // attackProperty wrapper 

    public function visitAttackVectorProperty(\Context\AttackVectorPropertyContext $context): mixed
    {
        return $this->visit($context->attackVectorProp());
    }

    public function visitTargetProfileProperty(\Context\TargetProfilePropertyContext $context): mixed
    {
        return $this->visit($context->targetProfileProp());
    }

    public function visitSuccessRateProperty(\Context\SuccessRatePropertyContext $context): mixed
    {
        return $this->visit($context->successRateProp());
    }

    public function visitAverageImpactProperty(\Context\AverageImpactPropertyContext $context): mixed
    {
        return $this->visit($context->averageImpactProp());
    }

    public function visitDeliveryMethodProperty(\Context\DeliveryMethodPropertyContext $context): mixed
    {
        return $this->visit($context->deliveryMethodProp());
    }

    public function visitDetectionDifficultyProperty(\Context\DetectionDifficultyPropertyContext $context): mixed
    {
        return $this->visit($context->detectionDifficultyProp());
    }

    public function visitPreventionMeasuresProperty(\Context\PreventionMeasuresPropertyContext $context): mixed
    {
        return $this->visit($context->preventionMeasuresProp());
    }

    public function visitBrandImpersonationProperty(\Context\BrandImpersonationPropertyContext $context): mixed
    {
        return $this->visit($context->brandImpersonationProp());
    }

    public function visitCveReferencesProperty(\Context\CveReferencesPropertyContext $context): mixed
    {
        return $this->visit($context->cveReferencesProp());
    }

    public function visitToolsUsedProperty(\Context\ToolsUsedPropertyContext $context): mixed
    {
        return $this->visit($context->toolsUsedProp());
    }

    public function visitAttributionProperty(\Context\AttributionPropertyContext $context): mixed
    {
        return $this->visit($context->attributionProp());
    }

    public function visitCapecIdProperty(\Context\CapecIdPropertyContext $context): mixed
    {
        return $this->visit($context->capecIdProp());
    }

    public function visitKillChainPhaseProperty(\Context\KillChainPhasePropertyContext $context): mixed
    {
        return $this->visit($context->killChainPhaseProp());
    }

    public function visitDataSourcesProperty(\Context\DataSourcesPropertyContext $context): mixed
    {
        return $this->visit($context->dataSourcesProp());
    }

    public function visitMitigationsProperty(\Context\MitigationsPropertyContext $context): mixed
    {
        return $this->visit($context->mitigationsProp());
    }

    public function visitPlatformsProperty(\Context\PlatformsPropertyContext $context): mixed
    {
        return $this->visit($context->platformsProp());
    }

    public function visitPrivilegeRequiredProperty(\Context\PrivilegeRequiredPropertyContext $context): mixed
    {
        return $this->visit($context->privilegeRequiredProp());
    }

    public function visitImpactTypeProperty(\Context\ImpactTypePropertyContext $context): mixed
    {
        return $this->visit($context->impactTypeProp());
    }

    public function visitNotesProperty(\Context\NotesPropertyContext $context): mixed
    {
        return $this->visit($context->notesProp());
    }


    // Concrete prop rules 

    public function visitAttackVectorProp(\Context\AttackVectorPropContext $context): mixed
    {
        return ['attack_vector' => $this->unquoteString($context->STRING()->getText())];
    }

    public function visitTargetProfileProp(\Context\TargetProfilePropContext $context): mixed
    {
        return ['target_profile' => $this->unquoteString($context->STRING()->getText())];
    }

    public function visitSuccessRateProp(\Context\SuccessRatePropContext $context): mixed
    {
        $raw = $context->RATE_RANGE() !== null
            ? $context->RATE_RANGE()->getText()
            : $this->unquoteString($context->STRING()->getText());

        return ['success_rate' => SuccessRate::fromDslToken($raw)];
    }

    public function visitAverageImpactProp(\Context\AverageImpactPropContext $context): mixed
    {
        return ['average_impact' => $this->unquoteString($context->STRING()->getText())];
    }

    public function visitDeliveryMethodProp(\Context\DeliveryMethodPropContext $context): mixed
    {
        return ['delivery_method' => $this->unquoteString($context->STRING()->getText())];
    }

    public function visitDetectionDifficultyProp(\Context\DetectionDifficultyPropContext $context): mixed
    {
        return ['detection_difficulty' => $this->visit($context->detectionLevel())];
    }

    public function visitDetectionLevel(\Context\DetectionLevelContext $context): mixed
    {
        return DetectionDifficulty::fromDsl($context->getText());
    }

    public function visitPreventionMeasuresProp(\Context\PreventionMeasuresPropContext $context): mixed
    {
        return ['prevention_measures' => $this->visit($context->stringArray())];
    }

    public function visitBrandImpersonationProp(\Context\BrandImpersonationPropContext $context): mixed
    {
        $realBrand    = $this->unquoteString($context->STRING(0)->getText());
        $spoofVariant = $this->unquoteString($context->STRING(1)->getText());

        return ['brand_impersonation' => BrandImpersonation::create($realBrand, $spoofVariant)];
    }

    public function visitCveReferencesProp(\Context\CveReferencesPropContext $context): mixed
    {
        return ['cve_references' => $this->visit($context->stringArray())];
    }

    public function visitToolsUsedProp(\Context\ToolsUsedPropContext $context): mixed
    {
        return ['tools_used' => $this->visit($context->stringArray())];
    }

    public function visitAttributionProp(\Context\AttributionPropContext $context): mixed
    {
        return ['attribution' => $this->unquoteString($context->STRING()->getText())];
    }

    public function visitCapecIdProp(\Context\CapecIdPropContext $context): mixed
    {
        return ['capec_id' => CapecId::fromString($this->unquoteString($context->STRING()->getText()))];
    }

    public function visitKillChainPhaseProp(\Context\KillChainPhasePropContext $context): mixed
    {
        return ['kill_chain_phase' => $this->visit($context->killChainValue())];
    }

    public function visitKillChainValue(\Context\KillChainValueContext $context): mixed
    {
        return KillChainPhase::fromDsl($context->getText());
    }

    public function visitDataSourcesProp(\Context\DataSourcesPropContext $context): mixed
    {
        return ['data_sources' => $this->visit($context->stringArray())];
    }

    public function visitMitigationsProp(\Context\MitigationsPropContext $context): mixed
    {
        return ['mitigations' => $this->visit($context->stringArray())];
    }

    public function visitPlatformsProp(\Context\PlatformsPropContext $context): mixed
    {
        return ['platforms' => $this->visit($context->stringArray())];
    }

    public function visitPrivilegeRequiredProp(\Context\PrivilegeRequiredPropContext $context): mixed
    {
        return ['privilege_required' => $this->visit($context->privilegeLevel())];
    }

    public function visitPrivilegeLevel(\Context\PrivilegeLevelContext $context): mixed
    {
        return PrivilegeLevel::fromDsl($context->getText());
    }

    public function visitImpactTypeProp(\Context\ImpactTypePropContext $context): mixed
    {
        return ['impact_type' => $this->visit($context->impactTypeValue())];
    }

    public function visitImpactTypeValue(\Context\ImpactTypeValueContext $context): mixed
    {
        return ImpactType::fromDsl($context->getText());
    }

    public function visitNotesProp(\Context\NotesPropContext $context): mixed
    {
        return ['notes' => $this->unquoteString($context->STRING()->getText())];
    }

    // String array (

    /**
     * @return list<string>
     */
    public function visitStringArray(\Context\StringArrayContext $context): mixed
    {
        $strings = $context->STRING();

        if ($strings === null) {
            return [];
        }

        $nodes = is_array($strings) ? $strings : [$strings];

        return array_values(
            array_map(
                fn ($node) => $this->unquoteString($node->getText()),
                $nodes
            )
        );
    }

    // Helpers

    private function unquoteString(string $quoted): string
    {
        $inner = trim($quoted, '"');

        return stripcslashes($inner);
    }
}
