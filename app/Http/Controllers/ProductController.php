<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\File; 

use App\Models\Site;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\Product;
use App\Models\Image;

use Illuminate\Support\Facades\Auth;

use Gate;

use Sentinel;






class ProductController extends Controller
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


       return view('product.indexProduct');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

       
        return view('product.add_Product'); 
    }

    


    public function get_product()
    {
        $products= Product::all(); 
   
       

        $data = array( 'products'=> $products);
        return $data;

        echo json_encode($data);
        exit;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function stote_img(Request $request){

        $new_img = new Image();

        if($request->hasFile('file')){

            $file = $request->file;
    
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName);

           $new_img->nom = $fileName;
        
        }
        $new_img->save();

        return Response()->json([ 'id' => $new_img->id  ]);
    }

    public function dropzoneRemove( $id)
    {
        $photo = Image::find($id);
        $destinationPath = public_path(). "\images" .$photo->nom;

            if(file_exists($destinationPath)) {
                File::delete($destinationPath);
                $photo->delete() ;   //Delete file record from DB

                 return response('Photo deleted', 200); //return success
            }

      
     }

     

     public function update(Request $request)
     {
        if($request->designation == ''){
            return Response()->json([ 'etat' => false , 'text' => 'Le champs text est obligatoire' ]);
            exit;
        }
        

        

 
         $update_Product = product::find($request->id); 
         $update_Product->designation = $request->input('designation');

      
         $update_Product->save();   
         return Response()->json(['etat' => true ]);
    

  
 
     }

    public function store(Request $request)
    {
            
        if( $request->designation == '' ){
            return Response()->json([ 'etat' => false , 'text' => 'designation' ]);
            exit;
        }
        


        if($request->isMethod('post')){
            $add_Product= new Product();
            $add_Product->designation = $request->input('designation');
            $add_Product->save(); 
            session()->flash('succes','le produit '.$add_Product->designation.' a été bien enregistré');
           return Response()->json(['etat' => true ]);      
            
        }
 

    }

 
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_data_product(Request $request)
    {
        $product   = Product::find($request->productId);

        $data = array( 'product'=> $product);

        echo json_encode($data);
        exit;

    }

    public function search_product(Request $request)
    {
       $products=  Product::where('titre', 'like', $request->term.'%')->get();
       $output = array();
       if( $products->count() > 0)
       {
           foreach($products as $row)
           {
               $temp_array = array();
               $temp_array['value'] = $row['titre'];
               $temp_array['value_hidden'] = $row['id'];
               $temp_array['label'] = '<img src="/storage'.$row['photo'].'" width="70" />&nbsp;&nbsp;&nbsp;'.$row['titre'].'';
               $output[] = $temp_array;
           }
       }
       else
       {
           $output['value'] = '';
           $output['label'] = 'Aucun Enregistrement Trouvé';
       }
   
       echo json_encode($output);

      

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products   = Product::find($id);


        $product =  array( 
        'id'=> $products->id ,
 
        'designation'=> $products->designation,

        
        );
        



         
        


    
     
        $data = array( "product" => $product );
        return view('product.update_Product',$data)  ; 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    public function type_product($id)
    {
       
        $product_type = Product::where('type', '=', $id)->where('quantite', '!=' , 0)->get(); 

        echo json_encode($product_type);
        exit;

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_Product= Product::find($id);  

        $delete_Product->delete();

        echo json_encode('ok');
    }
}
