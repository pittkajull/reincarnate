<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $products = $user->hasMany(\App\Models\Product::class)->latest()->paginate(12);
        return view('profile.show', compact('user', 'products'));
    }

    public function becomeSeller()
    {
        if (!Auth::check()) {
            return redirect('/');
        }
        $user = Auth::user();
        if (!($user->is_seller ?? false)) {
            $user->is_seller = true;
            $user->save();
        }
        return redirect('/profile/' . $user->id);
    }

    public function updateName(Request $request)
    {
        if (!Auth::check())
            return redirect('/');
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $user = Auth::user();
        $user->update(['name' => $data['name']]);
        return redirect('/profile/' . $user->id);
    }

    public function updatePassword(Request $request)
    {
        if (!Auth::check())
            return redirect('/');
        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        $user = Auth::user();
        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok']);
        }
        $user->update(['password' => $data['new_password']]);
        return redirect('/profile/' . $user->id);
    }

    public function updateAddress(Request $request)
    {
        if (!Auth::check())
            return redirect('/');
        $data = $request->validate([
            'address' => ['required', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);
        $user = Auth::user();
        $user->update([
            'address' => $data['address'],
            'phone' => $data['phone'] ?? null,
        ]);
        return redirect('/profile/' . $user->id);
    }
}
