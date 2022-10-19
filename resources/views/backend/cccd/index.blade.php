@extends('backend.layouts.master')

@section('main-content')

<div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Banner list <small> gallery design </small></h2>
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

          <div class="row">

            <p>Media gallery design emelents</p>
            @foreach($users as $user)
            <div class="col-md-4">
              <div style="height: 280px;" class="thumbnail">
                <div style="height: 199px;" class="image view view-first">
                  <img style="width: 100%; display: block;" src="{{ Storage::disk('s3')->url($user->latestcccds->front_image_url) }}" alt="image" />
                  <div class="mask">
                    <p class="content"></p>
                    <div id="content_img" class="tools tools-bottom">
                      {{-- <input type="hidden" value="{{ Storage::disk('s3')->url($user->latest_cccds->image_url) }}" id="{{ $user->id }}"> --}}
                      <a onclick="copyToClipboard('{{ $user->id }}')" style="cursor: pointer" class="pathImage" ><i class="fa fa-link"></i></a>
                      {{-- <a class="editImage" href="#"><i class="fa fa-pencil"></i></a> --}}
                      
                    </div>
                  </div>
                </div>
                <div class="caption">
                <div>
                  <center>
                    {{-- @if($cccd->user_info->id_verify == '0'){ --}}
                      <button type="button" style="width: 130px;" class="btn btn-round btn-warning" data-toggle="modal" data-target=".modal-verifly-{{ $user->id }}">Verify</button>
                    {{-- } --}}
                    {{-- @elseif($cccd->user_info->id_verify == '1') --}}

                  <p style="font-weight: 600;color: black;">Upload time:&nbsp;{{date_format($user->latestcccds->created_at,"H:i:s d/m/Y")}}</p>
                </center>

                </div>
                </div>
              </div>
            </div>
            {{-- <div class="x_content"> --}}

                <!-- modals -->
                <!-- Large modal -->

                <div class="modal fade bs-example-modal-lg modal-verifly-{{ $user->id }}"  tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Verify CCCD {{ $user->id }}</h4>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="x_panel fixed_height_390">
                                    <div class="x_content">
          
                                      <div class="flex">
                                        <h1 class="name">User Info</h1>
                                      </div>
          
                                      <h5 >Name: {{ $user->name }}</h5>
          
                                      <div class="flex">
                                      </div>
                                      
                                      <h5 >CCCD: {{ $user->cccd }}</h5>
          
                                      <div class="flex">
                                      </div>
                                      <h5 >Email: {{ $user->email }}</h5>
          
                                      <div class="flex">
                                      </div>
                                      <h5 >Phone: {{ $user->phone }}</h5>
          
                                      <div class="flex">
                                      </div>
                                      <h5 >Status: {{ $user->status }}</h5>
          
                                      <div class="flex">
                                      </div>
                                      <hr>
                                      <p>
                                        <button  
                                          type="button" 
                                          class="btn btn-round btn-primary approveUser" 
                                          data-token="{{ csrf_token() }}" 
                                          data-id={{$user->id}} 
                                          data-toggle="tooltip" 
                                          title="Delete">
                                          Approve
                                        </button>
                                        <button  
                                          type="button" 
                                          class="btn btn-round btn-danger rejectUser" 
                                          data-token="{{ csrf_token() }}" 
                                          data-id={{$user->id}} 
                                          data-toggle="tooltip" 
                                          title="Delete">
                                          Reject
                                        </button>
                                        <form id="approve-form-{{ $user->id }}" method="POST" action="{{route('cccds.approve')}}" style="display: none;">
                                            @csrf 
                                            <input name="idUserApprove" value="{{ $user->id }}" type="hidden">
                                            <input name="idCCCDApprove" value="{{ $user->latestcccds->id }}" type="hidden">
                                            @method('post')
                                          </form>
                                          <form id="reject-form-{{ $user->id }}" method="POST" action="{{route('cccds.reject')}}" style="display: none;">
                                            @csrf 
                                            <input name="idUserReject" value="{{ $user->id }}" type="hidden">
                                            <input name="idCCCDApprove" value="{{ $user->latestcccds->id }}" type="hidden">

                                            @method('post')
                                          </form>
                                      </p>
                                    </div>
                                  </div>
                             
                            </div>
                         
                            <div id="line" class="col-sm-8">
                            <div style="height: 320px" class="thumbnail">
                                <div style="height: 100%" class="image view view-first">
                                <img style="width: 100%; display: block;" src="{{ Storage::disk('s3')->url($user->latestcccds->front_image_url) }}" alt="image">
                                </div>
                            </div>
                            <div style="height: 320px" class="thumbnail">
                                <div  style="height: 100%" class="image view view-first">
                                    <img style="width: 100%; display: block;" src="{{ Storage::disk('s3')->url($user->latestcccds->back_image_url) }}" alt="image">
                                </div>
                                </div>
                            </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
                      </div>
                    </div>
                  </div>
                </div>
            @endforeach
          </div>
          {!! $users->links() !!}

        </div>
      </div>
    </div>
  </div>
  
  {{-- <img src="{{ Storage::disk('s3')->url('images/banners/test') }}"> --}}
@endsection
@push('styles')
    <style>
    .swal2-popup {
        font-size: 1.6rem !important;
    }
    #line::before {
        content: '';
        width: 0;
        height: 100%;
        position: absolute;
        border: 1px solid red;
        top: 0;
        left: -5px;
    }
    h5 {
        font-weight: 500;
        color: black;
        font-size: 16px;
    }
    </style>
@endpush
@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function(){
    $('.pathImage').mouseover(function(){
        $('.content').text('Copy Path');
    });
    $('.pathImage').mouseout(function(){
        $('.content').text('');
    });
    $('.editImage').mouseover(function(){
        $('.content').text('Edit banner');
    });
    $('.editImage').mouseout(function(){
        $('.content').text('');
    });
    $('.deleteImage').mouseover(function(){
        $('.content').text('Delele banner');
    });
    $('.deleteImage').mouseout(function(){
        $('.content').text('');
    });
	
});
    </script>
   <script>
    function copyToClipboard(id) {
      var copyText = document.getElementById(id).value;
      navigator.clipboard.writeText(copyText).then(() => {
        Swal.fire({
              icon: 'success',
              title: 'Success...',
              text: 'copied the path successfully',
            })
      });
    }
  </script>
  
@endpush
@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
 $(document).ready(function () {
  $.ajaxSetup({
      headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
  });
  $('.rejectUser').click(function(e){
      e.preventDefault();
      var id =$(this).data("id");
      Swal.fire({
      title: 'Are you sure?',
      text: "This user will be rejected!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, reject this user!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax(
            {
              data: $("#reject-form-"+id).submit(),
            success: function (response){ 
              Swal.fire(
              'Rejected!',
              'User has been rejected.',
              'success'
            )
            }
        });  
      }
    })
  });
  $('.approveUser').click(function(e){
      e.preventDefault();
      var id =$(this).data("id");
      Swal.fire({
      title: 'Are you sure?',
      text: "This user will be approved",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, approved this user!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax(
            {
              data: $("#approve-form-"+id).submit(),
            success: function (response){ 
              Swal.fire(
              'Approved!',
              'User has been approved.',
              'success'
            )
            }
        });  
      }
    })
  });
  // xu sau
//   $('#pagination a').on('click', function(e){
//     e.preventDefault();
//     var url = $(this).attr('href');
//     $.post(url, $('#search').serialize(), function(data){
//         $('#posts').html(data);
//     });
// });
});
</script>
    
@endpush