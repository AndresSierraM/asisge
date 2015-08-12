<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
//use App\Http\Requests\RolesRequest;
use App\Http\Controllers\Controller;

use App\Role;
use App\User;
use App\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $owner = new Role();
        $owner->name         = 'owner';
        $owner->display_name = 'Project Owner'; // optional
        $owner->description  = 'User is the owner of a given project'; // optional
        $owner->save();

        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'User Administrator'; // optional
        $admin->description  = 'User is allowed to manage and edit other users'; // optional
        $admin->save();

        $user = User::where('name', '=', 'asierra')->first();

        // role attach alias
        $user->attachRole($admin); // parameter can be an Role object, array, or id

        $createPost = new Permission();
        $createPost->name         = 'pais-crear';
        $createPost->display_name = 'Crear paises'; // optional
        // Allow a user to...
        $createPost->description  = 'Crear un nuevo pais'; // optional
        $createPost->save();

        $editUser = new Permission();
        $editUser->name         = 'usuario-modificar';
        $editUser->display_name = 'Modificar usuarios'; // optional
        // Allow a user to...
        $editUser->description  = 'Modificar usuarios existentes'; // optional
        $editUser->save();

        $admin->attachPermission($createPost);
        // equivalent to $admin->perms()->sync(array($createPost->id));

        $owner->attachPermissions(array($createPost, $editUser));
        // equivalent to $owner->perms()->sync(array($createPost->id, $editUser->id));
        
        echo 'TERMINADO';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('roles');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(RolesRequest $request)
    {
        \App\Roles::create([
            'codigoRoles' => $request['codigoRoles'],
            'nombreRoles' => $request['nombreRoles'],
            ]);

        return redirect('/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $roles = \App\Roles::find($id);
        return view('roles',['roles'=>$roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,RolesRequest $request)
    {
        


        //$roles = \App\Roles::find($id);
        //$roles->fill($request->all());
        //$roles->save();

        //return redirect('/roles');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
        \App\Roles::destroy($id);
        return redirect('/roles');
    }
}
