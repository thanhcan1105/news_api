<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Validator;
use Symfony\Component\HttpFoundation\Response;
class PermissionController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
         $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index','store']]);
         $this->middleware('permission:permission-create', ['only' => ['create','store']]);
         $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permissions = Permission::orderBy('id','DESC')->paginate(15);

        return view('backend.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
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
            'name' => 'required|unique:permissions,name',
        ],
        [
         'name.required'=> 'Vui lòng nhập tên Role', // custom message
         'name.unique'=> 'Role này đã tồn tại', // custom message
        ]);
        if ($validator->fails()) {    
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }
    
        Permission::create(['name' => $request->input('name')]);

        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully'
            ]
        );
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::find($id);
    
        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
    
        return view('backend.permissions.edit', compact('permission'));
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
            'name' => 'required|unique:permissions,name',
        ],
        [
         'name.required'=> 'Vui lòng nhập tên Role', // custom message
         'name.unique'=> 'Role này đã tồn tại', // custom message
        ]);
        if ($validator->fails()) {    
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }
    
        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->save();
        
        return response()->json(
            [
                'success' => true,
                'message' => 'Data update successfully'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission::find($id)->delete();
        
        return response()->json(
            [
                'success' => true,
                'message' => 'Data delete successfully'
            ]
        );
    }
}

