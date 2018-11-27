<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

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
     * @return string
     */
    protected function redirectTo() {

        $agent = new \Jenssegers\Agent\Agent();

        if ($agent->isDesktop()) {
            return '/profile/edit/'.(\Auth::user()->type == '1' ? 'individual' : 'juridical');
        }else{
            return '/profile';
        }
    }

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
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath())->with('success_message', 'Вы успешно зарегистрировались!');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, User::getValidatorRulesOnType(isset($data['type']) ? $data['type'] : '', true));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Model\User
     */
    protected function create(array $data)
    {
        $data['password'] = bcrypt($data['password']);

        return User::create($data);
    }


    public function showRegistrationForm()
    {

        $agent = new \Jenssegers\Agent\Agent();

        if ($agent->isDesktop()) {
            return view('auth.register');
        }else{
            return view('mobile.auth.register');
        }


    }

}
