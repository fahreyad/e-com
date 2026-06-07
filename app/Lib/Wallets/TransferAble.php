<?php

namespace App\Lib\Wallets;

use Illuminate\Database\Eloquent\Model;

interface TransferAble
{
    public function minimumTransferAmount(): float;

    public function maximumTransferAmount(): float;

    public function totalTransferOutFor(Model $model): float;

    public function totalTransferInFor(Model $model): float;
}
