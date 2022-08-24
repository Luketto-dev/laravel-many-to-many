<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // è un sistema che mi permette di intercettare qualsiasi richiesta effettuata al server e posso decidere se far passare o no l utente
        // questo middlwere mi permette di controllare se un utente è loggato può essere usato anche nelle rotte
        $this->middleware('auth');
    }

    public function index(){
        return view("admin.index");
    }

}
