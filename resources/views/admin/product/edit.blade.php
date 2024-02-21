@extends('layouts.admin.app')

@section('content')
    <div class="card">
        <div class="card-body">

            <form action="{{ route('app.product.update', $product->id) }}" method="POST" with-submit-crud>
                @csrf
                @method('PUT')

                @include('admin.product.form')

                <button class="btn btn-warning btn-sm mt-3">Update Produk</button>

            </form>

        </div>
    </div>
@endsection
