@extends('layout.master')
@section('style')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection
@section('content')

<section class="content-header">
  <h1>
    DRIVER
    <small>Control panel</small>
  </h1>

  <ol class="breadcrumb">
    <li><a href="{{route('index')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li class="active">Driver</li>
  </ol>
</section>

<div class="modal modal-info fade" id="add-driver" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Driver</h4>

      </div>
      <div class="modal-body">
        <!-- Custom Tabs (Pulled to the right) -->
        <form action="#" method="POST" id="frm-driver-create" enctype ="multipart/form-data">
          {!! csrf_field() !!}
          <div class="row">

            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Driver's Name: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="name" id="name" multiple="true">
              </div>
            </div>

            <div class="form-group">
              <label for="company_reg_ic_number" class="col-sm-3 control-label">IC Number: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="company_reg_ic_number" id="company_reg_ic_number" multiple="true">
              </div>
            </div>

            <div class="form-group">
              <label for="address" class="col-sm-3 control-label">Home Address: </label>
              <div class="col-sm-9">
                <textarea class="form-control" name="address" id="address" multiple="true"></textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="phonenumber" class="col-sm-3 control-label">Phone Number: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="phonenumber" id="phonenumber" multiple="true">
              </div>
            </div>

            <div class="form-group">
              <label for="license_number" class="col-sm-3 control-label">License Number: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="license_number" id="license_number" multiple="true">
              </div>
            </div>

            <div class="form-group">
              <label for="drivers_license" class="col-sm-3 control-label">Driver License: </label>
              <div class="col-sm-9">
                <input type="file" class="form-control" name="drivers_license" id="drivers_license" multiple="true">
              </div>
            </div>

            <div class="form-group">
              <label for="roadtax_expiry" class="col-sm-3 control-label">Roadtax Expiry: </label>
              <div class="col-sm-9">
                <input type="date" class="form-control" name="roadtax_expiry" id="roadtax_expiry" multiple="true">
              </div>
            </div>

             <div class="form-group">
              <label for="type_of_lorry" class="col-sm-3 control-label">Type of Lorry: </label>
              <div class="col-sm-9">
              <select class="form-control" name="type_of_lorry" id="type_of_lorry" placeholder="Select">
                      @foreach($types as $type)
                <option value="{{$type->type_id}}">{{$type->type}}</option>
                @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="lorry_capacity" class="col-sm-3 control-label">Lorry Capacity: </label>
              <div class="col-sm-9">
              <select class="form-control" name="lorry_capacity" id="lorry_capacity" placeholder="Select">
                      @foreach($capacities as $capacity)
                <option value="{{$capacity->cap_id}}">{{$capacity->capacity}}</option>
                @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="location_to_cover" class="col-sm-3 control-label">Location Covered: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="location_to_cover" id="location_to_cover" multiple="true">
              </div>
            </div>

            <div class="form-group">
              <label for="lorry_plate_number" class="col-sm-3 control-label">Lorry Plate No.: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="lorry_plate_number" id="lorry_plate_number" multiple="true">
              </div>
            </div>

            <!-- <div class="form-group">
              <label for="bank_name" class="col-sm-3 control-label">Bank Name: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="bank_name" id="bank_name" multiple="true">
              </div>
            </div>

            <div class="form-group">
              <label for="bank_acc_holder_name" class="col-sm-3 control-label">Acc Holder Name: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="bank_acc_holder_name" id="bank_acc_holder_name" multiple="true">
              </div>
            </div>

            <div class="form-group">
              <label for="bank_acc_number" class="col-sm-3 control-label">Bank Acc Number: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="bank_acc_number" id="bank_acc_number" multiple="true">
              </div>
            </div> -->

          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<section class="content">
  <div class="col-md-12">
    <!-- Custom Tabs (Pulled to the right) -->
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs ">
        <li class="active"><a href="#tab_1" data-toggle="tab">Active</a></li>
        <li class="pull-right"> 
          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add-driver">Add Driver</button></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <div class="box">

              <!-- /.box-header -->
              <div class="box-body no-padding">
                <div class="mailbox-controls">

                </div>
                <div class="table-responsive mailbox-messages">
                  <table class="table table-bordered" id="driver-table">
                   <thead>

                    <tr class="bg-black">
                      <!-- <th class="mailbox-star"><center><a href="#">Driver ID</a></center></th> -->
                      <th class="mailbox-star"><center>Driver Name</center></th>
                      <th class="mailbox-star"><center>Phone Number</center></th>
                      <th class="mailbox-star"><center>Location Cover</center></th>
                      <th class="mailbox-star"><center>Max Capacity</center></th>
                      <!-- <th class="mailbox-star"><center><a href="#">License Number</a></center></th> -->
                      <th class="mailbox-subject"><center>Operation</center></th>
                      
                    </tr>
                  </thead>
                  
                  <tbody>
                    @foreach($drivers as $driver) 
                    <tr>
                      <!-- <td class="mailbox-star"><center><a href="#">{{$driver->driver_id}}</a></center></td> -->
                      <td class="mailbox-name"><center>{{$driver->name}}</center></td>
                      <td class="mailbox-date"><center>{{$driver->phonenumber}}</center></td>
                      <td class="mailbox-date"><center>{{$driver->location_to_cover}}</center></td>
                      <td class="mailbox-date"><center>{{$driver->lorry_capacity}}</center></td>
                      <!-- <td class="mailbox-date"><center><a href="#">{{$driver->license_number}}</a></center></td> -->
                      <td class="mailbox-subject"><center><div class="btn-group">
                        <a class="button btn btn-success btn-sm" href="{{route('users.drivers.edit', ['user_id'=> $driver->user_id])}}"><i class="fa fa-edit"></i> Edit</a>
                        <a class="button btn btn-primary btn-sm" href="{{route('users.drivers.show', ['user_id'=> $driver->user_id])}}"><i class="fa fa-eye"></i> View Detail</a>
                        {{ Form::open(array('url' => 'driver/' . $driver->user_id, 'class' => 'pull-right')) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit('Delete', array('class' => 'button btn btn-warning btn-sm')) }}
                        {{ Form::close() }}
                      </center>
                    </td>
                  </tr>
                  @endforeach

                  
                </tbody>

              </table>
              <!-- /.table -->
            </div>
            <!-- /.mail-box-messages -->
          </div>
          <!-- /.box-body -->
        </div>
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
<!-- <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script> -->
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

<script>
  $(document).ready(function()
  {
    $('#driver-table').DataTable();
    // CKEDITOR.replace('address');

    $('#frm-driver-create').on('submit',function(e)
    {
      e.preventDefault();
      console.log('pressed');
      var data = $(this).serialize();

      console.log(data);
      var formData = new FormData($(this)[0]);
      // formData.append('address', CKEDITOR.instances.address.getData());
   // console.log(CKEDITOR.instances.description.getData());
   $.ajax(
   {
    url:"{{ route('users.drivers.store') }}", 
    type: "POST",
    data: formData,
    async: false,
    success: function(response)
    {
      console.log(response);
      $("[data-dismiss = modal]").trigger({type: "click"});
      window.location.reload();
    },  
    cache: false,
    contentType: false,
    processData: false
  });
 });
  });

</script>
@endsection 