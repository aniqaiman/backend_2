@extends('layout.master') 
@section('style')
@endsection
 
@section('content') @foreach($stocks as $stock)
<div class="modal fade" id="stock_{{ $stock->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_{{ $stock->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel_{{ $stock->id }}">{{ $stock->created_at }} | {{ $stock->id }}</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <th>#</th>
                        <th>Item</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                    </thead>
                    <tbody>
                        @foreach ($stock->products as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $product->name }} (Grade {{ $product->pivot->grade }})</td>
                            <td class="text-center" nowrap>{{ $product->pivot->quantity }} kg</td>
                            <td class="text-center" nowrap>
                                @switch($product->pivot->grade) @case("A") RM {{ number_format($product->price_latest["seller_price_a"], 2) }} @break @case("B")
                                RM {{ number_format($product->price_latest["seller_price_b"], 2) }} @break @endswitch
                            </td>
                            <td class="text-center" nowrap>
                                @switch($product->pivot->grade) @case("A") RM {{ number_format($product->pivot->quantity * $product->price_latest["buyer_price_a"],
                                2) }} @break @case("B") RM {{ number_format($product->pivot->quantity * $product->price_latest["buyer_price_b"],
                                2) }} @break @endswitch
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <span class="pull-left">
                    @if ($stock->status === 0)
                    <span class="label label-default">Submitted</span> @elseif ($stock->status === 1)
                    <span class="label label-warning">Pending</span> @elseif ($stock->status === 2)
                    <span class="label label-danger">Rejected</span> @elseif ($stock->status === 3)
                    <span class="label label-danger">Unpaid</span> @elseif ($stock->status === 4)
                    <span class="label label-success">Paid</span> @endif
                </span>
                <h3 class="pull-right">
                    Total:
                    <span class="label label-default">RM {{ number_format($stock->totalPrice(), 2) }}</span>
                </h3>
            </div>
        </div>
    </div>
</div>
@endforeach

<section class="content-header">
    <h1>
        Supplier Transaction
    </h1>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('index') }}">
                <i class="fa fa-dashboard"></i>Dashboard</a>
        </li>
        <li class="active">Supplier Transaction</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1" data-toggle="tab">Pending</a>
                    </li>
                    <li>
                        <a href="#tab_2" data-toggle="tab">Completed</a>
                    </li>
                    <li class="pull-right" style="margin-top: 3px;">
                        <form method="get" class="form-inline text-center">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <a class="btn btn-default" href="{{ route('orders.sellers.index') }}">Show All</a>
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
                            <table class="table table-bordered" id="pending-stock-table">
                                <thead>
                                    <tr class="bg-black">
                                        <th>Date</th>
                                        <th>Order#</th>
                                        <th>Buyer#</th>
                                        <th>Buyer Name</th>
                                        <th>Total Price</th>
                                        <th>Lorry</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($pending_stocks as $stock)
                                    <tr>
                                        <td>{{ $stock->created_at }}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#stock_{{ $stock->id }}">{{ $stock->id }}</a>
                                        </td>
                                        <td>{{ $stock->user->id }}</td>
                                        <td>{{ $stock->user->name }}</td>
                                        <td>{{ $stock->totalPrice() }}</td>
                                        @if ($stock["driver"])
                                        <td>{{$stock->driver->name}}</td>
                                        @else
                                        <td>No driver assigned</td>
                                        @endif
                                        <td class="text-center">
                                            @if ($stock->status === 0)
                                            <span class="label label-default">Submitted</span> 
                                            @elseif ($stock->status === 1)
                                            <span class="label label-warning">Pending</span>
                                            @elseif ($stock->status === 2)
                                            <span class="label label-danger">Rejected</span>
                                            @elseif ($stock->status === 3)
                                            <span class="label label-danger">Unpaid</span>
                                            @elseif ($stock->status === 4)
                                            <span class="label label-success">Paid</span>
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
                            <table class="table table-bordered" id="completed-stock-table">
                                <thead>
                                    <tr class="bg-black">
                                        <th>Date</th>
                                        <th>Order#</th>
                                        <th>Buyer#</th>
                                        <th>Buyer Name</th>
                                        <th>Total Price</th>
                                        <th>Lorry</th>
                                        <th>Status</th>
                                        <th style="width: 1%;"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($completed_stocks as $stock)
                                    <tr>
                                        <td>{{ $stock->created_at }}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#stock_{{ $stock->id }}">{{ $stock->id }}</a>
                                        </td>
                                        <td>{{ $stock->user->id }}</td>
                                        <td>{{ $stock->user->name }}</td>
                                        <td>{{ $stock->totalPrice() }}</td>
                                        @if ($stock["driver"])
                                        <td>{{$stock->driver->name}}</td>
                                        @else
                                        <td>No driver assigned</td>
                                        @endif
                                        <td class="text-center">
                                            @if ($stock->status === 0)
                                            <span class="label label-default">Submitted</span> 
                                            @elseif ($stock->status === 1)
                                            <span class="label label-warning">Pending</span>
                                            @elseif ($stock->status === 2)
                                            <span class="label label-danger">Rejected</span>
                                            @elseif ($stock->status === 3)
                                            <span class="label label-danger">Unpaid</span>
                                            @elseif ($stock->status === 4)
                                            <span class="label label-success">Paid</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($stock->status === 3)
                                            <div class="btn-group-vertical btn-group-sm">
                                                <button class="btn btn-success" data-id="{{ $stock->id }}" data-type="stock" data-status="4" onclick="payment(this)">Paid</button>
                                                <button class="btn btn-danger" disabled>Unpaid</button>
                                            </div>
                                            @elseif ($stock->status === 4)
                                            <div class="btn-group-vertical btn-group-sm">
                                                <button class="btn btn-success" disabled>Paid</button>
                                                <button class="btn btn-danger" data-id="{{ $stock->id }}" data-type="stock" data-status="3"onclick="payment(this)">Unpaid</button>
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
                <!-- /.box -->
            </div>
        </div>
        <!-- /.box -->
    </div>
</section>
@endsection
 
@section('script')
<script>
    $(document).ready(function () {

        $('#pending-stock-table').DataTable({
            'order': [],
            'ordering': true,
            'info': false,
        });

        $('#completed-stock-table').DataTable({
            'order': [],
            'ordering': true,
            'info': false,
        });

    });

    function payment(btn) {
        var data = {
            id: $(btn).data('id'),
            type: $(btn).data('type'),
            status: $(btn).data('status')
        }

        $(btn).prop('disabled', true);
        $(btn).html('<i class="fa fa-spinner fa-spin"></i> Updating...');

        $.ajax("{{ route('orders.update.status.payment') }}", {
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