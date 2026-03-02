<?php

/*
 * Generated from AttackDSL.g4 by ANTLR 4.13.1
 */

use Antlr\Antlr4\Runtime\Tree\ParseTreeVisitor;

/**
 * This interface defines a complete generic visitor for a parse tree produced by {@see AttackDSLParser}.
 */
interface AttackDSLVisitor extends ParseTreeVisitor
{
	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::attackCollection()}.
	 *
	 * @param Context\AttackCollectionContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitAttackCollection(Context\AttackCollectionContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::attackDefinition()}.
	 *
	 * @param Context\AttackDefinitionContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitAttackDefinition(Context\AttackDefinitionContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::mitreId()}.
	 *
	 * @param Context\MitreIdContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitMitreId(Context\MitreIdContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::category()}.
	 *
	 * @param Context\CategoryContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitCategory(Context\CategoryContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::categoryValue()}.
	 *
	 * @param Context\CategoryValueContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitCategoryValue(Context\CategoryValueContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::difficulty()}.
	 *
	 * @param Context\DifficultyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitDifficulty(Context\DifficultyContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::difficultyValue()}.
	 *
	 * @param Context\DifficultyValueContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitDifficultyValue(Context\DifficultyValueContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::realWorldCase()}.
	 *
	 * @param Context\RealWorldCaseContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitRealWorldCase(Context\RealWorldCaseContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::realWorldYear()}.
	 *
	 * @param Context\RealWorldYearContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitRealWorldYear(Context\RealWorldYearContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::realWorldVictim()}.
	 *
	 * @param Context\RealWorldVictimContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitRealWorldVictim(Context\RealWorldVictimContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::realWorldImpact()}.
	 *
	 * @param Context\RealWorldImpactContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitRealWorldImpact(Context\RealWorldImpactContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::realWorldAttribution()}.
	 *
	 * @param Context\RealWorldAttributionContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitRealWorldAttribution(Context\RealWorldAttributionContext $context);

	/**
	 * Visit a parse tree produced by the `AttackVectorProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\AttackVectorPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitAttackVectorProperty(Context\AttackVectorPropertyContext $context);

	/**
	 * Visit a parse tree produced by the `TargetProfileProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\TargetProfilePropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitTargetProfileProperty(Context\TargetProfilePropertyContext $context);

	/**
	 * Visit a parse tree produced by the `SuccessRateProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\SuccessRatePropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitSuccessRateProperty(Context\SuccessRatePropertyContext $context);

	/**
	 * Visit a parse tree produced by the `AverageImpactProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\AverageImpactPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitAverageImpactProperty(Context\AverageImpactPropertyContext $context);

	/**
	 * Visit a parse tree produced by the `DeliveryMethodProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\DeliveryMethodPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitDeliveryMethodProperty(Context\DeliveryMethodPropertyContext $context);

	/**
	 * Visit a parse tree produced by the `DetectionDifficultyProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\DetectionDifficultyPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitDetectionDifficultyProperty(Context\DetectionDifficultyPropertyContext $context);

	/**
	 * Visit a parse tree produced by the `PreventionMeasuresProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\PreventionMeasuresPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitPreventionMeasuresProperty(Context\PreventionMeasuresPropertyContext $context);

	/**
	 * Visit a parse tree produced by the `BrandImpersonationProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\BrandImpersonationPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitBrandImpersonationProperty(Context\BrandImpersonationPropertyContext $context);

	/**
	 * Visit a parse tree produced by the `CveReferencesProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\CveReferencesPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitCveReferencesProperty(Context\CveReferencesPropertyContext $context);

	/**
	 * Visit a parse tree produced by the `ToolsUsedProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\ToolsUsedPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitToolsUsedProperty(Context\ToolsUsedPropertyContext $context);

	/**
	 * Visit a parse tree produced by the `AttributionProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\AttributionPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitAttributionProperty(Context\AttributionPropertyContext $context);

	/**
	 * Visit a parse tree produced by the `CapecIdProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\CapecIdPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitCapecIdProperty(Context\CapecIdPropertyContext $context);

	/**
	 * Visit a parse tree produced by the `KillChainPhaseProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\KillChainPhasePropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitKillChainPhaseProperty(Context\KillChainPhasePropertyContext $context);

	/**
	 * Visit a parse tree produced by the `DataSourcesProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\DataSourcesPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitDataSourcesProperty(Context\DataSourcesPropertyContext $context);

	/**
	 * Visit a parse tree produced by the `MitigationsProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\MitigationsPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitMitigationsProperty(Context\MitigationsPropertyContext $context);

	/**
	 * Visit a parse tree produced by the `PlatformsProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\PlatformsPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitPlatformsProperty(Context\PlatformsPropertyContext $context);

	/**
	 * Visit a parse tree produced by the `PrivilegeRequiredProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\PrivilegeRequiredPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitPrivilegeRequiredProperty(Context\PrivilegeRequiredPropertyContext $context);

	/**
	 * Visit a parse tree produced by the `ImpactTypeProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\ImpactTypePropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitImpactTypeProperty(Context\ImpactTypePropertyContext $context);

	/**
	 * Visit a parse tree produced by the `NotesProperty` labeled alternative
	 * in {@see AttackDSLParser::attackProperty()}.
	 *
	 * @param Context\NotesPropertyContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitNotesProperty(Context\NotesPropertyContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::attackVectorProp()}.
	 *
	 * @param Context\AttackVectorPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitAttackVectorProp(Context\AttackVectorPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::targetProfileProp()}.
	 *
	 * @param Context\TargetProfilePropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitTargetProfileProp(Context\TargetProfilePropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::successRateProp()}.
	 *
	 * @param Context\SuccessRatePropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitSuccessRateProp(Context\SuccessRatePropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::averageImpactProp()}.
	 *
	 * @param Context\AverageImpactPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitAverageImpactProp(Context\AverageImpactPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::deliveryMethodProp()}.
	 *
	 * @param Context\DeliveryMethodPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitDeliveryMethodProp(Context\DeliveryMethodPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::detectionDifficultyProp()}.
	 *
	 * @param Context\DetectionDifficultyPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitDetectionDifficultyProp(Context\DetectionDifficultyPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::detectionLevel()}.
	 *
	 * @param Context\DetectionLevelContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitDetectionLevel(Context\DetectionLevelContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::preventionMeasuresProp()}.
	 *
	 * @param Context\PreventionMeasuresPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitPreventionMeasuresProp(Context\PreventionMeasuresPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::brandImpersonationProp()}.
	 *
	 * @param Context\BrandImpersonationPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitBrandImpersonationProp(Context\BrandImpersonationPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::cveReferencesProp()}.
	 *
	 * @param Context\CveReferencesPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitCveReferencesProp(Context\CveReferencesPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::toolsUsedProp()}.
	 *
	 * @param Context\ToolsUsedPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitToolsUsedProp(Context\ToolsUsedPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::attributionProp()}.
	 *
	 * @param Context\AttributionPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitAttributionProp(Context\AttributionPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::capecIdProp()}.
	 *
	 * @param Context\CapecIdPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitCapecIdProp(Context\CapecIdPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::killChainPhaseProp()}.
	 *
	 * @param Context\KillChainPhasePropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitKillChainPhaseProp(Context\KillChainPhasePropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::killChainValue()}.
	 *
	 * @param Context\KillChainValueContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitKillChainValue(Context\KillChainValueContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::dataSourcesProp()}.
	 *
	 * @param Context\DataSourcesPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitDataSourcesProp(Context\DataSourcesPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::mitigationsProp()}.
	 *
	 * @param Context\MitigationsPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitMitigationsProp(Context\MitigationsPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::platformsProp()}.
	 *
	 * @param Context\PlatformsPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitPlatformsProp(Context\PlatformsPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::privilegeRequiredProp()}.
	 *
	 * @param Context\PrivilegeRequiredPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitPrivilegeRequiredProp(Context\PrivilegeRequiredPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::privilegeLevel()}.
	 *
	 * @param Context\PrivilegeLevelContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitPrivilegeLevel(Context\PrivilegeLevelContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::impactTypeProp()}.
	 *
	 * @param Context\ImpactTypePropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitImpactTypeProp(Context\ImpactTypePropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::impactTypeValue()}.
	 *
	 * @param Context\ImpactTypeValueContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitImpactTypeValue(Context\ImpactTypeValueContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::notesProp()}.
	 *
	 * @param Context\NotesPropContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitNotesProp(Context\NotesPropContext $context);

	/**
	 * Visit a parse tree produced by {@see AttackDSLParser::stringArray()}.
	 *
	 * @param Context\StringArrayContext $context The parse tree.
	 *
	 * @return mixed The visitor result.
	 */
	public function visitStringArray(Context\StringArrayContext $context);
}