@extends('backend.layouts.master')

@section('main-content')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Permission List</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" permission="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" permission="menu">
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
        @can('permission-create')
                    <span class="float-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addpermissionModal">Create Permission</button>
    
                    </span>
                @endcan
        <table id="datatable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Permission name</th>
              <th>Created at</th>
              <th>Action</th>
            </tr>
          </thead>
    
    
          <tbody>
            @php $i = 0;
            
            @endphp
            @foreach($permissions as $permission) 
            @php 
            
            $i += 1;
            @endphp
            <tr>
              <td>{{$i}}</td>
              <td>{{$permission->name}}</td>
              <td>{{$permission->created_at->format('Y:m:d')}}</td>
              
              <td>
                <div style="display: inline-flex">
                  @can('permission-edit')
                    <a id="editpermission" href="{{route('permissions.edit',$permission->id)}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                    @endcan
                    @can('permission-delete')
    
                          <button  type="button" class="btn btn-danger btn-xs deletepermission" data-token="{{ csrf_token() }}" data-id={{$permission->id}} data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i>Delete</button>
                        @endcan
                </div>
             
              
            </td>
            </tr>
            @endforeach
    
          </tbody>
          
        </table>
        {!! $permissions->links() !!}
    
      </div>
    </div>
          <div id="addpermissionModal" class="modal fade bs-example-modal-sm" tabindex="-1" permission="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel2">Create new permission</h4>
                </div>
                <div class="modal-body">
                  <form id="permissionForm" action="{{route('permissions.store')}}" method="POST" class="form-horizontal form-label-left">
                    @csrf 
                    <div class="form-group">
                      <label  for="name">permission Name <span class="required">*</span>
                      </label>
                      <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button id="createpermission" type="submit" class="btn btn-primary">Create permission</button>
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
      $('#permissionForm').submit(function(e){
          e.preventDefault();
        
          var name = $("#name").val();
        
          $.ajax({
            url: "{{route('permissions.store')}}",
            type: "POST",
            data: {
              name: name,
            },
            dataType: 'json',
            success: function (data) {
                
                $('#permissionForm').trigger("reset");
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
                title: 'New permission Added'
              })
            location.reload();

            },
            error: function (data) {
              // console.log(data);
              Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.responseJSON.name,
            })
            }
        });
      });
      //Delete permission
      $('.deletepermission').click(function(e){
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
                  url: `{{ url('/admin/permissions/'.'${id}') }}`,
                  type: 'DELETE',
                  data: {
                        id: id
                },
                success: function (response){
                  
                  Swal.fire(
                  'Deleted!',
                  'permission has been deleted.',
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