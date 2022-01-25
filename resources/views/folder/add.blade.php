@extends('layouts.master')
@section('main-content')
<link rel="stylesheet" type="text/css" href={{ asset('css_vuetify/materialdesignicons.min.css') }}>
<link rel="stylesheet" type="text/css" href={{ asset('css_vuetify/vuetify.min.css') }}>
<link rel="stylesheet" type="text/css" href={{ asset('assets/styles/css/custom_vuetify.css') }}>
<link rel="stylesheet" type="text/css" href={{ asset('assets/styles/css/css_switch_toggle.css') }}>
<link rel="stylesheet" type="text/css" href={{ asset('assets/styles/css/vue-treeselect.min.css') }}>


<div class="breadcrumb">
   <h1>  Gestion des fichiers </h1>
</div>
<div id="app_folder" data-app>
   <div class="row">
      <div class="col-md-12">
         <v-card
            class="mx-auto"
            >
            <v-col
            class="d-flex"
            cols="12"
            sm="6"
          >
     
          </v-col>
         <v-sheet class="pa-4 p-3  addfolder">
            <div class="row">
               <div class="col-md-6">
                  <div class="my-4 subtitle-1  h5">
                     Ajouter Fichiers ou Dossier
                  </div>
                  <div class="mt-3  ">Choisir le répertoire de votre  <strong>Fichier ou Dossier</strong></div>
                  <v-text-field  
                  v-model="folder.name_item"
               
                  label="Nom de Dossier"
                  dark
                  flat
                  solo-inverted
                  hide-details
                  clearable
                  clear-icon="mdi-close-circle-outline"
                  ></v-text-field>

                  <v-text-field  
                  v-model="folder.name_item"
                  class="pt-3"
                  label="Description"
                  dark
                  flat
                  solo-inverted
                  hide-details
                  clearable
                  clear-icon="mdi-close-circle-outline"
                  ></v-text-field>
         
                  
                  <div class="mt-3  ">Choisir le type </div>
                  <div class="radio-btn-group mt-1 mb-2">
                     <div class="radio"><input    @change="changeState()"  type="radio" name="radio" value="folder" checked="checked" v-model="checked" id="folder"  /><label for="folder">Dossier</label></div>
                     <div class="radio"><input  @change="changeState()" type="radio" name="radio" value="file" v-model="checked" id="file" /><label for="file">Fichier</label></div>
                  </div>
               
                  <template v-if="show_input_file">
                     <v-file-input
                        v-model="folder.file"
                        color="deep-purple accent-4"
                        counter
                        label="File input"
                        multiple
                        placeholder="Select your files"
                        prepend-icon="mdi-paperclip"
                        outlined
                        :show-size="1000"
                        >
                        <template v-slot:selection="{ index, text }">
                           <v-chip
                              v-if="index < 2"
                              color="deep-purple accent-4"
                              dark
                              label
                              small
                              >
                              @{{ text }}
                           </v-chip>
                           <span
                              v-else-if="index === 2"
                              class="overline grey--text text--darken-3 mx-2"
                              >
                           +@{{ files.length - 2 }} File(s)
                           </span>
                        </template>
                     </v-file-input>
                  </template>
                  <v-btn
                     class="ma-2 mt-3"
                     :loading="loading2"
                     :disabled="loading2"
                     color="success"
                     @click="add_item"
                     >
                     Ajouter
                  </v-btn>
               </div>
            </div>
         </v-sheet>
         <template>
            <v-card>
               <v-tabs horizontal>
                  <v-tab>
                     <v-icon left>
                        mdi-table-large   
                     </v-icon>
                  Champs
                  </v-tab>
                  {{-- <v-tab>
                     <v-icon left>
                        mdi-folder-multiple-outline
                     </v-icon>
                     Répertoire &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </v-tab> --}}
                  <v-tab>
                     <v-icon left>
                        mdi-access-point
                     </v-icon>
                     Option 3 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </v-tab>
                  <v-tab-item>
                     <template >
                        <v-form class="m-3 p-3"
                          ref="form"
                          v-model="valid"
                          lazy-validation
                        >
                        <v-row>
                           <v-col> 
                              
                          <v-select
                          :items="item_fields"
                          filled
                          label="Choisir le champ"
                          dense
                        ></v-select>
                           
                           </v-col>

                           <v-col> 

                              <v-btn
                              tile
                              color="success"
                            >
                              <v-icon left>
                                 mdi-plus
                              </v-icon>
                           
                            </v-btn>

                           </v-col>


                        </v-row>
                       
          
     


                       
                      
                   
                      
                          <v-btn
                            :disabled="!valid"
                            color="success"
                            class="mr-4"
                            @click="validate"
                          >
                            Validate
                          </v-btn>
                      
                    
                      
                      
                        </v-form>
                      </template>
                  </v-tab-item>
                  {{-- <v-tab-item>
                     <v-card flat>
                        <h5 class="mt-3">  Répertoire des Fichiers</h5>
                        <v-app >
                           <v-treeview v-model="tree" :open="open" :items="items" item-key="name">
                              <template v-slot:prepend="{ item, open }">
                                 <v-icon v-if="!item.file">
                                    @{{ open ? 'mdi-folder-open' : 'mdi-folder' }}          
                                 </v-icon>
                                 <v-icon v-else @click="buscaBlob(item)">
                                    @{{ files[item.file] }}
                                 </v-icon>
                              </template>
                           </v-treeview>
                        </v-app>
                     </v-card>
                  </v-tab-item> --}}
                  <v-tab-item>
                     <v-card flat>
                        <v-card-text>
                           <p>
                              Fusce a quam. Phasellus nec sem in justo pellentesque facilisis. Nam eget dui. Proin viverra, ligula sit amet ultrices semper, ligula arcu tristique sapien, a accumsan nisi mauris ac eros. In dui magna, posuere eget, vestibulum et, tempor auctor, justo.
                           </p>
                           <p class="mb-0">
                              Cras sagittis. Phasellus nec sem in justo pellentesque facilisis. Proin sapien ipsum, porta a, auctor quis, euismod ut, mi. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nam at tortor in tellus interdum sagittis.
                           </p>
                        </v-card-text>
                     </v-card>
                  </v-tab-item>
               </v-tabs>
            </v-card>
         </template>
      </div>
   </div>
</div>
@endsection
@section('page-js')
<script src="{{ asset('js/plugins/vue.js') }}"></script>
<script src="{{ asset('js/plugins/vue-treeselect.umd.min.js') }}"></script>
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
<script src="{{ asset('js/add_file_parent.js') }}"></script>


@endsection