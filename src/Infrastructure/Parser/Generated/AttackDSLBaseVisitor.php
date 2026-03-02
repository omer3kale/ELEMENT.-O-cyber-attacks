<?php

/*
 * Generated from AttackDSL.g4 by ANTLR 4.13.1
 */

use Antlr\Antlr4\Runtime\Tree\AbstractParseTreeVisitor;

class AttackDSLBaseVisitor extends AbstractParseTreeVisitor implements AttackDSLVisitor
{
	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitAttackCollection(Context\AttackCollectionContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitAttackDefinition(Context\AttackDefinitionContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitMitreId(Context\MitreIdContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitCategory(Context\CategoryContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitCategoryValue(Context\CategoryValueContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitDifficulty(Context\DifficultyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitDifficultyValue(Context\DifficultyValueContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitRealWorldCase(Context\RealWorldCaseContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitRealWorldYear(Context\RealWorldYearContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitRealWorldVictim(Context\RealWorldVictimContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitRealWorldImpact(Context\RealWorldImpactContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitRealWorldAttribution(Context\RealWorldAttributionContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitAttackVectorProperty(Context\AttackVectorPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitTargetProfileProperty(Context\TargetProfilePropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitSuccessRateProperty(Context\SuccessRatePropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitAverageImpactProperty(Context\AverageImpactPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitDeliveryMethodProperty(Context\DeliveryMethodPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitDetectionDifficultyProperty(Context\DetectionDifficultyPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitPreventionMeasuresProperty(Context\PreventionMeasuresPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitBrandImpersonationProperty(Context\BrandImpersonationPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitCveReferencesProperty(Context\CveReferencesPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitToolsUsedProperty(Context\ToolsUsedPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitAttributionProperty(Context\AttributionPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitCapecIdProperty(Context\CapecIdPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitKillChainPhaseProperty(Context\KillChainPhasePropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitDataSourcesProperty(Context\DataSourcesPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitMitigationsProperty(Context\MitigationsPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitPlatformsProperty(Context\PlatformsPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitPrivilegeRequiredProperty(Context\PrivilegeRequiredPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitImpactTypeProperty(Context\ImpactTypePropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitNotesProperty(Context\NotesPropertyContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitAttackVectorProp(Context\AttackVectorPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitTargetProfileProp(Context\TargetProfilePropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitSuccessRateProp(Context\SuccessRatePropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitAverageImpactProp(Context\AverageImpactPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitDeliveryMethodProp(Context\DeliveryMethodPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitDetectionDifficultyProp(Context\DetectionDifficultyPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitDetectionLevel(Context\DetectionLevelContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitPreventionMeasuresProp(Context\PreventionMeasuresPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitBrandImpersonationProp(Context\BrandImpersonationPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitCveReferencesProp(Context\CveReferencesPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitToolsUsedProp(Context\ToolsUsedPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitAttributionProp(Context\AttributionPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitCapecIdProp(Context\CapecIdPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitKillChainPhaseProp(Context\KillChainPhasePropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitKillChainValue(Context\KillChainValueContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitDataSourcesProp(Context\DataSourcesPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitMitigationsProp(Context\MitigationsPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitPlatformsProp(Context\PlatformsPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitPrivilegeRequiredProp(Context\PrivilegeRequiredPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitPrivilegeLevel(Context\PrivilegeLevelContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitImpactTypeProp(Context\ImpactTypePropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitImpactTypeValue(Context\ImpactTypeValueContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitNotesProp(Context\NotesPropContext $context)
	{
	    return $this->visitChildren($context);
	}

	/**
	 * {@inheritdoc}
	 *
	 * The default implementation returns the result of calling
	 * {@see self::visitChildren()} on `context`.
	 */
	public function visitStringArray(Context\StringArrayContext $context)
	{
	    return $this->visitChildren($context);
	}
}