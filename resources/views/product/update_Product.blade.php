@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/quill.bubble.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/quill.snow.css')); ?>">
<link rel="stylesheet" type="text/css" href={{ asset('assets/styles/css/custom_style.css') }}>
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/dropzone.min.css')); ?>">
@endsection
@section('main-content')
<div class="breadcrumb">
   <h1>  Ajouter un produit</h1>
</div>
<div id="msg"></div>
<div class=" border-top"></div>


<style>
   .dropzone .dz-preview .dz-image img {
    width: 150px;
    height: 150px;
    }
    .dz-max-files-reached {
    pointer-events: none ;
    cursor: default;
       }
</style>

   <div class="card mt-3">
      <!--begin::form-->
      <div class="card-header bg-transparent">
         <p class="submit_mandatory ">* Le champ Description ne pas obligatoire </p>
      </div>

   <input type="hidden" value="{{ $product['id'] }}" id="id">
     
      <div class="card-body">
         <div class="row">
            <div class="col-md-2"> <label for="name" class="product-label text-dark">Description de produit</label></div>
            <div class="col-md-10">
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="inputtext11" class="ul-form__label">Designation*</label>
                     <input value="{{  $product['designation'] }}" id="titre" type="text"  name="titre" class="form-control input-product control_input"  >
                     <small  class="ul-form__text form-text ">
                     Veuillez choisir le Titre de designation.
                     </small>
                  </div>
             
                
                 
                  
     
             
               </div>
            </div>
         </div>
      </div>
      <!-- end::form 3-->
   </div>


   <div class="card mt-3">

      <div class="card-footer">
         <div class="mc-footer">
            <div class="row">
               <div class="col-lg-12 text-center">
                  <button   type="submit" id="submit-all" class="btn  btn-primary m-1">Save</button>
                  <button type="button" class="btn btn-outline-secondary m-1">Cancel</button>
               </div>
            </div>
         </div>
      </div>
      <!-- end::form 3-->
   </div>


@endsection
@section('page-js')
<script>

   window.img ={!! json_encode([
     'id' => csrf_token(),
     'url'=>  url('/'),

   ]) !!}

</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
<script src="<?php echo e(asset('assets/js/vendor/quill.min.js')); ?>"></script>
<script src="{{asset('assets/js/quill.script.js')}}"></script>
<script src="<?php echo e(asset('assets/js/vendor/dropzone.min.js')); ?>"></script>
<script src="{{ asset('js/dropezone_add.js') }}"></script>
<script src="{{ asset('js/product_update.js') }}"></script>



@endsection

