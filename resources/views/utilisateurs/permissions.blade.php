
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
         <th class="text-center">Créer</th>
         <th class="text-center">Accéder a la page</th>
         <th class="text-center">Modifier</th>
         <th class="text-center">Supprimer</th>
      </thead>
      <tbody>
         @foreach ($permissions  as $permission)
         @foreach ($menu as $menu_page)
         <tr>
            <td>
               <div class="pl-1"> {{$permission["role_nom"]}}</div>
            </td>
            <td>
               <div class="pl-1"> <strong>{{$menu_page->nom}}</strong> </div>
            </td>
            <td class="text-center">
               <div class="checkbox_pos">
                  <label class="checkbox checkbox-outline-primary">
                  <input type="checkbox" class="role-permission" data-page="{{$menu_page->nom}}" data-key="create" data-role="{{$permission["role_slug"]}}" @isset($permission[$permission["role_slug"]][$menu_page->nom.".create"])  @if ($permission[$permission["role_slug"]][$menu_page->nom.".create"]) checked  @endif @endisset >
                  <span class="checkmark"></span>
                  </label>
               </div>
               <br>
            </td>
            <td class="text-center">
               <div class="checkbox_pos">
                  <label class="checkbox checkbox-outline-primary">
                  <input type="checkbox" class="role-permission" data-page="{{$menu_page->nom}}" data-key="read" data-role="{{$permission["role_slug"]}}" @isset($permission[$permission["role_slug"]][$menu_page->nom.".read"]) @if ($permission[$permission["role_slug"]][$menu_page->nom.".read"]) checked  @endif @endisset    >
                  <span class="checkmark"></span>
                  </label>
               </div>
               <br>
            </td>
            <td class="text-center">
               <div class="checkbox_pos">
                  <label class="checkbox checkbox-outline-primary">
                  <input type="checkbox" class="role-permission" data-page="{{$menu_page->nom}}" data-key="update" data-role="{{$permission["role_slug"]}}" @isset($permission[$permission["role_slug"]][$menu_page->nom.".update"]) @if ($permission[$permission["role_slug"]][$menu_page->nom.".update"]) checked  @endif @endisset >
                  <span class="checkmark"></span>
                  </label>
               </div>
               <br>
            </td>
            <td class="text-center">
               <div class="checkbox_pos">
                  <label class="checkbox checkbox-outline-primary">
                  <input type="checkbox" class="role-permission" data-page="{{$menu_page->nom}}" data-key="delete" data-role="{{$permission["role_slug"]}}" @isset($permission[$permission["role_slug"]][$menu_page->nom.".delete"]) @if ($permission[$permission["role_slug"]][$menu_page->nom.".delete"]) checked  @endif @endisset >
                  <span class="checkmark"></span>
                  </label>
               </div>
               <br>
            </td>
         </tr>
         @endforeach
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