@extends('backend.layouts.master')

@section('main-content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Add Product </h2>
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

          <form class="form-horizontal form-label-left" action="{{route('products.store')}}" method="post" novalidate="">
            @csrf

            <span class="section">Product Info</span>

            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="name" class="form-control col-md-7 col-xs-12" placeholder="Tên khách hàng" name="name"  required="required" type="text">
              </div>
              @error('name')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Phone <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" id="email" name="phone" placeholder="SĐT khách hàng" required="required" class="form-control col-md-7 col-xs-12">
              </div>
              @error('phone')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Select 1 <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="email2" name="select1" value="Xe máy" placeholder="Loại tài sản" required="required" class="form-control col-md-7 col-xs-12">
              </div>
              @error('select1')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Link <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" placeholder="Link form đăng ký đơn" value="https://fhr.vn" id="number" name="link" required="required"  class="form-control col-md-7 col-xs-12">
              </div>
              @error('link')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Reference Type 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" placeholder="Mã đối tác" value="8809" name="reference_type" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
              {{-- <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Reference ID
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="number" placeholder="ID đối tác"  name="reference_id" class="form-control col-md-7 col-xs-12">
                </div>

              </div> --}}
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Current Group ID <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" placeholder="Mã code 4 số của PGD" value="1082" name="current_group_id" required class="form-control col-md-7 col-xs-12">
                </div>
                @error('current_group_id')
                <span class="text-danger">{{$message}}</span>
            @enderror
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Source <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="source" placeholder="Kênh" value="3P_HFHR" required class="form-control col-md-7 col-xs-12">
                </div>
                @error('source')
                <span class="text-danger">{{$message}}</span>
            @enderror
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Campaign <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="campaign" value="PTDT- API" placeholder="Tên Chiến Dịch" required class="form-control col-md-7 col-xs-12">
                </div>
                @error('campaign')
                <span class="text-danger">{{$message}}</span>
            @enderror
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">str_source_group<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="str_source_group" value="fhr" placeholder="Nhóm nguồn" required class="form-control col-md-7 col-xs-12">
                </div>
                @error('str_source_group')
                <span class="text-danger">{{$message}}</span>
            @enderror
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">str_secondary_source<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="str_secondary_source" value="fhr" placeholder="Nguồn phụ" required class="form-control col-md-7 col-xs-12">
                </div>
                @error('str_secondary_source')
                <span class="text-danger">{{$message}}</span>
            @enderror
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">is Digital<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" name="isdigital" value="1" readonly required class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <button type="reset" class="btn btn-primary">Reset </button>
                <button id="send" type="submit" class="btn btn-success">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endsection
  @push('scripts')
  <script src="{{asset('backend/vendors/validator/validator.js')}}"></script>
  @endpush