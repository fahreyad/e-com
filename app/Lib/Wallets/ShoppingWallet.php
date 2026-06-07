<?php

namespace App\Lib\Wallets;

use App\Enums\PaymentMethod;
use App\Models\User;

class ShoppingWallet implements Wallet
{
    use Commons;

    public function getName(): string
    {
        return 'Shopping Wallet';
    }

    public function getEnum(): \App\Enums\Wallet
    {
        return \App\Enums\Wallet::ShoppingWallet();
    }

    public function getColumn(): string
    {
        return 'shopping_wallet';
    }
}
