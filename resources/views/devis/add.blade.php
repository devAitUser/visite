@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.date.css')}}">
<style>
   .table-product.active{
   display: none;
   }
   td.row_p {
   width: 214px;
   }
   .btn-calendrier {
   position: relative;
   left: -40px;
   }
   .quantity {
   display: -webkit-inline-box;
   display: -ms-inline-flexbox;
   display: inline-flex;
   }
   .quantity input[type=button] {
   padding: 0 5px;
   min-width: 25px;
   height: 35px;
   border: 2px solid rgba(129,129,129,.2);
   background: 0 0;
   -webkit-box-shadow: none;
   box-shadow: none;
   }
   .quantity input[type=number] {
   width: 30px;
   height: 35px;
   border-right: none;
   border-left: none;
   }
   input[type=text], input[type=email], input[type=password], input[type=search], input[type=number], input[type=url], input[type=tel], input[type=date], select, textarea {
   padding: 0 15px;
   max-width: 100%;
   width: 100%;
   height: 35px;
   border: 2px solid rgba(129,129,129,.2);
   border-radius: 0;
   background-color: #fff !important;
   -webkit-box-shadow: none;
   box-shadow: none;
   vertical-align: middle;
   font-size: 14px;
   -webkit-transition: border-color .5s ease;
   transition: border-color .5s ease;
   } 
   input[type=number] {
   padding: 0;
   text-align: center;
   }
   .quantity input[type=button], .quantity input[type=number] {
   display: inline-block;
   color: #777;
   } 
   .quantity input[type=number], .quantity input[type=number]::-webkit-inner-spin-button, .quantity input[type=number]::-webkit-outer-spin-button {
   margin: 0;
   -webkit-appearance: none;
   -moz-appearance: none;
   appearance: none;
   }
</style>
@endsection
@section('main-content')
<div class="breadcrumb">
   <h1>Nouveau devis</h1>
</div>

@if (session()->has('no_product'))

    <script>   
    alert('Vous devez choisir au moins un produit');
   
   </script>


@endif


<div class="separator-breadcrumb border-top"></div>
<form action="{{ url('devis')}}" method="POST" id="FormOrder" onsubmit="return validateForm();">
   {{ csrf_field() }}
   <section class="chekout-page">
      <div class="row">
         <div class="col-lg-12 mb-3">
            <div class="card">
               <div class="card-body">
                  <div class="card-body">
                     <div class="card-title">Devis</div>
                     <div class=" form-row ">
                        <div class="form-group col-md-12">
                           <label for="inputtext11" class="ul-form__label">Objet  :</label>
                           <div class="row">
                              <div class="col-md-11">
                                 <input type="text" name="objet" class="form-control"   >
                                 <input type="hidden" name="date" id="date_system"   >
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="form-row">
                        <div class="form-group col-md-6">
                           <label for="inputtext11" class="ul-form__label">Client  :</label>
                           <div class="row">
                              <div class="col-md-11">
                              <select  id="client" class="js-client-dropdown form-control input-product" style="width: 100%" name="client" required>
                                    <option   value=""> Selectionner le client </option>
                                    @foreach ($clients as $client)
                                   <option  value="{{$client->denomination}}">{{$client->denomination	}}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                        </div>
          
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-6 mb-6">
            <div class="card">
               <div class="card-body">
                  <div class="d-flex justify-content-between">
                     <div class="card-title">les produits existe dans la base données</div>
                     <div class="headder-elements tt">
                        <div class="list-icons">
                           <a href="" class="ul-task-manager__list-icon " id="arrow-down"><i class="i-Arrow-Down"></i></a>
                           <a href="" class="ul-task-manager__list-icon btn-add"><i class="i-Add"></i></a>
                        </div>
                     </div>
                  </div>
                  <div class="table-responsive table-product ">
                     <table id="table_product" class="table">
                        <thead>
                           <tr>
                              <th scope="col">Produit</th>
                              <th scope="col">Unité de mesure</th>
                              <th scope="col">QTE</th>
                              <th scope="col">Prix</th>
                              <th scope="col">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr id='row1'>
                              <td scope="row" class="row_p">
                                
                                 <select   class=" form-control input-product" style="width: 100%" name="product[]" required>
                                    <option   value=""> Selectionner le produit </option>
                                    @foreach ($products as $product)
                                   <option  value="{{$product->designation}}">{{$product->designation}}</option>
                                    @endforeach
                                 </select>
                               
                              </td>
                              <td>
                                 <input type="text" name="unite[]" required>
                              </td>
                              <td>
                                 <input type="number" name="quantity[]" required>
                              </td>
                              <td>
                                 <input type="number" name="prix[]" required>
                              </td>
                              <td>
                                 <a href="" onClick="removeRow(event,1)" ><i class="i-Close-Window text-19 text-danger font-weight-700 prevent-default"></i></a>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
        
            </div>
         </div>
         <div class="col-lg-6">
            <div class="card">
                  <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div class="card-title">insertion des nouveaux produits dans le devis</div>
                        <div class="headder-elements tt">
                            <div class="list-icons">
                              <a href="" class="ul-task-manager__list-icon " id="arrow-down"><i class="i-Arrow-Down"></i></a>
                              <a href="" class="ul-task-manager__list-icon btn-add-n"><i class="i-Add"></i></a>
                            </div>
                        </div>
                      </div>
                      <div class="table-responsive table-product ">
                        <table id="table_product-n" class="table">
                            <thead>
                              <tr>
                                 <th scope="col">Produit</th>
                                 <th scope="col">Unité de mesure</th>
                                 <th scope="col">QTE</th>
                                  <th scope="col">Prix</th>
                                  <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr id='row_1'>
                                  <td scope="row" class="row_p">
                                      <input type="text" name="product[]" required>
                                
                                  </td>
                                  <td>
                                    <input type="text" name="unite[]" required>
                                  </td>
                                  <td>
                                    <input type="number" name="quantity[]" id="" required>
                                  </td>
                                  <td>
                                    <input type="number" name="prix[]" id="" required>
                                  </td>
                                  <td>
                                    <a href="" onClick="removeRow_table(event,1)" ><i class="i-Close-Window text-19 text-danger font-weight-700 prevent-default"></i></a>
                                  </td>
                              </tr>
                            </tbody>
                        </table>
                      </div>
                  </div>
   
              </div>
         </div>
    


            <div class="col-lg-12">
               <div class="card-footer">
                  <div class="mc-footer">
                      <div class="row">
                        <div class="col-lg-12 text-center">
                          
                            <button type="submit" class="btn d-inline  btn-primary m-1" type="button">
                            Créer
                            </button>
                          
                            <button type="button" class="btn btn-outline-secondary m-1">Annuler</button>
                        </div>
                      </div>
                  </div>
                </div>
                <!-- end::form 3-->
            </div>
      
      </div>
   </section>
</form>
@endsection
@section('page-js')

<script src="{{ asset('js/plugins/jquery-3.5.1.min.js') }}"></script>
<link href="{{asset('assets/styles/css/select2.min.css')}}" rel="stylesheet" />
<script src="{{ asset('js/plugins/select2.min.js') }}"></script>
<script src="{{asset('assets/js/vendor/pickadate/picker.js')}}"></script>
<script>
   window.laravel ={!! json_encode([
     'token' => csrf_token(),
     'url'   => url('/'),
     'date'   => date('Y-m-d'),
   
   
   ]) !!}
   
   
   
   
</script>
<script src="{{ asset('js/order_script.js') }}"></script>
@endsection
@section('bottom-js')
<script src="{{asset('assets/js/form.basic.script.js')}}"></script>
@endsection