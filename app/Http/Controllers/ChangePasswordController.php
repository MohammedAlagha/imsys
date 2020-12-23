<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class ChangePasswordController extends Controller
{
    public function form(User $user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }
        return View::make('users.password', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user = null)
    {
        if (!$user) {
            $user = Auth::user();
            $request->validate([
                'new_password' => ['required', 'min:8', 'confirmed'],
            ]);
        } else {
            $request->validate([
                'password' => ['required', 'password'],
                'new_password' => ['required', 'min:8', 'confirmed'],
            ]);    
        }

        $user->update([
            'password' => Hash::make($request->post('new_password')),
        ]);
    }
}
