@extends('layout.master') 
@section('style')
@endsection
 
@section('content')

<section class="content-header">
  <h1>
    Order Receipt
    <small>Edit Stock</small>
  </h1>

  <ol class="breadcrumb">
    <li>
      <a href="{{ route('index') }}">
        <i class="fa fa-dashboard"></i> Dashboard
      </a>
    </li>
    <li>
      <a href="{{ route('orders.index.receipts') }}">Order Receipt</a>
    </li>
    <li class="active">Edit</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-body">
          <dl class="dl-horizontal">
            <dt>Date</dt>
            <dd>{{ $stock->created_at }}</dd>
            <dt>Stock#</dt>
            <dd>{{ $stock->id }}</dd>
            <dt>Supplier</dt>
            <dd>{{ $stock->user->id }} | {{ $stock->user->name }}</dd>
            <dt>Status</dt>
            <dd>
              <div class="label label-default">Submitted</div>
            </dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <div class="box-title">Items</div>
        </div>
        <div class="box-body">
          <form method="post" action="{{ action('OrderController@updateSeller', $stock->id) }}">
            @csrf
            <input name="_method" type="hidden" value="PUT">
            <table class="table table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Quantity</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($stock->products as $product)
                <tr>
                  <td>
                    {{ $product->name }}
                    (Grade {{ $product->pivot->grade }})
                  </td>
                  <td>
                    <div class="input-group">
                      <input type="hidden" name="id[]" value="{{ $product->id }}">
                      <input type="hidden" name="grade[]" value="{{ $product->pivot->grade }}">
                      <input type="number" name="quantity[]" class="form-control" value="{{ $product->pivot->quantity }}" />
                      <div class="input-group-addon">kg</div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Update Stock</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
 
@section('script')
@endsection