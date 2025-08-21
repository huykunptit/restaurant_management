<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('guest.login');
    }

    public function login(Request $request, User $users)
    {   
        
        $this->validate($request, [
            'email' => 'required|max:200',
            'password' => 'required|max:200',
        ]);

        $remember = true;

        $user = $users->where('email', $request->email)->first();

        // If user exists
        if($user !== null){

            // Try log-in
            if(auth()->attempt(['email' => $request->email, 'password' => $request->password], $remember)){
            
                if(auth()->user()->hasRole('admin')){
                    
                    $request->session()->regenerate();
                    return redirect()->route('home.admin');
    
                } elseif(auth()->user()->hasRole('staff')){
    
                    $request->session()->regenerate();
                    return redirect()->route('home.staff');
    
                } elseif(auth()->user()->hasRole('customer')){
    
                    $request->session()->regenerate();
                    return redirect()->route('home.customer');
    
                }
    
            } else{
                return redirect()
                    ->route('login')
                    ->withInput()
                    ->with('error', 'Incorrect password! Please try again.');
            }

        } else{
            return redirect()
                ->route('login')
                ->withInput()
                ->with('error', 'A user with this email address does not exist.');
        }

    }

}
