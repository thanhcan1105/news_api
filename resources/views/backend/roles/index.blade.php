@extends('backend.layouts.master')

@section('main-content')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Role List</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Settings 1</a>
              </li>
              <li><a href="#">Settings 2</a>
              </li>
            </ul>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @can('role-create')
                    <span class="float-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addRoleModal">Create Role</button>
    
                    </span>
                @endcan
        <table id="datatable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th width="1%">#</th>
              <th  width="20%" >Role name</th>
              <th width="70%">Role has permissions</th>
              <th >Action</th>
            </tr>
          </thead>
    
    
          <tbody>
            @php $i = 0;
            
            @endphp
            @foreach($roles as $role) 
            @php 
            $rolePermissions = \Spatie\Permission\Models\Permission::join('role_has_permissions', 'role_has_permissions.permission_id', 'permissions.id')
            ->where('role_has_permissions.role_id',$role->id)
            ->get();
            $i += 1;
            @endphp
            <tr>
              <td>{{$i}}</td>
              <td>{{$role->name}}</td>
              @if(!empty($rolePermissions))
                <td>
                  @foreach($rolePermissions as $permission)
                    <span class="badge rounded-pill bg-info text-dark">{{ $permission->name }}</span>          
                  @endforeach
                </td>
              @else 
                <td>
                  <span class="badge rounded-pill bg-info text-danger">None</span>
                </td>
              @endif
              <td>
                <div style="display: inline-flex">
                  @can('role-edit')
                    <a id="editRole" href="{{route('roles.edit',$role->id)}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                    @endcan
                    @can('role-delete')
    
                          <button  type="button" class="btn btn-danger btn-xs deleteRole" data-token="{{ csrf_token() }}" data-id={{$role->id}} data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i>Delete</button>
                        @endcan
                </div>
             
              
            </td>
            </tr>
            @endforeach
    
          </tbody>
          
        </table>
        {!! $roles->links() !!}
    
      </div>
    </div>
          <div id="addRoleModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel2">Create new role</h4>
                </div>
                <div class="modal-body">
                  <form id="roleForm" action="{{route('roles.store')}}" method="POST" class="form-horizontal form-label-left">
                    @csrf 
                    <div class="form-group">
                      <label  for="name">Role Name <span class="required">*</span>
                      </label>
                      <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12">
                     
                      <div class="content">
                        <label >Select Permissions&nbsp;</label>(&nbsp;<i style="cursor: pointer" id="close" class="fa fa-remove">Close</i>)
                        <div class="container text-left">
                          <div class="row justify-content-center">
                            <div style="padding: 10px">
                            <select id="permission" name="permission[]" multiple="multiple"  class="3col active form-control">
                              @foreach($permissions as $permission)
                            <option value="{{$permission->id}}">{{$permission->name}}</option>                
                                                       
                            @endforeach
                            </select>
                            
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button id="createRole" type="submit" class="btn btn-primary">Create Role</button>
                    </div>
                  </form>
                </div>
               

              </div>
            </div>
          </div>

        
  </div>
 
 
   @endsection
   @push('styles')
  <style>
    .td{
      line-height: 2em!important;
    }
    .badge{
      background-color: #26c5b3;
    }
    .swal2-popup {
  font-size: 1.6rem !important;
}
    @media (min-width: 768px){
     .modal-content {
    width: 450px
   }
  }
  </style>
   @endpush
   @push('scripts')
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

       <script>
        $('#btnClose').click(function() {
          $(this).parents('.dropdown').find('button.dropdown-toggle').dropdown('toggle')
        });
       </script>
       <script>
        
      $(document).ready(function () {


      $.ajaxSetup({
          headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
      });

      //Save data into database
      $('#roleForm').submit(function(e){
          e.preventDefault();
        
          var name = $("#name").val();
          var permission = $("#permission").val();
        
          $.ajax({
            url: "{{route('roles.store')}}",
            type: "POST",
            data: {
              name: name,
              permission: permission
            },
            dataType: 'json',
            success: function (data) {
                
                $('#roleForm').trigger("reset");
                // $('#RoleModal').modal('hide');
                const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })

              Toast.fire({
                icon: 'success',
                title: 'New Role Added'
              })
              location.reload();

            },
            error: function (data) {
              // console.log(data);
              Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: (typeof data.responseJSON.permission =='undefined')  ? data.responseJSON.name  : data.responseJSON.permission,
            })
            }
        });
      });
      //Delete Role
      $('.deleteRole').click(function(e){
          e.preventDefault();
          var id =$(this).data("id");
          Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax(
                {
                  url: `{{ url('/admin/roles/'.'${id}') }}`,
                  type: 'DELETE',
                  data: {
                        id: id
                },
                success: function (response){
                  
                  Swal.fire(
                  'Deleted!',
                  'Role has been deleted.',
                  'success'
                )
                location.reload();
                }
            });
              
            }
          })
        });

      }); 
       </script>
   @endpush