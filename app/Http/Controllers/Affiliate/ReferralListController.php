<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralListController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->ajax()) {
            return datatables(
                Auth::user()->referrals()->select(['id','referrer_id','username','created_at'])
            )->addIndexColumn()->toJson();
        }

        return view('affiliate.list.index');
    }
}
