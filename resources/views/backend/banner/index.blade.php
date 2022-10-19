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
            @foreach($banners as $banner)
            <div class="col-md-55">
              <div class="thumbnail">
                <div class="image view view-first">
                  <img style="width: 100%; display: block;" src="{{ Storage::disk('s3')->url($banner->image_url) }}" alt="image" />
                  <div class="mask">
                    <p class="content"></p>
                    <div id="content_img" class="tools tools-bottom">
                      <input type="hidden" value="{{ Storage::disk('s3')->url($banner->image_url) }}" id="{{ $banner->id }}">
                      <a onclick="copyToClipboard('{{ $banner->id }}')" style="cursor: pointer" class="pathImage" ><i class="fa fa-link"></i></a>
                      {{-- <a class="editImage" href="#"><i class="fa fa-pencil"></i></a> --}}
                      <a 
                        class="deleteImage" 
                        onclick="event.preventDefault();
                        document.getElementById('delete-form-{{ $banner->id }}').submit();"
                        href="#">
                      <i class="fa fa-times"></i>
                    </a>
                      <form id="delete-form-{{ $banner->id }}" method="POST" action="{{route('banners.destroy',[$banner->id])}}" style="display: none;">
                        @csrf 
                        @method('delete')
                      </form>
                    </div>
                  </div>
                </div>
                <div class="caption">
                  <p style="font-weight: 600;color: black;">Upload time:&nbsp;{{date_format($banner->created_at,"H:i:s d/m/Y")}}</p>
                </div>
              </div>
            </div>
            @endforeach
          </div>
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