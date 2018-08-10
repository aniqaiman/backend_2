@extends('layout.master')
@section('style')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection
@section('content')

<section class="content-header">
  <h1>
    DRIVER DETAILS
    <small>Control panel</small>
  </h1>

  <ol class="breadcrumb">
    <li><a href="{{route('index')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li class="active">Driver</li>
  </ol>
</section>

<!-- test -->
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-solid">
           <div class="box-header with-border">
              <!-- <i class="fa fa-flag"></i> -->
              <h3 class="box-title"><b>DRIVER ID: </b></h3>
           </div>
           <!-- /.box-header -->
           <div class="box-body">
              <dl class="dl-horizontal">

                 <dt>Name</dt>
                 <dd>{{$driver->name}}</dd>

                 <dt>Address</dt>
                 <dd>{{$driver->address}}</dd>

                 <dt>Roadtax Expired Date</dt>
                 <dd>{{$driver->roadtax_expiry}}</dd>

                 <dt>Lorry Type</dt>
                 <dd>{{$driver->types->type}}</dd>

                 <dt>Lorry Capacity</dt>
                 <dd>{{$driver->capacities->capacity}}</dd>
              </dl>
              <!-- <a class="btn btn-warning"
                  href="#">
                <i class="fa fa-edit"></i> Edit
              </a> -->
           </div>
           <!-- /.box-body -->
        </div> <!-- /.box-solid -->
      </div> <!-- /.col -->
   </div> <!-- /.box -->
<!-- test -->


<div class="modal modal-info fade" id="add-transaction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Transaction</h4>

      </div>
      <div class="modal-body">
        <!-- Custom Tabs (Pulled to the right) -->
        <form action="#" method="POST" id="frm-transaction-create" enctype ="multipart/form-data">
          {!! csrf_field() !!}
          <div class="row">

           <!-- INSERT FIELD HERE -->

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
          <!-- <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add-price">Add Price</button></li> -->
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <div class="box">

              <!-- /.box-header -->
              <div class="box-body no-padding">
                <div class="mailbox-controls">

                </div>
                <div class="table-responsive mailbox-messages">
                  <table class="table table-bordered" id="transaction-table">
                   <thead>

                    <tr class="bg-black">
                      <th class="mailbox-star"><center>Date</center></th>
                      <th class="mailbox-star"><center>Item</center></th>
                      <th class="mailbox-star"><center>Product#</center></th>
                      <th class="mailbox-star"><center>Quantity</center></th>
                      <th class="mailbox-star"><center>Pick Up Location</center></th>
                      <th class="mailbox-star"><center>Supplier Name</center></th>
                      <th class="mailbox-star"><center>Supplier ID</center></th>
                      <th class="mailbox-star"><center>Drop Off Location</center></th>
                      <th class="mailbox-star"><center>Price per KG</center></th>
                      <th class="mailbox-star"><center>Total Amount</center></th>
                    </tr>
                  </thead>

                  <tbody>
                    
                    <tr>
                      <td class="mailbox-subject"><center></center></td>
                      <td class="mailbox-subject"><center></center></td>
                      <td class="mailbox-subject"><center></center></td>
                      <td class="mailbox-subject"><center></center></td>
                      <td class="mailbox-subject"><center></center></td>
                      <td class="mailbox-subject"><center></center></td>
                      <td class="mailbox-subject"><center></center></td>
                      <td class="mailbox-subject"><center></center></td>
                      <td class="mailbox-subject"><center></center></td>
                      <td class="mailbox-subject"><center></center></td>
                  </tr>
                  
                  
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
    $('#transaction-table').DataTable();
    $('#frm-transaction-create').on('submit',function(e)
    {
      e.preventDefault();
      console.log('pressed');
      var data = $(this).serialize();

      console.log(data);
      var formData = new FormData($(this)[0]);
   // formData.append('product_desc', CKEDITOR.instances.product_desc.getData());
   // console.log(CKEDITOR.instances.description.getData());
   $.ajax(
   {
    url:"#", 
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