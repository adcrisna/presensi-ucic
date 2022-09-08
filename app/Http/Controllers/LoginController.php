<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function prosesLogin(Request $request)
    {  
        if (Auth::attempt(['nip'=>$request->nip,'password'=>$request->password]))
        {
            if (Auth::User()->jabatan_id == "1")
            {
                return \Redirect::to('/admin/home');
            }
            else
            {
                \Session::flash('msg_login','Username Atau Password Salah!');
                return \Redirect::to('/');
            }

        }
        else
        {
            \Session::flash('msg_login','Username Atau Password Salah!');
            return \Redirect::to('/');
        }
    }
}
?>