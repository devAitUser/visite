@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" type="text/css" href={{ asset('css_vuetify/materialdesignicons.min.css') }}>
<link rel="stylesheet" type="text/css" href={{ asset('css_vuetify/vuetify.min.css') }}>
<link rel="stylesheet" type="text/css" href={{ asset('assets/styles/css/custom_vuetify.css') }}>
@endsection
@section('main-content')
<div class="breadcrumb">
   <h1>Lists</h1>
   <ul>
      <li><a href="">Tables</a></li>
      <li>Utilisateurs</li>
   </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<section  id="app_users" data-app>
 

       
               
                     <div class="card">
                        <v-card>


                           <template>
                              <v-row justify="center">
                                 <v-dialog
                                    v-model="dialog_add"
                                    persistent
                                    max-width="600px"
                                    >
                                    <v-card>
                                       <v-form  @submit.prevent="validate"   ref="form"
                                       v-model="valid"
                                       lazy-validation>
                                          <v-card-title>
                                             <span class="headline">Ajouter un utilisateur</span>
                                          </v-card-title>
                                          <v-card-text>
                                             <v-container>
                                                <v-row>
                                                   <v-col cols="12" sm="6" md="12"  >
                                                      <v-text-field
                                                         label="Nom*"
                                                         v-model="user_a.name"
                                                         :rules="nameRules"
                                                         required
                                                         ></v-text-field>
                                                   </v-col>
                                                   <v-col cols="12" sm="6" md="12" >
                                                      <v-text-field
                                                         label="Email*"
                                                         v-model="user_a.email"
                                                        
                                                         :rules="[checkDuplicate, rules.required]"
                                                         required
                                                         ></v-text-field>
                                                   </v-col>
                                                   <v-col cols="12" sm="6" md="12" >
                                                      <v-text-field
                                                         label="password*"
                                                         v-model="user_a.password"
                                                         :type="show1 ? 'text' : 'password'"
                                                         :rules="passwordRules"
                                                         required
                                                         
                                                         ></v-text-field>
                                                   </v-col>
                                                
                                                <v-col cols="12" sm="6" md="12" >

                                                   <v-select
                                                   v-model="user_a.select"
                                                  
                                                   :items="role_items"
                                                   item-text="name" item-value="id"
                                                   label="Selectionner"
                                                   persistent-hint
                                                   return-object
                                                   single-line
                                                   :rules="roleRules"
                                                     required
                                                  ></v-select>

                                                </v-col>


                                                <v-col cols="12" sm="6" md="12" >

                                                   <template>
                                                     
                                                        <v-combobox
                                                          v-model="user_a.project_id"
                                                          :items="items_project"
                                                          :search-input.sync="search_project"
                                                          hide-selected
                                                          item-text="nom" item-value="id"
                                                       
                                                          label="Ajouter des projets"
                                                          multiple
                                                          persistent-hint
                                                          small-chips
                                                          :rules="projetRules"
                                                        >
                                                          <template v-slot:no-data>
                                                            <v-list-item>
                                                              <v-list-item-content>
                                                                <v-list-item-title>
                                                                  Aucun résultat correspondant
                                                                </v-list-item-title>
                                                              </v-list-item-content>
                                                            </v-list-item>
                                                          </template>
                                                        </v-combobox>
                                                     
                                                    </template>

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




                           
                           <v-card-title>
                              Utilisateurs
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

                           
                           <button  @click="dialog_add = true" type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-primary btn-md m-1 text-white "><i class="i-Add-User text-white mr-2"></i>    Ajouter utilisateur</button>
                         
                           <button   @click="remove_item" type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-primary btn-md m-1 text-white"><i class="i-Close mr-2"></i>   Supprimer utilisateur</button>
                           
                            </v-card-title>

                           <v-data-table  @input="item($event)" :headers="headers" :items="users" :search="search" :value="selectedRows" v-model="selected" :items-per-page="5"  :sort-by.sync="sortBy"
                              :sort-desc.sync="sortDesc" show-select  item-key="id"
                              :expanded.sync="expanded" @click:row="clicked">
                              <template v-slot:item.roles="{ item }">

                                     <div  v-if="check_role(item.roles[0])" v-html="get_color(  item.roles[0].name , item.roles[0].color )"> </div>         
                           

                              </template>
                              <template v-slot:item.action="{ item }">
                                 <v-btn class="btn-primary"  fab small  @click="editItem(item)">
                                    <i class="nav-icon f-15 i-Pen-2 font-weight-bold"></i>
                                 </v-btn>
                                 <v-btn class="btn-primary" fab small   @click="delete_single_Item(item)">
                                    <i class="nav-icon  i-Close f-15 font-weight-bold"></i>
                                 </v-btn>
                                 <v-dialog v-model="dialog" max-width="500px">
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
                                                v-model="editedItem.email"
                                                required
                                                ></v-text-field>
                                             </v-col>
                                             <v-col cols="12" sm="6" md="12">
                                                <v-text-field
                                                label="password*"
                                                v-model="editedItem.password"
                                                :type="show1 ? 'text' : 'password'"
                                                required
                                                
                                                ></v-text-field>
                                     
                                             </v-col>
                                             <v-col cols="12" sm="6" md="12">

                                                

                                                <v-select
                                                v-model="editedItem.select"
                                               
                                                :items="role_items"
                                                item-text="name" item-value="id"
                                                label="Selectionner"
                                                persistent-hint
                                                return-object
                                                single-line
                                               ></v-select>
                                 
                                             </v-col>
                                             <v-col cols="12" sm="6" md="12">

                                                <template>
                                                     
                                                   <v-combobox
                                                     v-model="model_project"
                                                     :items="items_project"
                                                     :search-input.sync="search_project"
                                                     hide-selected
                                                     item-text="nom" item-value="id"
                                                     hint="Maximum of 5 tags"
                                                     label="Ajouter des projets"
                                                     multiple
                                                     persistent-hint
                                                     small-chips
                                                   >
                                                     <template v-slot:no-data>
                                                       <v-list-item>
                                                         <v-list-item-content>
                                                           <v-list-item-title>
                                                             Aucun résultat correspondant
                                                           </v-list-item-title>
                                                         </v-list-item-content>
                                                       </v-list-item>
                                                     </template>
                                                   </v-combobox>
                                                
                                               </template>
                                      
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
             
           
        
     
</section>

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
<script src="{{ asset('js/users_vue.js') }}"></script>
@endsection