<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{

    //Refatorar todo esse controller depois de testar funcionalidade
    public function index(){
        return Inertia::render("User/BecomeInstructor");
    }

    public function becomeInstructor(Request $request)
    {
        $user = Auth::user();

        if($user->is_instructor){
            return back()->with("message", "você já é um instrutor");
        }

        $user->is_instructor = true;
        $user->save();
        return redirect()->route("dashboard")
        ->with("success", "Agora você é um instrutor");
    }
}
