<?php

namespace App\Lib\Wallets;

use App\Enums\PaymentMethod;
use App\Models\User;

class AgentWallet implements Wallet
{
    use Commons;

    public function getName(): string
    {
        return 'Agent Wallet';
    }

    public function getEnum(): \App\Enums\Wallet
    {
        return \App\Enums\Wallet::AgentWallet();
    }

    public function getColumn(): string
    {
        return 'agent_wallet';
    }
}
