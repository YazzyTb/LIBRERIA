<?php

namespace App\Http\Requests\Login;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['nullable', 'string'],
            'email' => ['nullable', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
    
        // Verificar si se ingresó un email o un CI
        $loginField = filter_var($this->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'id';

        // Intentar autenticar con el campo correspondiente
        $credentials = [
            $loginField => $this->input('login'), 
            'password' => $this->input('password'),
        ];
    
        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
    
            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }
    
        RateLimiter::clear($this->throttleKey());
    }
    

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string{
        $login = $this->input('login');

        // Usar email o CI dependiendo de cuál se ingresó
        return Str::transliterate(Str::lower($login).'|'.$this->ip());
    }
}
