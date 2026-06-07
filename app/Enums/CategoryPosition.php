<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static HomePageTop() 
 * @method static static HomePageMedial() 
 * @method static static HomePageBottom() 
 * @method static static BannerTwo() 
 * @method static static BannerThree() 
 */
final class CategoryPosition extends Enum
{
    const HomePageTop = 1;
    const HomePageMedial = 2;
    const HomePageBottom = 3;
    const BannerTwo = 4;
    const BannerThree = 5;
}
