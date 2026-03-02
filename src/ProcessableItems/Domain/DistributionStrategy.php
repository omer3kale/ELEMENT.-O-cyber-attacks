<?php

declare(strict_types=1);

namespace ElementO\ProcessableItems\Domain;

enum DistributionStrategy: string
{
    case EVEN           = 'EVEN';
    case RANDOM_SPACED  = 'RANDOM_SPACED';
    case WEIGHTED       = 'WEIGHTED';
}
