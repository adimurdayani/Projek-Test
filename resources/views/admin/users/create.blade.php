@extends('layouts.admin.app')

@section('content')

  <div class="card">
    <div class="card-body">

      <form action="{{ route('app.users.store') }}" method="POST" with-submit-crud>
        @csrf

        @include('admin.users.form')

        <button class="btn btn-success btn-sm mt-3">Tambah User</button>

      </form>

    </div>
  </div>

@endsection
