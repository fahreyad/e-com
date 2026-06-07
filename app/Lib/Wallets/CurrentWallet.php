<?php

namespace App\Lib\Wallets;

use App\Enums\PaymentMethod;
use App\Models\User;

class CurrentWallet implements Wallet, CashInAble
{
    use Commons;

    public function getName(): string
    {
        return 'Current Wallet';
    }

    public function getEnum(): \App\Enums\Wallet
    {
        return \App\Enums\Wallet::CurrentWallet();
    }

    public function getColumn(): string
    {
        return 'share_wallet';
    }

    public function minimumCashInAmount(): float
    {
        return config('site.minimum_cash_in');
    }

    public function maximumCashInAmount(): float
    {
        return config('site.maximum_cash_in');
    }

    public function allowedCashInMethods(): array
    {
        return PaymentMethod::asArray();
    }

    public function allowedCashInModels(): array
    {
        return [User::class];
    }
}
