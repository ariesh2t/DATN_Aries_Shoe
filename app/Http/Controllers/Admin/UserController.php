<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $userRepo;
    protected $roleRepo;

    public function __construct(UserRepositoryInterface $userRepo, RoleRepositoryInterface $roleRepo)
    {
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
    }

    public function index()
    {
        $users = $this->userRepo->getAll();

        return view('admins.users.showAll', compact('users'));
    }

    public function create()
    {
        return view('admins.users.create');
    }

    public function store(RegisterRequest $request)
    {
        $id = $this->userRepo->insertDB([
            'first_name' => $request->input('fname'),
            'last_name' => $request->input('lname'),
            'email' => $request->input('email'),
            'phone' => $request->phone,
            'password' => bcrypt($request->input('password')),
            'status' => config('auth.status.active'),
            'role_id' => config('auth.roles.staff'),
        ]);

        $user = $this->userRepo->find($id);

        $avatar = time() . "-user-" . Str::slug($user->fullname) . ".png";
 
        if(!Storage::exists('users')){
            Storage::makeDirectory('users');
        }
        Storage::copy('users/img.png', 'users/' . $avatar);
        $user->image()->create(['name' => $avatar]);

        return redirect()
            ->route('users.index')
            ->with('success', __('create success', ['attr' => __('user')]));
    }

    public function detail($id)
    {
        $user = $this->userRepo->find($id);

        if (!$user) {
            return redirect()->back()->with('error', __('no user'));
        } elseif ($id == Auth::user()->id) {
            return view('admins.profiles.show', compact('user'));
        }

        return view('admins.users.detail', compact('user'));
    }

    public function updateStatus(Request $request, $id)
    {
        $user = $this->userRepo->find($id);

        if (empty($user)) {
            return redirect()->back()->with('error', __('no user', ['attr' => $id]));
        } elseif ($user->role_id == config('auth.roles.admin')) {
            return redirect()->back()->with('error', 'cannot update admin');
        } elseif ($request->status === null || ($request->status != 0 && $request->status != 1)) {
            return redirect()->back()->with('error', __('no status'));
        }

        $user->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', __('update success', ['attr' => strtolower(__('user'))]));
    }
}
