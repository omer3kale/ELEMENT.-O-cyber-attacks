<?php

/*
 * Generated from AttackDSL.g4 by ANTLR 4.13.1
 */

namespace {
	use Antlr\Antlr4\Runtime\Atn\ATN;
	use Antlr\Antlr4\Runtime\Atn\ATNDeserializer;
	use Antlr\Antlr4\Runtime\Atn\ParserATNSimulator;
	use Antlr\Antlr4\Runtime\Dfa\DFA;
	use Antlr\Antlr4\Runtime\Error\Exceptions\FailedPredicateException;
	use Antlr\Antlr4\Runtime\Error\Exceptions\NoViableAltException;
	use Antlr\Antlr4\Runtime\PredictionContexts\PredictionContextCache;
	use Antlr\Antlr4\Runtime\Error\Exceptions\RecognitionException;
	use Antlr\Antlr4\Runtime\RuleContext;
	use Antlr\Antlr4\Runtime\Token;
	use Antlr\Antlr4\Runtime\TokenStream;
	use Antlr\Antlr4\Runtime\Vocabulary;
	use Antlr\Antlr4\Runtime\VocabularyImpl;
	use Antlr\Antlr4\Runtime\RuntimeMetaData;
	use Antlr\Antlr4\Runtime\Parser;

	final class AttackDSLParser extends Parser
	{
		public const ATTACK = 1, REAL_WORLD_CASE = 2, BRAND_IMPERSONATION = 3, 
               MITRE_ID = 4, CATEGORY = 5, DIFFICULTY = 6, ATTACK_VECTOR = 7, 
               TARGET_PROFILE = 8, SUCCESS_RATE = 9, AVERAGE_IMPACT = 10, 
               DELIVERY_METHOD = 11, DETECTION_DIFFICULTY = 12, PREVENTION_MEASURES = 13, 
               CVE_REFERENCES = 14, TOOLS_USED = 15, ATTRIBUTION = 16, CAPEC_ID = 17, 
               KILL_CHAIN_PHASE = 18, DATA_SOURCES = 19, MITIGATIONS = 20, 
               PLATFORMS = 21, PRIVILEGE_REQUIRED = 22, IMPACT_TYPE = 23, 
               NOTES = 24, YEAR = 25, VICTIM = 26, IMPACT = 27, REAL_BRAND = 28, 
               SPOOF_VARIANT = 29, SOCIAL_ENGINEERING = 30, MALWARE = 31, 
               NETWORK = 32, APPLICATION = 33, CLOUD = 34, IOT = 35, MOBILE = 36, 
               SUPPLY_CHAIN = 37, PHYSICAL = 38, CRYPTOGRAPHIC = 39, AI_ML = 40, 
               QUANTUM = 41, TRIVIAL = 42, EASY = 43, MEDIUM = 44, HARD = 45, 
               EXPERT = 46, NATION_STATE = 47, LOW = 48, HIGH = 49, NEARLY_IMPOSSIBLE = 50, 
               RECONNAISSANCE = 51, WEAPONIZATION = 52, DELIVERY = 53, EXPLOITATION = 54, 
               INSTALLATION = 55, C2 = 56, ACTIONS_ON_OBJECTIVES = 57, NONE_PRIV = 58, 
               USER_PRIV = 59, ADMINISTRATOR = 60, SYSTEM_PRIV = 61, ROOT = 62, 
               FINANCIAL = 63, DATA_THEFT = 64, SERVICE_DISRUPTION = 65, 
               REPUTATIONAL = 66, PHYSICAL_IMPACT = 67, ESPIONAGE = 68, 
               SABOTAGE = 69, LBRACE = 70, RBRACE = 71, LBRACKET = 72, RBRACKET = 73, 
               COLON = 74, SEMICOLON = 75, COMMA = 76, RATE_RANGE = 77, 
               INTEGER = 78, STRING = 79, IDENTIFIER = 80, WS = 81, LINE_COMMENT = 82, 
               BLOCK_COMMENT = 83;

		public const RULE_attackCollection = 0, RULE_attackDefinition = 1, RULE_mitreId = 2, 
               RULE_category = 3, RULE_categoryValue = 4, RULE_difficulty = 5, 
               RULE_difficultyValue = 6, RULE_realWorldCase = 7, RULE_realWorldYear = 8, 
               RULE_realWorldVictim = 9, RULE_realWorldImpact = 10, RULE_realWorldAttribution = 11, 
               RULE_attackProperty = 12, RULE_attackVectorProp = 13, RULE_targetProfileProp = 14, 
               RULE_successRateProp = 15, RULE_averageImpactProp = 16, RULE_deliveryMethodProp = 17, 
               RULE_detectionDifficultyProp = 18, RULE_detectionLevel = 19, 
               RULE_preventionMeasuresProp = 20, RULE_brandImpersonationProp = 21, 
               RULE_cveReferencesProp = 22, RULE_toolsUsedProp = 23, RULE_attributionProp = 24, 
               RULE_capecIdProp = 25, RULE_killChainPhaseProp = 26, RULE_killChainValue = 27, 
               RULE_dataSourcesProp = 28, RULE_mitigationsProp = 29, RULE_platformsProp = 30, 
               RULE_privilegeRequiredProp = 31, RULE_privilegeLevel = 32, 
               RULE_impactTypeProp = 33, RULE_impactTypeValue = 34, RULE_notesProp = 35, 
               RULE_stringArray = 36;

		/**
		 * @var array<string>
		 */
		public const RULE_NAMES = [
			'attackCollection', 'attackDefinition', 'mitreId', 'category', 'categoryValue', 
			'difficulty', 'difficultyValue', 'realWorldCase', 'realWorldYear', 'realWorldVictim', 
			'realWorldImpact', 'realWorldAttribution', 'attackProperty', 'attackVectorProp', 
			'targetProfileProp', 'successRateProp', 'averageImpactProp', 'deliveryMethodProp', 
			'detectionDifficultyProp', 'detectionLevel', 'preventionMeasuresProp', 
			'brandImpersonationProp', 'cveReferencesProp', 'toolsUsedProp', 'attributionProp', 
			'capecIdProp', 'killChainPhaseProp', 'killChainValue', 'dataSourcesProp', 
			'mitigationsProp', 'platformsProp', 'privilegeRequiredProp', 'privilegeLevel', 
			'impactTypeProp', 'impactTypeValue', 'notesProp', 'stringArray'
		];

		/**
		 * @var array<string|null>
		 */
		private const LITERAL_NAMES = [
		    null, "'attack'", "'real_world_case'", "'brand_impersonation'", "'mitre_id'", 
		    "'category'", "'difficulty'", "'attack_vector'", "'target_profile'", 
		    "'success_rate'", "'average_impact'", "'delivery_method'", "'detection_difficulty'", 
		    "'prevention_measures'", "'cve_references'", "'tools_used'", "'attribution'", 
		    "'capec_id'", "'kill_chain_phase'", "'data_sources'", "'mitigations'", 
		    "'platforms'", "'privilege_required'", "'impact_type'", "'notes'", 
		    "'year'", "'victim'", "'impact'", "'real_brand'", "'spoof_variant'", 
		    "'SOCIAL_ENGINEERING'", "'MALWARE'", "'NETWORK'", "'APPLICATION'", 
		    "'CLOUD'", "'IOT'", "'MOBILE'", "'SUPPLY_CHAIN'", "'PHYSICAL'", "'CRYPTOGRAPHIC'", 
		    "'AI_ML'", "'QUANTUM'", "'TRIVIAL'", "'EASY'", "'MEDIUM'", "'HARD'", 
		    "'EXPERT'", "'NATION_STATE'", "'LOW'", "'HIGH'", "'NEARLY_IMPOSSIBLE'", 
		    "'RECONNAISSANCE'", "'WEAPONIZATION'", "'DELIVERY'", "'EXPLOITATION'", 
		    "'INSTALLATION'", "'C2'", "'ACTIONS_ON_OBJECTIVES'", "'NONE'", "'USER'", 
		    "'ADMINISTRATOR'", "'SYSTEM'", "'ROOT'", "'FINANCIAL'", "'DATA_THEFT'", 
		    "'SERVICE_DISRUPTION'", "'REPUTATIONAL'", "'PHYSICAL_IMPACT'", "'ESPIONAGE'", 
		    "'SABOTAGE'", "'{'", "'}'", "'['", "']'", "':'", "';'", "','"
		];

		/**
		 * @var array<string>
		 */
		private const SYMBOLIC_NAMES = [
		    null, "ATTACK", "REAL_WORLD_CASE", "BRAND_IMPERSONATION", "MITRE_ID", 
		    "CATEGORY", "DIFFICULTY", "ATTACK_VECTOR", "TARGET_PROFILE", "SUCCESS_RATE", 
		    "AVERAGE_IMPACT", "DELIVERY_METHOD", "DETECTION_DIFFICULTY", "PREVENTION_MEASURES", 
		    "CVE_REFERENCES", "TOOLS_USED", "ATTRIBUTION", "CAPEC_ID", "KILL_CHAIN_PHASE", 
		    "DATA_SOURCES", "MITIGATIONS", "PLATFORMS", "PRIVILEGE_REQUIRED", 
		    "IMPACT_TYPE", "NOTES", "YEAR", "VICTIM", "IMPACT", "REAL_BRAND", 
		    "SPOOF_VARIANT", "SOCIAL_ENGINEERING", "MALWARE", "NETWORK", "APPLICATION", 
		    "CLOUD", "IOT", "MOBILE", "SUPPLY_CHAIN", "PHYSICAL", "CRYPTOGRAPHIC", 
		    "AI_ML", "QUANTUM", "TRIVIAL", "EASY", "MEDIUM", "HARD", "EXPERT", 
		    "NATION_STATE", "LOW", "HIGH", "NEARLY_IMPOSSIBLE", "RECONNAISSANCE", 
		    "WEAPONIZATION", "DELIVERY", "EXPLOITATION", "INSTALLATION", "C2", 
		    "ACTIONS_ON_OBJECTIVES", "NONE_PRIV", "USER_PRIV", "ADMINISTRATOR", 
		    "SYSTEM_PRIV", "ROOT", "FINANCIAL", "DATA_THEFT", "SERVICE_DISRUPTION", 
		    "REPUTATIONAL", "PHYSICAL_IMPACT", "ESPIONAGE", "SABOTAGE", "LBRACE", 
		    "RBRACE", "LBRACKET", "RBRACKET", "COLON", "SEMICOLON", "COMMA", "RATE_RANGE", 
		    "INTEGER", "STRING", "IDENTIFIER", "WS", "LINE_COMMENT", "BLOCK_COMMENT"
		];

		private const SERIALIZED_ATN =
			[4, 1, 83, 297, 2, 0, 7, 0, 2, 1, 7, 1, 2, 2, 7, 2, 2, 3, 7, 3, 2, 4, 
		    7, 4, 2, 5, 7, 5, 2, 6, 7, 6, 2, 7, 7, 7, 2, 8, 7, 8, 2, 9, 7, 9, 
		    2, 10, 7, 10, 2, 11, 7, 11, 2, 12, 7, 12, 2, 13, 7, 13, 2, 14, 7, 
		    14, 2, 15, 7, 15, 2, 16, 7, 16, 2, 17, 7, 17, 2, 18, 7, 18, 2, 19, 
		    7, 19, 2, 20, 7, 20, 2, 21, 7, 21, 2, 22, 7, 22, 2, 23, 7, 23, 2, 
		    24, 7, 24, 2, 25, 7, 25, 2, 26, 7, 26, 2, 27, 7, 27, 2, 28, 7, 28, 
		    2, 29, 7, 29, 2, 30, 7, 30, 2, 31, 7, 31, 2, 32, 7, 32, 2, 33, 7, 
		    33, 2, 34, 7, 34, 2, 35, 7, 35, 2, 36, 7, 36, 1, 0, 4, 0, 76, 8, 0, 
		    11, 0, 12, 0, 77, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 
		    1, 1, 3, 1, 89, 8, 1, 1, 1, 4, 1, 92, 8, 1, 11, 1, 12, 1, 93, 1, 1, 
		    1, 1, 3, 1, 98, 8, 1, 1, 2, 1, 2, 1, 2, 1, 2, 1, 2, 1, 3, 1, 3, 1, 
		    3, 1, 3, 1, 3, 1, 4, 1, 4, 1, 5, 1, 5, 1, 5, 1, 5, 1, 5, 1, 6, 1, 
		    6, 1, 7, 1, 7, 1, 7, 1, 7, 1, 7, 1, 7, 3, 7, 125, 8, 7, 1, 7, 1, 7, 
		    3, 7, 129, 8, 7, 1, 8, 1, 8, 1, 8, 1, 8, 1, 8, 1, 9, 1, 9, 1, 9, 1, 
		    9, 1, 9, 1, 10, 1, 10, 1, 10, 1, 10, 1, 10, 1, 11, 1, 11, 1, 11, 1, 
		    11, 1, 11, 1, 12, 1, 12, 1, 12, 1, 12, 1, 12, 1, 12, 1, 12, 1, 12, 
		    1, 12, 1, 12, 1, 12, 1, 12, 1, 12, 1, 12, 1, 12, 1, 12, 1, 12, 1, 
		    12, 1, 12, 3, 12, 170, 8, 12, 1, 13, 1, 13, 1, 13, 1, 13, 1, 13, 1, 
		    14, 1, 14, 1, 14, 1, 14, 1, 14, 1, 15, 1, 15, 1, 15, 1, 15, 1, 15, 
		    1, 16, 1, 16, 1, 16, 1, 16, 1, 16, 1, 17, 1, 17, 1, 17, 1, 17, 1, 
		    17, 1, 18, 1, 18, 1, 18, 1, 18, 1, 18, 1, 19, 1, 19, 1, 20, 1, 20, 
		    1, 20, 1, 20, 1, 20, 1, 21, 1, 21, 1, 21, 1, 21, 1, 21, 1, 21, 1, 
		    21, 1, 21, 1, 21, 1, 21, 1, 21, 1, 21, 3, 21, 221, 8, 21, 1, 22, 1, 
		    22, 1, 22, 1, 22, 1, 22, 1, 23, 1, 23, 1, 23, 1, 23, 1, 23, 1, 24, 
		    1, 24, 1, 24, 1, 24, 1, 24, 1, 25, 1, 25, 1, 25, 1, 25, 1, 25, 1, 
		    26, 1, 26, 1, 26, 1, 26, 1, 26, 1, 27, 1, 27, 1, 28, 1, 28, 1, 28, 
		    1, 28, 1, 28, 1, 29, 1, 29, 1, 29, 1, 29, 1, 29, 1, 30, 1, 30, 1, 
		    30, 1, 30, 1, 30, 1, 31, 1, 31, 1, 31, 1, 31, 1, 31, 1, 32, 1, 32, 
		    1, 33, 1, 33, 1, 33, 1, 33, 1, 33, 1, 34, 1, 34, 1, 35, 1, 35, 1, 
		    35, 1, 35, 1, 35, 1, 36, 1, 36, 1, 36, 1, 36, 5, 36, 288, 8, 36, 10, 
		    36, 12, 36, 291, 9, 36, 3, 36, 293, 8, 36, 1, 36, 1, 36, 1, 36, 0, 
		    0, 37, 0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 
		    32, 34, 36, 38, 40, 42, 44, 46, 48, 50, 52, 54, 56, 58, 60, 62, 64, 
		    66, 68, 70, 72, 0, 7, 1, 0, 30, 41, 1, 0, 42, 47, 2, 0, 77, 77, 79, 
		    79, 3, 0, 42, 42, 44, 44, 48, 50, 1, 0, 51, 57, 1, 0, 58, 62, 1, 0, 
		    63, 69, 286, 0, 75, 1, 0, 0, 0, 2, 81, 1, 0, 0, 0, 4, 99, 1, 0, 0, 
		    0, 6, 104, 1, 0, 0, 0, 8, 109, 1, 0, 0, 0, 10, 111, 1, 0, 0, 0, 12, 
		    116, 1, 0, 0, 0, 14, 118, 1, 0, 0, 0, 16, 130, 1, 0, 0, 0, 18, 135, 
		    1, 0, 0, 0, 20, 140, 1, 0, 0, 0, 22, 145, 1, 0, 0, 0, 24, 169, 1, 
		    0, 0, 0, 26, 171, 1, 0, 0, 0, 28, 176, 1, 0, 0, 0, 30, 181, 1, 0, 
		    0, 0, 32, 186, 1, 0, 0, 0, 34, 191, 1, 0, 0, 0, 36, 196, 1, 0, 0, 
		    0, 38, 201, 1, 0, 0, 0, 40, 203, 1, 0, 0, 0, 42, 208, 1, 0, 0, 0, 
		    44, 222, 1, 0, 0, 0, 46, 227, 1, 0, 0, 0, 48, 232, 1, 0, 0, 0, 50, 
		    237, 1, 0, 0, 0, 52, 242, 1, 0, 0, 0, 54, 247, 1, 0, 0, 0, 56, 249, 
		    1, 0, 0, 0, 58, 254, 1, 0, 0, 0, 60, 259, 1, 0, 0, 0, 62, 264, 1, 
		    0, 0, 0, 64, 269, 1, 0, 0, 0, 66, 271, 1, 0, 0, 0, 68, 276, 1, 0, 
		    0, 0, 70, 278, 1, 0, 0, 0, 72, 283, 1, 0, 0, 0, 74, 76, 3, 2, 1, 0, 
		    75, 74, 1, 0, 0, 0, 76, 77, 1, 0, 0, 0, 77, 75, 1, 0, 0, 0, 77, 78, 
		    1, 0, 0, 0, 78, 79, 1, 0, 0, 0, 79, 80, 5, 0, 0, 1, 80, 1, 1, 0, 0, 
		    0, 81, 82, 5, 1, 0, 0, 82, 83, 5, 80, 0, 0, 83, 84, 5, 70, 0, 0, 84, 
		    85, 3, 4, 2, 0, 85, 86, 3, 6, 3, 0, 86, 88, 3, 10, 5, 0, 87, 89, 3, 
		    14, 7, 0, 88, 87, 1, 0, 0, 0, 88, 89, 1, 0, 0, 0, 89, 91, 1, 0, 0, 
		    0, 90, 92, 3, 24, 12, 0, 91, 90, 1, 0, 0, 0, 92, 93, 1, 0, 0, 0, 93, 
		    91, 1, 0, 0, 0, 93, 94, 1, 0, 0, 0, 94, 95, 1, 0, 0, 0, 95, 97, 5, 
		    71, 0, 0, 96, 98, 5, 75, 0, 0, 97, 96, 1, 0, 0, 0, 97, 98, 1, 0, 0, 
		    0, 98, 3, 1, 0, 0, 0, 99, 100, 5, 4, 0, 0, 100, 101, 5, 74, 0, 0, 
		    101, 102, 5, 79, 0, 0, 102, 103, 5, 75, 0, 0, 103, 5, 1, 0, 0, 0, 
		    104, 105, 5, 5, 0, 0, 105, 106, 5, 74, 0, 0, 106, 107, 3, 8, 4, 0, 
		    107, 108, 5, 75, 0, 0, 108, 7, 1, 0, 0, 0, 109, 110, 7, 0, 0, 0, 110, 
		    9, 1, 0, 0, 0, 111, 112, 5, 6, 0, 0, 112, 113, 5, 74, 0, 0, 113, 114, 
		    3, 12, 6, 0, 114, 115, 5, 75, 0, 0, 115, 11, 1, 0, 0, 0, 116, 117, 
		    7, 1, 0, 0, 117, 13, 1, 0, 0, 0, 118, 119, 5, 2, 0, 0, 119, 120, 5, 
		    70, 0, 0, 120, 121, 3, 16, 8, 0, 121, 122, 3, 18, 9, 0, 122, 124, 
		    3, 20, 10, 0, 123, 125, 3, 22, 11, 0, 124, 123, 1, 0, 0, 0, 124, 125, 
		    1, 0, 0, 0, 125, 126, 1, 0, 0, 0, 126, 128, 5, 71, 0, 0, 127, 129, 
		    5, 75, 0, 0, 128, 127, 1, 0, 0, 0, 128, 129, 1, 0, 0, 0, 129, 15, 
		    1, 0, 0, 0, 130, 131, 5, 25, 0, 0, 131, 132, 5, 74, 0, 0, 132, 133, 
		    5, 78, 0, 0, 133, 134, 5, 75, 0, 0, 134, 17, 1, 0, 0, 0, 135, 136, 
		    5, 26, 0, 0, 136, 137, 5, 74, 0, 0, 137, 138, 5, 79, 0, 0, 138, 139, 
		    5, 75, 0, 0, 139, 19, 1, 0, 0, 0, 140, 141, 5, 27, 0, 0, 141, 142, 
		    5, 74, 0, 0, 142, 143, 5, 79, 0, 0, 143, 144, 5, 75, 0, 0, 144, 21, 
		    1, 0, 0, 0, 145, 146, 5, 16, 0, 0, 146, 147, 5, 74, 0, 0, 147, 148, 
		    5, 79, 0, 0, 148, 149, 5, 75, 0, 0, 149, 23, 1, 0, 0, 0, 150, 170, 
		    3, 26, 13, 0, 151, 170, 3, 28, 14, 0, 152, 170, 3, 30, 15, 0, 153, 
		    170, 3, 32, 16, 0, 154, 170, 3, 34, 17, 0, 155, 170, 3, 36, 18, 0, 
		    156, 170, 3, 40, 20, 0, 157, 170, 3, 42, 21, 0, 158, 170, 3, 44, 22, 
		    0, 159, 170, 3, 46, 23, 0, 160, 170, 3, 48, 24, 0, 161, 170, 3, 50, 
		    25, 0, 162, 170, 3, 52, 26, 0, 163, 170, 3, 56, 28, 0, 164, 170, 3, 
		    58, 29, 0, 165, 170, 3, 60, 30, 0, 166, 170, 3, 62, 31, 0, 167, 170, 
		    3, 66, 33, 0, 168, 170, 3, 70, 35, 0, 169, 150, 1, 0, 0, 0, 169, 151, 
		    1, 0, 0, 0, 169, 152, 1, 0, 0, 0, 169, 153, 1, 0, 0, 0, 169, 154, 
		    1, 0, 0, 0, 169, 155, 1, 0, 0, 0, 169, 156, 1, 0, 0, 0, 169, 157, 
		    1, 0, 0, 0, 169, 158, 1, 0, 0, 0, 169, 159, 1, 0, 0, 0, 169, 160, 
		    1, 0, 0, 0, 169, 161, 1, 0, 0, 0, 169, 162, 1, 0, 0, 0, 169, 163, 
		    1, 0, 0, 0, 169, 164, 1, 0, 0, 0, 169, 165, 1, 0, 0, 0, 169, 166, 
		    1, 0, 0, 0, 169, 167, 1, 0, 0, 0, 169, 168, 1, 0, 0, 0, 170, 25, 1, 
		    0, 0, 0, 171, 172, 5, 7, 0, 0, 172, 173, 5, 74, 0, 0, 173, 174, 5, 
		    79, 0, 0, 174, 175, 5, 75, 0, 0, 175, 27, 1, 0, 0, 0, 176, 177, 5, 
		    8, 0, 0, 177, 178, 5, 74, 0, 0, 178, 179, 5, 79, 0, 0, 179, 180, 5, 
		    75, 0, 0, 180, 29, 1, 0, 0, 0, 181, 182, 5, 9, 0, 0, 182, 183, 5, 
		    74, 0, 0, 183, 184, 7, 2, 0, 0, 184, 185, 5, 75, 0, 0, 185, 31, 1, 
		    0, 0, 0, 186, 187, 5, 10, 0, 0, 187, 188, 5, 74, 0, 0, 188, 189, 5, 
		    79, 0, 0, 189, 190, 5, 75, 0, 0, 190, 33, 1, 0, 0, 0, 191, 192, 5, 
		    11, 0, 0, 192, 193, 5, 74, 0, 0, 193, 194, 5, 79, 0, 0, 194, 195, 
		    5, 75, 0, 0, 195, 35, 1, 0, 0, 0, 196, 197, 5, 12, 0, 0, 197, 198, 
		    5, 74, 0, 0, 198, 199, 3, 38, 19, 0, 199, 200, 5, 75, 0, 0, 200, 37, 
		    1, 0, 0, 0, 201, 202, 7, 3, 0, 0, 202, 39, 1, 0, 0, 0, 203, 204, 5, 
		    13, 0, 0, 204, 205, 5, 74, 0, 0, 205, 206, 3, 72, 36, 0, 206, 207, 
		    5, 75, 0, 0, 207, 41, 1, 0, 0, 0, 208, 209, 5, 3, 0, 0, 209, 210, 
		    5, 70, 0, 0, 210, 211, 5, 28, 0, 0, 211, 212, 5, 74, 0, 0, 212, 213, 
		    5, 79, 0, 0, 213, 214, 5, 75, 0, 0, 214, 215, 5, 29, 0, 0, 215, 216, 
		    5, 74, 0, 0, 216, 217, 5, 79, 0, 0, 217, 218, 5, 75, 0, 0, 218, 220, 
		    5, 71, 0, 0, 219, 221, 5, 75, 0, 0, 220, 219, 1, 0, 0, 0, 220, 221, 
		    1, 0, 0, 0, 221, 43, 1, 0, 0, 0, 222, 223, 5, 14, 0, 0, 223, 224, 
		    5, 74, 0, 0, 224, 225, 3, 72, 36, 0, 225, 226, 5, 75, 0, 0, 226, 45, 
		    1, 0, 0, 0, 227, 228, 5, 15, 0, 0, 228, 229, 5, 74, 0, 0, 229, 230, 
		    3, 72, 36, 0, 230, 231, 5, 75, 0, 0, 231, 47, 1, 0, 0, 0, 232, 233, 
		    5, 16, 0, 0, 233, 234, 5, 74, 0, 0, 234, 235, 5, 79, 0, 0, 235, 236, 
		    5, 75, 0, 0, 236, 49, 1, 0, 0, 0, 237, 238, 5, 17, 0, 0, 238, 239, 
		    5, 74, 0, 0, 239, 240, 5, 79, 0, 0, 240, 241, 5, 75, 0, 0, 241, 51, 
		    1, 0, 0, 0, 242, 243, 5, 18, 0, 0, 243, 244, 5, 74, 0, 0, 244, 245, 
		    3, 54, 27, 0, 245, 246, 5, 75, 0, 0, 246, 53, 1, 0, 0, 0, 247, 248, 
		    7, 4, 0, 0, 248, 55, 1, 0, 0, 0, 249, 250, 5, 19, 0, 0, 250, 251, 
		    5, 74, 0, 0, 251, 252, 3, 72, 36, 0, 252, 253, 5, 75, 0, 0, 253, 57, 
		    1, 0, 0, 0, 254, 255, 5, 20, 0, 0, 255, 256, 5, 74, 0, 0, 256, 257, 
		    3, 72, 36, 0, 257, 258, 5, 75, 0, 0, 258, 59, 1, 0, 0, 0, 259, 260, 
		    5, 21, 0, 0, 260, 261, 5, 74, 0, 0, 261, 262, 3, 72, 36, 0, 262, 263, 
		    5, 75, 0, 0, 263, 61, 1, 0, 0, 0, 264, 265, 5, 22, 0, 0, 265, 266, 
		    5, 74, 0, 0, 266, 267, 3, 64, 32, 0, 267, 268, 5, 75, 0, 0, 268, 63, 
		    1, 0, 0, 0, 269, 270, 7, 5, 0, 0, 270, 65, 1, 0, 0, 0, 271, 272, 5, 
		    23, 0, 0, 272, 273, 5, 74, 0, 0, 273, 274, 3, 68, 34, 0, 274, 275, 
		    5, 75, 0, 0, 275, 67, 1, 0, 0, 0, 276, 277, 7, 6, 0, 0, 277, 69, 1, 
		    0, 0, 0, 278, 279, 5, 24, 0, 0, 279, 280, 5, 74, 0, 0, 280, 281, 5, 
		    79, 0, 0, 281, 282, 5, 75, 0, 0, 282, 71, 1, 0, 0, 0, 283, 292, 5, 
		    72, 0, 0, 284, 289, 5, 79, 0, 0, 285, 286, 5, 76, 0, 0, 286, 288, 
		    5, 79, 0, 0, 287, 285, 1, 0, 0, 0, 288, 291, 1, 0, 0, 0, 289, 287, 
		    1, 0, 0, 0, 289, 290, 1, 0, 0, 0, 290, 293, 1, 0, 0, 0, 291, 289, 
		    1, 0, 0, 0, 292, 284, 1, 0, 0, 0, 292, 293, 1, 0, 0, 0, 293, 294, 
		    1, 0, 0, 0, 294, 295, 5, 73, 0, 0, 295, 73, 1, 0, 0, 0, 10, 77, 88, 
		    93, 97, 124, 128, 169, 220, 289, 292];
		protected static $atn;
		protected static $decisionToDFA;
		protected static $sharedContextCache;

		public function __construct(TokenStream $input)
		{
			parent::__construct($input);

			self::initialize();

			$this->interp = new ParserATNSimulator($this, self::$atn, self::$decisionToDFA, self::$sharedContextCache);
		}

		private static function initialize(): void
		{
			if (self::$atn !== null) {
				return;
			}

			RuntimeMetaData::checkVersion('4.13.1', RuntimeMetaData::VERSION);

			$atn = (new ATNDeserializer())->deserialize(self::SERIALIZED_ATN);

			$decisionToDFA = [];
			for ($i = 0, $count = $atn->getNumberOfDecisions(); $i < $count; $i++) {
				$decisionToDFA[] = new DFA($atn->getDecisionState($i), $i);
			}

			self::$atn = $atn;
			self::$decisionToDFA = $decisionToDFA;
			self::$sharedContextCache = new PredictionContextCache();
		}

		public function getGrammarFileName(): string
		{
			return "AttackDSL.g4";
		}

		public function getRuleNames(): array
		{
			return self::RULE_NAMES;
		}

		public function getSerializedATN(): array
		{
			return self::SERIALIZED_ATN;
		}

		public function getATN(): ATN
		{
			return self::$atn;
		}

		public function getVocabulary(): Vocabulary
        {
            static $vocabulary;

			return $vocabulary = $vocabulary ?? new VocabularyImpl(self::LITERAL_NAMES, self::SYMBOLIC_NAMES);
        }

		/**
		 * @throws RecognitionException
		 */
		public function attackCollection(): Context\AttackCollectionContext
		{
		    $localContext = new Context\AttackCollectionContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 0, self::RULE_attackCollection);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(75); 
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        do {
		        	$this->setState(74);
		        	$this->attackDefinition();
		        	$this->setState(77); 
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        } while ($_la === self::ATTACK);
		        $this->setState(79);
		        $this->match(self::EOF);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function attackDefinition(): Context\AttackDefinitionContext
		{
		    $localContext = new Context\AttackDefinitionContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 2, self::RULE_attackDefinition);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(81);
		        $this->match(self::ATTACK);
		        $this->setState(82);
		        $this->match(self::IDENTIFIER);
		        $this->setState(83);
		        $this->match(self::LBRACE);
		        $this->setState(84);
		        $this->mitreId();
		        $this->setState(85);
		        $this->category();
		        $this->setState(86);
		        $this->difficulty();
		        $this->setState(88);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if ($_la === self::REAL_WORLD_CASE) {
		        	$this->setState(87);
		        	$this->realWorldCase();
		        }
		        $this->setState(91); 
		        $this->errorHandler->sync($this);

		        $_la = $this->input->LA(1);
		        do {
		        	$this->setState(90);
		        	$this->attackProperty();
		        	$this->setState(93); 
		        	$this->errorHandler->sync($this);
		        	$_la = $this->input->LA(1);
		        } while (((($_la) & ~0x3f) === 0 && ((1 << $_la) & 33554312) !== 0));
		        $this->setState(95);
		        $this->match(self::RBRACE);
		        $this->setState(97);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if ($_la === self::SEMICOLON) {
		        	$this->setState(96);
		        	$this->match(self::SEMICOLON);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function mitreId(): Context\MitreIdContext
		{
		    $localContext = new Context\MitreIdContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 4, self::RULE_mitreId);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(99);
		        $this->match(self::MITRE_ID);
		        $this->setState(100);
		        $this->match(self::COLON);
		        $this->setState(101);
		        $this->match(self::STRING);
		        $this->setState(102);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function category(): Context\CategoryContext
		{
		    $localContext = new Context\CategoryContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 6, self::RULE_category);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(104);
		        $this->match(self::CATEGORY);
		        $this->setState(105);
		        $this->match(self::COLON);
		        $this->setState(106);
		        $this->categoryValue();
		        $this->setState(107);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function categoryValue(): Context\CategoryValueContext
		{
		    $localContext = new Context\CategoryValueContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 8, self::RULE_categoryValue);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(109);

		        $_la = $this->input->LA(1);

		        if (!(((($_la) & ~0x3f) === 0 && ((1 << $_la) & 4396972769280) !== 0))) {
		        $this->errorHandler->recoverInline($this);
		        } else {
		        	if ($this->input->LA(1) === Token::EOF) {
		        	    $this->matchedEOF = true;
		            }

		        	$this->errorHandler->reportMatch($this);
		        	$this->consume();
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function difficulty(): Context\DifficultyContext
		{
		    $localContext = new Context\DifficultyContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 10, self::RULE_difficulty);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(111);
		        $this->match(self::DIFFICULTY);
		        $this->setState(112);
		        $this->match(self::COLON);
		        $this->setState(113);
		        $this->difficultyValue();
		        $this->setState(114);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function difficultyValue(): Context\DifficultyValueContext
		{
		    $localContext = new Context\DifficultyValueContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 12, self::RULE_difficultyValue);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(116);

		        $_la = $this->input->LA(1);

		        if (!(((($_la) & ~0x3f) === 0 && ((1 << $_la) & 277076930199552) !== 0))) {
		        $this->errorHandler->recoverInline($this);
		        } else {
		        	if ($this->input->LA(1) === Token::EOF) {
		        	    $this->matchedEOF = true;
		            }

		        	$this->errorHandler->reportMatch($this);
		        	$this->consume();
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function realWorldCase(): Context\RealWorldCaseContext
		{
		    $localContext = new Context\RealWorldCaseContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 14, self::RULE_realWorldCase);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(118);
		        $this->match(self::REAL_WORLD_CASE);
		        $this->setState(119);
		        $this->match(self::LBRACE);
		        $this->setState(120);
		        $this->realWorldYear();
		        $this->setState(121);
		        $this->realWorldVictim();
		        $this->setState(122);
		        $this->realWorldImpact();
		        $this->setState(124);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if ($_la === self::ATTRIBUTION) {
		        	$this->setState(123);
		        	$this->realWorldAttribution();
		        }
		        $this->setState(126);
		        $this->match(self::RBRACE);
		        $this->setState(128);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if ($_la === self::SEMICOLON) {
		        	$this->setState(127);
		        	$this->match(self::SEMICOLON);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function realWorldYear(): Context\RealWorldYearContext
		{
		    $localContext = new Context\RealWorldYearContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 16, self::RULE_realWorldYear);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(130);
		        $this->match(self::YEAR);
		        $this->setState(131);
		        $this->match(self::COLON);
		        $this->setState(132);
		        $this->match(self::INTEGER);
		        $this->setState(133);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function realWorldVictim(): Context\RealWorldVictimContext
		{
		    $localContext = new Context\RealWorldVictimContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 18, self::RULE_realWorldVictim);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(135);
		        $this->match(self::VICTIM);
		        $this->setState(136);
		        $this->match(self::COLON);
		        $this->setState(137);
		        $this->match(self::STRING);
		        $this->setState(138);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function realWorldImpact(): Context\RealWorldImpactContext
		{
		    $localContext = new Context\RealWorldImpactContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 20, self::RULE_realWorldImpact);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(140);
		        $this->match(self::IMPACT);
		        $this->setState(141);
		        $this->match(self::COLON);
		        $this->setState(142);
		        $this->match(self::STRING);
		        $this->setState(143);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function realWorldAttribution(): Context\RealWorldAttributionContext
		{
		    $localContext = new Context\RealWorldAttributionContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 22, self::RULE_realWorldAttribution);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(145);
		        $this->match(self::ATTRIBUTION);
		        $this->setState(146);
		        $this->match(self::COLON);
		        $this->setState(147);
		        $this->match(self::STRING);
		        $this->setState(148);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function attackProperty(): Context\AttackPropertyContext
		{
		    $localContext = new Context\AttackPropertyContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 24, self::RULE_attackProperty);

		    try {
		        $this->setState(169);
		        $this->errorHandler->sync($this);

		        switch ($this->input->LA(1)) {
		            case self::ATTACK_VECTOR:
		            	$localContext = new Context\AttackVectorPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 1);
		            	$this->setState(150);
		            	$this->attackVectorProp();
		            	break;

		            case self::TARGET_PROFILE:
		            	$localContext = new Context\TargetProfilePropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 2);
		            	$this->setState(151);
		            	$this->targetProfileProp();
		            	break;

		            case self::SUCCESS_RATE:
		            	$localContext = new Context\SuccessRatePropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 3);
		            	$this->setState(152);
		            	$this->successRateProp();
		            	break;

		            case self::AVERAGE_IMPACT:
		            	$localContext = new Context\AverageImpactPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 4);
		            	$this->setState(153);
		            	$this->averageImpactProp();
		            	break;

		            case self::DELIVERY_METHOD:
		            	$localContext = new Context\DeliveryMethodPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 5);
		            	$this->setState(154);
		            	$this->deliveryMethodProp();
		            	break;

		            case self::DETECTION_DIFFICULTY:
		            	$localContext = new Context\DetectionDifficultyPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 6);
		            	$this->setState(155);
		            	$this->detectionDifficultyProp();
		            	break;

		            case self::PREVENTION_MEASURES:
		            	$localContext = new Context\PreventionMeasuresPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 7);
		            	$this->setState(156);
		            	$this->preventionMeasuresProp();
		            	break;

		            case self::BRAND_IMPERSONATION:
		            	$localContext = new Context\BrandImpersonationPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 8);
		            	$this->setState(157);
		            	$this->brandImpersonationProp();
		            	break;

		            case self::CVE_REFERENCES:
		            	$localContext = new Context\CveReferencesPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 9);
		            	$this->setState(158);
		            	$this->cveReferencesProp();
		            	break;

		            case self::TOOLS_USED:
		            	$localContext = new Context\ToolsUsedPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 10);
		            	$this->setState(159);
		            	$this->toolsUsedProp();
		            	break;

		            case self::ATTRIBUTION:
		            	$localContext = new Context\AttributionPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 11);
		            	$this->setState(160);
		            	$this->attributionProp();
		            	break;

		            case self::CAPEC_ID:
		            	$localContext = new Context\CapecIdPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 12);
		            	$this->setState(161);
		            	$this->capecIdProp();
		            	break;

		            case self::KILL_CHAIN_PHASE:
		            	$localContext = new Context\KillChainPhasePropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 13);
		            	$this->setState(162);
		            	$this->killChainPhaseProp();
		            	break;

		            case self::DATA_SOURCES:
		            	$localContext = new Context\DataSourcesPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 14);
		            	$this->setState(163);
		            	$this->dataSourcesProp();
		            	break;

		            case self::MITIGATIONS:
		            	$localContext = new Context\MitigationsPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 15);
		            	$this->setState(164);
		            	$this->mitigationsProp();
		            	break;

		            case self::PLATFORMS:
		            	$localContext = new Context\PlatformsPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 16);
		            	$this->setState(165);
		            	$this->platformsProp();
		            	break;

		            case self::PRIVILEGE_REQUIRED:
		            	$localContext = new Context\PrivilegeRequiredPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 17);
		            	$this->setState(166);
		            	$this->privilegeRequiredProp();
		            	break;

		            case self::IMPACT_TYPE:
		            	$localContext = new Context\ImpactTypePropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 18);
		            	$this->setState(167);
		            	$this->impactTypeProp();
		            	break;

		            case self::NOTES:
		            	$localContext = new Context\NotesPropertyContext($localContext);
		            	$this->enterOuterAlt($localContext, 19);
		            	$this->setState(168);
		            	$this->notesProp();
		            	break;

		        default:
		        	throw new NoViableAltException($this);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function attackVectorProp(): Context\AttackVectorPropContext
		{
		    $localContext = new Context\AttackVectorPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 26, self::RULE_attackVectorProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(171);
		        $this->match(self::ATTACK_VECTOR);
		        $this->setState(172);
		        $this->match(self::COLON);
		        $this->setState(173);
		        $this->match(self::STRING);
		        $this->setState(174);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function targetProfileProp(): Context\TargetProfilePropContext
		{
		    $localContext = new Context\TargetProfilePropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 28, self::RULE_targetProfileProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(176);
		        $this->match(self::TARGET_PROFILE);
		        $this->setState(177);
		        $this->match(self::COLON);
		        $this->setState(178);
		        $this->match(self::STRING);
		        $this->setState(179);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function successRateProp(): Context\SuccessRatePropContext
		{
		    $localContext = new Context\SuccessRatePropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 30, self::RULE_successRateProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(181);
		        $this->match(self::SUCCESS_RATE);
		        $this->setState(182);
		        $this->match(self::COLON);
		        $this->setState(183);

		        $_la = $this->input->LA(1);

		        if (!($_la === self::RATE_RANGE || $_la === self::STRING)) {
		        $this->errorHandler->recoverInline($this);
		        } else {
		        	if ($this->input->LA(1) === Token::EOF) {
		        	    $this->matchedEOF = true;
		            }

		        	$this->errorHandler->reportMatch($this);
		        	$this->consume();
		        }
		        $this->setState(184);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function averageImpactProp(): Context\AverageImpactPropContext
		{
		    $localContext = new Context\AverageImpactPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 32, self::RULE_averageImpactProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(186);
		        $this->match(self::AVERAGE_IMPACT);
		        $this->setState(187);
		        $this->match(self::COLON);
		        $this->setState(188);
		        $this->match(self::STRING);
		        $this->setState(189);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function deliveryMethodProp(): Context\DeliveryMethodPropContext
		{
		    $localContext = new Context\DeliveryMethodPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 34, self::RULE_deliveryMethodProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(191);
		        $this->match(self::DELIVERY_METHOD);
		        $this->setState(192);
		        $this->match(self::COLON);
		        $this->setState(193);
		        $this->match(self::STRING);
		        $this->setState(194);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function detectionDifficultyProp(): Context\DetectionDifficultyPropContext
		{
		    $localContext = new Context\DetectionDifficultyPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 36, self::RULE_detectionDifficultyProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(196);
		        $this->match(self::DETECTION_DIFFICULTY);
		        $this->setState(197);
		        $this->match(self::COLON);
		        $this->setState(198);
		        $this->detectionLevel();
		        $this->setState(199);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function detectionLevel(): Context\DetectionLevelContext
		{
		    $localContext = new Context\DetectionLevelContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 38, self::RULE_detectionLevel);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(201);

		        $_la = $this->input->LA(1);

		        if (!(((($_la) & ~0x3f) === 0 && ((1 << $_la) & 1992315069530112) !== 0))) {
		        $this->errorHandler->recoverInline($this);
		        } else {
		        	if ($this->input->LA(1) === Token::EOF) {
		        	    $this->matchedEOF = true;
		            }

		        	$this->errorHandler->reportMatch($this);
		        	$this->consume();
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function preventionMeasuresProp(): Context\PreventionMeasuresPropContext
		{
		    $localContext = new Context\PreventionMeasuresPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 40, self::RULE_preventionMeasuresProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(203);
		        $this->match(self::PREVENTION_MEASURES);
		        $this->setState(204);
		        $this->match(self::COLON);
		        $this->setState(205);
		        $this->stringArray();
		        $this->setState(206);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function brandImpersonationProp(): Context\BrandImpersonationPropContext
		{
		    $localContext = new Context\BrandImpersonationPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 42, self::RULE_brandImpersonationProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(208);
		        $this->match(self::BRAND_IMPERSONATION);
		        $this->setState(209);
		        $this->match(self::LBRACE);
		        $this->setState(210);
		        $this->match(self::REAL_BRAND);
		        $this->setState(211);
		        $this->match(self::COLON);
		        $this->setState(212);
		        $this->match(self::STRING);
		        $this->setState(213);
		        $this->match(self::SEMICOLON);
		        $this->setState(214);
		        $this->match(self::SPOOF_VARIANT);
		        $this->setState(215);
		        $this->match(self::COLON);
		        $this->setState(216);
		        $this->match(self::STRING);
		        $this->setState(217);
		        $this->match(self::SEMICOLON);
		        $this->setState(218);
		        $this->match(self::RBRACE);
		        $this->setState(220);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if ($_la === self::SEMICOLON) {
		        	$this->setState(219);
		        	$this->match(self::SEMICOLON);
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function cveReferencesProp(): Context\CveReferencesPropContext
		{
		    $localContext = new Context\CveReferencesPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 44, self::RULE_cveReferencesProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(222);
		        $this->match(self::CVE_REFERENCES);
		        $this->setState(223);
		        $this->match(self::COLON);
		        $this->setState(224);
		        $this->stringArray();
		        $this->setState(225);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function toolsUsedProp(): Context\ToolsUsedPropContext
		{
		    $localContext = new Context\ToolsUsedPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 46, self::RULE_toolsUsedProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(227);
		        $this->match(self::TOOLS_USED);
		        $this->setState(228);
		        $this->match(self::COLON);
		        $this->setState(229);
		        $this->stringArray();
		        $this->setState(230);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function attributionProp(): Context\AttributionPropContext
		{
		    $localContext = new Context\AttributionPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 48, self::RULE_attributionProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(232);
		        $this->match(self::ATTRIBUTION);
		        $this->setState(233);
		        $this->match(self::COLON);
		        $this->setState(234);
		        $this->match(self::STRING);
		        $this->setState(235);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function capecIdProp(): Context\CapecIdPropContext
		{
		    $localContext = new Context\CapecIdPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 50, self::RULE_capecIdProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(237);
		        $this->match(self::CAPEC_ID);
		        $this->setState(238);
		        $this->match(self::COLON);
		        $this->setState(239);
		        $this->match(self::STRING);
		        $this->setState(240);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function killChainPhaseProp(): Context\KillChainPhasePropContext
		{
		    $localContext = new Context\KillChainPhasePropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 52, self::RULE_killChainPhaseProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(242);
		        $this->match(self::KILL_CHAIN_PHASE);
		        $this->setState(243);
		        $this->match(self::COLON);
		        $this->setState(244);
		        $this->killChainValue();
		        $this->setState(245);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function killChainValue(): Context\KillChainValueContext
		{
		    $localContext = new Context\KillChainValueContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 54, self::RULE_killChainValue);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(247);

		        $_la = $this->input->LA(1);

		        if (!(((($_la) & ~0x3f) === 0 && ((1 << $_la) & 285978576338026496) !== 0))) {
		        $this->errorHandler->recoverInline($this);
		        } else {
		        	if ($this->input->LA(1) === Token::EOF) {
		        	    $this->matchedEOF = true;
		            }

		        	$this->errorHandler->reportMatch($this);
		        	$this->consume();
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function dataSourcesProp(): Context\DataSourcesPropContext
		{
		    $localContext = new Context\DataSourcesPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 56, self::RULE_dataSourcesProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(249);
		        $this->match(self::DATA_SOURCES);
		        $this->setState(250);
		        $this->match(self::COLON);
		        $this->setState(251);
		        $this->stringArray();
		        $this->setState(252);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function mitigationsProp(): Context\MitigationsPropContext
		{
		    $localContext = new Context\MitigationsPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 58, self::RULE_mitigationsProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(254);
		        $this->match(self::MITIGATIONS);
		        $this->setState(255);
		        $this->match(self::COLON);
		        $this->setState(256);
		        $this->stringArray();
		        $this->setState(257);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function platformsProp(): Context\PlatformsPropContext
		{
		    $localContext = new Context\PlatformsPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 60, self::RULE_platformsProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(259);
		        $this->match(self::PLATFORMS);
		        $this->setState(260);
		        $this->match(self::COLON);
		        $this->setState(261);
		        $this->stringArray();
		        $this->setState(262);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function privilegeRequiredProp(): Context\PrivilegeRequiredPropContext
		{
		    $localContext = new Context\PrivilegeRequiredPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 62, self::RULE_privilegeRequiredProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(264);
		        $this->match(self::PRIVILEGE_REQUIRED);
		        $this->setState(265);
		        $this->match(self::COLON);
		        $this->setState(266);
		        $this->privilegeLevel();
		        $this->setState(267);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function privilegeLevel(): Context\PrivilegeLevelContext
		{
		    $localContext = new Context\PrivilegeLevelContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 64, self::RULE_privilegeLevel);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(269);

		        $_la = $this->input->LA(1);

		        if (!(((($_la) & ~0x3f) === 0 && ((1 << $_la) & 8935141660703064064) !== 0))) {
		        $this->errorHandler->recoverInline($this);
		        } else {
		        	if ($this->input->LA(1) === Token::EOF) {
		        	    $this->matchedEOF = true;
		            }

		        	$this->errorHandler->reportMatch($this);
		        	$this->consume();
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function impactTypeProp(): Context\ImpactTypePropContext
		{
		    $localContext = new Context\ImpactTypePropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 66, self::RULE_impactTypeProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(271);
		        $this->match(self::IMPACT_TYPE);
		        $this->setState(272);
		        $this->match(self::COLON);
		        $this->setState(273);
		        $this->impactTypeValue();
		        $this->setState(274);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function impactTypeValue(): Context\ImpactTypeValueContext
		{
		    $localContext = new Context\ImpactTypeValueContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 68, self::RULE_impactTypeValue);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(276);

		        $_la = $this->input->LA(1);

		        if (!((((($_la - 63)) & ~0x3f) === 0 && ((1 << ($_la - 63)) & 127) !== 0))) {
		        $this->errorHandler->recoverInline($this);
		        } else {
		        	if ($this->input->LA(1) === Token::EOF) {
		        	    $this->matchedEOF = true;
		            }

		        	$this->errorHandler->reportMatch($this);
		        	$this->consume();
		        }
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function notesProp(): Context\NotesPropContext
		{
		    $localContext = new Context\NotesPropContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 70, self::RULE_notesProp);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(278);
		        $this->match(self::NOTES);
		        $this->setState(279);
		        $this->match(self::COLON);
		        $this->setState(280);
		        $this->match(self::STRING);
		        $this->setState(281);
		        $this->match(self::SEMICOLON);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}

		/**
		 * @throws RecognitionException
		 */
		public function stringArray(): Context\StringArrayContext
		{
		    $localContext = new Context\StringArrayContext($this->ctx, $this->getState());

		    $this->enterRule($localContext, 72, self::RULE_stringArray);

		    try {
		        $this->enterOuterAlt($localContext, 1);
		        $this->setState(283);
		        $this->match(self::LBRACKET);
		        $this->setState(292);
		        $this->errorHandler->sync($this);
		        $_la = $this->input->LA(1);

		        if ($_la === self::STRING) {
		        	$this->setState(284);
		        	$this->match(self::STRING);
		        	$this->setState(289);
		        	$this->errorHandler->sync($this);

		        	$_la = $this->input->LA(1);
		        	while ($_la === self::COMMA) {
		        		$this->setState(285);
		        		$this->match(self::COMMA);
		        		$this->setState(286);
		        		$this->match(self::STRING);
		        		$this->setState(291);
		        		$this->errorHandler->sync($this);
		        		$_la = $this->input->LA(1);
		        	}
		        }
		        $this->setState(294);
		        $this->match(self::RBRACKET);
		    } catch (RecognitionException $exception) {
		        $localContext->exception = $exception;
		        $this->errorHandler->reportError($this, $exception);
		        $this->errorHandler->recover($this, $exception);
		    } finally {
		        $this->exitRule();
		    }

		    return $localContext;
		}
	}
}

namespace Context {
	use Antlr\Antlr4\Runtime\ParserRuleContext;
	use Antlr\Antlr4\Runtime\Token;
	use Antlr\Antlr4\Runtime\Tree\ParseTreeVisitor;
	use Antlr\Antlr4\Runtime\Tree\TerminalNode;
	use Antlr\Antlr4\Runtime\Tree\ParseTreeListener;
	use AttackDSLParser;
	use AttackDSLVisitor;

	class AttackCollectionContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_attackCollection;
	    }

	    public function EOF(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::EOF, 0);
	    }

	    /**
	     * @return array<AttackDefinitionContext>|AttackDefinitionContext|null
	     */
	    public function attackDefinition(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(AttackDefinitionContext::class);
	    	}

	        return $this->getTypedRuleContext(AttackDefinitionContext::class, $index);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitAttackCollection($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class AttackDefinitionContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_attackDefinition;
	    }

	    public function ATTACK(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::ATTACK, 0);
	    }

	    public function IDENTIFIER(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::IDENTIFIER, 0);
	    }

	    public function LBRACE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::LBRACE, 0);
	    }

	    public function mitreId(): ?MitreIdContext
	    {
	    	return $this->getTypedRuleContext(MitreIdContext::class, 0);
	    }

	    public function category(): ?CategoryContext
	    {
	    	return $this->getTypedRuleContext(CategoryContext::class, 0);
	    }

	    public function difficulty(): ?DifficultyContext
	    {
	    	return $this->getTypedRuleContext(DifficultyContext::class, 0);
	    }

	    public function RBRACE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::RBRACE, 0);
	    }

	    public function realWorldCase(): ?RealWorldCaseContext
	    {
	    	return $this->getTypedRuleContext(RealWorldCaseContext::class, 0);
	    }

	    /**
	     * @return array<AttackPropertyContext>|AttackPropertyContext|null
	     */
	    public function attackProperty(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTypedRuleContexts(AttackPropertyContext::class);
	    	}

	        return $this->getTypedRuleContext(AttackPropertyContext::class, $index);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitAttackDefinition($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class MitreIdContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_mitreId;
	    }

	    public function MITRE_ID(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::MITRE_ID, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function STRING(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::STRING, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitMitreId($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class CategoryContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_category;
	    }

	    public function CATEGORY(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::CATEGORY, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function categoryValue(): ?CategoryValueContext
	    {
	    	return $this->getTypedRuleContext(CategoryValueContext::class, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitCategory($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class CategoryValueContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_categoryValue;
	    }

	    public function SOCIAL_ENGINEERING(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SOCIAL_ENGINEERING, 0);
	    }

	    public function MALWARE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::MALWARE, 0);
	    }

	    public function NETWORK(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::NETWORK, 0);
	    }

	    public function APPLICATION(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::APPLICATION, 0);
	    }

	    public function CLOUD(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::CLOUD, 0);
	    }

	    public function IOT(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::IOT, 0);
	    }

	    public function MOBILE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::MOBILE, 0);
	    }

	    public function SUPPLY_CHAIN(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SUPPLY_CHAIN, 0);
	    }

	    public function PHYSICAL(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::PHYSICAL, 0);
	    }

	    public function CRYPTOGRAPHIC(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::CRYPTOGRAPHIC, 0);
	    }

	    public function AI_ML(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::AI_ML, 0);
	    }

	    public function QUANTUM(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::QUANTUM, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitCategoryValue($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class DifficultyContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_difficulty;
	    }

	    public function DIFFICULTY(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::DIFFICULTY, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function difficultyValue(): ?DifficultyValueContext
	    {
	    	return $this->getTypedRuleContext(DifficultyValueContext::class, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitDifficulty($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class DifficultyValueContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_difficultyValue;
	    }

	    public function TRIVIAL(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::TRIVIAL, 0);
	    }

	    public function EASY(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::EASY, 0);
	    }

	    public function MEDIUM(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::MEDIUM, 0);
	    }

	    public function HARD(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::HARD, 0);
	    }

	    public function EXPERT(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::EXPERT, 0);
	    }

	    public function NATION_STATE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::NATION_STATE, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitDifficultyValue($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class RealWorldCaseContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_realWorldCase;
	    }

	    public function REAL_WORLD_CASE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::REAL_WORLD_CASE, 0);
	    }

	    public function LBRACE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::LBRACE, 0);
	    }

	    public function realWorldYear(): ?RealWorldYearContext
	    {
	    	return $this->getTypedRuleContext(RealWorldYearContext::class, 0);
	    }

	    public function realWorldVictim(): ?RealWorldVictimContext
	    {
	    	return $this->getTypedRuleContext(RealWorldVictimContext::class, 0);
	    }

	    public function realWorldImpact(): ?RealWorldImpactContext
	    {
	    	return $this->getTypedRuleContext(RealWorldImpactContext::class, 0);
	    }

	    public function RBRACE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::RBRACE, 0);
	    }

	    public function realWorldAttribution(): ?RealWorldAttributionContext
	    {
	    	return $this->getTypedRuleContext(RealWorldAttributionContext::class, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitRealWorldCase($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class RealWorldYearContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_realWorldYear;
	    }

	    public function YEAR(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::YEAR, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function INTEGER(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::INTEGER, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitRealWorldYear($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class RealWorldVictimContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_realWorldVictim;
	    }

	    public function VICTIM(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::VICTIM, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function STRING(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::STRING, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitRealWorldVictim($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class RealWorldImpactContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_realWorldImpact;
	    }

	    public function IMPACT(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::IMPACT, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function STRING(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::STRING, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitRealWorldImpact($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class RealWorldAttributionContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_realWorldAttribution;
	    }

	    public function ATTRIBUTION(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::ATTRIBUTION, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function STRING(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::STRING, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitRealWorldAttribution($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class AttackPropertyContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_attackProperty;
	    }
	 
		public function copyFrom(ParserRuleContext $context): void
		{
			parent::copyFrom($context);

		}
	}

	class DataSourcesPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function dataSourcesProp(): ?DataSourcesPropContext
	    {
	    	return $this->getTypedRuleContext(DataSourcesPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitDataSourcesProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class AttackVectorPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function attackVectorProp(): ?AttackVectorPropContext
	    {
	    	return $this->getTypedRuleContext(AttackVectorPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitAttackVectorProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class TargetProfilePropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function targetProfileProp(): ?TargetProfilePropContext
	    {
	    	return $this->getTypedRuleContext(TargetProfilePropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitTargetProfileProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class ImpactTypePropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function impactTypeProp(): ?ImpactTypePropContext
	    {
	    	return $this->getTypedRuleContext(ImpactTypePropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitImpactTypeProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class CapecIdPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function capecIdProp(): ?CapecIdPropContext
	    {
	    	return $this->getTypedRuleContext(CapecIdPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitCapecIdProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class MitigationsPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function mitigationsProp(): ?MitigationsPropContext
	    {
	    	return $this->getTypedRuleContext(MitigationsPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitMitigationsProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class NotesPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function notesProp(): ?NotesPropContext
	    {
	    	return $this->getTypedRuleContext(NotesPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitNotesProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class SuccessRatePropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function successRateProp(): ?SuccessRatePropContext
	    {
	    	return $this->getTypedRuleContext(SuccessRatePropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitSuccessRateProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class PlatformsPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function platformsProp(): ?PlatformsPropContext
	    {
	    	return $this->getTypedRuleContext(PlatformsPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitPlatformsProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class BrandImpersonationPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function brandImpersonationProp(): ?BrandImpersonationPropContext
	    {
	    	return $this->getTypedRuleContext(BrandImpersonationPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitBrandImpersonationProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class CveReferencesPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function cveReferencesProp(): ?CveReferencesPropContext
	    {
	    	return $this->getTypedRuleContext(CveReferencesPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitCveReferencesProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class ToolsUsedPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function toolsUsedProp(): ?ToolsUsedPropContext
	    {
	    	return $this->getTypedRuleContext(ToolsUsedPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitToolsUsedProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class AverageImpactPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function averageImpactProp(): ?AverageImpactPropContext
	    {
	    	return $this->getTypedRuleContext(AverageImpactPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitAverageImpactProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class DetectionDifficultyPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function detectionDifficultyProp(): ?DetectionDifficultyPropContext
	    {
	    	return $this->getTypedRuleContext(DetectionDifficultyPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitDetectionDifficultyProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class PreventionMeasuresPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function preventionMeasuresProp(): ?PreventionMeasuresPropContext
	    {
	    	return $this->getTypedRuleContext(PreventionMeasuresPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitPreventionMeasuresProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class KillChainPhasePropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function killChainPhaseProp(): ?KillChainPhasePropContext
	    {
	    	return $this->getTypedRuleContext(KillChainPhasePropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitKillChainPhaseProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class AttributionPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function attributionProp(): ?AttributionPropContext
	    {
	    	return $this->getTypedRuleContext(AttributionPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitAttributionProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class DeliveryMethodPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function deliveryMethodProp(): ?DeliveryMethodPropContext
	    {
	    	return $this->getTypedRuleContext(DeliveryMethodPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitDeliveryMethodProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	}

	class PrivilegeRequiredPropertyContext extends AttackPropertyContext
	{
		public function __construct(AttackPropertyContext $context)
		{
		    parent::__construct($context);

		    $this->copyFrom($context);
	    }

	    public function privilegeRequiredProp(): ?PrivilegeRequiredPropContext
	    {
	    	return $this->getTypedRuleContext(PrivilegeRequiredPropContext::class, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitPrivilegeRequiredProperty($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class AttackVectorPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_attackVectorProp;
	    }

	    public function ATTACK_VECTOR(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::ATTACK_VECTOR, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function STRING(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::STRING, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitAttackVectorProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class TargetProfilePropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_targetProfileProp;
	    }

	    public function TARGET_PROFILE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::TARGET_PROFILE, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function STRING(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::STRING, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitTargetProfileProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class SuccessRatePropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_successRateProp;
	    }

	    public function SUCCESS_RATE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SUCCESS_RATE, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

	    public function RATE_RANGE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::RATE_RANGE, 0);
	    }

	    public function STRING(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::STRING, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitSuccessRateProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class AverageImpactPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_averageImpactProp;
	    }

	    public function AVERAGE_IMPACT(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::AVERAGE_IMPACT, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function STRING(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::STRING, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitAverageImpactProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class DeliveryMethodPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_deliveryMethodProp;
	    }

	    public function DELIVERY_METHOD(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::DELIVERY_METHOD, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function STRING(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::STRING, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitDeliveryMethodProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class DetectionDifficultyPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_detectionDifficultyProp;
	    }

	    public function DETECTION_DIFFICULTY(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::DETECTION_DIFFICULTY, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function detectionLevel(): ?DetectionLevelContext
	    {
	    	return $this->getTypedRuleContext(DetectionLevelContext::class, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitDetectionDifficultyProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class DetectionLevelContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_detectionLevel;
	    }

	    public function TRIVIAL(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::TRIVIAL, 0);
	    }

	    public function LOW(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::LOW, 0);
	    }

	    public function MEDIUM(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::MEDIUM, 0);
	    }

	    public function HIGH(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::HIGH, 0);
	    }

	    public function NEARLY_IMPOSSIBLE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::NEARLY_IMPOSSIBLE, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitDetectionLevel($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class PreventionMeasuresPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_preventionMeasuresProp;
	    }

	    public function PREVENTION_MEASURES(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::PREVENTION_MEASURES, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function stringArray(): ?StringArrayContext
	    {
	    	return $this->getTypedRuleContext(StringArrayContext::class, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitPreventionMeasuresProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class BrandImpersonationPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_brandImpersonationProp;
	    }

	    public function BRAND_IMPERSONATION(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::BRAND_IMPERSONATION, 0);
	    }

	    public function LBRACE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::LBRACE, 0);
	    }

	    public function REAL_BRAND(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::REAL_BRAND, 0);
	    }

	    /**
	     * @return array<TerminalNode>|TerminalNode|null
	     */
	    public function COLON(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTokens(AttackDSLParser::COLON);
	    	}

	        return $this->getToken(AttackDSLParser::COLON, $index);
	    }

	    /**
	     * @return array<TerminalNode>|TerminalNode|null
	     */
	    public function STRING(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTokens(AttackDSLParser::STRING);
	    	}

	        return $this->getToken(AttackDSLParser::STRING, $index);
	    }

	    /**
	     * @return array<TerminalNode>|TerminalNode|null
	     */
	    public function SEMICOLON(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTokens(AttackDSLParser::SEMICOLON);
	    	}

	        return $this->getToken(AttackDSLParser::SEMICOLON, $index);
	    }

	    public function SPOOF_VARIANT(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SPOOF_VARIANT, 0);
	    }

	    public function RBRACE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::RBRACE, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitBrandImpersonationProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class CveReferencesPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_cveReferencesProp;
	    }

	    public function CVE_REFERENCES(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::CVE_REFERENCES, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function stringArray(): ?StringArrayContext
	    {
	    	return $this->getTypedRuleContext(StringArrayContext::class, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitCveReferencesProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ToolsUsedPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_toolsUsedProp;
	    }

	    public function TOOLS_USED(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::TOOLS_USED, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function stringArray(): ?StringArrayContext
	    {
	    	return $this->getTypedRuleContext(StringArrayContext::class, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitToolsUsedProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class AttributionPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_attributionProp;
	    }

	    public function ATTRIBUTION(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::ATTRIBUTION, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function STRING(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::STRING, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitAttributionProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class CapecIdPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_capecIdProp;
	    }

	    public function CAPEC_ID(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::CAPEC_ID, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function STRING(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::STRING, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitCapecIdProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class KillChainPhasePropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_killChainPhaseProp;
	    }

	    public function KILL_CHAIN_PHASE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::KILL_CHAIN_PHASE, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function killChainValue(): ?KillChainValueContext
	    {
	    	return $this->getTypedRuleContext(KillChainValueContext::class, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitKillChainPhaseProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class KillChainValueContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_killChainValue;
	    }

	    public function RECONNAISSANCE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::RECONNAISSANCE, 0);
	    }

	    public function WEAPONIZATION(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::WEAPONIZATION, 0);
	    }

	    public function DELIVERY(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::DELIVERY, 0);
	    }

	    public function EXPLOITATION(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::EXPLOITATION, 0);
	    }

	    public function INSTALLATION(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::INSTALLATION, 0);
	    }

	    public function C2(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::C2, 0);
	    }

	    public function ACTIONS_ON_OBJECTIVES(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::ACTIONS_ON_OBJECTIVES, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitKillChainValue($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class DataSourcesPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_dataSourcesProp;
	    }

	    public function DATA_SOURCES(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::DATA_SOURCES, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function stringArray(): ?StringArrayContext
	    {
	    	return $this->getTypedRuleContext(StringArrayContext::class, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitDataSourcesProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class MitigationsPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_mitigationsProp;
	    }

	    public function MITIGATIONS(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::MITIGATIONS, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function stringArray(): ?StringArrayContext
	    {
	    	return $this->getTypedRuleContext(StringArrayContext::class, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitMitigationsProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class PlatformsPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_platformsProp;
	    }

	    public function PLATFORMS(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::PLATFORMS, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function stringArray(): ?StringArrayContext
	    {
	    	return $this->getTypedRuleContext(StringArrayContext::class, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitPlatformsProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class PrivilegeRequiredPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_privilegeRequiredProp;
	    }

	    public function PRIVILEGE_REQUIRED(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::PRIVILEGE_REQUIRED, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function privilegeLevel(): ?PrivilegeLevelContext
	    {
	    	return $this->getTypedRuleContext(PrivilegeLevelContext::class, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitPrivilegeRequiredProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class PrivilegeLevelContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_privilegeLevel;
	    }

	    public function NONE_PRIV(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::NONE_PRIV, 0);
	    }

	    public function USER_PRIV(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::USER_PRIV, 0);
	    }

	    public function ADMINISTRATOR(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::ADMINISTRATOR, 0);
	    }

	    public function SYSTEM_PRIV(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SYSTEM_PRIV, 0);
	    }

	    public function ROOT(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::ROOT, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitPrivilegeLevel($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ImpactTypePropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_impactTypeProp;
	    }

	    public function IMPACT_TYPE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::IMPACT_TYPE, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function impactTypeValue(): ?ImpactTypeValueContext
	    {
	    	return $this->getTypedRuleContext(ImpactTypeValueContext::class, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitImpactTypeProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class ImpactTypeValueContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_impactTypeValue;
	    }

	    public function FINANCIAL(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::FINANCIAL, 0);
	    }

	    public function DATA_THEFT(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::DATA_THEFT, 0);
	    }

	    public function SERVICE_DISRUPTION(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SERVICE_DISRUPTION, 0);
	    }

	    public function REPUTATIONAL(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::REPUTATIONAL, 0);
	    }

	    public function PHYSICAL_IMPACT(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::PHYSICAL_IMPACT, 0);
	    }

	    public function ESPIONAGE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::ESPIONAGE, 0);
	    }

	    public function SABOTAGE(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SABOTAGE, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitImpactTypeValue($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class NotesPropContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_notesProp;
	    }

	    public function NOTES(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::NOTES, 0);
	    }

	    public function COLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::COLON, 0);
	    }

	    public function STRING(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::STRING, 0);
	    }

	    public function SEMICOLON(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::SEMICOLON, 0);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitNotesProp($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 

	class StringArrayContext extends ParserRuleContext
	{
		public function __construct(?ParserRuleContext $parent, ?int $invokingState = null)
		{
			parent::__construct($parent, $invokingState);
		}

		public function getRuleIndex(): int
		{
		    return AttackDSLParser::RULE_stringArray;
	    }

	    public function LBRACKET(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::LBRACKET, 0);
	    }

	    public function RBRACKET(): ?TerminalNode
	    {
	        return $this->getToken(AttackDSLParser::RBRACKET, 0);
	    }

	    /**
	     * @return array<TerminalNode>|TerminalNode|null
	     */
	    public function STRING(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTokens(AttackDSLParser::STRING);
	    	}

	        return $this->getToken(AttackDSLParser::STRING, $index);
	    }

	    /**
	     * @return array<TerminalNode>|TerminalNode|null
	     */
	    public function COMMA(?int $index = null)
	    {
	    	if ($index === null) {
	    		return $this->getTokens(AttackDSLParser::COMMA);
	    	}

	        return $this->getToken(AttackDSLParser::COMMA, $index);
	    }

		public function accept(ParseTreeVisitor $visitor): mixed
		{
			if ($visitor instanceof AttackDSLVisitor) {
			    return $visitor->visitStringArray($this);
		    }

			return $visitor->visitChildren($this);
		}
	} 
}