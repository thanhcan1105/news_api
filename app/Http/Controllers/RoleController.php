<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Validator;
use Symfony\Component\HttpFoundation\Response;
class RoleController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->paginate(10);
        $permissions = Permission::get();
        
        return view('backend.roles.index', compact('roles','permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ],
        [
         'name.required'=> 'Vui lòng nhập tên Role', // custom message
         'name.unique'=> 'Role này đã tồn tại', // custom message
         'permission.required'=> 'Vui lòng chọn permission' // custom message
        ]);
        if ($validator->fails()) {    
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
        if($role){
            return response()->json(
                [
                  'success' => true,
                  'message' => 'Data inserted successfully'
                ]
              );
        }else{
            return response()->json(
                [
                  'error' => false,
                  'message' => 'Error'
                ]
              );
        }
        
        // $p = $request->permission;
        // dd($p);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', 'permissions.id')
            ->where('role_has_permissions.role_id',$id)
            ->get();
    
        return view('backend.roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('backend.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), 
         [
            'name' => 'required',
            'permission' => 'required',
        ],
        [
         'name.required'=> 'Vui lòng nhập tên Role', // custom message
         'permission.required'=> 'Vui lòng chọn permission' // custom message
        ]);
        if ($validator->fails()) {    
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permission'));
    
        if($role){
            return response()->json(
                [
                  'success' => true,
                  'message' => 'Data inserted successfully'
                ]
              );
        }else{
            return response()->json(
                [
                  'error' => false,
                  'message' => 'Error'
                ]
              );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();
        
        return response()->json(
            [
              'success' => true,
              'message' => 'Role delete successfully'
            ]
          );
    }
}
