<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Folder;

class FolderController extends Controller
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
     
        
        return view('folder.index');
    }


    public function add_parents()
    {
     
        
        return view('folder.add');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function get_folders_items()
    {

        $folder = Folder::all(); 

        

         for($i=0;$i<count($folder);$i++)
         {
             if($folder[$i]->file == null){
                $att[] =  [ 'id'=> $folder[$i]->id , 
                'parentId'=> $folder[$i]->parentId ,
                 'label'=> $folder[$i]->name,
                 'file'=> $folder[$i]->file ,
                ];

             }
            
         }

    
       $data = array( 'item_folder_label' => $att ,'item_folder' => $folder );
   

       echo json_encode($data);
       exit;
    
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_folder(Request $request)
    {
        if($request->isMethod('post')){
            $folder = new Folder; 
            $folder->parentId = $request->id_parent;
            $folder->name = $request->name;

            if($request->hasFile('file')){
                $file = $request->file;
                $fileName = $file->getClientOriginalName();
                $file->move(public_path('files'), $fileName);
                $type_file =explode('.',$fileName);
                 $folder->file = $type_file[1];
                 $folder->name = $type_file[0];
            } else {
                $folder->name = $request->name;
            }

     


            $folder->save();
            return Response()->json(['etat' => true  ]);
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
        $folder = Folder::find($request->id);
        $folder->name = $request->name;
       
        $folder->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_folder = Folder::find($id);  

        $delete_folder->delete();
    }
}
