<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static BestSale() 
 * @method static static NewArrival() 
 * @method static static Variation() 
 */
final class ProductStatus extends Enum
{
    const BestSale = 1;
    const NewArrival = 2;
    const Variation = 3;
}
