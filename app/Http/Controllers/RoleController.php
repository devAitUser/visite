<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;

class RoleController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {  

        $this->authorize('admin_access_all_page_utilisateurs');
        return view('roles.indexRoles');

    }
    

    public function get_roles()
    {
        $roles= Role::all();

   
       
    
        
    
       $data = array( 'roles'=> $roles);
       return $data;

       echo json_encode($data);
       exit;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->isMethod('post')){
            $role = new Role; 
            $role->name = $request->name;
            $role->slug = $request->slug;
            $role->color = $request->color;
            $role->save();
        
            return Response()->json(['etat' => true  , 'id_role' => $role->id ]);
         }   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
            $role = Role::find($request->id);
            $role->name = $request->name;
            $role->slug = $request->slug;
            $role->color = $request->color;
           
            $role->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_role= Role::find($id);  

        $delete_role->delete();
    }


}
