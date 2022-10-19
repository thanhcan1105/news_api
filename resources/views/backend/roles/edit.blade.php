@extends('backend.layouts.master')

@section('main-content')
<div class="col-md-12">
    <div class="x_panel">
 
<div class="x_content">
    <br>
    <div class="x_title">
        <h2>Edit Role</h2>
        <div class="clearfix"></div>
      </div>
    <form id="roleForm" action="{{route('roles.update', $role->id)}}" method="PATCH" class="form-horizontal form-label-left" novalidate="">
        @csrf
        @method('PATCH')
      <div class="form-group">
        <input type="hidden" id="id" name="id" value="{{$role->id}}" required="required" class="form-control col-md-7 col-xs-12 " data-parsley-id="5">

        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Role Name
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" id="name" name="name" value="{{$role->name}}" required="required" class="form-control col-md-7 col-xs-12 " data-parsley-id="5">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Permissions
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <select id="permission" name="permission[]" multiple="multiple"  class="3col active form-control">
            @foreach($permissions as $permission)
            <option value="{{ $permission->id }}" @if (in_array($permission->id, $rolePermissions)) selected @endif>{{ $permission->name}}</option>   
          @endforeach
          </select>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="form-group">
        <div style="justify-content: center" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <a class="btn btn-primary" href="{{route('roles.index')}}" type="button">Back</a>
          <button id="updateRole" type="submit" class="btn btn-success">Update</button>
        </div>
      </div>

    </form>
  </div>
    </div>
</div>
@push('styles')
  <style>
    .swal2-popup {
  font-size: 1.6rem !important;
}

  </style>
   @endpush
@endsection
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

    $('#roleForm').submit(function(e){
          e.preventDefault();
          var id = $("#id").val();
          var name = $("#name").val();
          var permission = $("#permission").val();
          var url = "{{route('roles.update', ':id')}}";
          url = url.replace(':id', id);
          $.ajax({
            url: url,
            type: "PATCH",
            data: {
              name: name,
              permission: permission,
              _method: "PATCH"
            },
            dataType: 'json',
            success: function (data) {
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
                title: 'Update Role Successfully'
              })
            },
            error: function (data) {
              var nameError = data.responseJSON.name;
              var permissionError = data.responseJSON.permission;
              Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: (typeof permissionError =='undefined')  ? nameError  : permissionError,
            })
            }
        });
      });
    }); 
    </script>
@endpush