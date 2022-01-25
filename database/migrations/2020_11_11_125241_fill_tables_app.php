<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class FillTablesApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('menus')->insert(array(
            'nom' => 'product',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ));
        DB::table('menus')->insert(array(
            'nom' => 'client',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ));
        DB::table('menus')->insert(array(
            'nom' => 'users',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ));
        DB::table('users')->insert(array(
            'email' => 'mehdi@gmail.com',
            'name' => 'mehdi',
            'password' =>  Hash::make('mehdi@1111111111'),
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ));
        DB::table('roles')->insert(array(
            'slug' => 'admin',
            'name' => 'Admin',
            'color' =>  '#DD2626FF',
            'permissions' =>  '{"order.read": true, "users.read": true, "client.read": true, "product.read": true, "users.create": true, "users.delete": true, "users.update": true, "client.create": true, "client.delete": true, "client.update": true, "product.create": true, "product.delete": true, "product.update": true}',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ));
        DB::table('role_users')->insert(array(
            'user_id' => '1',
            'role_id' => '1',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ));
        DB::table('role_users')->insert(array(
            'user_id' => '1',
            'role_id' => '1',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('menus')->where('nom','=','product')->delete();
        DB::table('menus')->where('nom','=','client')->delete();
        DB::table('menus')->where('nom','=','users')->delete();
        DB::table('users')->where('email','=','mehdi@gmail.com')->delete();
        DB::table('users')->where('user_id','=','1')->delete();
        
    }
}
