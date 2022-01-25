@extends('layouts.master')
@section('main-content')
           <div class="breadcrumb">
                <h1>Dashboard</h1>
             
            </div>

            <div class="separator-breadcrumb border-top"></div>

            <div class="row">
                <!-- ICON BG -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Add-User"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Utilisateurs</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{$count_user}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Checkout-Basket"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Produits</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{$product_count}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Receipt-3"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Devis</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{$devis_count}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Target"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Visite</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{$visite_count}}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
            
                <div class="col-lg-4 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title">Les utilisateurs les plus Commandés</div>
                          <input id='test' type="hidden" value="ttt">
                            <div id="echartPie" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>

    


       



@endsection

@section('page-js')
     <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>

   
     <script>
        var user_statistique_order = []
        user_statistique_order ={!! json_encode($user_statistique_order) !!}
       
     </script>



@endsection
