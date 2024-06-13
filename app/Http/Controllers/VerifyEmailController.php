<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function verify(Request $request, $id)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $user = Users::findOrFail($id);

        if (!$user->verification) {
            $user->verification = true;
            $user->save();
        }

        return redirect()->route('home')->with('verified', true);
    }
}
