<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function update(Request $request,User $user)
    {

    }

    public function edit(User $user)
    {

    }
}
