@extends('layouts.master')
@section('main-content')

           <link rel="stylesheet" type="text/css" href={{ asset('css_vuetify/materialdesignicons.min.css') }}>
           <link rel="stylesheet" type="text/css" href={{ asset('css_vuetify/vuetify.min.css') }}>
           <link rel="stylesheet" type="text/css" href={{ asset('assets/styles/css/custom_vuetify.css') }}>
           
           <div class="breadcrumb">
                <h1>  La liste des clients</h1>
            
            </div>

            @include('layouts.common.flash_message')

            <div class=" border-top"></div>
            
            <div id="app_client" data-app>
         

               <div class="row">
                  <div class="col-md-12">
                      <div class="card">
                          <div class="card-header  gradient-purple-indigo  0-hidden pb-80">
                             <div class="pt-4">
                              <div class="row">
                                  <h4 class="col-md-4 text-white">clients</h4>
                                  <input v-model="search" type="text" class="form-control form-control-rounded col-md-4 ml-3 mr-3"  append-icon="mdi-magnify" placeholder="Rechercher produits ...">
                                  <i aria-hidden="true" class="v-icon notranslate btn_search mdi mdi-magnify theme--light"></i>
                              </div>
                             </div>
                          </div>
                          <div class="card-body">
                              <div class="ul-contact-list-body">
                                  <div class="ul-contact-main-content">
                                   
                                      <div class="ul-contact-content">
                                          <div class="card">
                                            
                                             <v-card>
                                                <v-card-title>
                                                 la liste des clients
                                                   <v-spacer></v-spacer>
                                                   
                                                </v-card-title>


                                                <v-card-title class="text-right">

                                                    <v-spacer></v-spacer>


                                                    <a href="{{url('clients/create')}}"  class="btn btn-primary btn-md m-1 text-white "><i class="nav-icon i-Shopping-Basket"></i>    Nouveau  </a>

                                                    @if ($user_logged->inRole('admin'))
                                                          @if ($user_logged->hasAccess(['product.delete']))

                                                    <button   @click="remove_item" type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-primary btn-md m-1 text-white"><i class="i-Close mr-2"></i>   Supprimer </button>

                                                       @endif
                                                     @endif

                                                    </v-card-title>
                                              
                                                <v-data-table  @input="item($event)" :headers="headers" :items="clients" :search="search" :value="selectedRows" v-model="selected" :items-per-page="5"  :sort-by.sync="sortBy"
                                             :sort-desc.sync="sortDesc" show-select   item-key="id"
                                      :expanded.sync="expanded" @click:row="clicked">
                                    <template v-slot:item.img="{ item }">
                                       <img :src="'images/' + item.photo" style="width: 55px; height: 55px" />
                                    </template>
                                    
                                    <template v-slot:item.action="{ item }">
                                        <v-btn color="purple" fab small dark  @click="editItem(item)">
                                            <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                         </v-btn>
                                    </template>
                   
                     </v-data-table>
                                              
                                             </v-card>
                                             
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
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
            <script src="{{ asset('js/app_client.js') }}"></script>

@endsection



