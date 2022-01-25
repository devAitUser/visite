@extends('layouts.master')
@section('main-content')
<link rel="stylesheet" type="text/css" href={{ asset('css_vuetify/materialdesignicons.min.css') }}>
<link rel="stylesheet" type="text/css" href={{ asset('css_vuetify/vuetify.min.css') }}>
<link rel="stylesheet" type="text/css" href={{ asset('assets/styles/css/custom_vuetify.css') }}>
<div class="breadcrumb">
   <h1>  Gestion des fichiers </h1>
</div>

<div id="app_folder" data-app>
  <div class="card">
    <v-card>


     




       
       <v-card-title>
          Fichiers
       <v-spacer></v-spacer>

       <v-text-field
       v-model="search"
       append-icon="mdi-magnify"
       label="Rechercher"
       single-line
       hide-details ></v-text-field>

     
       
       </v-card-title>

       <v-card-title class="text-right">

          <v-spacer></v-spacer>

       
       <button  @click="add_item" type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-primary btn-md m-1 text-white "><i class="i-Files text-white mr-2"></i>    Ajouter Dossier ou Fichiers </button>
     
       <button   @click="remove_item" type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-primary btn-md m-1 text-white"><i class="i-Close mr-2"></i>   Supprimer utilisateur</button>
       
        </v-card-title>

       <v-data-table  @input="item($event)" :headers="headers" :items="reponse_items" :search="search" :value="selectedRows" v-model="selected" :items-per-page="5"  :sort-by.sync="sortBy"
          :sort-desc.sync="sortDesc" show-select  item-key="id"
          :expanded.sync="expanded" @click:row="clicked">
         
          <template v-slot:item.action="{ item }">
             <v-btn class="btn-primary"  fab small  @click="editItem(item)">
                <i class="nav-icon f-15 i-Pen-2 font-weight-bold"></i>
             </v-btn>
             <v-btn class="btn-primary" fab small   @click="delete_single_Item(item)">
                <i class="nav-icon  i-Close f-15 font-weight-bold"></i>
             </v-btn>
             <v-dialog v-model="dialog" max-width="500px" :retain-focus="false">
                <v-card>
                   <v-card-title>
                      <span class="headline"> Modifier l 'utilisateur   </span>
                   </v-card-title>
                   <v-container>
                      <v-row class="pl-3 pr-3" >
                         <v-col cols="12" sm="6" md="12">
                            <v-text-field
                            label="Nom*"
                            v-model="editedItem.name"
                            required
                            ></v-text-field>
                         </v-col>
                         <v-col cols="12" sm="6" md="12">
                            <v-text-field
                            label="Email*"
                            v-model="editedItem.file"
                            required
                            ></v-text-field>
                         </v-col>
                      
                    
                      </v-row>
                   </v-container>
                   </v-form>
                   </v-card-title>
                   <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="blue darken-1" text @click="close">Annuler</v-btn>
                      <v-btn color="blue darken-1" text @click="save">Sauvegarder
                      </v-btn>
                   </v-card-actions>
                </v-card>
             </v-dialog>
          </template>
          <div class="pt-2 pb-2 pl-2">
             <v-btn class="ma-2" color="purple" dark @click="editItem(item)">
                <v-icon dark>mdi-wrench</v-icon>
             </v-btn>
          </div>
       </v-data-table>
    </v-card>
 </div>
 
</div>
@endsection
@section('page-js')
<script src="{{ asset('js/plugins/vue.js') }}"></script>
<script src="{{ asset('js/plugins/vee-validate.js') }}"></script>
<script src="{{ asset('js/plugins/axios.min.js') }}"></script>
<script src="{{ asset('js/plugins/sweetalert2@9.js') }}"></script>
<script src="{{ asset('js/plugins/vuetify.js') }}"></script>


<script>
   window.laravel ={!! json_encode([
     'token' => csrf_token(),
     'url'   => url('/'),
     'date'   => date('Y-m-d'),
   
   
   ]) !!}
</script>
<script src="{{ asset('js/folder_vue.js') }}"></script>
@endsection


