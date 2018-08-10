@extends('layout.master')
@section('style')
@endsection
@section('content')

<section class="content-header">
  <h1>
    BUYER
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Buyer</li>
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
              <form action="#" method="POST" id="frm-buyer-edit" enctype ="multipart/form-data">
                {!! csrf_field() !!}
                <div class="row">

                  <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Owner Name: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="name" id="name" value="{{$buyers->name}}">
              </div>
            </div>

            <div class="form-group">
              <label for="company_name" class="col-sm-3 control-label">Company Name: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="company_name" id="company_name" value="{{$buyers->company_name}}">
              </div>
            </div>

            <div class="form-group">
              <label for="company_reg_ic_number" class="col-sm-3 control-label">Company Reg No./IC No.: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="company_reg_ic_number" id="company_reg_ic_number" value="{{$buyers->company_reg_ic_number}}">
              </div>
            </div>

            <div class="form-group">
              <label for="address" class="col-sm-3 control-label">Company Address: </label>
              <div class="col-sm-9">
                <textarea class="form-control" name="address" id="address">{{$buyers->address}}</textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="buss_hour" class="col-sm-3 control-label">Business Hour: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="buss_hour" id="buss_hour" value="{{$buyers->buss_hour}}">
              </div>
            </div>

            <div class="form-group">
              <label for="phonenumber" class="col-sm-3 control-label">Phone No.: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="phonenumber" id="phonenumber" value="{{$buyers->phonenumber}}">
              </div>
            </div>

            <div class="form-group">
              <label for="handphone_number" class="col-sm-3 control-label">Handphone No.: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="handphone_number" id="handphone_number" value="{{$buyers->handphone_number}}">
              </div>
            </div>

            <div class="form-group">
              <label for="email" class="col-sm-3 control-label">Email Address: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="email" id="email" value="{{$buyers->email}}">
              </div>
            </div>

            <!-- <div class="form-group">
              <label for="password" class="col-sm-3 control-label">Password: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="password" id="password" value="{{$buyers->password}}">
              </div>
            </div> -->

                </div>
                <input type="hidden" name="user_id" value="{{$buyers->user_id}}">
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
  $(document).ready(function()
  {
    // CKEDITOR.replace('address');
    $('#frm-buyer-edit').on('submit',function(e)
    {
      e.preventDefault();
      console.log('pressed');
      var data = $(this).serialize();
      console.log(data);
      var formData = new FormData($(this)[0]);
      // formData.append('address', CKEDITOR.instances.address.getData());

      $.ajax(
      {
        url:"{{route('updateBuyer')}}", 
        type: "POST",
        data: formData,
        async: false,
        success: function(response)
        {
          console.log(response);
          $("[data-dismiss = modal]").trigger({type: "click"});
          window.location.replace("{{route('buyer')}}");
        },
        cache: false,
        contentType: false,
        processData: false
      });
    });
  });

</script>
@endsection