@extends('layout.master') 
@section('style')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection
 
@section('content')

<section class="content-header">
  <h1>
    FRUIT DETAILS
    <small>Control panel</small>
  </h1>

  <ol class="breadcrumb">
    <li>
      <a href="{{route('index')}}">
        <i class="fa fa-dashboard"></i>Dashboard</a>
    </li>
    <li class="active">Fruit</li>
  </ol>
</section>

<!-- test -->
<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid">
      <div class="box-header with-border">
        <!-- <i class="fa fa-flag"></i> -->
        <h3 class="box-title">
          <b>PRODUCT ID: {{$fruit->product_id}}</b>
        </h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <dl class="dl-horizontal">

          <dt>Name</dt>
          <dd>{{$fruit->product_name}}</dd>

          <dt>Fruit Description</dt>
          <dd>{{$fruit->product_desc}}</dd>

          <dt>Fruit Image</dt>
          <dd>
            <img src="{{ env('APP_PHOTO_URL') }}{{$fruit->product_image}}" style="max-height: 100px;" />
          </dd>

          <dt>Category</dt>
          <dd>{{$fruit->category}}</dd>

          <dt>Added At</dt>
          <dd>{{$fruit->created_at}}</dd>

          <dt>Last Updated At</dt>
          <dd>{{$fruit->updated_at}}</dd>
        </dl>
        <!-- <a class="btn btn-warning"
                  href="#">
                <i class="fa fa-edit"></i> Edit
              </a> -->
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box-solid -->
  </div>
  <!-- /.col -->
</div>
<!-- /.box -->
<!-- test -->


<div class="modal modal-info fade" id="add-price" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Add Price</h4>

      </div>
      <div class="modal-body">
        <!-- Custom Tabs (Pulled to the right) -->
        <form action="#" method="POST" id="frm-price-create" enctype="multipart/form-data">
          {!! csrf_field() !!}
          <div class="row">

            <div class="form-group">
              <label for="product_price" class="col-sm-3 control-label">Grade A Price: </label>
              <div class="col-sm-9">
                @if (isset($latestPrice))
                <input type="number" class="form-control" name="product_price" id="product_price" min="1" value="{{ $latestPrice->product_price }}">                @else
                <input type="number" class="form-control" name="product_price" id="product_price" min="1" value="1"> @endif
              </div>
            </div>

            <div class="form-group">
              <label for="product_price2" class="col-sm-3 control-label">Grade B Price: </label>
              <div class="col-sm-9">
                @if (isset($latestPrice))
                <input type="number" class="form-control" name="product_price2" id="product_price2" min="1" value="{{ $latestPrice->product_price2 }}">                @else
                <input type="number" class="form-control" name="product_price2" id="product_price2" min="1" value="1"> @endif
              </div>
            </div>

            <div class="form-group">
              <label for="product_price3" class="col-sm-3 control-label">Grade C Price: </label>
              <div class="col-sm-9">
                @if (isset($latestPrice))
                <input type="number" class="form-control" name="product_price3" id="product_price3" min="1" value="{{ $latestPrice->product_price3 }}">                @else
                <input type="number" class="form-control" name="product_price3" id="product_price3" min="1" value="1"> @endif
              </div>
            </div>

            <div class="form-group">
              <label for="date_price" class="col-sm-3 control-label">Date Price: </label>
              <div class="col-sm-9">
                <input type="date" class="form-control" name="date_price" id="date_price" value="{{ Carbon\Carbon::now()->toDateString() }}">
              </div>
            </div>

          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save New Price</button>
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
        <li class="active">
          <a href="#tab_1" data-toggle="tab">Active</a>
        </li>
        <li class="pull-right">
          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add-price">Add Price</button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="box">

            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">

              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-bordered" id="price-table">
                  <thead>

                    <tr class="bg-black">
                      <th class="mailbox-subject">
                        <center>Price ID</center>
                      </th>
                      <th class="mailbox-subject">
                        <center>Price A</center>
                      </th>
                      <th class="mailbox-subject">
                        <center>Price B</center>
                      </th>
                      <th class="mailbox-subject">
                        <center>Price C</center>
                      </th>
                      <th class="mailbox-subject">
                        <center>Date Price</center>
                      </th>
                      <th class="mailbox-subject">
                        <center>Operation</center>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach($prices as $price)
                    <tr>
                      <td class="mailbox-subject">
                        <center>{{$price->price_id}}</center>
                      </td>
                      <td class="mailbox-subject">
                        <center>{{$price->product_price}}</center>
                      </td>
                      <td class="mailbox-subject">
                        <center>{{$price->product_price2}}</center>
                      </td>
                      <td class="mailbox-subject">
                        <center>{{$price->product_price3}}</center>
                      </td>
                      <td class="mailbox-subject">
                        <center>{{$price->date_price}}</center>
                      </td>
                      <td class="mailbox-subject">
                        <center>
                          <div class="btn-group">
                            <a class="button btn btn-success btn-sm" href="{{route('editFruitPrice', ['price_id'=> $price->price_id, 'product_id'=> $fruit->product_id])}}">
                              <i class="fa fa-edit"></i> Edit</a> {{ Form::open(array('url' =>
                            'fruitprice/' . $price->price_id, 'class' => 'pull-right')) }} {{ Form::hidden('_method', 'DELETE')
                            }} {{ Form::submit('Delete', array('class' => 'button btn btn-warning btn-sm')) }} {{ Form::close()
                            }}
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
  $(document).ready(function () {
    $('#price-table').DataTable({
      "order": []
    });
    
    $('#frm-price-create').on('submit', function (e) {
      e.preventDefault();
      console.log('pressed');
      var data = $(this).serialize();

      console.log(data);
      var formData = new FormData($(this)[0]);
      // formData.append('product_desc', CKEDITOR.instances.product_desc.getData());
      // console.log(CKEDITOR.instances.description.getData());
      $.ajax({
        url: "{{route('createFruitPrice', ['product_id'=> $fruit->product_id])}}",
        type: "POST",
        data: formData,
        async: false,
        success: function (response) {
          console.log(response);
          $("[data-dismiss = modal]").trigger({
            type: "click"
          });
          window.location.href = window.location.href;
        },
        cache: false,
        contentType: false,
        processData: false
      });
    });
  });

</script>
@endsection