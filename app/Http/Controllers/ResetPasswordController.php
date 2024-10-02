<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Parents; // Adjust to correct namespace and model name
use App\Models\Teachers; // Adjust to correct namespace and model name

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;


class ResetPasswordController extends Controller
{
    /**
     * Send a password reset link to the given email.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendResetLinkEmail(Request $request): JsonResponse
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $userType = $this->getUserTypeByEmail($request->input('email'));

    if (!$userType) {
        return response()->json([
            'success' => false,
            'message' => 'No user found with this email address.'
        ]);
    }

    $response = Password::broker($userType)->sendResetLink($request->only('email'));

    if ($response == Password::RESET_LINK_SENT) {
        return response()->json([
            'success' => true,
            'message' => 'We have emailed your password reset link!'
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Unable to send password reset link.'
        ]);
    }
}
    /**
     * Handle a password reset request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function reset(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
    
        $response = Password::broker($this->getUserTypeByEmail($request->input('email')))->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );
    
        if ($response == Password::PASSWORD_RESET) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => __($response)
            ]);
        }
    }
    /**
     * Determine the user type by email.
     *
     * @param string $email
     * @return string|null
     */

private function getUserTypeByEmail(string $email)
{
    // Logic to determine user type (e.g., admin, parent, teacher) based on email
    if (Admin::where('email', $email)->exists()) {
        return 'admins';
    } elseif (Teachers::where('email', $email)->exists()) {
        return 'teachers';
    } elseif (Parents::where('email', $email)->exists()) {
        return 'parents';
    }

    return null;
}
public function showResetForm(Request $request, $token = null)
{
    return view('index')->with(
        ['token' => $token, 'email' => $request->email]
    );
}

}