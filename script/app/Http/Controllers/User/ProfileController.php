<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Newsletter;

class ProfileController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        return view('user.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = \Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,' . \Auth::id()],
            'phone' => ['required', new Phone],
            'password' => ['nullable', Password::default()],
            'avatar' => ['nullable']
        ]);

        if ($request->input('avatar')) {
            $profileFile = base64_image_decode($request->input('avatar'));
            $profilePath = 'uploads/' . Auth::id() .'/profile/'. date('/y') . '/' . date('m');
            $profileName = $profilePath . '/' . uniqid() . $profileFile['type'];

            $old = str(auth()->user()->avatar)->remove('/storage')->remove('storage');
            if (Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            Storage::disk('public')->put($profileName, $profileFile['content']);
        }

        if ($request->input('cover')) {
            $file = base64_image_decode($request->input('cover'));
            $coverPath = 'uploads/' . Auth::id() .'/cover'. date('/y') . '/' . date('m');
            $coverName = $coverPath . '/' . uniqid() . $file['type'];

            if (auth()->user()->meta['cover_img'] ?? false) {
                $old = str(auth()->user()->meta['cover_img'])->remove('/storage')->remove('storage');
                if (Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }
            Storage::disk('public')->put($coverName, $file['content']);
        }

        Auth::user()->update([
                'avatar' => isset($profileName) ? '/storage/'.$profileName : auth()->user()->avatar,
                'meta' => [
                    'cover_img' => isset($coverName) ? '/storage/'.$coverName : auth()->user()->meta['cover_img'],
                ],
                'password' => $request->input('password') !== null ? bcrypt($request->input('password')) : \Auth::user()->password,
            ] + $validated);

        if (config('newsletter.apiKey') && config('newsletter.lists.subscribers.id')) {
            if ($request->has('newsletter')) {
                Newsletter::subscribe(\Auth::user()->email, ['NAME' => \Auth::user()->name]);
            } else {
                Newsletter::unsubscribe(\Auth::user()->email);
            }
        }

        return response()->json(__('Profile Updated Successfully'));
    }
}
