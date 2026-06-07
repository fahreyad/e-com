<?php

namespace App\Traits;

use Carbon\Carbon;

trait HasInstallments
{
    public function shouldCreateInstallment()
    {
        $existing = $this->installments()->count();

        if ($this->isMatured($existing)) return false;

        $startDate = Carbon::parse($this->created_at)->startOfDay();

        $nextDueDate = $startDate->copy();

        $frequency = method_exists($this, 'getInstallmentFrequency')
            ? $this->getInstallmentFrequency()
            : 'monthly';
        // return true;
        if ($frequency === 'Weekly') {
            $nextDueDate = $nextDueDate->addWeeks($existing);
        } else {
            $nextDueDate = $nextDueDate->addMonths($existing);
        }

        return now()->startOfDay()->equalTo($nextDueDate);
    }

    public function isMatured($installmentCount = null): bool
    {
        $total = $this->getInstallmentCount();
        if (is_int($installmentCount)) {
            $existing = $installmentCount;
        } else {
            $existing = $this->installments()->count();
        }

        if ($existing >= $total) {
            return true;
        }

        return false;
    }
}
