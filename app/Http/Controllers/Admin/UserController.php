<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\UserDetail;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){

        $users = User::all();

        return view("admin.users.index", compact("users"));
    }


    public function edit($id){
        $user = User::findOrFail($id);

        return view("admin.users.edit", compact("user"));
    }


    public function update(Request $request, $id){

        $data = $request->all();
        

        $user = User::findOrFail($id);
        
        $user->update($data);
        // può capitare che nella seconda tab non ci sia ancora nessuna informazione
        //sull utente indicato
        //in questo caso dobbiamo crearli noi manualmente, come se stessimo facendo il CREATE
        // dobbiamo fare un controllo e vedere se esistono i dettagli di quell utente perchè potrebbero non esistere inizialmente
        if (!$user->details) {
            $user->details = new UserDetail();
            $user->details->user_id = $user->id;
            $user->details->fill($data);
            $user->details->save();
        }else{
            $user->details->update($data);
        }

        
        return redirect()->route("admin.users.edit", $user->id);
    }
}
