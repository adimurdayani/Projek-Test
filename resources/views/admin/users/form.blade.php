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
<x-grid-input col1="2" col2="6">
  <x-slot:label>
    <label>Password</label>
  </x-slot>
  <x-slot:input>
    <div class="input-group">
      <input type="password" name="password" class="form-control">
      <span class="input-group-text">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="checkboxShowPassword" onclick="User.showPassword()">
          <label class="form-check-label">Tampilkan Password</label>
        </div>
      </span>
    </div>
  </x-slot>
</x-grid-input>

@push('script')
<script src="{{ asset('assets/js/apps/user.js?v=' . random_string(6)) }}"></script>
@endpush
