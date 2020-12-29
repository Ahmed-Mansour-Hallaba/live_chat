<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
Use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;
use Illuminate\Support\Facades\Session as FacadesSession;
use Session;


class AuthController extends Controller
{

    public function index()
    {
        if(Auth::check()){
            return redirect()->intended('/chat');
        }
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function postLogin(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $name=$request->name;
        $password=$request->password;
        if (Auth::attempt(['email' => $name, 'password' => $password])) {
            // Authentication passed...
            return redirect()->intended('/chat');
        }
        //        return Redirect::to("login")->withSuccess('Oppes! You have entered invalid credentials');
        return redirect('login')->with('error', 'عذرا اسم المستخدم او كلمه المرور خاطئه');

    }

    public function postRegistration(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();

        $check = $this->create($data);

        return FacadesRedirect::to("/")->withSuccess('Great! You have Successfully loggedin');
    }

    public function dashboard()
    {


            return view('dashboard');

    }

    public function create(array $data)
    {
        return ModelsUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function logout() {
        FacadesSession::flush();
        Auth::logout();
        return Redirect('login');
    }
}
