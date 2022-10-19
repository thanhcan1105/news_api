<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use RealRashid\SweetAlert\Facades\Alert;
use DB;

class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $role = Role::all();
        $members=User::orderBy('id','desc')->paginate(10);
        return view('backend.user.index',compact('members','role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('backend.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'name'=>'string|required|max:30',
            'email'=>'string|required',
            'phone'=>'required|max:15',
            'cccd'=>'required|max:15',
            'password'=>'required',
            'status'=>'in:active,inactive',
        ]);
        $data = $request->all();
        $data['password']=Hash::make($request->password);
        $status = User::create($data);
        $status->assignRole($request->roles);
        if($status){
            toast('New user added','success');
        }
        else{
            alert()->error('Oops...', 'Something went wrong!');
        }
        return redirect()->route('users.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        // return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        // $roles = Role::pluck('name', 'name')->all();
        $roles = Role::all();
        $userRole = $user->roles->pluck('name', 'name')->all();
    
        return view('backend.user.edit', compact('user', 'roles', 'userRole'));
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
        
        $this->validate($request,
        [
            'name'=>'string|required|max:30',
            'email'=>'string|required',
            'phone'=>'required|max:15',
            'cccd'=>'required|max:15',
            'password' => 'confirmed',
            'status'=>'in:active,inactive',
        ]);
        $data=$request->all();
        if(!empty($input['password'])) { 
            $data['password'] = Hash::make($data['password']);
        }else {
            $data = Arr::except($data, array('password'));    
        }
        $user=User::findOrFail($id);
        $status=$user->update($data);
        DB::table('model_has_roles')
            ->where('model_id', $id)
            ->delete();
        $user->assignRole($request->input('roles'));
        if($status){
            alert()->success('User Update', 'Successfully');
        }
        else{
            alert()->error('User Update', 'Something went wrong!');
        }
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete=User::findorFail($id);
        $status=$delete->delete();
        if($status){
            alert()->success('User Deleted', 'Successfully');
        }
        else{
            alert()->error('User Delete', 'Something went wrong!');
        }
        return redirect()->route('users.index');
    }
    
}
