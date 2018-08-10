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
                    <i class="fa fa-spinner fa-spin"></i> Fetching supplier details...
                </div>
                <dl id="ud" class="hidden">
                    <dt>Owner Name</dt>
                    <dd id="ud-owner-name">xxx</dd>
                    <dt>Company Name</dt>
                    <dd id="ud-company-name">xxx</dd>
                    <dt>Company Registration / MyKad Number</dt>
                    <dd id="ud-company-registration-mykad-number">xxx</dd>
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
                    <dt>E-Mail Address</dt>
                    <dd id="ud-email">xxx</dd>
                    <dt>Bank Account Number</dt>
                    <dd id="ud-account-number">xxx</dd>
                    <dt>Bank Name</dt>
                    <dd id="ud-bank-name">xxx</dd>
                    <dt>Bank Account Owner Name</dt>
                    <dd id="ud-account-owner-name">xxx</dd>
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
        Supplier Management
    </h1>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('index') }}">
                <i class="fa fa-dashboard"></i> Dashboard
            </a>
        </li>
        <li class="active">Supplier Management</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="#tab_1" data-toggle="tab">
                            Activated
                            <span class="badge bg-light-blue">{{ $activated_sellers->count() }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#tab_2" data-toggle="tab">
                            Deactivated
                            <span class="badge bg-light-blue">{{ $deactivated_sellers->count() }}</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane" id="tab_1">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="activated-seller-table" style="width:100%">
                                <thead>
                                    <tr class="bg-black">
                                        <th>Supplier Name</th>
                                        <th>Supplier#</th>
                                        <th>Supplied Products</th>
                                        <th>Date Registered</th>
                                        <th>Location</th>
                                        <th>Contact (H/P &amp; Email)</th>
                                        <th class="text-center">Status</th>
                                        <th style="width: 1%;"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($activated_sellers as $seller)
                                    <tr id="seller_{{ $seller->id }}">
                                        <td>{{ $seller->name }}</td>
                                        <td>
                                            <a href="#" data-id="{{ $seller->id }}" data-toggle="modal" data-target="#exampleModal">
                                                {{ $seller->id }}
                                            </a>
                                        </td>
                                        <td nowrap>
                                            @if (!$seller->supplies()->exists())
                                            <div>No products been supplied.</div>
                                            @endif
                                            <ul class="list-unstyled">
                                                @foreach ($seller->supplies()->orderBy('active_counter', 'desc')->get() as $supply)
                                                <li>{{ $supply->name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $seller->created_at }}</td>
                                        <td>
                                            {{ $seller->address }}
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $seller->latitude }},{{ $seller->longitude }}" target="_blank">
                                                <i class="fa fa-map-marker"></i>
                                            </a>
                                        </td>
                                        <td>
                                            Mobile:
                                            <br />
                                            <a href="tel:{{ $seller->mobile_number }}">{{ $seller->mobile_number }}</a>
                                            <br />E-Mail:
                                            <br />
                                            <a href="mailto:{{ $seller->email }}">{{ $seller->email }}</a>
                                        </td>
                                        <td class="text-center">
                                            E-Mail: @if ($seller->status_email === 1)
                                            <span class="label label-success">Verified</span> @else
                                            <span class="label label-danger">Unverified</span> @endif
                                            <br /> Account: @if ($seller->status_account === 1)
                                            <span class="label label-success">Activated</span> @else
                                            <span class="label label-danger">Deactivated</span> @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group-vertical btn-group-sm">
                                                <a href="{{ route('users.sellers.show', [$seller->id]) }}" class="btn btn-primary">View</a>                                                @if ($seller->status_account === 0)
                                                <button class="btn btn-success" data-id="{{ $seller->id }}" onclick="activateUser(this)">Activate</button>
                                                <button class="btn btn-warning" disabled>Deactivate</button> @elseif ($seller->status_account
                                                === 1)
                                                <button class="btn btn-success" disabled>Activate</button>
                                                <button class="btn btn-warning" data-id="{{ $seller->id }}" onclick="deactivateUser(this)">Deactivate</button>                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="deactivated-seller-table" style="width:100%">
                                <thead>
                                    <tr class="bg-black">
                                        <th>Supplier Name</th>
                                        <th>Supplier#</th>
                                        <th>Supplied Products</th>
                                        <th>Date Registered</th>
                                        <th>Location</th>
                                        <th>Contact (H/P &amp; Email)</th>
                                        <th class="text-center">Status</th>
                                        <th style="width: 1%;"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($deactivated_sellers as $seller)
                                    <tr id="seller_{{ $seller->id }}">
                                        <td>{{ $seller->name }}</td>
                                        <td>
                                            <a href="#" data-id="{{ $seller->id }}" data-toggle="modal" data-target="#exampleModal">
                                                {{ $seller->id }}
                                            </a>
                                        </td>
                                        <td nowrap>
                                            @if (!$seller->supplies()->exists())
                                            <div>No products been supplied.</div>
                                            @endif
                                            <ul class="list-unstyled">
                                                @foreach ($seller->supplies()->orderBy('active_counter', 'desc')->get() as $supply)
                                                <li>{{ $supply->name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $seller->created_at }}</td>
                                        <td>
                                            {{ $seller->address }}
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $seller->latitude }},{{ $seller->longitude }}" target="_blank">
                                                <i class="fa fa-map-marker"></i>
                                            </a>
                                        </td>
                                        <td>
                                            Mobile:
                                            <br />
                                            <a href="tel:{{ $seller->mobile_number }}">{{ $seller->mobile_number }}</a>
                                            <br />E-Mail:
                                            <br />
                                            <a href="mailto:{{ $seller->email }}">{{ $seller->email }}</a>
                                        </td>
                                        <td class="text-center">
                                            E-Mail: @if ($seller->status_email === 1)
                                            <span class="label label-success">Verified</span> @else
                                            <span class="label label-danger">Unverified</span> @endif
                                            <br /> Account: @if ($seller->status_account === 1)
                                            <span class="label label-success">Activated</span> @else
                                            <span class="label label-danger">Deactivated</span> @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group-vertical btn-group-sm">
                                                <a href="{{ route('users.sellers.show', [$seller->id]) }}" class="btn btn-primary">View</a>                                                @if ($seller->status_account === 0)
                                                <button class="btn btn-success" data-id="{{ $seller->id }}" onclick="activateUser(this)">Activate</button>
                                                <button class="btn btn-warning" disabled>Deactivate</button> @elseif ($seller->status_account
                                                === 1)
                                                <button class="btn btn-success" disabled>Activate</button>
                                                <button class="btn btn-warning" data-id="{{ $seller->id }}" onclick="deactivateUser(this)">Deactivate</button>                                                @endif
                                            </div>
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
            modal.find('#exampleModalLabel').text('Supplier Details | ' + id);
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
                    $('#ud-company-address').text(data.address);
                    $('#ud-company-address-latitude').text(data.latitude);
                    $('#ud-company-address-longitude').text(data.longitude);
                    $('#ud-company-address-navigation').attr("href", "https://www.google.com/maps/search/?api=1&query=" + data.latitude + "," + data.longitude);
                    $('#ud-mobile-number').text(data.mobile_number);
                    $('#ud-email').text(data.email);
                    $('#ud-account-number').text(data.bank_account_number);
                    $('#ud-bank-name').text(data.bank_account_number);
                    $('#ud-bank-name').text(data.bank_account_holder_name);

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

        $('#activated-seller-table').DataTable({
            'order': [],
            'ordering': true,
            'paging': false,
            'info': false,
        });

        $('#deactivated-seller-table').DataTable({
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