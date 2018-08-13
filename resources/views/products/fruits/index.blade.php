@extends('layout.master') 
@section('style')
@endsection
 
@section('content')
<div class="modal fade" id="add-product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add Fruit</h4>
            </div>

            <form action="{{ action('FruitController@store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                @csrf

                <div class="modal-body">
                    <div class="form-group">
                        <label for="image" class="col-sm-3 control-label">Image:</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="image" id="image" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" id="name" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="desc" class="col-sm-3 control-label">Description:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="description" id="desc" /></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="short_desc" class="col-sm-3 control-label">Short Description:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="short_description" id="short_desc" /></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Quantity:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">Grade A</span>
                                <input type="number" name="quantity_a" class="form-control" min="0" required />
                                <span class="input-group-addon">kg</span>
                            </div>
                        </div>
                        <div class="col-sm-offset-3 col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">Grade B</span>
                                <input type="number" name="quantity_b" class="form-control" min="0" required />
                                <span class="input-group-addon">kg</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Demand:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">Grade A</span>
                                <input type="number" name="demand_a" class="form-control" min="0" required />
                                <span class="input-group-addon">kg</span>
                            </div>
                        </div>
                        <div class="col-sm-offset-3 col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">Grade B</span>
                                <input type="number" name="demand_b" class="form-control" min="0" required />
                                <span class="input-group-addon">kg</span>
                            </div>
                        </div>
                    </div>

                    <p class="lead">Initial Price</p>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Seller:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">Grade A</span>
                                <span class="input-group-addon">RM</span>
                                <input type="number" name="seller_price_a" class="form-control" min="0.01" step="0.01" required />
                            </div>
                        </div>
                        <div class="col-sm-offset-3 col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">Grade B</span>
                                <span class="input-group-addon">RM</span>
                                <input type="number" name="seller_price_b" class="form-control" min="0.01" step="0.01" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Buyer:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">Grade A</span>
                                <span class="input-group-addon">RM</span>
                                <input type="number" name="buyer_price_a" class="form-control" min="0.01" step="0.01" required />
                            </div>
                        </div>
                        <div class="col-sm-offset-3 col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">Grade B</span>
                                <span class="input-group-addon">RM</span>
                                <input type="number" name="buyer_price_b" class="form-control" min="0.01" step="0.01" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add New Fruit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<section class="content-header">
    <h1>
        Product Management
        <small>Manage Fruits</small>
    </h1>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('index') }}">
                <i class="fa fa-dashboard"></i> Dashboard
            </a>
        </li>
        <li>Product Management</li>
        <li class="active">Manage Fruits</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Fruit List</h3>
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-product">Add Fruit</button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table" id="product-table" style="width:100%">
                            <thead>
                                <tr class="bg-black">
                                    <th rowspan="2" style="width: 1%;">Image</th>
                                    <th rowspan="2">Name</th>
                                    <th rowspan="2">Description</th>
                                    <th colspan="2" class="text-center">Quantity</th>
                                    <th colspan="2" class="text-center">Demand</th>
                                    <th rowspan="2" style="width: 1%;"></th>
                                </tr>
                                <tr class="bg-black">
                                    <th class="text-center">Grade A</th>
                                    <th class="text-center">Grade B</th>
                                    <th class="text-center">Grade A</th>
                                    <th class="text-center">Grade B</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fruits as $fruit)
                                <tr>
                                    <td class="text-center">
                                        <img style="max-height: 100px;" src="{{ env('APP_PHOTO_URL') }}{{ $fruit->image }}" onerror="this.src='/img/no-image.jpg'" />
                                    </td>
                                    <td>{{ $fruit->name }}</td>
                                    <td>
                                        <dl>
                                            <dt>Short</dt>
                                            <dd>{{ isset($fruit->short_description) ? $fruit->short_description : '-' }}</dd>
                                            <dt>Full</dt>
                                            <dd>{{ isset($fruit->description) ? $fruit->description : '-' }}</dd>
                                        </dl>
                                    </td>
                                    <td class="text-center text-nowrap">{{ $fruit->quantity_a }} kg</td>
                                    <td class="text-center text-nowrap">{{ $fruit->quantity_b }} kg</td>
                                    <td class="text-center text-nowrap">{{ $fruit->demand_a }} kg</td>
                                    <td class="text-center text-nowrap">{{ $fruit->demand_b }} kg</td>
                                    <td class="text-center text-nowrap">
                                        <form method="POST" action="{{ action('FruitController@destroy', $fruit->id) }}" class="btn-group-vertical btn-group-sm">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <div class="btn-group-vertical btn-group-sm">
                                                <a class="btn btn-info" href="{{ route('products.fruits.edit', ['product_id'=> $fruit->id]) }}">Edit</a>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection
 
@section('script')
<script>
    $(document).ready(function () {
        $('#product-table').DataTable({
            'order': [],
        });
    });

</script>
@endsection