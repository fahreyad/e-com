<?php

namespace App\Lib\Wallets;

class CashBackWallet implements Wallet
{
    use Commons;

    public function getName(): string
    {
        return 'CashBack Wallet';
    }

    public function getEnum(): \App\Enums\Wallet
    {
        return \App\Enums\Wallet::CashbackWallet();
    }

    public function getColumn(): string
    {
        return 'cashback_wallet';
    }
}
