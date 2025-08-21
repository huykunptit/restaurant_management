<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {   
        $users = User::with(['role'])->paginate(10);

        return view('user.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {   
        $roles = Role::all();

        return view('user.create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required|max:200',
            'lastName' => 'required|max:200',
            'email' => 'required|max:200',
            'password' => 'required|max:200',
            'role' => 'required',
        ]);

        // Check if user's email already exist
        $user = User::where('email', '=', $request->email)->exists();

        if ($user) {

            return redirect()
                ->back()
                ->with('error', 'A user with this email already exists!');
            
        } else{

            User::create([
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role,
            ]);
    
            return redirect()
                ->route('user.index')
                ->with('success', 'New user successfully added!');
        }

    }

    public function edit($id)
    {   
        $user = User::find($id);
        $roles = Role::all();
        
        return view('user.edit', [
            'roles' => $roles,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'firstName' => 'max:200',
            'lastName' => 'max:200',
            'email' => 'max:200',
            'password' => 'max:200',
            'role_id' => 'max:200',
        ]);

        $user = User::find($id);

        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->email = $request->email;

        if(($request->password) != ''){
            $user->password = Hash::make($request->password);
        } 

        $user->role_id = $request->role;

        $user->save();

        return redirect()
            ->route('user.index')
            ->with('success','User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return redirect()
            ->route('user.index')
            ->with('success','User deleted successfully');
    }
}
