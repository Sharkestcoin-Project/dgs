<?php

namespace App\Http\Controllers\User\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FontLib\Table\Type\name;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.settings.settings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'store_logo' => 'nullable',
            'email' => 'required|email',
            'support_email' => 'nullable|email',
            'city' => 'nullable|max:100|string',
            'postal_code' => 'nullable|integer',
            'name' => 'required|max:100|string',
            'state' => 'nullable|max:100|string',
            'store_name' => 'required|max:100|string',
            'shop_address' => 'nullable|max:100|string',
            'password' => 'nullable|min:4|max:20|confirmed',
        ]);

        $user = auth()->user();
        $old_logo = $user->meta['store_logo'] ?? '';

        // Upload Store Logo
        if ($request->store_logo){
            //Upload Cover Photo
            $logo = base64_image_decode($request->input('store_logo'));
            $logoPath = 'uploads/users/' . Auth::id() . date('/y') . '/' . date('m');
            $logoName = $logoPath . '/'.uniqid().$logo['type'];

            if (config('filesystems.default') == 'local'){
                Storage::disk('public')->put($logoName, $logo['content']);
            } else {
                Storage::disk(config('filesystems.default'))->put($logoName, $logo['content']);
            }

            if (config('filesystems.default') == 'local'){
                if (Storage::disk('public')->exists($old_logo)){
                    Storage::disk('public')->delete($old_logo);
                }
            }else{
                if (Storage::disk(config('filesystems.default'))->exists($old_logo)){
                    Storage::disk(config('filesystems.default'))->delete($old_logo);
                }
            }
        }

        $data = [
            'city' => $request->city,
            'store_logo' => $logoName ?? $old_logo,
            'state' => $request->state,
            'store_name' => $request->store_name,
            'postal_code' => $request->postal_code,
            'shop_address' => $request->shop_address,
            'support_email' => $request->support_email,
        ];

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'meta' => $data,
        ]);

        return response()->json(__('Profile updated successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
