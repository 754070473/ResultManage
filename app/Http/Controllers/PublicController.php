<?php
namespace App\Http\Controllers;

class PublicController extends Controller
{
    public function top()
    {
        return view('public.top');
    }
    
    public function left()
    {
        return view('public.left');
    }
}
