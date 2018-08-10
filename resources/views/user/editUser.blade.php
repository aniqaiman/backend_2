@extends('layout.master')
@section('style')
@endsection
@section('content')

<section class="content-header">
  <h1>
    USER
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">User</li>
  </ol>
</section>

<section class="content">
  <div class="col-md-12">
    <!-- Custom Tabs (Pulled to the right) -->
    <div class="nav-tabs-custom">

      <ul class="nav nav-tabs ">
        <li class="active"><a href="#tab_1" data-toggle="tab">Active</a></li> 
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="box">

            <!-- /.box-header -->
            <div class="modal-body">
              <!-- Custom Tabs (Pulled to the right) -->
              <form action="#" method="POST" id="frm-user-edit" enctype ="multipart/form-data">
                {!! csrf_field() !!}
                <div class="row">

                  <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Name: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="name" id="name" value="{{$users->name}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="email" id="email" value="{{$users->email}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="address" class="col-sm-3 control-label">Address: </label>
                    <div class="col-sm-9">
                      <textarea class="form-control" name="address" id="address">{{$users->address}}"</textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="handphone_number" class="col-sm-3 control-label">Handphone No: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="handphone_number" id="handphone_number" value="{{$users->handphone_number}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="profilepic" class="col-sm-3 control-label">Profile Picture: </label>
                    <div class="col-sm-9">
                      <input type="file" class="form-control" name="profilepic" id="profilepic" value="{{$users->profilepic}}">
                    </div>
                  </div>

                </div>
                <input type="hidden" name="user_id" value="{{$users->user_id}}">
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Save Change</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.tab-pane -->

      </div>
      <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->
  </div>
  <!-- Main content -->
</section>
@endsection

@section('script')
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>

<script>
  $(document).ready(function(){
    // CKEDITOR.replace('address');
    $('#frm-user-edit').on('submit',function(e){
      e.preventDefault();
      console.log('pressed');
      var data = $(this).serialize();
      console.log(data);
      var formData = new FormData($(this)[0]);
      // formData.append('address', CKEDITOR.instances.address.getData());

      $.ajax({
        url:"{{route('updateUser')}}", 
        type: "POST",
        data: formData,
        async: false,
        success: function(response){
          console.log(response);
          $("[data-dismiss = modal]").trigger({type: "click"});
          window.location.replace("{{route('users')}}");

        },
        cache: false,
        contentType: false,
        processData: false
      });
    });
  });

  </script>
  @endsection