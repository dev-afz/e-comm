<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->where('status',0)->get();
        return view('product.view.user',compact('users'));
    }
}
