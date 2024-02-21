@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Pembayaran:</h5>
                                    <h5 class="font-size-15 mb-2">{{ Auth::user()->name }}</h5>
                                    <p class="mb-1">4068 Post Avenue Newfolden, MN 56738</p>
                                    <p class="mb-1">{{ Auth::user()->email }}</p>
                                    <p>001-234-5678</p>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-sm-6">
                                <div class="text-muted text-sm-end">
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                        <p>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Order No:</h5>
                                        <p>#{{ $order->no_order }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="py-2">
                            <h5 class="font-size-15">Order Produk</h5>

                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">No.</th>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th class="text-end" style="width: 120px;">Total</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                    <tbody>
                                        @foreach ($order->orderDetails as $detail)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>
                                                    <div>
                                                        <h5 class="text-truncate font-size-14 mb-1">
                                                            {{ $detail->product->product_name }}</h5>
                                                        <p class="text-muted mb-0">
                                                            {{ $detail->product->product_description }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td>Rp. {{ number_format($detail->product->product_price_sell, 0) }}</td>
                                                <td>{{ $detail->qty }}</td>
                                                <td class="text-end">Rp. {{ number_format($detail->total, 0) }}</td>
                                            </tr>
                                        @endforeach
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="4" class="text-end">Sub Total</th>
                                            <td class="text-end">
                                                Rp.{{ number_format($order->orderDetails->sum('total'), 0) }}
                                            </td>
                                        </tr>
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                Pembayaran :</th>
                                            <td class="border-0 text-end">Rp.{{ number_format($order->pembayaran, 0) }}
                                            </td>
                                        </tr>
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                Kembalian :</th>
                                            <td class="border-0 text-end">Rp.{{ number_format($order->kembalian, 0) }}</td>
                                        </tr>
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">Total</th>
                                            <td class="border-0 text-end">
                                                <h4 class="m-0 fw-semibold">Rp.{{ number_format($order->grand_total, 0) }}
                                                </h4>
                                            </td>
                                        </tr>
                                        <!-- end tr -->
                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div><!-- end table responsive -->
                            <div class="d-print-none mt-4">
                                <div class="float-end">
                                    <a href="javascript:window.print()" class="btn btn-success me-1"><i
                                            class="bi bi-printer"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
