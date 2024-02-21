@extends('layouts.admin.app')

@section('content')

<div class="card">
  <div class="card-body">
    <button class="btn btn-info btn-sm mb-3" onclick="CORE.showModal('modalEditRole')">Edit</button>
    <table class="table">
      <tr>
        <th>Role</th>
        <td>: {{ $role->role_name }}</td>
      </tr>
    </table>
  </div>
</div>

<ul class="nav nav-pills">
  <li class="nav-item">
    <a class="nav-link active" data-bs-toggle="pill" href="#home">User</a>
  </li>
  @if (check_authorized("004RT"))
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="pill" href="#menu1">Module</a>
    </li>
  @endif
</ul>

<div class="card">
  <div class="card-body">
    <div class="tab-content">
      <div class="tab-pane container active" id="home">
        <button class="btn btn-success btn-sm mb-3" onclick="CORE.showModal('modalAssignUser')">Assign user ke role ini</button>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
              <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="2" class="text-center">Tidak ada user</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if (check_authorized("004RT"))
        <div class="tab-pane container fade" id="menu1">

          @livewire('apps.admin.role.module-assign', ['role' => $role])

        </div>
      @endif
    </div>
  </div>
</div>

<div class="modal fade" id="modalEditRole">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Role</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

        <form action="{{ route('app.roles.update', $role->id) }}" method="POST" with-submit-crud>
          @csrf
          @method("PUT")

          <div class="form-group">
            <label>Role</label>
            <input type="text" class="form-control" name="role_name" value="{{ $role->role_name }}">
          </div>

          <button class="btn btn-success btn-sm mt-2">Update</button>
        </form>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="modalAssignUser">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Assign User</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

        <form action="{{ route('app.roles.assign_user', $role->id) }}" method="POST" with-submit-crud>
          @csrf

          <table class="table table-bordered">
            <thead>
              <tr>
                <th>User</th>
                <th>Role</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($user_other as $user)
                <tr>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->role->role_name }}</td>
                  <td>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="user_id[]" value="{{ $user->id }}">
                      <label class="form-check-label">Pilih</label>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="text-center">Tidak Ada User</td>
                </tr>
              @endforelse
            </tbody>
          </table>

          <button class="btn btn-success btn-sm mt-2">Update Role</button>
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
