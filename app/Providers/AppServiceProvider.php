<?php
namespace App\Providers;

use Illuminate\Support\Facades\Schema;

use App\Models\Product;
use App\Policies\gestion_stock;

use View;
use Sentinel;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    protected $policies = [Product::class => gestion_stock::class , ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerPolicies();

        Gate::define('view_all_page_product', function ()
        {
            $value = false;

            $id = Auth::id();
            $user = Sentinel::findById($id);
           

            if (!empty($user->roles[0]))
            {
                $role = $user->roles[0]->slug;
               
               
                if ($user->inRole($role))
                {
                    if ($user->hasAccess(['product.read']))
                    {
                        $value = true;
                    }
                }

            }

            return $value;

        });

        Gate::define('view_page_create_order', function ()
        {
            $value = false;

            $id = Auth::id();
            $user = Sentinel::findById($id);
           

            if (!empty($user->roles[0]))
            {
                $role = $user->roles[0]->slug;
               
               
                if ($user->inRole($role))
                {
                    if ($user->hasAccess(['order.create']))
                    {
                        $value = true;
                    }
                }

            }

            return $value;

        });


        Gate::define('view_all_page_order', function ()
        {
            $value = false;

            $id = Auth::id();
            $user = Sentinel::findById($id);
           

            if (!empty($user->roles[0]))
            {
                $role = $user->roles[0]->slug;
               
               
                if ($user->inRole($role))
                {
                    if ($user->hasAccess(['order.read']))
                    {
                        $value = true;
                    }
                }

            }

            return $value;

        });

        Gate::define('admin_access_all_page_utilisateurs', function ($user)
        {
            $value = false;
            $id=Auth::id();


            if ($id==1)
            {
                $value = true;         

            }
            
            return $value;

        });

        Schema::defaultStringLength(191);

        View::composer('*', function ($view)
        {
            if (Auth::id())
            {
                $id = Auth::id();
                $role = '';
                $user = Sentinel::findById($id);
                if (!empty($user->roles[0]))
                {
                    $role = $user->roles[0]->slug;
                    $role_color = $user->roles[0]->color;
                }
                $view->with('user_logged', $user);
                $view->with('current_user_name_role', $role);
                $view->with('role_color', $role_color);

            }

        });
    }
}

