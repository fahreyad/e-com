<?php

namespace App\Lib\Wallets;

use App\Enums\CashInStatus;
use App\Enums\PaymentMethod;
use App\Enums\TransactionType;
use App\Models\CashInLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WalletManager
{
    /**
     * @return array<\App\Lib\Wallets\Wallet>
     */
    public static function all()
    {
        return array_map('app', [
            CurrentWallet::class,
            ShoppingWallet::class,
            CommissionWallet::class,
            PVWallet::class,
            SavingWallet::class,
            CashBackWallet::class,
            AgentWallet::class,
        ]);
    }

    public static function get(\App\Enums\Wallet $enum): Wallet
    {
        foreach (static::all() as $wallet) {
            if ($wallet->getEnum()->is($enum)) {
                return $wallet;
            }
        }
        throw new \Exception('No wallet found for '.$enum->key);
    }

    public static function cashInAbles()
    {
        return array_filter(static::all(), function ($wallet) {
            return $wallet instanceof CashInAble;
        });
    }

    public static function cashInAblesFor(string $model)
    {
        return array_filter(static::cashInAbles(), function ($wallet) use ($model) {
            return in_array($model, $wallet->allowedCashInModels());
        });
    }

    public static function transferAble()
    {
        return array_filter(static::all(), function ($wallet) {
            return $wallet instanceof TransferAble;
        });
    }

    public static function withdrawAbles()
    {
        return array_filter(static::all(), function ($wallet) {
            return $wallet instanceof WithdrawAble;
        });
    }

    public static function withdrawAblesFor(string $model)
    {
        return array_filter(static::withdrawAbles(), function ($wallet) use ($model) {
            return in_array($model, $wallet->allowedWithdrawModels());
        });
    }

    public static function cashIn(Model $target, Wallet $wallet, PaymentMethod $method, float $amount, string $message = '', CashInStatus $status = null, CashInLog $log = null)
    {
        $status = $status ?? CashInStatus::Pending();
        try {
            DB::beginTransaction();
            if (is_null($log)) {
                CashInLog::create([
                    'target_type' => get_class($target),
                    'target_id' => $target->getKey(),
                    'amount' => $amount,
                    'status' => $status->value,
                    'wallet' => $wallet->getEnum()->value,
                    'method' => $method->value,
                    'message' => $message,
                ]);
            }
            $target->incrementWallet($wallet, TransactionType::TransferShare(), $amount, $message, false);
            $target->{$wallet->getColumn().'_cash_in'} += $amount;
            $target->save();
            DB::commit();

            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
throw $ex;
            return false;
        }
    }
}
