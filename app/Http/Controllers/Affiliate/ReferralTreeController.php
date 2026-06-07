<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralTreeController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->has('user_id')
            ? User::where('id', $request->get('user_id'))->first()
            : Auth::user();

        if ($user->id != Auth::id()) {
            $invalid = true;
            $referrer = $user->referrer;
            while ($referrer) {
                if ($referrer->id == Auth::id()) {
                    $invalid = false;
                    break;
                }
                $referrer = $referrer->referrer;
            }
            abort_if($invalid, 404);
        }

        $user = $user ?? Auth::user();

        return view('affiliate.tree.index', [
            'user' => $user,
        ]);
    }
}
