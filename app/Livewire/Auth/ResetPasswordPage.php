<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Reset Password')]
class ResetPasswordPage extends Component
{
    #[Url]
    public $token;

    #[Url]
    public $email;

    public $password;
    public $password_confirmation;

    public function mount()
    {
        if (!$this->token) {
            abort(404); // إذا لم يكن هناك توكن، يتم عرض خطأ
        }
    }

    public function save()
    {
        // التحقق من صحة البيانات المدخلة
        $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        // تحضير بيانات إعادة تعيين كلمة المرور
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token,
        ];

        // تنفيذ إعادة تعيين كلمة المرور
        $status = Password::reset(
            $credentials,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        // التحقق من نجاح العملية
        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', 'Password reset successfully');
            return redirect('/login');
        } else {
            session()->flash('error', 'Something went wrong, please try again.');
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}
