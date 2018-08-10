@extends('layout.master') 
@section('style')
@endsection
 
@section('content')
<section class="content-header">
    <h1>
        Wastage Management
    </h1>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('index') }}">
                <i class="fa fa-dashboard"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="#">Wastage Management</a>
        </li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="wastages-table" style="width:100%">
                            <thead>
                                <tr class="bg-black">
                                    <th class="text-center">Date</th>
                                    <th>Order#</th>
                                    <th>Item</th>
                                    <th class="text-center">SKU#</th>
                                    <th class="text-center">
                                        Storage Wastage
                                        <br />(from Inventory Mgmt)
                                    </th>
                                    <th class="text-center">
                                        Promo Wastage
                                        <br />(from Promo Price Mgmt)
                                    </th>
                                    <th class="text-center">Total Wastage</th>
                                    <th class="text-center">Buy At Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wastages as $wastage)
                                <tr>
                                    <td class="text-center">{{ Carbon\Carbon::parse($wastage->created_at)->format('d/m/Y') }}</td>
                                    <td></td>
                                    <td>{{ $wastage->product->name }}</td>
                                    <td class="text-center">#{{ sprintf("%04s", $wastage->product->id) }}</td>
                                    <td class="text-center">{{ $wastage->storage_wastage }} kg</td>
                                    <td class="text-center">{{ $wastage->promo_wastage }} kg</td>
                                    <td class="text-center">{{ $wastage->promo_wastage + $wastage->storage_wastage }} kg</td>
                                    <td class="text-center">RM {{ $wastage->buy_at_price }}</td>
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
        $('#wastages-table').DataTable({
            'order': [],
            'ordering': true,
            'paging': false,
            'info': false,
        });
    });

</script>
@endsection