<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gategorie;

class GategorieController extends Controller
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
        $this->authorize('view_all_page_product');
        return view('gategorie.indexGategorie');
    }


    public function get_gategorie()
    {
        $gategories= Gategorie::all();

   
        $att=[];
    

        for($i=0;$i<count($gategories);$i++)
        {
            $att[] =  [ 'id'=> $gategories[$i]->id , 
            'nom'=> $gategories[$i]->nom , 
             'date_create'=> $gategories[$i]->date_create , 
             'total'=> $gategories[$i]->product()->count() ,
            
            ];
        
         

    
        }
        
    
       $data = array( 'gategories'=> $att);
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
                   $gategorie = new Gategorie; 
                   $gategorie->nom = $request->nom;
                   $gategorie->date_create = $request->date_create;
                   $gategorie->save();
               
                   return Response()->json(['etat' => true  , 'id_cate' => $gategorie->id ]);
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
            $gategorie = Gategorie::find($request->id);
            $gategorie->nom = $request->nom;
           
            $gategorie->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $delete_gategorie= Gategorie::find($id);  
        $delete_gategorie->delete();
  
    }
}
