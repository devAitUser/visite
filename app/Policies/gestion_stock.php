<?php

namespace App\Policies;

use App\Models\User;

use Sentinel;

use Illuminate\Auth\Access\HandlesAuthorization;

class gestion_stock
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    

}
