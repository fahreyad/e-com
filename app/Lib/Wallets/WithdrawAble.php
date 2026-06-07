<?php

namespace App\Lib\Wallets;

use Illuminate\Database\Eloquent\Model;

interface WithdrawAble
{
    public function minimumWithdrawAmount(): float;

    public function maximumWithdrawAmount(): float;

    public function getTotalWithdrawAmountFor(Model $model): float;

    public function allowedWithdrawMethods(): array;

    public function allowedWithdrawModels(): array;
}
