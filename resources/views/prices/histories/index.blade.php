@extends('layout.master') 
@section('style')
@endsection
 
@section('content')
<section class="content-header">
    <h1>
        Historic Price Data
    </h1>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('index') }}">
                <i class="fa fa-dashboard"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="#">Historic Price Data</a>
        </li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <form method="get" class="form-inline text-center">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <a class="btn btn-default" href="{{ route('prices.index.histories') }}">Show All</a>
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
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="historic-table" style="width:100%">
                            <thead>
                                <tr class="bg-black">
                                    <th class="text-center">Date</th>
                                    <th>Item</th>
                                    <th class="text-center">SKU#</th>
                                    <th class="text-center">
                                        Buyer Price
                                        <br />(Grade A)
                                    </th>
                                    <th class="text-center">
                                        Supplier Price
                                        <br />(Grade A)
                                    </th>
                                    <th class="text-center">
                                        Buyer Price
                                        <br />(Grade B)
                                    </th>
                                    <th class="text-center">
                                        Supplier Price
                                        <br />(Grade B)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prices as $price)
                                <tr>
                                    <td class="text-center">{{ Carbon\Carbon::parse($price->date_price)->format('d/m/Y') }}</td>
                                    <td>{{ $price->product->name }}</td>
                                    <td class="text-center">#{{ sprintf("%04s", $price->product->id) }}</td>
                                    <td class="text-center">{{ $price->buyer_price_a }}</td>
                                    <td class="text-center">{{ $price->seller_price_a }}</td>
                                    <td class="text-center">{{ $price->buyer_price_b }}</td>
                                    <td class="text-center">{{ $price->seller_price_b }}</td>
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
        $('#historic-table').DataTable({
            'order': [],
            'ordering': true,
            'paging': false,
            'info': false,
        });
    });

</script>
@endsection