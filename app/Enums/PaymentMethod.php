<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ByAdmin()
 * @method static static bKash()
 */
final class PaymentMethod extends Enum
{
    const ByAdmin =   0;
    const bKash = 1;
}
