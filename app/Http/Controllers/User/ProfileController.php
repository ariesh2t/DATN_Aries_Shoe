<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PasswordRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    protected $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo
    ) {
        $this->userRepo = $userRepo;
    }

    public function show($id)
    {
        $user = $this->userRepo->find($id);

        return view('customers.profiles.show', compact('user'));
    }

    public function edit($id)
    {
        $user = $this->userRepo->find($id);

        return view('customers.profiles.edit', compact('user'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = $this->userRepo->find($id);
        $currentFile = $user->image->name;
        $path = public_path('images/users/');
        DB::transaction(function() use($request, $path, $user, $currentFile){
            $file = $request->image;
            if (empty($file)) {
                $extension = pathinfo($path . $currentFile)['extension'];
                $new_name = time() . '-user-' . Str::slug($request->fname) . '-' . Str::slug($request->lname) . '.' . $extension;
            } else {
                $new_name = time() . '-user-' . Str::slug($request->fname) . '-' . Str::slug($request->lname) . '.' . $file->getClientOriginalExtension();
            }

            $user->update([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            $user->image()->update(['name' => $new_name]);

            if (empty($file)) {
                rename($path . $currentFile, $path . $new_name);
            } else {
                unlink($path . $currentFile);
                $file->move($path, $new_name);
            }

            return redirect()->route('profile', $user->id)->with('success', __('update success', ['attr' => __('profile')]));
        });

        return redirect()->route('profile', $user->id)->with('error', __('update fail', ['attr' => __('profile')]));
    }

    public function changePass(PasswordRequest $request)
    {
        $user = $this->userRepo->find(Auth::user()->id);

        if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return redirect()->route('profile', $user->id)->with('success', __('update success', ['attr' => __('profile')]));
    }
}
