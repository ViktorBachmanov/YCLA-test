<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;


class AuthController extends Controller
{
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

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'password' => ['required'],
        ]);

        $email = $request->input('email');
        $phone = $request->input('phone');

        $authSuccess = false;
        $checkedFieldName = '';

        if (!$email && !$phone) {
            abort(400, 'You must provide email or phone');
        } else if ($email && !$phone) {
            $checkedFieldName = 'email';
            $credentials += $request->validate([$checkedFieldName => 'email']);
            $authSuccess = Auth::attempt($credentials);
        } else if (!$email && $phone) {
            $checkedFieldName = 'phone';
            $credentials += $request->validate([$checkedFieldName => 'string']);
            $authSuccess = Auth::attempt($credentials);
        } else if ($email && $phone) {
            try {
                $credentials += $request->validate(['email' => 'email']); 
                $authSuccess = Auth::attempt($credentials);
            } catch (ValidationException) {
                // do nothing
            } finally {
                if (!$authSuccess) {
                    $credentials += $request->validate(['phone' => 'string']);

                    unset($credentials['email']);

                    $authSuccess = Auth::attempt($credentials);
                }   
                $checkedFieldName = 'email phone';         
            }
        }
 
        if ($authSuccess) {
            $token = $request->user()->createToken('token123');
 
            return ['token' => $token->plainTextToken];
        }
 
        return response()->json([
            $checkedFieldName => 'The provided credentials do not match our records.',
        ], 401);
    }

}
