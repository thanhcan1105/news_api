@extends('backend.layouts.master')

@section('main-content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Add User </h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br>
          <form id="demo-form2" data-parsley-validate="" action="{{route('users.store')}}" method="post" class="form-horizontal form-label-left" novalidate="">
            @csrf
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12">
              </div>
              @error('name')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="last-name" name="email" required="required" class="form-control col-md-7 col-xs-12">
              </div>
              @error('email')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>
            <div class="form-group">
              <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="middle-name" class="form-control col-md-7 col-xs-12" type="password" name="password" required>
              </div>
              @error('password')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>
            <div class="form-group">
              <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">CCCD</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="middle-name" class="form-control col-md-7 col-xs-12" type="number" name="cccd" required>
              </div>
              @error('cccd')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>
            <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="middle-name" class="form-control col-md-7 col-xs-12" type="number" name="phone" required>
                </div>
                @error('phone')
                <span class="text-danger">{{$message}}</span>
            @enderror
              </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div id="gender" class="btn-group"  data-toggle="buttons">
                  <label class="btn btn-default active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                    <input type="radio" name="gender" value="active" data-parsley-multiple="status"> &nbsp; active &nbsp;
                  </label>
                  <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                    <input type="radio" name="gender" value="inactive" data-parsley-multiple="status"> inactive
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Role</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
            <select id="permission"name="roles[]" multiple="multiple"  class="3col active form-control">
              @foreach($roles as $role)
              <option class="option-card" value="{{ $role->id }}">{{ $role->name}}</option>   
            @endforeach
            </select>
              </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href="{{route('users.index')}}" class="btn btn-primary" type="button">Back</a>
                <button class="btn btn-primary" type="reset">Reset</button>
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
  @endsection
  @push('styles')
  <style>
    .swal2-popup {
  font-size: 1.6rem !important;
}
  </style>
   @endpush