<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use App\Models\User;
use App\Models\Role_user;
use App\Models\Menu;
use App\Models\Role;
use App\Models\Site;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function get_users()
    {
        $users = Sentinel::getUserRepository()->with("roles")
            ->get();
        $role = Role::all();
        $data = array(
            'users' => $users,
            'roles_all' => $role
        );
        echo json_encode($data);
        exit;
    }
    public function permissions()
    {
        $this->authorize('admin_access_all_page_utilisateurs');
        $roles = Sentinel::getRoleRepository()->get();
        $menu = Menu::all();
        $this->authorize('admin_access_all_page_utilisateurs');
        foreach ($roles as $role)
        {
            $json_permissions = json_encode($role->permissions, true);
            $permissions[] = array(
                'role_slug' => $role->slug,
                $role->slug => json_decode($json_permissions, true) ,
                'role_nom' => $role->name
            );;
        }
        $data = array(
            'menu' => $menu,
            'permissions' => $permissions
        );
        return view('utilisateurs.permissions', $data);
    }
    public function edit($id)
    {
        $this->authorize('admin_access_all_page_utilisateurs');
        $user = Sentinel::findById($id);
        $role = Role::all();
        $sites = Site::all();
        $projets = Project::where('user_id', '=', $id)->first();
        $client = [];
        if (!empty($projets->clients_id))
        {
            $arry_project = json_decode($projets->clients_id, true);
            for ($i = 0;$i < count($arry_project);$i++)
            {
                $client[] = array(
                    'id' => Site::find((int)$arry_project[$i]['id'])->id,
                    'name' => Site::find((int)$arry_project[$i]['id'])->nom,
                );
            }
        }
        $role_user = '';
        if (!empty($user->roles[0]))
        {
            $role_user = $user->roles[0]->name;
        }
        $att = array(
            'id' => $user->id,
            'nom' => $user->name,
            'email' => $user->email,
            'role' => $role_user,
        );
        $data = array(
            "user" => $att,
            'roles' => $role,
            'projets' => $role,
            'project' => $client,
            'clients' => $sites
        );
        return view('utilisateurs.users_details', $data);
    }
    public function edit_owner($id)
    {
    
        $user = Sentinel::findById($id);
        $role = Role::all();
        $clients = Site::all();
        $projets = Project::where('user_id', '=', $id)->first();
        $client = [];
        if (!empty($projets))
        {
            $arry_project = json_decode($projets->clients_id, true);
            for ($i = 0;$i < count($arry_project);$i++)
            {
                $client[] = array(
                    'id' => Site::find((int)$arry_project[$i]['id'])->id,
                    'name' => Site::find((int)$arry_project[$i]['id'])->nom,
                );
            }
        }
        $role_user = '';
        if (!empty($user->roles[0]))
        {
            $role_user = $user->roles[0]->name;
        }
        $att = array(
            'id' => $user->id,
            'nom' => $user->name,
            'email' => $user->email,
            'role' => $role_user,
        );
        $data = array(
            "user" => $att,
            'roles' => $role,
            'projets' => $role,
            'project' => $client,
            'clients' => $clients
        );
        return view('utilisateurs.user_owner_update', $data);
    }
    public function destroy($id)
    {
        $delete_user = User::find($id);
        $delete_user->delete();
        return Response()
            ->json(['etat' => true]);
    }
    public function update(Request $request)
    {
        if ($request->input('nom') == '')
        {
            return Response()
                ->json(['etat' => false, 'text' => 'Nom']);
            exit;
        }
        if ($request->input('email') == '')
        {
            return Response()
                ->json(['etat' => false, 'text' => 'Email']);
            exit;
        }
        // if ($request->input('role_id') == '')
        // {
        //     return Response()
        //         ->json(['etat' => false, 'text' => 'Role']);
        //     exit;
        // }
        if ($request->isMethod('post'))
        {
            $user = Sentinel::findById($request->input('id'));
            $user->name = $request->input('nom');
            $user->email = $request->input('email');
            if ($request->input('password') != "")
            {
                $user->password = Hash::make($request->input('password'));
            }
            $user->save();
            if (empty($request->type_user))
            {
                $user_role = Role_user::where('user_id', '=', $request->input('id'))
                    ->first();
                if (!empty($user_role->role_id))
                {
                    $user_role->role_id = $request->input('role_id');
                    $user_role->save();
                }
                else
                {
                    $role_user = new Role_user();
                    $role_user->user_id = $request->input('id');
                    $role_user->role_id = $request->input('role_id');
                    $role_user->save();
                }
                $project_update = Project::where('user_id', '=', $request->input('id'))
                    ->first();
                if (!empty($request->project_id))
                {
                    for ($i = 0;$i < count($request->project_id);$i++)
                    {
                        $index_project_id[] = array(
                            'id' => $request->project_id[$i]
                        );
                        $project_id_json = json_encode($index_project_id);
                    }
                    if (!empty($project_update))
                    {
                        $project_update->clients_id = $project_id_json;
                        $project_update->save();
                    }
                    else
                    {
                        $project = new Project();
                        $project->user_id = $request->input('id');
                        $project->clients_id = $project_id_json;
                        $project->save();
                    }
                } else {

                    if (!empty($project_update))
                    {

                        if (empty($request->project_id)) {
                                        
                        $project_update->clients_id = $request->project_id ;
                        $project_update->save();
                        }
                    }


                }
            }
            if (!empty($request->type_user))
            {
                return Response()
                    ->json(['redirect_home' => true]);
            }
            else
            {
                return Response()
                    ->json(['redirect_users' => true]);
            }
        }
    }
    public function permission_order()
    {
        $this->authorize('admin_access_all_page_utilisateurs');
        $roles = Sentinel::getRoleRepository()->get();
        $menu = 'order';
        $this->authorize('admin_access_all_page_utilisateurs');
        foreach ($roles as $role)
        {
            $json_permissions = json_encode($role->permissions, true);
            $permissions[] = array(
                'role_slug' => $role->slug,
                $role->slug => json_decode($json_permissions, true) ,
                'role_nom' => $role->name
            );;
        }
        $data = array(
            'menu' => $menu,
            'permissions' => $permissions
        );
        return view('utilisateurs.permission_order', $data);
    }
    public function create_user(Request $request)
    {
        $new_user = new User();
        $new_user->name = $request->input('name');
        $new_user->email = $request->input('email');
        $new_user->password = Hash::make($request->input('password'));
        $new_user->save();
        $role_user = new Role_user();
        $role_user->user_id = $new_user->id;
        $role_user->role_id = $request->input('role_id');
        $role_user->save();
        $role = Role::find($request->input('role_id'));
        $project_id_array = explode(",", $request->projet_id);
        for ($i = 0;$i < count($project_id_array);$i++)
        {
            $index_project_id[] = array(
                'id' => $project_id_array[$i]
            );
        }
        $project_id_json = json_encode($index_project_id);
        $project = new Project();
        $project->user_id = $new_user->id;
        $project->clients_id = $project_id_json;
        $project->save();
        return Response()
            ->json(['etat' => true, 'id_user' => $new_user->id, 'color' => $role->color, 'name' => $role->name]);
    }
    public function users()
    {
        $this->authorize('admin_access_all_page_utilisateurs');
        $users = Sentinel::getUserRepository()->with("roles")
            ->get();
        $role = Role::all();
        $data = array(
            'users' => $users,
            'roles' => $role
        );
        return view('utilisateurs.users', $data);
    }
}