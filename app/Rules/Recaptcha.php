<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Kirim request verifikasi ke Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        // Jika Google bilang gagal, maka validasi gagal
        if (! $response->json('success')) {
            $fail('Verifikasi keamanan (reCAPTCHA) gagal. Silakan coba lagi.');
        }
    }
}