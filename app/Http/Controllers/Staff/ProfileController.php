<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PasswordRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    protected $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo
    ) {
        $this->userRepo = $userRepo;
    }

    public function show()
    {
        $user = Auth::user();

        return view('staffs.profiles.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();

        return view('staffs.profiles.edit', compact('user'));
    }

    public function update(UpdateRequest $request)
    {
        $user = $this->userRepo->find(Auth::user()->id);
        $currentFile = $user->image->name;
        DB::transaction(function() use($request, $user, $currentFile){
            $file = $request->image;
            if (!empty($file)) {
                $new_name = time() . '-user-' . Str::slug($request->fname) . '-' . Str::slug($request->lname) . '.' . $file->getClientOriginalExtension();
            }

            $user->update([
                'first_name' => $request->fname,
                'last_name' => $request->lname,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if (!empty($file)) {
                $user->image()->update(['name' => $new_name]);
                Storage::delete('users/' . $currentFile);
                $file->storeAs('users', $new_name);
            }

            return redirect()->route('staff.profile', $user->id)->with('success', __('update success', ['attr' => strtolower(__('profile'))]));
        });

        return redirect()->route('staff.profile', $user->id)->with('error', __('update fail', ['attr' => strtolower(__('profile'))]));
    }

    public function changePass(PasswordRequest $request)
    {
        $user = $this->userRepo->find(Auth::user()->id);

        if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->route('profile', $user->id)->with('success', __('change pass success'));
        } else {
            return redirect()->back()->with('error', __('change pass fail'));
        }
    }
}
