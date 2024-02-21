<div>
  <x-forms.input-grid col1="2" col2="6" label="Nama" name="name" value="{{ $user->name ?? '' }}" placeholder="Masukan nama user..."></x-forms.input-grid>

  <div class="row align-items-center my-2">
    <div class="col-md-2">
      <label>Jabatan</label>
    </div>
    <div class="col-md-6">
      <select name="role_id" class="form-control">
        @foreach ($roles as $role)
          <option {{ isset($user->role_id) && $user->role_id == $role->id ?"selected" : "" }} value="{{ $role->id }}">{{ $role->role_name }}</option>
        @endforeach
      </select>
      <div></div>
    </div>
  </div>

  <x-forms.input-grid col1="2" col2="6" label="Email" name="email" type="email" value="{{ $user->email ?? '' }}" placeholder="Masukan email user..."></x-forms.input-grid>
  <x-forms.input-grid col1="2" col2="6" label="Username" name="username" value="{{ $user->username ?? '' }}" placeholder="Masukan username user..."></x-forms.input-grid>
  {{-- <x-forms.input-grid col1="2" col2="6" label="Password" name="password" type="password" placeholder="Masukan password user..."></x-forms.input-grid> --}}

  <div class="row">
    <div class="col-md-2">
      <label>Password</label>
    </div>
    <div class="col-md-6">
      <div class="input-group">
        @if ($show_password)
          <input type="text" name="password" class="form-control" wire:model="text_password">
        @else
          <input type="password" name="password" class="form-control" wire:model="text_password">
        @endif
        <span class="input-group-text">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" wire:click="show_password_toggle">
            <label class="form-check-label">Tampilkan Password</label>
          </div>
        </span>
      </div>
    </div>
  </div>

</div>
