<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use App\Models\Devi;
use App\Models\Product_devi;
use Illuminate\Support\Facades\Auth;
use PDF;
use \NumberFormatter;

class DevisController extends Controller
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
       return view('devis.index');
    }


    public function getdevis(Request $request)
    {
        $devis = Devi::all(); 
        $data = array( 'devis'=> $devis);
        return  $data ;

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        $products= Product::all();
        $clients = Client::all();


        
         


       
         

        $data = array( 'products'=> $products , 'clients'=> $clients   );
        return view('devis.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       

       


        if (!$request->product) {

            session()->flash('no_product','no_product');
            return redirect()->to('/devis/create');

        } else {


            if($request->isMethod('post')){

                $add_devis = new Devi();
                $add_devis->objet= $request->input('objet');
                $add_devis->date= $request->input('date');
                $add_devis->client= $request->input('client');
                $add_devis->save();
    
                for($i=0;$i<count($request->product);$i++){
                    $product_devis = new Product_devi();
                    $product_devis->devis_id  = $add_devis->id;
                    $product_devis->designation = $request->product[$i];
                    $product_devis->quantite = $request->quantity[$i];
                    $product_devis->unite = $request->unite[$i];
                    $product_devis->prix = $request->prix[$i];
                    $product_devis->save();
                }
    
                return redirect()->to('/devis');
            
            }
           



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
        $client = Client::find($request->id);
        $client->nom = $request->nom;
        $client->telephone = $request->telephone;
        $client->adresse = $request->adresse;
       
        $client->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client_client= Devi::find($id);  

        $client_client->delete();
    }

    function pdf($id)
    {

     $devis= Devi::find($id);


     $products = Product_devi::where('devis_id', '=', $devis->id)->get(); 

     
     for($i=0;$i<count($products);$i++)
     {
         $table_product[] = (object) [ 
         'id'=> $products[$i]->id ,
          'designation'=> $products[$i]->designation,
          'unite'=> $products[$i]->unite ,
          'quantite'=> $products[$i]->quantite ,
          'prix'=> $products[$i]->prix , 
          'prix_total'=> $products[$i]->prix * $products[$i]->quantite , 
         ];
         $sum[] =  $products[$i]->prix * $products[$i]->quantite ;
 
     }

    function sumArray($array) {
        $total = 0;
        foreach ($array as $value) {
            $total += $value;
        }
   
        return $total;
     }

     function calcul_tva($value) {
        $value = $value * 0.20;
        return $value;
     }

    $calcul_total_htva = sumArray($sum);
    $calcul_tva= calcul_tva($calcul_total_htva);
    $calcul_ttc= $calcul_tva +  $calcul_total_htva;
    $date = date('d/m/Y ', time());

    $letter_to_number = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);

     $devis['products']=$table_product;
     $devis['current_date']= $date;
     $devis['total_htva']= number_format($calcul_total_htva,2,",",".");
     $devis['tva']= number_format($calcul_tva,2,",",".");
     $devis['ttc']= number_format($calcul_ttc,2,",",".") ;
     $devis['amount_letter']= $letter_to_number->format($calcul_ttc);

     

     
        view()->share('devis', $devis);
       $pdf = PDF::loadView('devis.pdf');
     
     return $pdf->stream();


    }


}
