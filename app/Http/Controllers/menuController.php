<?php

namespace App\Http\Controllers;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class menuController extends Controller
{
    function dashboard()
    {
        return view('layouts.template');
    }



}

