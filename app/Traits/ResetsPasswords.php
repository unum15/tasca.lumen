<?php

namespace App\Traits;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

trait ResetsPasswords
{
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'login' => 'required|email',
            'password' => 'required|confirmed',
        ];
    }

    protected function validationErrorMessages()
    {
        return [];
    }

    protected function credentials(Request $request)
    {
        return $request->only(
            'login', 'password', 'password_confirmation', 'token'
        );
    }

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->save();

        event(new PasswordReset($user));
    }

    protected function setUserPassword($user, $password)
    {
        $user->password = Hash::make($password);
    }

    protected function sendResetResponse(Request $request, $response)
    {
        $login = $request->only('login');
        return response(['message' => 'You may now login with your new password using login: ' . $login['login']]);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response(['message' => $response], 422);
    }

    public function broker()
    {
        return Password::broker();
    }

    protected function guard()
    {
        return Auth::guard();
    }
}