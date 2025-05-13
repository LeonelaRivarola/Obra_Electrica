<?php

namespace App\Http\Controllers;

use Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Helpers\Contraseña;
use App\Models\UsuarioCorpico;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        $UsuarioCorpico = UsuarioCorpico::where('USU_CODIGO', $attributes['username'])->first();

        if (!$UsuarioCorpico || $attributes['password'] !== Contraseña::decodificar($UsuarioCorpico->USU_PASSWORD)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials do not match our records.']
            ]);
        }

        Auth::guard()->login($UsuarioCorpico);
        session()->regenerate();

        return redirect('/');
    }

    public function show()
    {
        request()->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            request()->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function update()
    {

        request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => ($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/sign-in');
    }
}
