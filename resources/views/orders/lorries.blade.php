@extends('layout.master') 
@section('style')
@endsection
 
@section('content')


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Title</h4>
            </div>
            <div class="modal-body">
                <div id="spinner">
                    <i class="fa fa-spinner fa-spin"></i> Fetching driver details...
                </div>
                <dl id="dd" class="hidden">
                    <dt>Driver Name</dt>
                    <dd id="dd-driver-name">xxx</dd>
                    <dt>Driver Id</dt>
                    <dd id="dd-driver-id">xxx</dd>
                    <dt>IC Number</dt>
                    <dd id="dd-mykad-number">xxx</dd>
                    <dt>Home Address</dt>
                    <dd id="dd-home-address">xxx</dd>
                    <dt>Phone number</dt>
                    <dd id="dd-phone-number">xxx</dd>
                    <dt>Driver Licence Image</dt>
                    <dd id="dd-driver-image"></dd>
                    <dt>Roadtax Expiry</dt>
                    <dd id="dd-roadtax-expiry">xxx</dd>
                    <dt>Type of lorry</dt>
                    <dd id="dd-lorry-type">xxx</dd>
                    <dt>Lorry capacity</dt>
                    <dd id="dd-lorry-capacity">xxx</dd>
                    <dt>Location covered</dt>
                    <dd id="dd-location-covered"></dd>
                    <dt>Lorry plate no</dt>
                    <dd id="dd-lorry-plate">xxx</dd>
                    <dt>Bank account no</dt>
                    <dd id="dd-bank-account">xxx</dd>
                    <dt>Bank name</dt>
                    <dd id="dd-bank-name">xxx</dd>
                    <dt>Bank owner name</dt>
                    <dd id="dd-bank-owner-name">xxx</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<section class="content-header">
    <h1>
        Lorry Management
    </h1>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('index') }}">
                <i class="fa fa-dashboard"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="#">Lorry Management</a>
        </li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1" data-toggle="tab">Buyer</a>
                    </li>
                    <li>
                        <a href="#tab_2" data-toggle="tab">Supplier</a>
                    </li>
                    <li class="pull-right" style="margin-top: 3px;">
                        <form method="get" class="form-inline">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <a class="btn btn-default" href="{{ route('orders.index.lorries') }}">Show All</a>
                                </span>
                                <input type="date" class="form-control" name="filter_date" value="{{ $filter_date }}" />
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                        Filter
                                    </button>
                                </span>
                            </div>
                        </form>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="tab_1">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="driver-order-table" style="width:100%">
                                <thead>
                                    <tr class="bg-black">
                                        <th>Date</th>
                                        <th>Driver Name</th>
                                        <th class="text-center">Driver#</th>
                                        <th class="text-center">Order#</th>
                                        <th class="text-center">Pick Up Location</th>
                                        <th>Buyer Name</th>
                                        <th class="text-center">Buyer#</th>
                                        <th class="text-center">Drop off Location</th>
                                        <th class="text-center">Total Distance</th>
                                        <th class="text-center">Total Tonnage</th>
                                        <th class="text-center">Total Payout</th>
                                        <th class="text-center">Route Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order["date"] }}</td>
                                        <td>{{ $order["driver_name"] }}</td>
                                        <td class="text-center">
                                            <a href="#" data-id='{{ $order["driver_id"] }}' data-toggle="modal" data-target="#exampleModal">
                                                {{ $order["driver_id"] }}
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $order["id"] }}</td>
                                        <td class="text-center">
                                            Warehouse
                                            <a href='https://www.google.com/maps/search/?api=1&query=3.123093,101.468913' target="_blank">
                                                <i class="fa fa-map-marker"></i>
                                            </a>
                                        </td>
                                        <td>{{ $order["user_name"] }}</td>
                                        <td class="text-center">{{ $order["user_id"] }}</td>
                                        <td class="text-center">
                                            {{ $order["user_address"] }}
                                            <a href='https://www.google.com/maps/search/?api=1&query={{ $order["latitude"] }},{{ $order["longitude"] }}' target="_blank">
                                                <i class="fa fa-map-marker"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $order["distance"] }} km</td>
                                        <td class="text-center">{{ $order["tonnage"] }} kg</td>
                                        <td class="text-center">RM {{ number_format($order["total_payout"], 2) }}</td>
                                        <td class="text-center"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="driver-stock-table" style="width:100%">
                                <thead>
                                    <tr class="bg-black">
                                        <th>Date</th>
                                        <th>Driver Name</th>
                                        <th class="text-center">Driver#</th>
                                        <th class="text-center">Order#</th>
                                        <th class="text-center">Pick Up Location</th>
                                        <th>Supplier Name</th>
                                        <th class="text-center">Supplier#</th>
                                        <th class="text-center">Drop off Location</th>
                                        <th class="text-center">Total Distance</th>
                                        <th class="text-center">Total Tonnage</th>
                                        <th class="text-center">Total Payout</th>
                                        <th class="text-center">Route Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stocks as $stock)
                                    <tr>
                                        <td>{{ $stock["date"] }}</td>
                                        <td>{{ $stock["driver_name"] }}</td>

                                        <td class="text-center">
                                            <a href="#" data-id='{{ $stock["driver_id"] }}' data-toggle="modal" data-target="#exampleModal">
                                                {{ $stock["driver_id"] }}
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $stock["id"] }}</td>
                                        <td class="text-center">{{ $stock["user_address"] }}
                                            <a href='https://www.google.com/maps/search/?api=1&query={{ $stock["latitude"] }},{{ $stock["longitude"] }}' target="_blank">
                                                <i class="fa fa-map-marker"></i>
                                            </a>
                                        </td>
                                        <td>{{ $stock["user_name"] }}</td>
                                        <td class="text-center">{{ $stock["user_id"] }}</td>
                                        <td class="text-center">
                                            Warehouse
                                            <a href='https://www.google.com/maps/search/?api=1&query=3.123093,101.468913' target="_blank">
                                                <i class="fa fa-map-marker"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $stock["distance"] }} km</td>
                                        <td class="text-center">{{ $stock["tonnage"] }} kg</td>
                                        <td class="text-center">RM {{ number_format($stock["total_payout"], 2) }}</td>
                                        <td class="text-center"></td>
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
    </div>
</section>
@endsection
 
@section('script')
<script>
    $(document).ready(function () {

        $('#driver-stock-table').DataTable({
            'order': [],
            'ordering': true,
            'paging': false,
            'info': false,
        });

        $('#driver-order-table').DataTable({
            'order': [],
            'ordering': true,
            'paging': false,
            'info': false,
        });

        $('#exampleModal').on('show.bs.modal', function (event) {
            var spinner = $('#spinner');
            var ud = $('#dd');
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var url = "{{ route('users.json', ['xxx']) }}";

            spinner.toggleClass('hidden', false);
            ud.toggleClass('hidden', true);

            var modal = $(this);
            modal.find('#exampleModalLabel').text('Driver Details | ' + id);
            modal.find('#feedback-id').val(id);

            $.ajax(url.replace("xxx", id), {
                dataType: "json",
                error: (jqXHR, textStatus, errorThrown) => { },
                method: "GET",
                success: (data, textStatus, jqXHR) => {
                    spinner.toggleClass('hidden', true);
                    ud.toggleClass('hidden', false);
                    console.log(data)

                    $('#dd-driver-name').text(data.name);
                    $('#dd-driver-id').text(data.id);
                    $('#dd-mykad-number').text(data.company_registration_mykad_number);
                    $('#dd-home-address').text(data.address);
                    $('#dd-phone-number').text(data.phone_number);
                    $('#dd-roadtax-expiry').text(data.lorry_roadtax_expiry);
                    $('#dd-lorry-type').text(data.lorry_type_id);
                    $('#dd-lorry-capacity').text(data.lorry_capacity_id);
                    $('#dd-lorry-plate').text(data.lorry_plate_number);
                    $('#dd-bank-account').text(data.bank_account_number);
                    $('#dd-bank-name').text(data.bank_name);
                    $('#dd-bank-owner-name').text(data.bank_account_holder_name);

                }
            });
        });
    });

</script>
@endsection