<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register')]
class RegisterPage extends Component
{
    public $name;
    public $email;
    public $password;

    // قواعد التحقق
    protected $rules = [
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users|max:255',
        'password' => 'required|min:6|max:255',
    ];

    public function save()
    {
        // التحقق من صحة البيانات
        $this->validate();

        // إنشاء المستخدم الجديد
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // تسجيل الدخول تلقائياً بعد التسجيل
        auth()->login($user);

        // إعادة توجيه المستخدم بعد التسجيل الناجح
        return redirect('/'); // استبدل 'dashboard' بالمسار المناسب
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
