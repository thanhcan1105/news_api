@extends('backend.layouts.master')

@section('main-content')
<div class="col-md-12">
    <div class="x_panel">
 
<div class="x_content">
    <br>
    <div class="x_title">
        <h2>Edit Permission</h2>
        <div class="clearfix"></div>
      </div>
    <form id="permissionForm" action="{{route('permissions.update', $permission->id)}}" method="PATCH" class="form-horizontal form-label-left" novalidate="">
        @csrf
        @method('PATCH')
      <div class="form-group">
        <input type="hidden" id="id" name="id" value="{{$permission->id}}" required="required" class="form-control col-md-7 col-xs-12 " data-parsley-id="5">

        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Permission Name
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" id="name" name="name" value="{{$permission->name}}" required="required" class="form-control col-md-7 col-xs-12 " data-parsley-id="5">
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="form-group">
        <div style="justify-content: center" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <a class="btn btn-primary" href="{{route('permissions.index')}}" type="button">Back</a>
          <button id="updatepermission" type="submit" class="btn btn-success">Update</button>
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

    $('#permissionForm').submit(function(e){
          e.preventDefault();
          var id = $("#id").val();
          var name = $("#name").val();
          var url = "{{route('permissions.update', ':id')}}";
          url = url.replace(':id', id);
          $.ajax({
            url: url,
            type: "PATCH",
            data: {
              name: name,
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
                title: 'Update permission Successfully'
              })
            },
            error: function (data) {
              Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.responseJSON.name,
            })
            }
        });
      });
    }); 
    </script>
@endpush