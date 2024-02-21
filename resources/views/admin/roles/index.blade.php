@extends('layouts.admin.app')

@section('content')

<div class="card">
  <div class="card-body">
    <button class="btn btn-success btn-sm mb-3" onclick="CORE.showModal('modalAddNew')">Tambah</button>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($roles as $role)
          <tr>
            <td>{{ $role->role_name }}</td>
            <td>
              <a href="{{ route('app.roles.show', $role->id) }}" class="btn btn-info btn-sm">Detail</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </div>
</div>

<div class="modal fade" id="modalAddNew">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Role</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

        <form action="{{ route('app.roles.store') }}" method="POST" with-submit-crud>
          @csrf

          <x-forms.input label="Role" name="role_name"></x-forms>

          <button class="btn btn-success btn-sm mt-1">Tambah Baru</button>
        </form>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

@endsection
