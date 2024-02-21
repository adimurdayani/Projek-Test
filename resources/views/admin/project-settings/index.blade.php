@extends('layouts.admin.app')

@section('content')

<div class="card">
  <div class="card-body">

    <form action="{{ route('app.settings.update') }}" method="POST" with-submit-crud>
      @csrf
      @method("PUT")

      <div class="row my-3">
        <div class="col-md-4">
          <label>Multi Login</label>
        </div>
        <div class="col-md-6">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="multi_login_device" {{ $setting->multi_login_device == 1 ? "checked" : "" }}>
            <label class="form-check-label">Izinkan</label>
          </div>
        </div>
      </div>

      <div class="row my-3">
        <div class="col-md-4">
          <label>Maintenance</label>
        </div>
        <div class="col-md-6">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_maintenance" {{ $setting->is_maintenance == 1 ? "checked" : "" }}>
            <label class="form-check-label">Ya</label>
          </div>
        </div>
      </div>

      <button class="btn btn-success btn-sm mt-2">Update Setting</button>

    </form>

  </div>
</div>

@endsection
