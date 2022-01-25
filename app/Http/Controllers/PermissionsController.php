<?php

namespace App\Http\Controllers;

use Sentinel;



use Illuminate\Http\Request;

class PermissionsController extends Controller
{
  

    public function index(){
        $roles = Sentinel::getRoleRepository()->get();


        $data = array( 'roles'=> $roles);
        return view('permissions',$data);
    }

    public function assignPermissions(Request $request){
        $role= Sentinel::findRoleByName($request->role);
        $page = $request->page;
        $key = $request->key;
        $value =($request->value == 1) ? true : false ; 
        $role->removePermission($page.'.'. $key)->save();
        $role->addPermission($page.'.'. $key, $value)->save();

    }
}
