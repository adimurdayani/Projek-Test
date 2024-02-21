@extends('layouts.admin.app')

@section('content')
    <div class="card">
        <div class="card-body">

            <a href="{{ route('app.product.edit', $product->id) }}" class="btn btn-info btn-sm mb-3">Edit</a>

            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Nama Produk</th>
                            <td>: {{ $product->product_name }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi Produk</th>
                            <td>: {{ $product->product_description }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Stok</th>
                            <td>: {{ $product->product_price_capital }}</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>: {{ number_format($product->product_price_sell, 0) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
