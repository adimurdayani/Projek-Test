@extends('layouts.admin.app')

@section('content')
  
  <div class="card">
    <div class="card-body">

      <a href="{{ route('app.users.edit', $user->id) }}" class="btn btn-info btn-sm mb-3">Edit</a>

      <div class="row">
        <div class="col-md-6">
          <table class="table">
            <tr>
              <th>Nama</th>
              <td>: {{ $user->name }}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>: {{ $user->email }}</td>
            </tr>
          </table>
        </div>
        <div class="col-md-6">
          <table class="table">
            <tr>
              <th>Username</th>
              <td>: {{ $user->username }}</td>
            </tr>
            <tr>
              <th>Jabatan</th>
              <td>: {{ $user->role->role_name }}</td>
            </tr>
          </table>
        </div>
      </div>

    </div>
  </div>

@endsection