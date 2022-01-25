<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Site;

class SiteController extends Controller
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


        //$this->authorize('view_all_page_product');
        
        return view('site.indexSite');

    }
    

    public function get_site()
    {
        $sites = Site::all();

   
        $att=[];
    

        for($i=0;$i<count($sites);$i++)
        {
            $att[] =  [ 
            'id'=> $sites[$i]->id , 
            'nom'=> $sites[$i]->nom , 
            'date_create'=> $sites[$i]->date_create , 
            ];
        
         

    
        }
        
    
       $data = array( 'sites'=> $att);
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
            $site = new Site; 
            $site->nom = $request->nom;
            $site->date_create = $request->date_create;
            $site->save();
        
            return Response()->json(['etat' => true  , 'id_site' => $site->id ]);
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
            $site = Site::find($request->id);
            $site->nom = $request->nom;
           
            $site->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_site= Site::find($id);  

        $delete_site->delete();
       
    }
}
