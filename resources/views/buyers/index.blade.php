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
                    <i class="fa fa-spinner fa-spin"></i> Fetching buyer details...
                </div>
                <dl id="ud" class="hidden">
                    <dt>Owner Name</dt>
                    <dd id="ud-owner-name">xxx</dd>
                    <dt>Company Name</dt>
                    <dd id="ud-company-name">xxx</dd>
                    <dt>Company Registration / MyKad Number</dt>
                    <dd id="ud-company-registration-mykad-number">xxx</dd>
                    <dt>Business Hour</dt>
                    <dd id="ud-business-hour">xxx</dd>
                    <dt>Address</dt>
                    <dd id="ud-company-address">xxx</dd>
                    <dd>
                        Latitude:
                        <span id="ud-company-address-latitude"></span>
                    </dd>
                    <dd>
                        Longitude:
                        <span id="ud-company-address-longitude"></span>
                    </dd>
                    <dd>
                        <a href="" target="_blank" id="ud-company-address-navigation">
                            <i class="fa fa-map-marker"></i> Navigate
                        </a>
                    </dd>
                    <dt>Mobile Number</dt>
                    <dd id="ud-mobile-number">xxx</dd>
                    <dt>Phone Number</dt>
                    <dd id="ud-phone-number">xxx</dd>
                    <dt>E-Mail Address</dt>
                    <dd id="ud-email">xxx</dd>
                    <dt>Status</dt>
                    <dd>
                        E-Mail:
                        <span id="ud-email-status-verified" class="label label-success">Verified</span>
                        <span id="ud-email-status-unverified" class="label label-danger">Unverified</span>
                        <br /> Account:
                        <span id="ud-account-status-verified" class="label label-success">Activated</span>
                        <span id="ud-account-status-unverified" class="label label-danger">Deactivated</span>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<section class="content-header">
    <h1>
        Buyer Management
    </h1>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('index') }}">
                <i class="fa fa-dashboard"></i> Dashboard
            </a>
        </li>
        <li class="active">Buyer Management</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
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
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="#tab_1" data-toggle="tab">
                            Activated
                            <span class="badge bg-light-blue">{{ $activated_buyers->count() }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#tab_2" data-toggle="tab">
                            Deactivated
                            <span class="badge bg-light-blue">{{ $deactivated_buyers->count() }}</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane" id="tab_1">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="activated-buyer-table" style="width:100%">
                                <thead>
                                    <tr class="bg-black">
                                        <th>Buyer Name</th>
                                        <th>Buyer#</th>
                                        <th>Purchased Products</th>
                                        <th>Date Registered</th>
                                        <th>Location</th>
                                        <th>Contact (H/P &amp; Email)</th>
                                        <th class="text-center">Status</th>
                                        <th style="width: 1%;"></th>
                                    </tr>
                                </thead>
    
                                <tbody>
                                    @foreach($activated_buyers as $buyer)
                                    <tr id="buyer_{{ $buyer->id }}">
                                        <td>{{ $buyer->name }}</td>
                                        <td>
                                            <a href="#" data-id="{{ $buyer->id }}" data-toggle="modal" data-target="#exampleModal">
                                                {{ $buyer->id }}
                                            </a>
                                        </td>
                                        <td nowrap>
                                            @if (!$buyer->orders()->exists())
                                            <div>No products been ordered.</div>
                                            @endif
                                            <ul class="list-unstyled">
                                                @foreach ($buyer->products as $product)
                                                <li>{{ $product->name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $buyer->created_at }}</td>
                                        <td>
                                            {{ $buyer->address }}
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $buyer->latitude }},{{ $buyer->longitude }}" target="_blank">
                                                <i class="fa fa-map-marker"></i>
                                            </a>
                                        </td>
                                        <td>
                                            Phone:
                                            <a href="tel:{{ $buyer->phone_number }}">{{ $buyer->phone_number }}</a>
                                            <br /> Mobile:
                                            <a href="tel:{{ $buyer->mobile_number }}">{{ $buyer->mobile_number }}</a>
                                            <br /> E-Mail:
                                            <a href="tel:{{ $buyer->email }}">{{ $buyer->email }}</a>
                                        </td>
                                        <td class="text-center">
                                            E-Mail: @if ($buyer->status_email === 1)
                                            <span class="label label-success">Verified</span> @else
                                            <span class="label label-danger">Unverified</span> @endif
                                            <br /> Account: @if ($buyer->status_account === 1)
                                            <span class="label label-success">Activated</span> @else
                                            <span class="label label-danger">Deactivated</span> @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($buyer->status_account === 0)
                                            <div class="btn-group-vertical btn-group-sm">
                                                <button class="btn btn-success" data-id="{{ $buyer->id }}" onclick="activateUser(this)">Activate</button>
                                                <a class="button btn btn-primary">Edit</a>
                                                <button class="btn btn-warning" disabled>Deactivate</button>
                                            </div>
                                            @elseif ($buyer->status_account === 1)
                                            <div class="btn-group-vertical btn-group-sm">
                                                <button class="btn btn-success" disabled>Activate</button>
                                                <a class="button btn btn-primary" href="{{ route('users.buyers.edit', ['user_id'=> $buyer->id]) }}">Edit</a>
                                                <button class="btn btn-warning" data-id="{{ $buyer->id }}" onclick="deactivateUser(this)">Deactivate</button>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="deactivated-buyer-table" style="width:100%">
                                <thead>
                                    <tr class="bg-black">
                                        <th>Buyer Name</th>
                                        <th>Buyer#</th>
                                        <th>Purchased Products</th>
                                        <th>Date Registered</th>
                                        <th>Location</th>
                                        <th>Contact (H/P &amp; Email)</th>
                                        <th class="text-center">Status</th>
                                        <th style="width: 1%;"></th>
                                    </tr>
                                </thead>
    
                                <tbody>
                                    @foreach($deactivated_buyers as $buyer)
                                    <tr id="buyer_{{ $buyer->id }}">
                                        <td>{{ $buyer->name }}</td>
                                        <td>
                                            <a href="#" data-id="{{ $buyer->id }}" data-toggle="modal" data-target="#exampleModal">
                                                {{ $buyer->id }}
                                            </a>
                                        </td>
                                        <td nowrap>
                                            @if (!$buyer->orders()->exists())
                                            <div>No products been ordered.</div>
                                            @endif
                                            <ul class="list-unstyled">
                                                @foreach ($buyer->products as $product)
                                                <li>{{ $product->name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $buyer->created_at }}</td>
                                        <td>
                                            {{ $buyer->address }}
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $buyer->latitude }},{{ $buyer->longitude }}" target="_blank">
                                                <i class="fa fa-map-marker"></i>
                                            </a>
                                        </td>
                                        <td>
                                            Phone:
                                            <a href="tel:{{ $buyer->phone_number }}">{{ $buyer->phone_number }}</a>
                                            <br /> Mobile:
                                            <a href="tel:{{ $buyer->mobile_number }}">{{ $buyer->mobile_number }}</a>
                                            <br /> E-Mail:
                                            <a href="tel:{{ $buyer->email }}">{{ $buyer->email }}</a>
                                        </td>
                                        <td class="text-center">
                                            E-Mail: @if ($buyer->status_email === 1)
                                            <span class="label label-success">Verified</span> @else
                                            <span class="label label-danger">Unverified</span> @endif
                                            <br /> Account: @if ($buyer->status_account === 1)
                                            <span class="label label-success">Activated</span> @else
                                            <span class="label label-danger">Deactivated</span> @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($buyer->status_account === 0)
                                            <div class="btn-group-vertical btn-group-sm">
                                                <button class="btn btn-success" data-id="{{ $buyer->id }}" onclick="activateUser(this)">Activate</button>
                                                <button class="btn btn-warning" disabled>Deactivate</button>
                                            </div>
                                            @elseif ($buyer->status_account === 1)
                                            <div class="btn-group-vertical btn-group-sm">
                                                <button class="btn btn-success" disabled>Activate</button>
                                                <button class="btn btn-warning" data-id="{{ $buyer->id }}" onclick="deactivateUser(this)">Deactivate</button>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
 
@section('script')
<script>
    $(document).ready(function () {
        $('#exampleModal').on('show.bs.modal', function (event) {
            var spinner = $('#spinner');
            var ud = $('#ud');
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var url = "{{ route('users.json', ['xxx']) }}";

            spinner.toggleClass('hidden', false);
            ud.toggleClass('hidden', true);

            var modal = $(this);
            modal.find('#exampleModalLabel').text('Buyer Details | ' + id);
            modal.find('#feedback-id').val(id);

            $.ajax(url.replace("xxx", id), {
                dataType: "json",
                error: (jqXHR, textStatus, errorThrown) => { },
                method: "GET",
                success: (data, textStatus, jqXHR) => {
                    spinner.toggleClass('hidden', true);
                    ud.toggleClass('hidden', false);

                    $('#ud-owner-name').text(data.name);
                    $('#ud-company-name').text(data.company_name);
                    $('#ud-company-registration-mykad-number').text(data.company_registration_mykad_number);
                    $('#ud-business-hour').text(data.bussiness_hour);
                    $('#ud-company-address').text(data.address);
                    $('#ud-company-address-latitude').text(data.latitude);
                    $('#ud-company-address-longitude').text(data.longitude);
                    $('#ud-company-address-navigation').attr("href", "https://www.google.com/maps/search/?api=1&query=" + data.latitude + "," + data.longitude);
                    $('#ud-mobile-number').text(data.mobile_number);
                    $('#ud-phone-number').text(data.phone_number);
                    $('#ud-email').text(data.email);

                    if (data.status_email === 0) {
                        $('#ud-email-status-verified').hide();
                        $('#ud-email-status-unverified').show();
                    }
                    else if (data.status_email === 1) {
                        $('#ud-email-status-verified').show();
                        $('#ud-email-status-unverified').hide();
                    }

                    if (data.status_account === 0) {
                        $('#ud-account-status-verified').hide();
                        $('#ud-account-status-unverified').show();
                    }
                    else if (data.status_account === 1) {
                        $('#ud-account-status-verified').show();
                        $('#ud-account-status-unverified').hide();
                    }
                }
            });
        });

        $('#activated-buyer-table').DataTable({
            'order': [],
            'ordering': true,
            'paging': false,
            'info': false,
        });

        $('#deactivated-buyer-table').DataTable({
            'order': [],
            'ordering': true,
            'paging': false,
            'info': false,
        });

    });

    function activateUser(btn) {
        var data = {
            id: $(btn).data('id'),
        }

        $(btn).prop('disabled', true);
        $(btn).html('<i class="fa fa-spinner fa-spin"></i> Updating...');

        $.ajax("{{ route('users.activate') }}", {
            data: data,
            dataType: "json",
            error: (jqXHR, textStatus, errorThrown) => { },
            method: "PUT",
            success: (data, textStatus, jqXHR) => {
                window.location.href = window.location.href;
            }
        });
    }

    function deactivateUser(btn) {
        var data = {
            id: $(btn).data('id'),
        }

        $(btn).prop('disabled', true);
        $(btn).html('<i class="fa fa-spinner fa-spin"></i> Updating...');

        $.ajax("{{ route('users.deactivate') }}", {
            data: data,
            dataType: "json",
            error: (jqXHR, textStatus, errorThrown) => { },
            method: "PUT",
            success: (data, textStatus, jqXHR) => {
                window.location.href = window.location.href;
            }
        });
    }


</script>
@endsection