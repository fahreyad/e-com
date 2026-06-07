<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static AddToCart()
 * @method static static BuyNow() 
 */
final class ProductAddCartStatus extends Enum
{
    const AddToCart =   0;
    const BuyNow =   1;
}
