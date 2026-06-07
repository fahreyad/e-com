<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Pending()
 * @method static static Delivered()
 * @method static static Cancelled()
 
 
 */
final class OrderStatus extends Enum
{
    const Pending =   0;
    const Processing = 1;
    const Delivered = 2;
    const Cancelled = 3;
}
