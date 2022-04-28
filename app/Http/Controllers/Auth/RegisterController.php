<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $userRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->middleware('guest');
        $this->userRepo = $userRepo;
    }


    public function register(RegisterRequest $request)
    {
        $id = $this->userRepo->insertDB([
            'first_name' => $request->input('fname'),
            'last_name' => $request->input('lname'),
            'email' => $request->input('email'),
            'phone' => $request->phone,
            'password' => bcrypt($request->input('password')),
            'status' => config('auth.status.active'),
            'role_id' => config('auth.roles.customer'),
        ]);

        $user = $this->userRepo->find($id);

        $avatar = time() . "-user-" . Str::slug($user->fullname) . ".png";
 
        if(!Storage::exists('users')){
            Storage::makeDirectory('users');
        }
        Storage::copy('users/img.png', 'users/' . $avatar);
        $user->image()->create(['name' => $avatar]);

        return redirect()
            ->route('login')
            ->with('success', __('registation success'));
    }
}
