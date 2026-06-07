<?php

namespace App\Lib\Wallets;

use App\Enums\PaymentMethod;
use App\Models\User;

class SavingWallet implements Wallet, WithdrawAble
{
    use Commons;

    public function getName(): string
    {
        return 'Saving Wallet';
    }

    public function getEnum(): \App\Enums\Wallet
    {
        return \App\Enums\Wallet::SavingWallet();
    }

    public function getColumn(): string
    {
        return 'saving_wallet';
    }

    public function minimumWithdrawAmount(): float
    {
        return config('site.minimum_withdraw');
    }

    public function maximumWithdrawAmount(): float
    {
        return 100000;
    }

    public function allowedWithdrawMethods(): array
    {
        return [
            PaymentMethod::ByAdmin,
        ];
    }

    public function allowedWithdrawModels(): array
    {
        return [
            User::class,
        ];
    }
}
