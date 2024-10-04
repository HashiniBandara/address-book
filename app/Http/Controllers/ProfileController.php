<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use Intervention\Image\Facades\Image as ImageIntervention;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        if ($user->role === 'admin') {
            return view('admin.profile.edit', [
                'user' => $request->user(),
            ]);
        } elseif ($user->role === 'user') {
            return view('user.profile.edit', [
                'user' => $request->user(),
            ]);
        }

        // return view('superadmin.profile.edit', [
        //     'user' => $request->user(),
        // ]);
    }

    /**
     * Update the user's profile information.
     */

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time() . '_' . $file->getClientOriginalName();

            $directory = public_path('images/profileImages/' . $user->id);
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0777, true, true);
            }

            $image = Image::make($file)->resize(600, 600);
            $image->save(public_path('images/profileImages/' . $user->id . '/' . $fileName));

            // $filePath = $file->storeAs('public/images/profileImages', $fileName);
            // $user->profile_image = '/images/profileImages/' . $fileName; //save image name with file path
            // // }

            //delete the previous profile image if it exists
            if ($user->getOriginal('profile_image')) {
                File::delete(public_path($user->getOriginal('profile_image')));
            }

            $user->profile_image = 'images/profileImages/' . $user->id . '/' . $fileName;
        }

        $user->save();

        //redirect based on user role
        if ($user->role === 'admin') {
            return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
         } elseif ($user->role === 'user') {
            return Redirect::route('user.profile.edit')->with('status', 'profile-updated');
        }
    }

    /**
     * Delete the user's account.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}
