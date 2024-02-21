@extends('layouts.admin.app')

@section('content')
    <div class="card">
        <div class="card-body table-responsive">

            @livewire('apps.admin.transaction.create')

        </div>
    </div>
@endsection
