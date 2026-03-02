<?php

declare(strict_types=1);

namespace ElementO\Domain\Category;

enum AttackCategory: string
{
    case SocialEngineering = 'SOCIAL_ENGINEERING';
    case Malware           = 'MALWARE';
    case Network           = 'NETWORK';
    case Application       = 'APPLICATION';
    case Cloud             = 'CLOUD';
    case Iot               = 'IOT';
    case Mobile            = 'MOBILE';
    case SupplyChain       = 'SUPPLY_CHAIN';
    case Physical          = 'PHYSICAL';
    case Cryptographic     = 'CRYPTOGRAPHIC';
    case AiMl              = 'AI_ML';
    case Quantum           = 'QUANTUM';

    // Human-readable label 

    public function label(): string
    {
        return match ($this) {
            self::SocialEngineering => 'Social Engineering',
            self::Malware           => 'Malware',
            self::Network           => 'Network Attacks',
            self::Application       => 'Application Attacks',
            self::Cloud             => 'Cloud Attacks',
            self::Iot               => 'IoT Attacks',
            self::Mobile            => 'Mobile Attacks',
            self::SupplyChain       => 'Supply Chain',
            self::Physical          => 'Physical Attacks',
            self::Cryptographic     => 'Cryptographic Attacks',
            self::AiMl              => 'AI / ML Attacks',
            self::Quantum           => 'Quantum Threats',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::SocialEngineering => 'Human manipulation: phishing, pretexting, BEC, smishing',
            self::Malware           => 'Malicious software: ransomware, trojans, keyloggers, wipers',
            self::Network           => 'Network-layer attacks: DDoS, MITM, DNS tunnelling, ARP spoofing',
            self::Application       => 'App-layer exploits: SQLi, XSS, SSRF, deserialization',
            self::Cloud             => 'Cloud misconfigurations, IAM abuse, serverless attacks',
            self::Iot               => 'Embedded device exploitation, firmware attacks',
            self::Mobile            => 'Android/iOS malware, smishing, rogue MDM profiles',
            self::SupplyChain       => 'Third-party compromise: SolarWinds, XZ Utils style attacks',
            self::Physical          => 'Physical intrusion, USB drops, hardware implants',
            self::Cryptographic     => 'Weak cipher attacks, certificate spoofing, hash collisions',
            self::AiMl              => 'Adversarial ML, model poisoning, prompt injection',
            self::Quantum           => 'Harvest-now-decrypt-later, post-quantum migration risks',
        };
    }

    public function cssToken(): string
    {
        return match ($this) {
            self::SocialEngineering => 'social-engineering',
            self::Malware           => 'malware',
            self::Network           => 'network',
            self::Application       => 'application',
            self::Cloud             => 'cloud',
            self::Iot               => 'iot',
            self::Mobile            => 'mobile',
            self::SupplyChain       => 'supply-chain',
            self::Physical          => 'physical',
            self::Cryptographic     => 'cryptographic',
            self::AiMl              => 'ai-ml',
            self::Quantum           => 'quantum',
        };
    }

    public function mitreUrl(): ?string
    {
        return match ($this) {
            self::SocialEngineering => 'https://attack.mitre.org/tactics/TA0043/',  
            self::Malware           => 'https://attack.mitre.org/tactics/TA0002/',  
            self::Network           => 'https://attack.mitre.org/tactics/TA0011/',  
            self::Application       => 'https://attack.mitre.org/tactics/TA0001/',  
            self::Cloud             => 'https://attack.mitre.org/matrices/enterprise/cloud/',
            self::Iot               => 'https://attack.mitre.org/matrices/ics/',
            self::Mobile            => 'https://attack.mitre.org/matrices/mobile/',
            self::SupplyChain       => 'https://attack.mitre.org/techniques/T1195/', 
            self::Physical          => 'https://attack.mitre.org/techniques/T1200/', 
            self::Cryptographic     => 'https://attack.mitre.org/techniques/T1600/', 
            self::AiMl              => 'https://atlas.mitre.org/',                 
            self::Quantum           => null,                                          
        };
    }

    public function faIcon(): string
    {
        return match ($this) {
            self::SocialEngineering => 'fa-fish-fins',        
            self::Malware           => 'fa-bug',             
            self::Network           => 'fa-network-wired',    
            self::Application       => 'fa-code',             
            self::Cloud             => 'fa-cloud',            
            self::Iot               => 'fa-microchip',        
            self::Mobile            => 'fa-mobile-screen',    
            self::SupplyChain       => 'fa-boxes-stacked',    
            self::Physical          => 'fa-lock-open',       
            self::Cryptographic     => 'fa-key',              
            self::AiMl              => 'fa-robot',            
            self::Quantum           => 'fa-atom',            
        };
    }

    public function reportCode(): string
    {
        return match ($this) {
            self::SocialEngineering => 'SE',
            self::Malware           => 'MAL',
            self::Network           => 'NET',
            self::Application       => 'APP',
            self::Cloud             => 'CLOUD',
            self::Iot               => 'IOT',
            self::Mobile            => 'MOB',
            self::SupplyChain       => 'SCM',
            self::Physical          => 'PHYS',
            self::Cryptographic     => 'CRYPT',
            self::AiMl              => 'AIML',
            self::Quantum           => 'QNT',
        };
    }

    // Factory 

    public static function fromDsl(string $raw): self
    {
        return self::from($raw);   
    }

    /**
     * @return list<self>
     */
    public static function navigationOrder(): array
    {
        return [
            self::SocialEngineering,
            self::Malware,
            self::Network,
            self::Application,
            self::Cloud,
            self::Mobile,
            self::Iot,
            self::SupplyChain,
            self::Physical,
            self::Cryptographic,
            self::AiMl,
            self::Quantum,
        ];
    }
}
