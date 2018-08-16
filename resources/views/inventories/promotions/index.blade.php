@extends('layout.master') 
@section('style')
@endsection
 
@section('content')
<section class="content-header">
    <h1>
        Promo Price Management
    </h1>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('index') }}">
                <i class="fa fa-dashboard"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="#">Promo Price Management</a>
        </li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="promo-table" style="width:100%">
                            <thead>
                                <tr class="bg-black">
                                    <th>Date</th>
                                    <th>Order#</th>
                                    <th>Item</th>
                                    <th class="text-center">SKU#</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total Sold</th>
                                    <th class="text-center">Promo Wastage</th>
                                    <th class="text-center">Buy At Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($promotions as $promo)
                                <tr>
                                    <td>{{ Carbon\Carbon::parse($promo->created_at)->format('d/m/Y') }}</td>
                                    <td></td>
                                    <td>{{ $promo->product["name"] }}</td>
                                    <td class="text-center">#{{ sprintf("%04s", $promo->product["id"]) }}</td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon">RM</span>
                                            <input type="number" id='promo_price_{{ $promo->product["id"] }}' class="promo_price form-control" value='{{ $promo->price }}' style="min-width: 70px;" />
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $promo->quantity }} kg</td>
                                    <td class="text-center">{{ $promo->total_sold }} kg</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" id='promo_wastage_{{ $promo->product["id"] }}' class="promo_wastage form-control" value="{{ $promo->wastage }}"
                                                data-promoid="{{ $promo->id }}" style="min-width: 70px;" />
                                            <div class="input-group-addon">kg</div>
                                        </div>
                                    </td>
                                    <td class="text-center">RM {{ $promo->buy_at_price }}</td> 
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

        $(".promo_price").focusout(function () {

            var data = {
                product_id: $(this).attr('id').split("_")[2],
                price: $(this).val(),
            }

            swal({
                title: "",
                text: "Saving....",
                showConfirmButton: false
            });

            $.ajax("{{ route('products.update.promo_price') }}", {
                data: data,
                dataType: "json",
                error: (jqXHR, textStatus, errorThrown) => {
                    console.log("x ok")
                    swal.close();
                },
                method: "POST",
                success: (data, textStatus, jqXHR) => {
                    console.log("ok")
                    swal.close();
                }
            });
        });

        $(".promo_wastage").focusout(function () {

            var data = {
                promo_id: $(this).data('promoid'),
                product_id: $(this).attr('id').split("_")[2],
                promo_wastage: $(this).val(),
            }

            swal({
                title: "",
                text: "Saving....",
                showConfirmButton: false
            });

            $.ajax("{{ route('products.update.promowastage') }}", {
                data: data,
                dataType: "json",
                error: (jqXHR, textStatus, errorThrown) => {
                    console.log("x ok")
                    swal.close();

                    swal("Review Needed", jqXHR.responseJSON.message, "error");
                },
                method: "POST",
                success: (data, textStatus, jqXHR) => {
                    console.log("ok")
                    swal.close();
                }
            });
        });

        $('#promo-table').DataTable({
            'order': [],
            'ordering': true,
            'paging': false,
            'info': false,
        });
    });

</script>
@endsection