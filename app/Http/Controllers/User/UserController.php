<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->paginate(10);

        return view('user.users-index', compact('users'));
    }

    public function create()
    {
        return view('user.create-user');
    }

    public function store(UserRequest $request)
    {
        $newUser = $request->all();
        $newUser['password'] = bcrypt($newUser['password']);

        $this->user->create($newUser);

        return redirect()->route('user.index');
    }

    public function edit(User $user)
    {
        return view('user.create-user', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['string', 'min:8', 'confirmed', 'nullable'],
            'role' => [
                'required',
                Rule::in(['administrador', 'controlador', 'monitor']),
            ]
        ])->validate();

        $data = $request->only(['name', 'password', 'role']);

        if (!$data['password']) {
            $data['password'] = Auth::user()->password;
        }

        $user->update($data);

        return redirect()->action('User\UserController@index');
    }

    public function destroy($id)
    {
        if (Auth::user()->id === (int) $id) {
            return redirect()->action('User\UserController@index');
        }

        $this->user->destroy($id);

        return redirect()->action('User\UserController@index');
    }
}
