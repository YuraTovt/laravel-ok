<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\CorrectUserPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $paginator = User::query()
            ->paginate(2);

        return view('users.index', ['paginator' => $paginator]);
    }

    public function create(Request $request)
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5'
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = new User($data);

        $user->save();

        return response()->redirectToRoute('users.index');
    }

    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validate($request, [
            'name' => 'string',
            'email' => [
                'email',
                Rule::unique('users')->ignore($user)
            ],
            'old_password' => [
                'nullable',
                'string',
                'min:5',
                Rule::requiredIf(!empty($request->input('password'))),
                new CorrectUserPassword($user)
            ],
            'password' => 'nullable|string|min:5'
        ]);

        if ($data['name']) $user->name = $data['name'];
        if ($data['email']) $user->email = $data['email'];
        if ($data['password']) $user->password = Hash::make($data['password']);

        $user->save();

        return response()->redirectToRoute('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->redirectToRoute('users.index');
    }
}
