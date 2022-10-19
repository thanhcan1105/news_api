@extends('backend.layouts.master')

@section('main-content')

<div class="x_panel">
    <div class="x_title">
      <h2>Upload Banner <small></small></h2>
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
      <br>
      <form action="{{route('banners.store')}}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
        @csrf
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Company ID </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input type="text" name="company_id " class="form-control" placeholder="Default 1">
          </div>
        </div>

     

       <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Image </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="file-drop-area">
                    <span class="fake-btn">Choose files</span>
                    <span class="file-msg">or drag and drop files here</span>
                    <input class="file-input" name="image" type="file" accept="image/*" >
                </div>
            </div>
       </div>
       <div class="form-group"></div>
       
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div id="gender" class="btn-group"  data-toggle="buttons">
                <label class="btn btn-default active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="status" value="1" data-parsley-multiple="status"> &nbsp; Active &nbsp;
                </label>
                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="status" value="0" data-parsley-multiple="status"> Inactive
                </label>
              </div>
            </div>
        </div>


        <div class="ln_solid"></div>
        <div class="form-group">
          <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
            <button style="margin-top: 5px;" type="submit" class="btn btn-app"><i class="glyphicon glyphicon-send"></i>Up load</button>
          </div>
        </div>

      </form>
    </div>
  </div>
@endsection

@push('styles')
<style>
     .swal2-popup {
  font-size: 1.6rem !important;
}
  .file-drop-area {
/* position: relative; */
/* display: flex; */
/* align-items: center; */
/* width: 450px; */
max-width: 100%;
padding: 25px;
border: 1px dashed rgb(203 0 53 / 40%);
border-radius: 3px;
transition: 0.2s;
&.is-active {
  background-color: rgba(255, 255, 255, 0.05);
}
}

.fake-btn {
flex-shrink: 0;
background-color: rgb(18 189 162 / 4%);
border: 1px solid rgb(8 98 85 / 10%);
border-radius: 3px;
padding: 8px 15px;
margin-right: 10px;
font-size: 12px;
text-transform: uppercase;
}

.file-msg {
font-size: small;
font-weight: 300;
line-height: 1.4;
white-space: nowrap;
overflow: hidden;
text-overflow: ellipsis;
}

.file-input {
position: absolute;
left: 0;
top: 0;
height: 100%;
width: 100%;
cursor: pointer;
opacity: 0;
&:focus {
  outline: none;
}
}

  </style>
@endpush
@push('scripts')
    <script>
    var $fileInput = $('.file-input');
    var $droparea = $('.file-drop-area');

    // highlight drag area
    $fileInput.on('dragenter focus click', function() {
      $droparea.addClass('is-active');
    });

    // back to normal state
    $fileInput.on('dragleave blur drop', function() {
      $droparea.removeClass('is-active');
    });

    // change inner text
    $fileInput.on('change', function() {
      var filesCount = $(this)[0].files.length;
      var $textContainer = $(this).prev();

      if (filesCount === 1) {
        // if single file is selected, show file name
        var fileName = $(this).val().split('\\').pop();
        $textContainer.text(fileName);
      } else {
        // otherwise show number of files
        $textContainer.text(filesCount + ' files selected');
      }
    });
  </script>
@endpush