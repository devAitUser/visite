<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item {{ request()->is('home')  ? 'active' : '' }}  {{ request()->is('/')  ? 'active' : '' }}" >
                <a class="nav-item-hold" href="{{ route('home') }}">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('visites')  ? 'active' : '' }}  " >
                <a class="nav-item-hold" href="{{ url('visites')}}">
                    <i class="nav-icon i-Calendar-4"></i>
                    <span class="nav-text">Visites</span>
                </a>
                <div class="triangle"></div>
            </li>

  



    
              
           
             <li class="nav-item @if (Route::current()->getName() == 'product.edit'  ) active @endif {{ request()->is('product/create') ? 'active' : '' }} {{ request()->is('product') ? 'active' : '' }}"  >
                <a class="nav-item-hold" href="{{ url('product') }}">
                    <i class="nav-icon i-Shop-2"></i>
                    <span class="nav-text"> Produits</span>
                </a>
                <div class="triangle"></div>
             </li>

             <li class="nav-item {{ request()->is('clients')  ? 'active' : '' }}  {{ request()->is('clients/index')  ? 'active' : '' }}"  >

                <a class="nav-item-hold" href="{{ url('clients')}}">
                    <i class="nav-icon i-Network"></i>
                    <span class="nav-text"> Clients</span>
                </a>
                <div class="triangle"></div>
             </li>
     
        
            <li class="nav-item {{ request()->is('devis')  ? 'active' : '' }}  {{ request()->is('devis/create')  ? 'active' : '' }}" >
                <a class="nav-item-hold" href="{{ url('devis')}}">
                    <i class="nav-icon i-Receipt-3"></i>
                    <span class="nav-text">Devis</span>
                </a>
                <div class="triangle"></div>
            </li>
       
         
        
        </ul>
    </div>


    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->