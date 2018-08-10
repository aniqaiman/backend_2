@extends('layout.master')
@section('style')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection
@section('content')

<section class="content-header">
  <h1>
    User
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">User</li>
  </ol>
</section>

<!-- Modal -->
<div class="modal modal-info fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" >Add User</h4>

      </div>
      <div class="modal-body">
        <!-- Custom Tabs (Pulled to the right) -->

        <form action="#" method="POST" id="frm-user-create" enctype ="multipart/form-data">
          {!! csrf_field() !!}
          <div class="row">

            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Name: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="name" id="name">
              </div>
            </div>

            <div class="form-group">
              <label for="email" class="col-sm-3 control-label">Email: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="email" id="email">
              </div>
            </div>

            <div class="form-group">
              <label for="address" class="col-sm-3 control-label">Address: </label>
              <div class="col-sm-9">
                <textarea class="form-control" name="address" id="address"></textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="handphone_number" class="col-sm-3 control-label">Handphone No: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="handphone_number" id="handphone_number">
              </div>
            </div>

            <div class="form-group">
              <label for="profilepic" class="col-sm-3 control-label">Profile Picture: </label>
              <div class="col-sm-9">
                <input type="file" class="form-control" name="profilepic" id="profilepic">
              </div>
            </div>

            <div class="form-group">
              <label for="password" class="col-sm-3 control-label">Password: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="password" id="password">
              </div>
            </div>

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
          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add-user">Add User</button></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <div class="box">

              <!-- /.box-header -->
              <div class="box-body no-padding">
                <div class="mailbox-controls">

                </div>
                <div class="table-responsive mailbox-messages">
                  <table class="table table-bordered" id="user-table">

                    <thead>
                      <tr class="bg-black">
                        <!-- <th class="mailbox-star"><center><a href="#">Id</a></center></th> -->
                        <th class="mailbox-name"><center>Name</center></th>
                        <th class="mailbox-name"><center>Email</center></th>
                        <!-- <th class="mailbox-name"><center>Address</center></th> -->
                        <th class="mailbox-name"><center>Handphone Number</center></th>
                        <th class="col-sm-3"><center>Profile Picture</center></th>
                        <th class="mailbox-name"><center>Operation</center></th>
                      </tr>
                    </thead>

                    <tbody>        
                     @foreach($users as $user)
                     <tr>
                      <!-- <td class="mailbox-star"><center><a href="#">{{$user->user_id}}</a></center></td> -->
                      <td class="mailbox-name"><center>{{$user->name}}</center></td>
                      <td class="mailbox-name"><center>{{$user->email}}</center></td>
                      <!-- <td class="mailbox-name"><center>{{$user->address}}</center></td> -->
                      <td class="mailbox-name"><center>{{$user->handphone_number}}</center></td>
                      <td class="col-sm-3"><center><img style="width: 25%" src="{{ env('APP_PHOTO_URL') }}{{$user->profilepic}}"></center></td>
                      <td class="mailbox-name"><center><div class="btn-group">
                      <a class="button btn btn-success btn-sm" href="{{route('editUser', ['user_id'=> $user->user_id])}}"><i class="fa fa-gear"></i>Edit</a>
                        {{ Form::open(array('url' => 'users/' . $user->user_id, 'class' => 'pull-right')) }}
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
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

<script>
  $(document).ready(function(){
    $('#user-table').DataTable();
    // CKEDITOR.replace('address');
    $('#frm-user-create').on('submit',function(e)
    {
      e.preventDefault();
      console.log('pressed');
      var data = $(this).serialize();
      console.log(data);
      var formData = new FormData($(this)[0]);
      // formData.append('address', CKEDITOR.instances.address.getData());

      $.ajax(
      {
        url:"{{route('createUser')}}", 
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
        processData: false,
      });
    });
  });

</script>
@endsection