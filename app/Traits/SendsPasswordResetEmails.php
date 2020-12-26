<?php

namespace app\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Log;

trait SendsPasswordResetEmails
{
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request,['login' => 'required|email']);

        $response = Password::broker()->sendResetLink(
            $request->only('login')
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        $login = $request->only('login');
        return response(['message' => 'Reset link sent to ' . $login['login']]);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response(['message' => $response], 422);
    }

}