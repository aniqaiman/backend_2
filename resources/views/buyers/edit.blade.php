@extends('layout.master') 
@section('style')
@endsection

@section('content')
<section class="content-header">
    <h1>
        User Management
        <small>Edit Buyer</small>
    </h1>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('index') }}">
                <i class="fa fa-dashboard"></i> Dashboard 
            </a>
        </li>
        <li>User Management</li>
        <li class="active">Edit Buyer</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Buyer</h3>
                </div>
                <form action="{{ route('users.buyers.update', $buyers->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    @csrf

                    <div class="box-body">
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <p>
                                <i class="icon fa fa-check"></i> {{ Session::get('success') }}
                            </p>
                        </div>
                        @elseif (Session::has('error'))
                        <div class="alert alert-error">
                            <p>
                                <i class="icon fa fa-times"></i> {{ Session::get('error') }}
                            </p>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="display_picture" class="col-sm-3 control-label">Buyer Image : </label>
                            <div class="col-sm-9">
                              <input type="file" class="form-control" name="display_picture" id="display_picture">
                              <span class="help-block">Choose only if there is new picture.</span>
                          </div>
                          <div class="col-sm-offset-3 col-sm-9">
                              @if($buyers->display_picture)
                              Current:
                              <br/>
                              <img src="{{ env('APP_PHOTO_URL') }}{{$buyers->display_picture}}" class="gridimage" />
                              @else
                              Default:
                              <br/>
                              <img src="{{url('/img/no-image.jpg')}}" class="gridimage" />
                              @endif
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Owner Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" value="{{$buyers->name}}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="company_name" class="col-sm-3 control-label">Company Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="company_name" value="{{$buyers->company_name}}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="company_registration_mykad_number" class="col-sm-3 control-label">Company Reg. No. / MyKad No.:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="company_registration_mykad_number" value="{{$buyers->company_registration_mykad_number}}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bussiness_hour" class="col-sm-3 control-label">Business Hour:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="bussiness_hour" value="{{$buyers->bussiness_hour}}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">Address:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="address">{{$buyers->address}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Location:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon" style="min-width: 95px;">Latitude</span>
                                <input type="text" id="latitude" name="latitude" class="form-control" value="{{$buyers->latitude}}" />
                            </div>
                        </div>
                        <div class="col-sm-offset-3 col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon" style="min-width: 95px;">Longitude</span>
                                <input type="text" id="longitude" name="longitude" class="form-control" value="{{$buyers->longitude}}" />
                            </div>
                        </div>
                        <a href="#" class="help-block col-sm-offset-3 col-sm-9" onclick="locate()">
                            <i class="fa fa-map-pin"></i> Use Current Location
                        </a>
                    </div>

                    <div class="form-group">
                        <label for="mobile_number" class="col-sm-3 control-label">Mobile Number:</label>
                        <div class="col-sm-9">
                            <input type="text" name="mobile_number" class="form-control" value="{{$buyers->mobile_number}}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone_number" class="col-sm-3 control-label">Phone Number:</label>
                        <div class="col-sm-9">
                            <input type="text" name="phone_number" class="form-control" value="{{$buyers->phone_number}}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">E-Mail Address:</label>
                        <div class="col-sm-9">
                            <input type="email" name="email" class="form-control" value="{{$buyers->email}}" />
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Edit Buyer</button>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </div>
</div>
</section>
@endsection

@section('script')
<script>
    function locate() {
        const latitude = $('#latitude');
        const longitude = $('#longitude');

        navigator.geolocation.getCurrentPosition(
            position => {
                latitude.val(position.coords.latitude);
                longitude.val(position.coords.longitude);
            }, error => swal("Location Retrieval Error", "Cannot retrieve current location. Please retry.", "error"), { timeout: 15000 }
            );

    }
</script>
@endsection