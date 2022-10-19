@extends('backend.layouts.master')

@section('main-content')
<div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
              <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Product</a>
              </li>
              <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Search</a>
              </li>
              <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Excel</a>
              </li>
            </ul>
            <div id="myTabContent" class="tab-content">
              <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
               
                &nbsp;&nbsp;<a style="height: 32px;width: 90px;justify-content: start;text-align: center;line-height: 28px;" href="{{route('products.create')}}" class="btn btn-success btn-xs">Add Product</a>

              </div>
              <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                <form style="display: flex;justify-content: center;" action="">

                  <div style="display: flex;justify-content: end;" class="col-md-3 col-sm-5 col-xs-12 form-group pull-right top_search">
                  {{-- <form action=""> --}}
                    <div class="input-group">
                      <input id="phone" type="text" name="phone" class="form-control" placeholder="Search by phone...">
                    </div>
                  {{-- </form> --}}
                </div>
      
                  <div class="col-md-3">
                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                      <i class="fa fa-calendar"></i>&nbsp;
                         <span id="date"></span> <i class="fa fa-caret-down">
                     </i>
                  </div>
                  </div>
                  <button type="button" id="search" style="height: 32px;width: 90px;" class="btn btn-info btn-xs">Search</button> 
                  <button style="height: 32px;width: 90px;" href="{{route('products.index')}}" class="btn btn-primary btn-xs">Refresh</button>
                
      
                </form>
              </div>
              <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="x_content">
                      <ul class="list-unstyled timeline">
                        <li>
                          <div style="padding: 0" class="block">
                            <div class="tags">
                              <a href="" class="tag">
                                <span style="color: #fffcfc;">Export</span>
                              </a>
                            </div>
                            <div style="justify-content: center;display: table;" class="block_content">
                              <a href="{{route('products.export')}}" class="btn btn-app"><i class="fa fa-save"></i>Export</a>

                              <p style="text-align:center; 
                              vertical-align: middle;
                              display: table-cell; " class="excerpt">&nbsp;&nbsp; Xuất file excel
                              </p>
                            </div>
                          </div>
                        </li>
                      </ul>
    
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="x_content">
                      <ul class="list-unstyled timeline">
                        <li>
                          <div style="padding: 0" class="block">
                            <div class="tags">
                              <a href="" class="tag">
                                <span style="color: #fffcfc;">Import</span>
                              </a>
                            </div>
                            <div  class="block_content">
                              
                              <form style="display: flex;height: 71px;" action="{{route('products.import')}}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                &nbsp;&nbsp;
                                <div class="file-drop-area">
                                  <span class="fake-btn">Choose files</span>
                                  <span class="file-msg">or drag and drop files here</span>
                                  <input class="file-input" name="productfile" type="file" accept=".xlsx, .xls, .csv, .ods">
                                </div>
                                {{-- <input id="user-file" type="file" required name="productfile" class="file-input"  accept=".xlsx, .xls, .csv, .ods"> --}}
                                <button style="margin-top: 5px;" class="btn btn-app"><i class="glyphicon glyphicon-send"></i>Up load</button>

                            </form>
                              {{-- <form action="form_upload.html" class="dropzone dz-clickable"><div class="dz-default dz-message"><span>Drop files here to upload</span></div></form> --}}
                            </div>
                          </div>
                        </li>
                      </ul>
    
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">


         
          
          <section style="overflow: auto;width: 100%" class="data">
          @include('backend.product.table')
        </section>
          <!-- end project list -->
        </div>
      </div>
    </div>
  </div>
  @endsection
  
  @push('styles')
  <style>
    .file-drop-area {
  position: relative;
  display: flex;
  align-items: center;
  width: 450px;
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
  <script type="text/javascript">
   $(function () {
    var startDate = "";
    var endDate = "";
    var start = moment().subtract(29, 'days');
    var end = moment();
    function cb(start, end) {
      console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));

        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb).on('apply.daterangepicker', function (ev, picker) {
         startDate = picker.startDate.format('YYYY-MM-DD');
         endDate = picker.endDate.format('YYYY-MM-DD');
        console.log(`startDate = ${startDate}, endDate = ${endDate}`);
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
    
    });
    $('#search').on('click', function (e) {
          var phone = $("#phone").val();
          // alert(startDate + endDate);
          if(phone == "" && startDate =="" && endDate ==""){
            alert("Vui lòng nhập SĐT hoặc Ngày để tìm kiếm");
          }else{
            $.ajax({
             type:'get',
             url:"{{ route('products.index') }}",
             data:{start:startDate, end:endDate, phone:phone},
             success:function(data){
              $('.data').html(data);
             }
          });
          $('body').on('click', '.pagination a', function (e) {
            e.preventDefault();
            $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 10000;" src="https://i.imgur.com/v3KWF05.gif />');
            var url = $(this).attr('href');
            window.history.pushState("", "", url);
            loadProducts(url);
        });

        function loadProducts(url) {
            $.ajax({
                type:'get',
                url: url,
                data:{start:startDate, end:endDate, phone:phone},
            }).done(function (data) {
                $('.data').html(data);
            }).fail(function () {
                console.log("Failed to load data!");
            });
        }
          }
          
      });
    cb(start, end);

  });
   </script>
  
  @endpush