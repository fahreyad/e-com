<?php

namespace App\Lib\Wallets;

use Illuminate\Database\Eloquent\Model;

interface Wallet
{
    public function getName(): string;

    public function getEnum(): \App\Enums\Wallet;

    public function getColumn(): string;

    public function getBalanceFor(Model $model): float;

    public function getTotalInFor(Model $model): float;

    public function getTotalOutFor(Model $model): float;
}
