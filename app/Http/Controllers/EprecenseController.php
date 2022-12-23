<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EprecenseController extends Controller
{
    public function show()
    {
        dd($this->user);
    }

    public function storeIn(Request $request)
    {
        $user = Auth::user();
        dd($user);
    }

    public function storeOut()
    {

    }
}
