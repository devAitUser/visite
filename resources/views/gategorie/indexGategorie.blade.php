@extends('layouts.master')
@section('main-content')

           <link rel="stylesheet" type="text/css" href={{ asset('css_vuetify/materialdesignicons.min.css') }}>
           <link rel="stylesheet" type="text/css" href={{ asset('css_vuetify/vuetify.min.css') }}>
           <link rel="stylesheet" type="text/css" href={{ asset('assets/styles/css/custom_vuetify.css') }}>
           
           <div class="breadcrumb">
                <h1>  La liste des Gategories</h1>
            
            </div>

            <div class=" border-top"></div>

        

            <div id="app_gategorie" data-app>
         

               <div class="row">
                  <div class="col-md-12">
                      <div class="card">
                          <div class="card-header  gradient-purple-indigo  0-hidden pb-80">
                             <div class="pt-4">
                              <div class="row">
                                  <h4 class="col-md-4 text-white">Gategories</h4>
                                  <input v-model="search" type="text" class="form-control form-control-rounded col-md-4 ml-3 mr-3"  append-icon="mdi-magnify" placeholder="Rechercher Gategories ...">
                                  <i aria-hidden="true" class="v-icon notranslate btn_search mdi mdi-magnify theme--light"></i>
                              </div>
                             </div>
                          </div>
                          <div class="card-body">
                              <div class="ul-contact-list-body">
                                  <div class="ul-contact-main-content">
                                      <div class="ul-contact-left-side">
                                          <div class="card">
                                              <div class="card-body">
                                                  <div class="ul-contact-list">
                                                      <div class="contact-close-mobile-icon float-right mb-2">
                                                          <i class="i-Close-Window text-15 font-weight-600"></i>
                                                      </div>
                                                      <!-- modal  -->
                                                      
                                                      <button class="btn btn-outline-secondary btn-block mb-4" >
                                                        Parametres
                                                       </button>

                                                      <template>
                                                         <v-row justify="center">
                                                           <v-dialog
                                                             v-model="dialog_add"
                                                             persistent
                                                             max-width="600px"
                                                           >
                                                            
                                                             <v-card>
                                                               <v-form @submit.prevent="validate"   ref="form"
                                                               v-model="valid"
                                                               lazy-validation>
                                                               <v-card-title>
                                                                 <span class="headline">Ajouter un gategorie</span>
                                                               </v-card-title>
                                                               <v-card-text>
                                                                 <v-container>
                                                                
                                                                   <v-row>
                                                                     <v-col cols="12" sm="6" md="12"  >

                                                                        <v-text-field
                                                                         label="Nom*"
                                                                         v-model="gategorie_a.nom"
                                                                         :rules="nameRules"
                                                                         required
                                                                       ></v-text-field>

                                                                     </v-col>
                                                
                                                                      
                                                                    
                                                                    
                                                                     <v-col cols="12" sm="6" md="12" >

                                                                        <v-text-field
                                                                        label="date creation*"
                                                                        v-model="gategorie_a.date_create"
                                                                        required
                                                                        disabled
                                                                      ></v-text-field>
                                                                      
                                                                    </v-col>
                                                                      
                                                                     
                                                                    
                                                                  
                                                                  
                                                                    
                                                                     
                                                                   </v-row>
                                                                 
                                                                 </v-container>
                                                                 <small>* indique le champ obligatoire</small>
                                                               </v-card-text>
                                                               <v-card-actions>
                                                                 <v-spacer></v-spacer>
                                                                 <v-btn
                                                                 color="primary mr-3"
                                                                 dark
                                                                  
                                                                   @click="dialog_add = false"
                                                                 >
                                                                   Fermer 
                                                                 </v-btn>
                                                                 <v-btn color="error" class="mr-4" @click="resetValidation">
                                                                  Effacer
                                                                  </v-btn>
                                                                 <v-btn class="mr-4" type="submit"  :disabled="!valid"
                                                                 color="success"
                                                                 class="mr-4">
                                                                  Ajouter
                                                                 </v-btn>
                                                               </v-card-actions>
                                                              </v-form>
                                                             </v-card>
                                                           </v-dialog>
                                                         </v-row>
                                                       </template>   
                                                      
   
                                                      <!-- end:modal  -->
   
   
                                                      <div class="list-group" id="list-tab" role="tablist">
                                                          <a    @click="dialog_add = true" class="list-group-item list-group-item-action border-0" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home" aria-selected="false">
                                                              <i class="nav-icon i-Add-Window"></i>
                                                              Nouveau Gategorie</a>
                                                       
                                                          <a  @click="remove_item" class="list-group-item list-group-item-action border-0" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings" aria-selected="false">
                                                              <i class="nav-icon i-Remove"></i>
                                                              Supprimer</a>
   
                                                          <label for="" class="text-muted font-weight-600 py-8">MEMBERS</label>
   
                                                          <a class="list-group-item list-group-item-action border-0 " id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                                                              <i class="nav-icon i-Arrow-Next"></i>
                                                              Contact List</a>
                                                          <a class="list-group-item list-group-item-action border-0 active show" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile" aria-selected="true">
                                                              <i class="nav-icon i-Arrow-Next"></i>
                                                              Conected</a>
                                                          <a class="list-group-item list-group-item-action border-0" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings" aria-selected="false">
                                                              <i class="nav-icon i-Arrow-Next"></i>
                                                              Settings</a>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="ul-contact-content">
                                          <div class="card">
                                            
                                             <v-card>
                                                <v-card-title>
                                                 la liste des Gategories
                                                   <v-spacer></v-spacer>
                                                   
                                                </v-card-title>
                                              
                                                <v-data-table  @input="item($event)" :headers="headers" :items="gategorie" :search="search" :value="selectedRows" v-model="selected" :items-per-page="5"  :sort-by.sync="sortBy"
                                                :sort-desc.sync="sortDesc" show-select   item-key="id"
                                                :expanded.sync="expanded" @click:row="clicked">
                                                <template v-slot:item.action="{ item }">
                                                   <v-btn color="purple" fab small dark  @click="editItem(item)">
                                                      <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                                   </v-btn>
                                                   <v-dialog v-model="dialog" max-width="500px">
                                                      <v-card>
                                                         <v-card-title>
                                                            <span class="headline">Modifier la gategorie</span>
                                                         </v-card-title>
                                                         <v-container>
                                                            <v-row class="pl-3 pr-3" >
                                                               <v-col cols="12" sm="6" md="12">
                                                                  <v-text-field pl="5" v-model="editedItem.nom"  label="Nom"></v-text-field>
                                                               </v-col>
                                                               <v-col cols="12" sm="6" md="12">
                                                                  <v-text-field  v-model="editedItem.date_create" label="Date" disabled></v-text-field>
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
          <script src="{{ asset('js/gategories_vue.js') }}"></script>

@endsection







   


