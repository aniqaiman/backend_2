@extends('layout.master') 
@section('style')
@endsection
 
@section('content')
<section class="content-header">
    <h1>
        User Management
        <small>New Driver</small>
    </h1>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('index') }}">
                <i class="fa fa-dashboard"></i> Dashboard
            </a>
        </li>
        <li>User Management</li>
        <li class="active">New Driver</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Driver</h3>
                </div>
                <form action="{{ action('DriverController@store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    @csrf

                    <div class="box-body">
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <p>
                                <i class="icon fa fa-check"></i> {{ Session::get('success') }}
                            </p>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Name:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company_registration_mykad_number" class="col-sm-3 control-label">MyKad Number:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="company_registration_mykad_number" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label">Address:</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="address" required /></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone_number" class="col-sm-3 control-label">Phone Number:</label>
                            <div class="col-sm-9">
                                <input type="text" name="phone_number" class="form-control" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="driver_license_number" class="col-sm-3 control-label">Licence Number:</label>
                            <div class="col-sm-9">
                                <input type="text" name="driver_license_number" class="form-control" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="driver_license_picture" class="col-sm-3 control-label">Licence Picture:</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="driver_license_picture" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lorry_roadtax_expiry" class="col-sm-3 control-label">Roadtax Expiry:</label>
                            <div class="col-sm-9">
                                <input type="date" name="lorry_roadtax_expiry" class="form-control" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lorry_type_id" class="col-sm-3 control-label">Type of Lorry:</label>
                            <div class="col-sm-9">
                                <select name="lorry_type_id" class="form-control">
                                    @foreach ($lorry_types as $lorry_type)
                                    <option value="{{ $lorry_type->id }}">{{ $lorry_type->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lorry_capacity_id" class="col-sm-3 control-label">Lorry Capacity:</label>
                            <div class="col-sm-9">
                                <select name="lorry_capacity_id" class="form-control">
                                    @foreach ($lorry_capacities as $lorry_capacity)
                                    <option value="{{ $lorry_capacity->id }}">{{ $lorry_capacity->capacity }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lorry_plate_number" class="col-sm-3 control-label">Lorry Plate Number:</label>
                            <div class="col-sm-9">
                                <input type="text" name="lorry_plate_number" class="form-control" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location_covered" class="col-sm-3 control-label">Location Covered:</label>
                            <div class="col-sm-9">
                                <input type="text" name="location_covered" class="form-control" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">Password:</label>
                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Add New</button>
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