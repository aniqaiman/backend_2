@extends('layout.master') 
@section('style')
@endsection
 
@section('content')
<section class="content-header">
    <h1>
        Product Management
        <small>Edit Fruit</small>
    </h1>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('index') }}">
                <i class="fa fa-dashboard"></i> Dashboard
            </a>
        </li>
        <li>Product Management</li>
        <li>
            <a href="{{ route('products.fruits.index') }}">Manage Fruits</a>
        </li>
        <li class="active">Edit Fruit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Fruit</h3>
                </div>
                <form action="{{ action('FruitController@update', $fruit->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="_method" value="PUT" />

                    <div class="box-body">
                        <div class="form-group">
                            <label for="image" class="col-sm-3 control-label">Image:</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="image" />
                                <span class="help-block">Choose only if there is new picture.</span>
                            </div>
                            <div class="col-sm-offset-3 col-sm-9">
                                Current:
                                <br/>
                                <img style="max-width: 100px;" src="{{ env('APP_PHOTO_URL') }}{{ $fruit->image }}" onerror="this.src='/img/no-image.jpg'"
                                />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Name:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" value="{{ $fruit->name }}" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="desc" class="col-sm-3 control-label">Description:</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="description" />{{ $fruit->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="short_desc" class="col-sm-3 control-label">Short Description:</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="short_description" />{{ $fruit->short_description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Quantity:</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon">Grade A</span>
                                    <input type="number" name="quantity_a" class="form-control" min="0" value="{{ $fruit->quantity_a }}" required />
                                    <span class="input-group-addon">kg</span>
                                </div>
                            </div>
                            <div class="col-sm-offset-3 col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon">Grade B</span>
                                    <input type="number" name="quantity_b" class="form-control" min="0" value="{{ $fruit->quantity_b }}" required />
                                    <span class="input-group-addon">kg</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Demand:</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon">Grade A</span>
                                    <input type="number" name="demand_a" class="form-control" min="0" value="{{ $fruit->demand_a }}" required />
                                    <span class="input-group-addon">kg</span>
                                </div>
                            </div>
                            <div class="col-sm-offset-3 col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon">Grade B</span>
                                    <input type="number" name="demand_b" class="form-control" min="0" value="{{ $fruit->demand_b }}" required />
                                    <span class="input-group-addon">kg</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="{{ $fruit->id }}">
                        <button type="submit" class="btn btn-primary">Save Fruit</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection
 
@section('script')
@endsection