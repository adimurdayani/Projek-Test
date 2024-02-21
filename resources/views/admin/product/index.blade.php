@extends('layouts.admin.app')

@section('content')
    <div class="card">
        <div class="card-body table-responsive">

            <a href="{{ route('app.product.create') }}" class="btn btn-success btn-sm mb-3">Tambah</a>

            <table class="table table-bordered" id="tbProduct">
                <thead>
                    <tr>
                        <th style="width: 0px;">No</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>
    </div>
@endsection

@if (check_authorized('002D'))
    @push('script')
        <script>
            CORE.dataTableServer("tbProduct", "/app/product/get");
        </script>
    @endpush
@endif
