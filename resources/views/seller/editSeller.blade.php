@extends('layout.master')
@section('style')
@endsection
@section('content')

<section class="content-header">
  <h1>
    SUPPLIER
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Supplier</li>
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
              <form action="#" method="POST" id="frm-supplier-edit" enctype ="multipart/form-data">
                {!! csrf_field() !!}
                <div class="row">

                  <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Owner Name: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="name" id="name" value="{{$sellers->name}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="company_name" class="col-sm-3 control-label">Company Name: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="company_name" id="company_name" value="{{$sellers->company_name}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="company_reg_ic_number" class="col-sm-3 control-label">Company Reg No./IC No.: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="company_reg_ic_number" id="company_reg_ic_number" value="{{$sellers->company_reg_ic_number}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="address" class="col-sm-3 control-label">Farm Address: </label>
                    <div class="col-sm-9">
                      <textarea class="form-control" name="address" id="address">{{$sellers->address}}</textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="latitude" class="col-sm-3 control-label">Latitude: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="latitude" id="latitude" value="{{$sellers->latitude}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="longitude" class="col-sm-3 control-label">Longitude: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="longitude" id="longitude" value="{{$sellers->longitude}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="handphone_number" class="col-sm-3 control-label">Handphone No.: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="handphone_number" id="handphone_number" value="{{$sellers->handphone_number}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email Address: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="email" id="email" value="{{$sellers->email}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="bank_name" class="col-sm-3 control-label">Bank Name: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="bank_name" id="bank_name" value="{{$sellers->bank_name}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="bank_acc_holder_name" class="col-sm-3 control-label">Acc Holder Name: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="bank_acc_holder_name" id="bank_acc_holder_name" value="{{$sellers->bank_acc_holder_name}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="bank_acc_number" class="col-sm-3 control-label">Bank Acc Number: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="bank_acc_number" id="bank_acc_number" value="{{$sellers->bank_acc_number}}">
                    </div>
                  </div>

                 <!--  <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password: </label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" name="password" id="password" value="{{$sellers->password}}">
                    </div>
                  </div> -->

                </div>
                <input type="hidden" name="user_id" value="{{$sellers->user_id}}">
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
    $('#frm-supplier-edit').on('submit',function(e)
    {
      e.preventDefault();
      console.log('pressed');
      var data = $(this).serialize();
      console.log(data);
      var formData = new FormData($(this)[0]);
      // formData.append('address', CKEDITOR.instances.address.getData());

      $.ajax(
      {
        url:"{{route('updateSeller')}}", 
        type: "POST",
        data: formData,
        async: false,
        success: function(response)
        {
          console.log(response);
          $("[data-dismiss = modal]").trigger({type: "click"});
          window.location.replace("{{route('seller')}}");

        },
        cache: false,
        contentType: false,
        processData: false
      });
    });
  });

</script>
@endsection