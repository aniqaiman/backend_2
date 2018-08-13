@extends('layout.master')
@section('style')
@endsection
@section('content')

<section class="content-header">
  <h1>
    FRUIT
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li class="active">Fruit</li>
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
              <form action="#" method="POST" id="frm-price-edit" enctype ="multipart/form-data">
                {!! csrf_field() !!}
                <div class="row">

                  <div class="form-group">
                    <label for="product_price" class="col-sm-3 control-label">Grade A Price: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="product_price" id="product_price" value="{{$prices->product_price}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="product_price2" class="col-sm-3 control-label">Grade B Price: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="product_price2" id="product_price2" value="{{$prices->product_price2}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="product_price3" class="col-sm-3 control-label">Grade C Price: </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="product_price3" id="product_price3" value="{{$prices->product_price3}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="date_price" class="col-sm-3 control-label">Date Price: </label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" name="date_price" id="date_price" value="{{$prices->date_price}}">
                    </div>
                  </div>

                </div>
                <input type="hidden" name="price_id" value="{{$prices->price_id}}">
                <input type="hidden" name="product_id" value="{{$prices->product_id}}">
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
// CKEDITOR.replace('product_desc');
$('#frm-price-edit').on('submit',function(e){
  e.preventDefault();
  console.log('pressed');
  var data = $(this).serialize();
  console.log(data);
  var formData = new FormData($(this)[0]);
    // formData.append('product_desc', CKEDITOR.instances.product_desc.getData());

    $.ajax({
      url:"{{route('updateFruitPrice')}}", 
      type: "POST",
      data: formData,
      async: false,
      success: function(response){
        console.log(response);
        $("[data-dismiss = modal]").trigger({type: "click"});

        window.location.replace("{{route('getFruitDetail',['product_id'=> $fruit->product_id])}}");

      },
      cache: false,
      contentType: false,
      processData: false
    });
  });

</script>
@endsection