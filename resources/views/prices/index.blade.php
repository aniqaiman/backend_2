@extends('layout.master') 
@section('style')
@endsection
 
@section('content')
<section class="content-header">
    <h1>
        Price Dashboard
        <small>{{ Carbon\Carbon::now()->toFormattedDateString() }}</small>
    </h1>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('index') }}">
                <i class="fa fa-dashboard"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="#">Price Dashboard</a>
        </li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table" id="dashboard-table" style="width:100%">
                            <thead>
                                <tr class="bg-black">
                                    <th rowspan="2">Item</th>
                                    <th rowspan="2">SKU#</th>
                                    <th colspan="4" class="text-center">Today</th>
                                    <th colspan="4" class="text-center">Yesterday</th>
                                    <th colspan="4" class="text-center">% Price Difference</th>
                                </tr>
                                <tr class="bg-black">
                                    <th class="text-center">Supplier Price (Grade A)</th>
                                    <th class="text-center">Buyer Price (Grade A)</th>
                                    <th class="text-center">Supplier Price (Grade B)</th>
                                    <th class="text-center">Buyer Price (Grade B)</th>
                                    <th class="text-center">Supplier Price (Grade A)</th>
                                    <th class="text-center">Buyer Price (Grade A)</th>
                                    <th class="text-center">Supplier Price (Grade B)</th>
                                    <th class="text-center">Buyer Price (Grade B)</th>
                                    <th class="text-center">Supplier Price (Grade A)</th>
                                    <th class="text-center">Buyer Price (Grade A)</th>
                                    <th class="text-center">Supplier Price (Grade B)</th>
                                    <th class="text-center">Buyer Price (Grade B)</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product["name"] }}</td>
                                    <td>#{{ sprintf("%04s", $product["id"]) }}</td>
                                    <td colspan="1">
                                        <div class="input-group">
                                            <span class="input-group-addon">RM</span>
                                            <input type="number" class="selling_a form-control" id='selling_a_{{ $product["id"] }}' value='{{ number_format($product["seller_price_a"], 2, ".", "") }}'
                                                min="0.01" style="min-width: 70px">
                                        </div>
                                    </td>
                                    <td colspan="1">
                                        <div class="input-group">
                                            <span class="input-group-addon">RM</span>
                                            <input type="number" class="buying_a form-control" id='buying_a_{{ $product["id"] }}' value='{{ number_format($product["buyer_price_a"], 2, ".", "") }}'
                                                min="0.01" style="min-width: 70px">
                                        </div>
                                    </td>
                                    <td colspan="1">
                                        <div class="input-group">
                                            <span class="input-group-addon">RM</span>
                                            <input type="number" class="selling_b form-control" id='selling_b_{{ $product["id"] }}' value='{{ number_format($product["seller_price_b"], 2, ".", "") }}'
                                                min="0.01" style="min-width: 70px">
                                        </div>
                                    </td>
                                    <td colspan="1">
                                        <div class="input-group">
                                            <span class="input-group-addon">RM</span>
                                            <input type="number" class="buying_b form-control" id='buying_b_{{ $product["id"] }}' value='{{ number_format($product["buyer_price_b"], 2, ".", "") }}'
                                                min="0.01" style="min-width: 70px">
                                        </div>
                                    </td>
                                    <td class="text-center">RM {{ number_format($product["seller_yest_price_a"], 2, '.', '') }}</td>
                                    <td class="text-center">RM {{ number_format($product["buyer_yest_price_a"], 2, '.', '') }}</td>
                                    <td class="text-center">RM {{ number_format($product["seller_yest_price_b"], 2, '.', '') }}</td>
                                    <td class="text-center">RM {{ number_format($product["buyer_yest_price_b"], 2, '.', '') }}</td>
                                    <td class="text-center" id='{{ $product["id"] }}_seller_price_a'>{{ number_format($product["difference"]->seller_price_a * 100, 2, '.', '') }}%</td>
                                    <td class="text-center" id='{{ $product["id"] }}_buyer_price_a'>{{ number_format($product["difference"]->buyer_price_a * 100, 2, '.', '') }}%</td>
                                    <td class="text-center" id='{{ $product["id"] }}_seller_price_b'>{{ number_format($product["difference"]->seller_price_b * 100, 2, '.', '') }}%</td>
                                    <td class="text-center" id='{{ $product["id"] }}_buyer_price_b'>{{ number_format($product["difference"]->buyer_price_b * 100, 2, '.', '') }}%</td>
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
        console.log("loaded");

        $(".selling_a").focusout(function () {
            $(this).prop('disabled', true);

            var newPrice = $(this).val();
            console.log($(this).attr('id'))
            console.log(newPrice);
            var arrItem = $(this).attr('id').split("_")[2]
            var currentDate = new Date();
            var formattedDate = currentDate.getFullYear() + "-" + (currentDate.getMonth() + 1) + "-" +
                currentDate.getDate();

            var data = {
                product_id: arrItem,
                seller_price_a: newPrice,
                date: formattedDate
            }

            $.ajax("{{ route('updateFruitPrice') }}", {
                data: data,
                dataType: "json",
                error: (jqXHR, textStatus, errorThrown) => {
                    $(this).parent().addClass('has-error');
                    $(this).parent().removeClass('has-success');
                    $(this).prop('disabled', false);
                },
                method: "POST",
                success: (data, textStatus, jqXHR) => {
                    console.log("ok")
                    updatePriceDifference(arrItem);
                    $(this).parent().addClass('has-success');
                    $(this).parent().removeClass('has-error');
                    $(this).prop('disabled', false);
                    //  window.location.href = window.location.href;
                }
            });

        });

        $(".selling_b").focusout(function () {
            $(this).prop('disabled', true);

            var newPrice = $(this).val();
            console.log($(this).attr('id'))
            console.log(newPrice);
            var arrItem = $(this).attr('id').split("_")[2]
            var currentDate = new Date();
            var formattedDate = currentDate.getFullYear() + "-" + (currentDate.getMonth() + 1) + "-" +
                currentDate.getDate();

            var data = {
                product_id: arrItem,
                seller_price_b: newPrice,
                date: formattedDate
            }

            $.ajax("{{ route('updateFruitPrice') }}", {
                data: data,
                dataType: "json",
                error: (jqXHR, textStatus, errorThrown) => {
                    $(this).parent().addClass('has-error');
                    $(this).parent().removeClass('has-success');
                    $(this).prop('disabled', false);
                },
                method: "POST",
                success: (data, textStatus, jqXHR) => {
                    console.log("ok")
                    updatePriceDifference(arrItem);
                    $(this).parent().addClass('has-success');
                    $(this).parent().removeClass('has-error');
                    $(this).prop('disabled', false);
                    //  window.location.href = window.location.href;
                }
            });
        });

        $(".buying_a").focusout(function () {
            $(this).prop('disabled', true);

            var newPrice = $(this).val();
            console.log($(this).attr('id'))
            console.log(newPrice);
            var arrItem = $(this).attr('id').split("_")[2]
            var currentDate = new Date();
            var formattedDate = currentDate.getFullYear() + "-" + (currentDate.getMonth() + 1) + "-" +
                currentDate.getDate();

            var data = {
                product_id: arrItem,
                buyer_price_a: newPrice,
                date: formattedDate
            }

            $.ajax("{{ route('updateFruitPrice') }}", {
                data: data,
                dataType: "json",
                error: (jqXHR, textStatus, errorThrown) => {
                    $(this).parent().addClass('has-error');
                    $(this).parent().removeClass('has-success');
                    $(this).prop('disabled', false);
                },
                method: "POST",
                success: (data, textStatus, jqXHR) => {
                    updatePriceDifference(arrItem);
                    $(this).parent().addClass('has-success');
                    $(this).parent().removeClass('has-error');
                    $(this).prop('disabled', false);
                    //  window.location.href = window.location.href;
                }
            });
        });

        $(".buying_b").focusout(function () {
            $(this).prop('disabled', true);

            var newPrice = $(this).val();
            console.log($(this).attr('id'))
            console.log(newPrice);
            var arrItem = $(this).attr('id').split("_")[2]

            var currentDate = new Date();
            var formattedDate = currentDate.getFullYear() + "-" + (currentDate.getMonth() + 1) + "-" +
                currentDate.getDate();

            var data = {
                product_id: arrItem,
                buyer_price_b: newPrice,
                date: formattedDate
            }

            $.ajax("{{ route('updateFruitPrice') }}", {
                data: data,
                dataType: "json",
                error: (jqXHR, textStatus, errorThrown) => {
                    $(this).parent().addClass('has-error');
                    $(this).parent().removeClass('has-success');
                    $(this).prop('disabled', false);
                },
                method: "POST",
                success: (data, textStatus, jqXHR) => {
                    console.log("ok")
                    updatePriceDifference(arrItem);
                    $(this).parent().addClass('has-success');
                    $(this).parent().removeClass('has-error');
                    $(this).prop('disabled', false);
                    //  window.location.href = window.location.href;
                }
            });
        });

        $('#dashboard-table').DataTable({
            'order': [],
            'ordering': true,
            'paging': false,
            'info': false,
        });

    });

    function updatePriceDifference(id) {
        $.ajax("{{ route('prices.difference') }}?id=" + id, {
            dataType: "json",
            error: (jqXHR, textStatus, errorThrown) => { },
            method: "GET",
            success: (data, textStatus, jqXHR) => {
                $("#" + id + "_seller_price_a").html(parseFloat(Math.round(jqXHR.responseJSON.seller_price_a * 100)).toFixed(2) + '%');
                $("#" + id + "_buyer_price_a").html(parseFloat(Math.round(jqXHR.responseJSON.buyer_price_a * 100)).toFixed(2) + '%');
                $("#" + id + "_seller_price_b").html(parseFloat(Math.round(jqXHR.responseJSON.seller_price_b * 100)).toFixed(2) + '%');
                $("#" + id + "_buyer_price_b").html(parseFloat(Math.round(jqXHR.responseJSON.buyer_price_b * 100)).toFixed(2) + '%');
            }
        });
    }

</script>
@endsection