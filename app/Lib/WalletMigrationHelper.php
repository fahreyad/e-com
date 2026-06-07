<?php

namespace App\Lib;

use App\Lib\Wallets\CashInAble;
use App\Lib\Wallets\TransferAble;
use App\Lib\Wallets\Wallet;
use App\Lib\Wallets\WithdrawAble;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WalletMigrationHelper
{
    public static function addWallet(Wallet &$wallet, Blueprint &$table)
    {
        $columns = Schema::getColumnListing($table->getTable());

        if (! in_array($wallet->getColumn(), $columns)) {
            $table->decimal($wallet->getColumn(), 12, DIGITS)->default(0);
            $table->unsignedDecimal($wallet->getColumn().'_in', 12, DIGITS)->default(0);
            $table->unsignedDecimal($wallet->getColumn().'_out', 12, DIGITS)->default(0);
        }

        if ($wallet instanceof CashInAble && ! in_array($wallet->getColumn().'_cash_in', $columns)) {
            $table->unsignedDecimal($wallet->getColumn().'_cash_in', 12, DIGITS)->default(0);
        }
        if ($wallet instanceof WithdrawAble && ! in_array($wallet->getColumn().'_withdraw', $columns)) {
            $table->unsignedDecimal($wallet->getColumn().'_withdraw', 12, DIGITS)->default(0);
        }
        if ($wallet instanceof TransferAble && ! in_array($wallet->getColumn().'_send', $columns)) {
            $table->unsignedDecimal($wallet->getColumn().'_send', 12, DIGITS)->default(0);
            $table->unsignedDecimal($wallet->getColumn().'_received', 12, DIGITS)->default(0);
        }
    }

    public static function removeWallet(Wallet &$wallet, Blueprint &$table)
    {
        $columns = Schema::getColumnListing($table->getTable());

        if (in_array($wallet->getColumn(), $columns)) {
            $table->dropColumn($wallet->getColumn());
            $table->dropColumn($wallet->getColumn().'_in');
            $table->dropColumn($wallet->getColumn().'_out');
        }
        if ($wallet instanceof CashInAble && in_array($wallet->getColumn().'_cash_in', $columns)) {
            $table->dropColumn($wallet->getColumn().'_cash_in');
        }
        if ($wallet instanceof WithdrawAble && in_array($wallet->getColumn().'_withdraw', $columns)) {
            $table->dropColumn($wallet->getColumn().'_withdraw');
        }
        if ($wallet instanceof TransferAble && in_array($wallet->getColumn().'_send', $columns)) {
            $table->dropColumn($wallet->getColumn().'_send');
            $table->dropColumn($wallet->getColumn().'_received');
        }
    }
}
