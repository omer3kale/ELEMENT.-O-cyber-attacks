
grammar AttackDSL;


// PARSER RULES


/**
 * Root rule — a file contains one or more attack definitions.
 *
 *   attackCollection: attackDefinition+ EOF ;
 */
attackCollection
    : attackDefinition+ EOF
    ;

/**
 * Top-level attack block.
 *
 *   attack PhishingMicrosoft {
 *     mitre_id    : "T1566.001" ;
 *     category    : SOCIAL_ENGINEERING ;
 *     difficulty  : HARD ;
 *     realWorldCase { ... }      
 *     <properties>+
 *   }
 */
attackDefinition
    : ATTACK IDENTIFIER LBRACE
          mitreId
          category
          difficulty
          realWorldCase?
          attackProperty+
      RBRACE SEMICOLON?
    ;

// Required scalar properties 

/**
 * mitre_id : "T1566" ;
 * mitre_id : "T1566.001" ;   
 */
mitreId
    : MITRE_ID COLON STRING SEMICOLON
    ;

/**
 * category : SOCIAL_ENGINEERING ;
 *
 * Allowed values (validated by semantic analysis, not grammar):
 *   SOCIAL_ENGINEERING | MALWARE | NETWORK | APPLICATION |
 *   CLOUD | IOT | MOBILE | SUPPLY_CHAIN | PHYSICAL |
 *   CRYPTOGRAPHIC | AI_ML | QUANTUM
 */
category
    : CATEGORY COLON categoryValue SEMICOLON
    ;

categoryValue
    : SOCIAL_ENGINEERING
    | MALWARE
    | NETWORK
    | APPLICATION
    | CLOUD
    | IOT
    | MOBILE
    | SUPPLY_CHAIN
    | PHYSICAL
    | CRYPTOGRAPHIC
    | AI_ML
    | QUANTUM
    ;

/**
 * difficulty : HARD ;
 *
 * Allowed values:
 *   TRIVIAL | EASY | MEDIUM | HARD | EXPERT | NATION_STATE
 */
difficulty
    : DIFFICULTY COLON difficultyValue SEMICOLON
    ;

difficultyValue
    : TRIVIAL
    | EASY
    | MEDIUM
    | HARD
    | EXPERT
    | NATION_STATE
    ;

// Optional top-level block ─

/**
 * realWorldCase {
 *   year   : 2017 ;
 *   victim : "NHS (UK National Health Service)" ;
 *   impact : "£92M damages, 80 NHS trusts affected" ;
 * }
 */
realWorldCase
    : REAL_WORLD_CASE LBRACE
          realWorldYear
          realWorldVictim
          realWorldImpact
          realWorldAttribution?
      RBRACE SEMICOLON?
    ;

realWorldYear
    : YEAR COLON INTEGER SEMICOLON
    ;

realWorldVictim
    : VICTIM COLON STRING SEMICOLON
    ;

realWorldImpact
    : IMPACT COLON STRING SEMICOLON
    ;

/**
 * attribution : "Lazarus Group (DPRK)" ;   
 */
realWorldAttribution
    : ATTRIBUTION COLON STRING SEMICOLON
    ;

// Attack property dispatch 

/**
 * All remaining named properties inside an attack block.
 * Each maps to exactly one concrete property form.
 */
attackProperty
    : attackVectorProp          # AttackVectorProperty
    | targetProfileProp         # TargetProfileProperty
    | successRateProp           # SuccessRateProperty
    | averageImpactProp         # AverageImpactProperty
    | deliveryMethodProp        # DeliveryMethodProperty
    | detectionDifficultyProp   # DetectionDifficultyProperty
    | preventionMeasuresProp    # PreventionMeasuresProperty
    | brandImpersonationProp    # BrandImpersonationProperty
    | cveReferencesProp         # CveReferencesProperty
    | toolsUsedProp             # ToolsUsedProperty
    | attributionProp           # AttributionProperty
    | capecIdProp               # CapecIdProperty
    | killChainPhaseProp        # KillChainPhaseProperty
    | dataSourcesProp           # DataSourcesProperty
    | mitigationsProp           # MitigationsProperty
    | platformsProp             # PlatformsProperty
    | privilegeRequiredProp     # PrivilegeRequiredProperty
    | impactTypeProp            # ImpactTypeProperty
    | notesProp                 # NotesProperty
    ;

// Required attack properties 

/**
 * attack_vector : "Malicious email attachment with .pdf.exe double extension" ;
 */
attackVectorProp
    : ATTACK_VECTOR COLON STRING SEMICOLON
    ;

/**
 * target_profile : "Corporate Finance Departments, SMEs, enterprises" ;
 */
targetProfileProp
    : TARGET_PROFILE COLON STRING SEMICOLON
    ;

/**
 * success_rate : "45-65%" ;
 * Lexer enforces the MIN-MAX% format via RATE_RANGE token.
 */
successRateProp
    : SUCCESS_RATE COLON (RATE_RANGE | STRING) SEMICOLON
    ;

/**
 * average_impact : "€87,000 average wire transfer loss" ;
 */
averageImpactProp
    : AVERAGE_IMPACT COLON STRING SEMICOLON
    ;

/**
 * delivery_method : "Email with weaponised Office document (macro enabled)" ;
 */
deliveryMethodProp
    : DELIVERY_METHOD COLON STRING SEMICOLON
    ;

/**
 * detection_difficulty : HIGH ;
 *
 * Allowed values:
 *   TRIVIAL | LOW | MEDIUM | HIGH | NEARLY_IMPOSSIBLE
 */
detectionDifficultyProp
    : DETECTION_DIFFICULTY COLON detectionLevel SEMICOLON
    ;

detectionLevel
    : TRIVIAL
    | LOW
    | MEDIUM
    | HIGH
    | NEARLY_IMPOSSIBLE
    ;

/**
 * prevention_measures : [
 *   "Enable MFA on all accounts",
 *   "Anti-phishing email gateway",
 *   "Security awareness training"
 * ] ;
 */
preventionMeasuresProp
    : PREVENTION_MEASURES COLON stringArray SEMICOLON
    ;

// Optional attack properties 

/**
 * brand_impersonation {
 *   real_brand    : "Microsoft" ;
 *   spoof_variant : "Micnosoft (n→n character substitution)" ;
 * }
 */
brandImpersonationProp
    : BRAND_IMPERSONATION LBRACE
          REAL_BRAND    COLON STRING SEMICOLON
          SPOOF_VARIANT COLON STRING SEMICOLON
      RBRACE SEMICOLON?
    ;

/**
 * cve_references : [ "CVE-2017-0144", "CVE-2017-0145" ] ;
 */
cveReferencesProp
    : CVE_REFERENCES COLON stringArray SEMICOLON
    ;

/**
 * tools_used : [ "Metasploit", "Cobalt Strike", "Mimikatz" ] ;
 */
toolsUsedProp
    : TOOLS_USED COLON stringArray SEMICOLON
    ;

/**
 * attribution : "APT28 (Fancy Bear, GRU Unit 26165)" ;
 * Top-level property variant (outside realWorldCase).
 */
attributionProp
    : ATTRIBUTION COLON STRING SEMICOLON
    ;

/**
 * capec_id : "CAPEC-98" ;
 */
capecIdProp
    : CAPEC_ID COLON STRING SEMICOLON
    ;

/**
 * kill_chain_phase : EXPLOITATION ;
 *
 * Lockheed Martin Cyber Kill Chain phases:
 *   RECONNAISSANCE | WEAPONIZATION | DELIVERY |
 *   EXPLOITATION | INSTALLATION | C2 | ACTIONS_ON_OBJECTIVES
 */
killChainPhaseProp
    : KILL_CHAIN_PHASE COLON killChainValue SEMICOLON
    ;

killChainValue
    : RECONNAISSANCE
    | WEAPONIZATION
    | DELIVERY
    | EXPLOITATION
    | INSTALLATION
    | C2
    | ACTIONS_ON_OBJECTIVES
    ;

/**
 * data_sources : [ "Email gateway logs", "Endpoint telemetry", "DNS logs" ] ;
 */
dataSourcesProp
    : DATA_SOURCES COLON stringArray SEMICOLON
    ;

/**
 * mitigations : [ "M1049", "M1031", "M1017" ] ;   
 */
mitigationsProp
    : MITIGATIONS COLON stringArray SEMICOLON
    ;

/**
 * platforms : [ "Windows", "macOS", "Linux", "SaaS" ] ;
 */
platformsProp
    : PLATFORMS COLON stringArray SEMICOLON
    ;

/**
 * privilege_required : USER ;
 *
 * Allowed: NONE | USER | ADMINISTRATOR | SYSTEM | ROOT
 */
privilegeRequiredProp
    : PRIVILEGE_REQUIRED COLON privilegeLevel SEMICOLON
    ;

privilegeLevel
    : NONE_PRIV    // maps keyword NONE to avoid conflict with detectionLevel
    | USER_PRIV
    | ADMINISTRATOR
    | SYSTEM_PRIV
    | ROOT
    ;

/**
 * impact_type : FINANCIAL ;
 *
 * Allowed:
 *   FINANCIAL | DATA_THEFT | SERVICE_DISRUPTION |
 *   REPUTATIONAL | PHYSICAL | ESPIONAGE | SABOTAGE
 */
impactTypeProp
    : IMPACT_TYPE COLON impactTypeValue SEMICOLON
    ;

impactTypeValue
    : FINANCIAL
    | DATA_THEFT
    | SERVICE_DISRUPTION
    | REPUTATIONAL
    | PHYSICAL_IMPACT
    | ESPIONAGE
    | SABOTAGE
    ;

/**
 * notes : "Double-extortion: exfiltrate then encrypt. ALPHV/BlackCat successor." ;
 */
notesProp
    : NOTES COLON STRING SEMICOLON
    ;

// Shared utility rules 

/**
 * Generic string array: [ "value1", "value2", ... ]
 */
stringArray
    : LBRACKET (STRING (COMMA STRING)*)? RBRACKET
    ;


// LEXER RULES  (order matters — more specific first)


// Structure keywords 
ATTACK              : 'attack' ;
REAL_WORLD_CASE     : 'real_world_case' ;
BRAND_IMPERSONATION : 'brand_impersonation' ;

// Property keywords 
MITRE_ID            : 'mitre_id' ;
CATEGORY            : 'category' ;
DIFFICULTY          : 'difficulty' ;
ATTACK_VECTOR       : 'attack_vector' ;
TARGET_PROFILE      : 'target_profile' ;
SUCCESS_RATE        : 'success_rate' ;
AVERAGE_IMPACT      : 'average_impact' ;
DELIVERY_METHOD     : 'delivery_method' ;
DETECTION_DIFFICULTY: 'detection_difficulty' ;
PREVENTION_MEASURES : 'prevention_measures' ;
CVE_REFERENCES      : 'cve_references' ;
TOOLS_USED          : 'tools_used' ;
ATTRIBUTION         : 'attribution' ;
CAPEC_ID            : 'capec_id' ;
KILL_CHAIN_PHASE    : 'kill_chain_phase' ;
DATA_SOURCES        : 'data_sources' ;
MITIGATIONS         : 'mitigations' ;
PLATFORMS           : 'platforms' ;
PRIVILEGE_REQUIRED  : 'privilege_required' ;
IMPACT_TYPE         : 'impact_type' ;
NOTES               : 'notes' ;

// Sub-block field keywords 
YEAR                : 'year' ;
VICTIM              : 'victim' ;
IMPACT              : 'impact' ;
REAL_BRAND          : 'real_brand' ;
SPOOF_VARIANT       : 'spoof_variant' ;

// Category enum values 
SOCIAL_ENGINEERING  : 'SOCIAL_ENGINEERING' ;
MALWARE             : 'MALWARE' ;
NETWORK             : 'NETWORK' ;
APPLICATION         : 'APPLICATION' ;
CLOUD               : 'CLOUD' ;
IOT                 : 'IOT' ;
MOBILE              : 'MOBILE' ;
SUPPLY_CHAIN        : 'SUPPLY_CHAIN' ;
PHYSICAL            : 'PHYSICAL' ;
CRYPTOGRAPHIC       : 'CRYPTOGRAPHIC' ;
AI_ML               : 'AI_ML' ;
QUANTUM             : 'QUANTUM' ;

// ── Difficulty / Detection level enum values ──
TRIVIAL             : 'TRIVIAL' ;
EASY                : 'EASY' ;
MEDIUM              : 'MEDIUM' ;
HARD                : 'HARD' ;
EXPERT              : 'EXPERT' ;
NATION_STATE        : 'NATION_STATE' ;
LOW                 : 'LOW' ;
HIGH                : 'HIGH' ;
NEARLY_IMPOSSIBLE   : 'NEARLY_IMPOSSIBLE' ;

// Kill chain enum values
RECONNAISSANCE      : 'RECONNAISSANCE' ;
WEAPONIZATION       : 'WEAPONIZATION' ;
DELIVERY            : 'DELIVERY' ;
EXPLOITATION        : 'EXPLOITATION' ;
INSTALLATION        : 'INSTALLATION' ;
C2                  : 'C2' ;
ACTIONS_ON_OBJECTIVES : 'ACTIONS_ON_OBJECTIVES' ;

// Privilege level enum values
// Prefixed to avoid clash with other enums
NONE_PRIV           : 'NONE' ;
USER_PRIV           : 'USER' ;
ADMINISTRATOR       : 'ADMINISTRATOR' ;
SYSTEM_PRIV         : 'SYSTEM' ;
ROOT                : 'ROOT' ;

// Impact type enum values 
FINANCIAL           : 'FINANCIAL' ;
DATA_THEFT          : 'DATA_THEFT' ;
SERVICE_DISRUPTION  : 'SERVICE_DISRUPTION' ;
REPUTATIONAL        : 'REPUTATIONAL' ;
PHYSICAL_IMPACT     : 'PHYSICAL_IMPACT' ;
ESPIONAGE           : 'ESPIONAGE' ;
SABOTAGE            : 'SABOTAGE' ;

// Punctuation tokens 
LBRACE              : '{' ;
RBRACE              : '}' ;
LBRACKET            : '[' ;
RBRACKET            : ']' ;
COLON               : ':' ;
SEMICOLON           : ';' ;
COMMA               : ',' ;

// Literals

/**
 * Success-rate range literal: "15-25%"
 * Matches directly without quotes so it can be used unquoted:
 *   success_rate : 15-25% ;
 * Quoted form falls back to STRING and is also accepted by the parser.
 */
RATE_RANGE
    : [0-9]+ '-' [0-9]+ '%'
    ;

/**
 * Integer literal (used for 'year').
 */
INTEGER
    : [0-9]+
    ;

/**
 * Double-quoted string with standard escape sequences.
 * Supports multi-line content via \n inside the string.
 *
 *   "Line one\nLine two"
 *   "Path: C:\\Users\\victim"
 *   "Quote: \"hello\""
 */
STRING
    : '"' ( EscapeSequence | ~["\\\r\n] | '\r'? '\n' )* '"'
    ;

fragment EscapeSequence
    : '\\' [btnfr"'\\]    // standard Java-style escapes
    | '\\' 'u' HexDigit HexDigit HexDigit HexDigit  // unicode
    ;

fragment HexDigit
    : [0-9a-fA-F]
    ;

/**
 * Identifier: attack block name, e.g. PhishingMicrosoft_T1566
 * Allows letters, digits, underscores, hyphens.
 * Must start with a letter or underscore.
 */
IDENTIFIER
    : [a-zA-Z_][a-zA-Z0-9_\-]*
    ;

// Whitespace and comments — skip silently 

WS
    : [ \t\r\n]+ -> skip
    ;

LINE_COMMENT
    : '//' ~[\r\n]* -> skip
    ;

BLOCK_COMMENT
    : '/*' .*? '*/' -> skip
    ;
