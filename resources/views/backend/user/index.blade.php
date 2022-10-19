@extends('backend.layouts.master')

@section('main-content')
<div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Users List</h2>
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

          <a style="height: 32px;width: 90px;" href="{{route('users.create')}}" class="btn btn-success btn-xs">Add User</a>

          <!-- start project list -->
          <table class="table table-striped projects">
            <thead>
              <tr>
                <th style="width: 1%">#</th>
                <th style="width: 20%">Name</th>
                <th tyle="width: 20%">Email</th>
                <th tyle="width: 10%">CCCD</th>
                <th tyle="width: 10%">Phone</th>
                <th tyle="width: 40%">Role</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
                @php $i = 0;
                @endphp
                @foreach($members as $member) 
                @php 
                $i += 1;
                @endphp
              <tr>
                <td>{{$i}}</td>
                <td>
                  <a>{{$member->name}}</a>
                  <br>
                  <small>Created {{$member->created_at}}</small>
                </td>
                <td>
                    <a>{{$member->email}}</a>
                </td>
                <td>
                    <a>{{$member->cccd}}</a>
                </td>
                <td class="project_progress">
                    <a>{{$member->phone}}</a>
                </td>
                <td> 
                  @if($member->getRoleNames()->count() > 0)
                    @foreach($member->getRoleNames() as $val)
                    <span class="badge rounded-pill bg-info text-danger">{{ $val }}</span>
                    @endforeach
                    @else
                    <span class="badge none rounded-pill bg-info text-danger">None</span>
                @endif
                </td>
                <td>
                  @if ($member->status == 'active')
                  <button type="button" class="btn btn-success btn-xs">{{$member->status}}</button>
                  @else 
                  <button type="button" class="btn btn-danger btn-xs">{{$member->status}}</button>

                  @endif
                </td>
                <td>
                    <div style="display: inline-flex">
                        <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a>
                        <a href="{{route('users.edit',$member->id)}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                        <form method="POST" action="{{route('users.destroy',[$member->id])}}">
                          @csrf 
                          @method('delete')
                              <button class="btn btn-danger btn-xs" data-id={{$member->id}} data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i>Delete</button>
                            </form>
                    </div>
                 
                  
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <!-- end project list -->

        </div>
      </div>
    </div>
  </div>
  @endsection
  @push('styles')
  <style>
    .badge{
      background-color: #cc1313;
    }.none{
      background-color: #c4c0c0ea;
    }
    .swal2-popup {
  font-size: 1.6rem !important;
}
  </style>
   @endpush