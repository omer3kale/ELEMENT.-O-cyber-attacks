<?php

declare(strict_types=1);

namespace ElementO\Domain\Category;


enum KillChainPhase: string
{
    case Reconnaissance      = 'RECONNAISSANCE';
    case Weaponization       = 'WEAPONIZATION';
    case Delivery            = 'DELIVERY';
    case Exploitation        = 'EXPLOITATION';
    case Installation        = 'INSTALLATION';
    case C2                  = 'C2';
    case ActionsOnObjectives = 'ACTIONS_ON_OBJECTIVES';

    // Display 

    public function label(): string
    {
        return match ($this) {
            self::Reconnaissance      => 'Reconnaissance',
            self::Weaponization       => 'Weaponization',
            self::Delivery            => 'Delivery',
            self::Exploitation        => 'Exploitation',
            self::Installation        => 'Installation',
            self::C2                  => 'Command & Control (C2)',
            self::ActionsOnObjectives => 'Actions on Objectives',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Reconnaissance      => 'Attacker gathers intelligence about the target (OSINT, scanning)',
            self::Weaponization       => 'Exploit + payload combined into a deliverable weapon',
            self::Delivery            => 'Weapon transmitted to target (email, USB, watering hole)',
            self::Exploitation        => 'Weapon triggers, exploiting a vulnerability in the target',
            self::Installation        => 'Malware/backdoor installed on compromised system',
            self::C2                  => 'Attacker establishes persistent remote control channel',
            self::ActionsOnObjectives => 'Goal achieved: data theft, encryption, destruction',
        };
    }

   
    public function phaseNumber(): int
    {
        return match ($this) {
            self::Reconnaissance      => 1,
            self::Weaponization       => 2,
            self::Delivery            => 3,
            self::Exploitation        => 4,
            self::Installation        => 5,
            self::C2                  => 6,
            self::ActionsOnObjectives => 7,
        };
    }

    /**
     * @return list<string>
     */
    public function mitreTacticIds(): array
    {
        return match ($this) {
            self::Reconnaissance      => ['TA0043'],                    
            self::Weaponization       => ['TA0001'],                    
            self::Delivery            => ['TA0001', 'TA0002'],          
            self::Exploitation        => ['TA0004', 'TA0005', 'TA0006'],
            self::Installation        => ['TA0003'],                    
            self::C2                  => ['TA0011'],                    
            self::ActionsOnObjectives => ['TA0009', 'TA0010', 'TA0040'],
        };
    }

    /**
     * @return list<self>
     */
    public static function orderedPhases(): array
    {
        return [
            self::Reconnaissance,
            self::Weaponization,
            self::Delivery,
            self::Exploitation,
            self::Installation,
            self::C2,
            self::ActionsOnObjectives,
        ];
    }

    // Factory 

    public static function fromDsl(string $raw): self
    {
        return self::from($raw);
    }
}
