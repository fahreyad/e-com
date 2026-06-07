<?php

namespace App\Lib\Wallets;

class PVWallet implements Wallet
{
    use Commons;

    public function getName(): string
    {
        return 'PV Wallet';
    }

    public function getEnum(): \App\Enums\Wallet
    {
        return \App\Enums\Wallet::PVWallet();
    }

    public function getColumn(): string
    {
        return 'pv_wallet';
    }
}
