<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerifyEmail;

class UsersController extends Controller
{
    public function register(Request $rq)
    {
        $rq->validate([
            'user_name' => 'required',
            'user_phone' => 'required|unique:users',
            'user_email' => 'required|email|unique:users',
            'user_gender' => 'required',
            'user_date_of_birth' => 'required|date',
            'user_password' => 'required|min:8',
        ]);

        $user = new Users;
        $user->user_id = 'USER' . str_pad((Users::count() + 1), 6, '0', STR_PAD_LEFT);
        $user->user_name = $rq->user_name;
        $user->user_phone = $rq->user_phone;
        $user->user_email = $rq->user_email;
        $user->user_gender = $rq->user_gender;
        $user->user_date_of_birth = $rq->user_date_of_birth;
        $user->user_password = bcrypt($rq->user_password);
        $user->role_id = 0;

        $token = Str::random(255);
        $user->verification_token = $token;

        $user->save();

        $verificationUrl = url('/verify/'.$token);

        Mail::to($user->user_email)->send(new VerifyEmail($user, $verificationUrl));

        //Auth::guard('users')->login($user);
        return redirect()->route('VerifyNotify');
    }
    public function login(Request $rq)
    {
        $rq->validate([
            'user_email' => 'required|email',
            'user_password' => 'required',
        ]);
        $user = Users::where('user_email', $rq->user_email)->first();
        if($user && !$user->verification)
        {
            return redirect()->route('VerifyNotify');
        }
        else if (Auth::guard('users')->attempt(['user_email' => $rq->user_email, 'password' => $rq->user_password])) {
            if (Auth::guard('users')->user()->role_id == 0) {
                return redirect()->route('home');
            } else if (Auth::guard('users')->user()->role_id == 5) {
                return redirect()->route('AdminPage');
            }
        } else {
            return redirect('/login')->withErrors([
                'user_email' => 'The provided credentials do not match our records.',
            ]);
        }
    }
    public function logout()
    {
        Auth::guard('users')->logout();
        return redirect()->route('home');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Users $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Users $users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $users)
    {
        //
    }
}
