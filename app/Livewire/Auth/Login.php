<?php

namespace App\Livewire\Auth;

use App\Helpers\Renato;
use App\Models\Config;
use App\Models\User;
use App\Traits\WithToastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Login extends Component
{
    use WithToastr;

    public string $email = '';

    public string $password = '';

    public function login(): mixed
    {
        try {
            $this->validate();
        } catch (ValidationException $exception) {
            $this->toastError('Preencha e-mail e senha corretamente.');

            throw $exception;
        }

        $throttleKey = $this->throttleKey();

        if (RateLimiter::tooManyAttempts($throttleKey, 10)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->toastError("Muitas tentativas. Aguarde {$seconds} segundos.");

            return null;
        }

        if (! Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ])) {
            RateLimiter::hit($throttleKey);

            $this->addError('email', __('auth.failed'));
            $this->toastError('E-mail ou senha inválidos.');

            return null;
        }

        /** @var User $user */
        $user = Auth::user();

        if ((int) $user->status !== 1) {
            Auth::logout();

            $this->toastError('Seu usuário está inativo. Entre em contato com o administrador.');

            return null;
        }

        RateLimiter::clear($throttleKey);

        session()->regenerate();

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Bem-vindo de volta, ' . Renato::getPrimeiroNome($user->name) . '!',
        ]);

        return redirect()->route('admin');
    }

    #[Title('Login')]
    public function render()
    {
        return view('livewire.auth.login', [
            'config' => Config::first(),
        ]);
    }

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'password.required' => 'Informe a senha.',
            'password.min' => 'A senha deve ter no mínimo :min caracteres.',
        ];
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
