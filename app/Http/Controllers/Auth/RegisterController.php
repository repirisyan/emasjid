<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'TanggalLahir' => ['required'],
            'TempatLahir' => ['required', 'max:255'],
            'JenisKelamin' => ['required'],
            'email' => ['required', 'email:rfc,dns', 'unique:users'],
            'kontak' => ['required', 'digits_between:8,12', 'unique:users'],
            'alamat' => ['required', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'TanggalLahir' => $data['TanggalLahir'],
            'TempatLahir' => $data['TempatLahir'],
            'alamat' => $data['alamat'],
            'kontak' => $data['kontak'],
            'email' => $data['email'],
            'JenisKelamin' => $data['JenisKelamin'],
            'role' => 2,
            'password' => Hash::make($data['password']),
            'picture' => 'default_picture.png'
        ]);
    }
}
