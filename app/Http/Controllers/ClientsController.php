<?php

namespace App\Http\Controllers;
use App\Models\Client;

use Illuminate\Http\Request;

class ClientsController extends Controller
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
       return view('clients.index');
    }


    public function get_clients(Request $request)
    {
        $clients = Client::all(); 
        $data = array( 'clients'=> $clients);
       return  $data ;

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.add'); 
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
            $client = new Client; 
            $client->denomination = $request->denomination;
            $client->personne = $request->personne;
            $client->ice = $request->ice;
            $client->adresse = $request->adresse;
            $client->save();
        
            return redirect()->to('/clients');
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


        $clients   = Client::find($id);   


    
     
        $data = array( "clients" => $clients );
        return view('clients.edit',$data)  ; 
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
        $client = Client::find($request->id);
        $client->denomination = $request->denomination;
        $client->personne = $request->personne;
        $client->ice = $request->ice;
        $client->adresse = $request->adresse;
        $client->save();
       
        return redirect()->to('/clients');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client_client= Client::find($id);  

        $client_client->delete();
    }
}
