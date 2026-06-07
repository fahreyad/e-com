<?php

namespace App\Lib\Wallets;

use Illuminate\Database\Eloquent\Model;

trait Commons
{
    public function getBalanceFor(Model $model): float
    {
        return $model->{$this->getColumn()};
    }

    public function getTotalInFor(Model $model): float
    {
        return $model->{$this->getColumn().'_in'};
    }

    public function getTotalOutFor(Model $model): float
    {
        return $model->{$this->getColumn().'_out'};
    }

    public function getTotalWithdrawAmountFor(Model $model): float
    {
        return $model->{$this->getColumn().'_withdraw'};
    }

    public function getTotalCashInAmountFor(Model $model): float
    {
        return $model->{$this->getColumn().'_cash_in'};
    }

    public function totalTransferOutFor(Model $model): float
    {
        return $model->{$this->getColumn().'_send'};
    }

    public function totalTransferInFor(Model $model): float
    {
        return $model->{$this->getColumn().'_received'};
    }
}
