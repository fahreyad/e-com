<?php

namespace App\Lib\Wallets;

use Illuminate\Database\Eloquent\Model;

interface CashInAble
{
    public function minimumCashInAmount(): float;

    public function maximumCashInAmount(): float;

    public function getTotalCashInAmountFor(Model $model): float;

    public function allowedCashInMethods(): array;

    public function allowedCashInModels(): array;
}
