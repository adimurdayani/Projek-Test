@extends('layouts.admin.app')

@section('content')
    <div class="card">
        <div class="card-body table-responsive">

            @livewire('apps.admin.transaction')

        </div>
    </div>
@endsection

@if (check_authorized('002D'))
    @push('script')
        <script>
            CORE.dataTableCostum("tbTransaction", "/app/transaction/get");
        </script>
    @endpush
@endif
