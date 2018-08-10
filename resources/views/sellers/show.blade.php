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
    Supplier Farm
    <small>Dashboard</small>
  </h1>

  <ol class="breadcrumb">
    <li>
      <a href="{{ route('index') }}">
        <i class="fa fa-dashboard"></i> Dashboard
      </a>
    </li>
    <li>
      <a href="#">User Management</a>
    </li>
    <li>
      <a href="{{ route('users.sellers.index') }}">Suppliers</a>
    </li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-body">
          <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>
              <a href="#" data-id="{{ $seller->id }}" data-toggle="modal" data-target="#exampleModal">
                {{ $seller->name }}
              </a>
            </dd>
            <dt>ID</dt>
            <dd>{{ $seller->id }}</dd>
            <dt>Location</dt>
            <dd>
              {{ $seller->address }}
              <a href="https://www.google.com/maps/search/?api=1&query={{ $seller->latitude }},{{ $seller->longitude }}" target="_blank">
                <i class="fa fa-map-marker"></i>
              </a>
            </dd>
            <dt>Mobile Number</dt>
            <dd>{{ $seller->mobile_number }}</dd>
            <dt>E-Mail Address</dt>
            <dd>{{ $seller->email }}</dd>
          </dl>
        </div>
      </div>
      <!-- /.box -->
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-body">
          <table class="table" id="seller-table" style="width:100%">
            <thead>
              <tr class="bg-black">
                <th rowspan="2">Item</th>
                <th rowspan="2" class="text-center">SKU#</th>
                <th colspan="2" class="text-center">Harvesting period</th>
                <th rowspan="2" class="text-center">Harvest Frequency</th>
                <th rowspan="2" class="text-center">Total plants</th>
                <th rowspan="2" class="text-center">Total Farm Area</th>
              </tr>
              <tr class="bg-black">
                <th class="text-center">Start</th>
                <th class="text-center">End</th>
              </tr>
            </thead>
            <tbody>
              @foreach($seller->supplies as $supply)
              <tr>
                <td>{{ $supply->name }}</td>
                <td class="text-center">#{{ sprintf("%04s", $supply->id) }}</td>
                <td class="text-center">{{ $supply->pivot->harvesting_period_start }}</td>
                <td class="text-center">{{ $supply->pivot->harvesting_period_end }}</td>
                <td class="text-center">{{ $supply->pivot->harvest_frequency }}</td>
                <td class="text-center">{{ $supply->pivot->total_plants }}</td>
                <td class="text-center">{{ $supply->pivot->total_farm_area }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
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
        error: (jqXHR, textStatus, errorThrown) => {},
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
          $('#ud-company-address-navigation').attr("href",
            "https://www.google.com/maps/search/?api=1&query=" + data.latitude + "," + data.longitude);
          $('#ud-mobile-number').text(data.mobile_number);
          $('#ud-email').text(data.email);
          $('#ud-account-number').text(data.bank_account_number);
          $('#ud-bank-name').text(data.bank_account_number);
          $('#ud-bank-name').text(data.bank_account_holder_name);

          if (data.status_email === 0) {
            $('#ud-email-status-verified').hide();
            $('#ud-email-status-unverified').show();
          } else if (data.status_email === 1) {
            $('#ud-email-status-verified').show();
            $('#ud-email-status-unverified').hide();
          }

          if (data.status_account === 0) {
            $('#ud-account-status-verified').hide();
            $('#ud-account-status-unverified').show();
          } else if (data.status_account === 1) {
            $('#ud-account-status-verified').show();
            $('#ud-account-status-unverified').hide();
          }
        }
      });
    });

  });

</script>
@endsection