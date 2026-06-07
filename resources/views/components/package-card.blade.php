<form action="{{ route('loan.store') }}" method="POST"
    class="p-6 bg-white rounded-lg shadow hover:shadow-md border border-gray-100">
    @csrf
    <input type="hidden" name="loan_package_id" value="{{ $item->id }}">

    <div class="flex items-center justify-between mb-2">
        <h3 class="text-lg font-semibold text-gray-800">
            {{ $item->status->value === \App\Enums\LoanStatus::Monthly ? 'Monthly Loan Plan' : 'Weekly Loan Plan' }}
        </h3>
        <span class="text-lg text-green-600 font-bold">TK {{ number_format($item->amount) }}</span>
    </div>

    <div class="text-gray-700 text-sm mb-4 space-y-1">
        <p><strong>Interest Rate:</strong> <span
                class="text-green-600 font-bold">{{ number_format($item->interest_rate) }}%</span></p>
        <p><strong>Interest Amount:</strong> <span class="text-green-600 font-bold">TK
                {{ number_format($item->interest_amount) }}</span></p>
        <p><strong>Total Amount:</strong> <span class="text-green-600 font-bold">TK
                {{ number_format($item->total_amount) }}</span></p>
        <p>
            <strong>Per
                {{ $item->status->value === \App\Enums\LoanStatus::Monthly ? 'Month' : 'Week' }}:</strong>
            <span class="text-green-600 font-bold"> TK {{ number_format(ceil($item->total_amount / $duration)) }}</span>
        </p>
    </div>

    <!-- Terms Checkbox -->
    <label class="inline-flex items-center mb-4">
        <input type="checkbox" name="agree_terms" value="yes" class="form-checkbox text-blue-600" required />
        <span class="ml-2 text-gray-700 text-sm">I agree to the terms and conditions</span>
    </label>

    <div class="flex justify-between items-center">
        <span class="text-xs text-gray-600">Duration: <span class="text-green-600 font-bold">{{ $duration }}</span>
            {{ $item->status->value === \App\Enums\LoanStatus::Monthly ? 'months' : 'weeks' }}</span>
        <button type="submit" class="text-sm text-white bg-green-600 px-4 py-2 rounded hover:bg-blue-700">Apply
            Now</button>
    </div>
</form>
