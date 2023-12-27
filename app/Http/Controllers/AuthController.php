<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;


class AuthController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function register(Request $request)
    {
        $input = $request->all();
        
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:100'],
            'family' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'patronymic' => $input['patronymic'],
            'family' => $input['family'],
            'phone' => $input['phone'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
