
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/toastr.css')}}">
<link rel="stylesheet" type="text/css" href={{ asset('css_vuetify/materialdesignicons.min.css') }}>
<link rel="stylesheet" type="text/css" href={{ asset('css_vuetify/vuetify.min.css') }}>
<link rel="stylesheet" type="text/css" href={{ asset('assets/styles/css/custom_vuetify.css') }}>
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection
@extends('layouts.master')
@section('main-content')
<style>
   .theme--light .teal {
   background-color: #009688!important;
   border-color: #009688!important;
   }
</style>
<div class="breadcrumb">
   <h1>  Assigner Permission </h1>
</div>
<div class="col-md-12">
   <div class="alert alert-card alert-warning text-center" role="alert">
      NB: il faut choisir soit <strong> Supprimer et modifier et valider les commande </strong> ou <strong> Ajouter </strong>ou <strong>Voir les commande valide </strong> il faut pas selectionne tous les trois options
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
           <span aria-hidden="true">×</span>
       </button>
   </div>
</div>
<style>
   .text-center{
   text-align: center;
   }
   .checkbox, .radio {
   display: initial !important;
   }
   .checkbox_pos {
   MARGIN-TOP: 5PX;
   MARGIN-BOTTOM: -12PX;
   }
   th.row_order {
    background-color: #f1f8ff;
    }
</style>
<body>
   <table id="feature_disable_table" class="display table table-striped table-bordered dataTable" style="width: 100%;" role="grid">
      <thead>
         <th>
            <div class="pl-1">Role</div>
         </th>
         <th>
            <div class="pl-1"> Page </div>
         </th>
         <th class="text-center row_order">Supprimer et modifier et valider les commande</th>
      
         <th class="text-center row_order">Ajouter</th>
         <th class="text-center row_order">Voir les commande valide</th>
         <th class="text-center ">Accéder a la page</th>
      </thead>
      <tbody>
         @foreach ($permissions  as $permission)

         <tr>
            <td>
               <div class="pl-1"> {{$permission["role_nom"]}}</div>
            </td>
            <td>
               <div class="pl-1"> <strong>{{$menu}}</strong> </div>
            </td>
            <td class="text-center">
               <div class="checkbox_pos">
                  <label class="checkbox checkbox-outline-primary">
                  <input type="checkbox" class="role-permission" data-page="{{$menu}}" data-key="delete_validation" data-role="{{$permission["role_slug"]}}" @isset($permission[$permission["role_slug"]][$menu.".delete_validation"])  @if ($permission[$permission["role_slug"]][$menu.".delete_validation"]) checked  @endif @endisset >
                  <span class="checkmark"></span>
                  </label>
               </div>
               <br>
            </td>
            <td class="text-center">
               <div class="checkbox_pos">
                  <label class="checkbox checkbox-outline-primary">
                  <input type="checkbox" class="role-permission" data-page="{{$menu}}" data-key="create" data-role="{{$permission["role_slug"]}}" @isset($permission[$permission["role_slug"]][$menu.".create"]) @if ($permission[$permission["role_slug"]][$menu.".create"]) checked  @endif @endisset >
                  <span class="checkmark"></span>
                  </label>
               </div>
               <br>
            </td>
            <td class="text-center">
               <div class="checkbox_pos">
                  <label class="checkbox checkbox-outline-primary">
                  <input type="checkbox" class="role-permission" data-page="{{$menu}}" data-key="view" data-role="{{$permission["role_slug"]}}" @isset($permission[$permission["role_slug"]][$menu.".view"]) @if ($permission[$permission["role_slug"]][$menu.".view"]) checked  @endif @endisset >
                  <span class="checkmark"></span>
                  </label>
               </div>
               <br>
            </td>
                  <td class="text-center">
               <div class="checkbox_pos">
                  <label class="checkbox checkbox-outline-primary">
                  <input type="checkbox" class="role-permission" data-page="{{$menu}}" data-key="read" data-role="{{$permission["role_slug"]}}" @isset($permission[$permission["role_slug"]][$menu.".read"]) @if ($permission[$permission["role_slug"]][$menu.".read"]) checked  @endif @endisset    >
                  <span class="checkmark"></span>
                  </label>
               </div>
               <br>
            </td>
         </tr>
         
         @endforeach
         <tr>
      </tbody>
   </table>
   @include('utilisateurs.script_permission')
   @endsection
   @section('page-js')
   <script>
      window.laravel ={!! json_encode([
        'token' => csrf_token(),
        'url'   => url('/'),
        'date'   => date('Y-m-d'),
      
      
      ]) !!}
   </script>
   <script src="{{asset('assets/js/vendor/toastr.min.js')}}"></script>
   @endsection