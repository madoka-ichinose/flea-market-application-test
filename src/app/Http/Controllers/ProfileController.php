<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function edit(Request $request){
        return view('profile', [
            'user' => Auth::user(),
        ]);
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $validated = $request->validated();

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->name = $validated['name'];
        $user->postal_code = $validated['postal_code'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->building = $validated['building'] ?? null;

        $user->profile_completed = true;
        $user->save();

        return redirect('/')->with('status', '※プロフィールを更新しました');
    }
}

