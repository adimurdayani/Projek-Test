<div>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Module</th>
        <th>Keterangan</th>
        <th>Assign Date</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($modules as $module)
        <tr>
          <td>{{ $module->module_name }}</td>
          <td>{{ $module->module_description }}</td>
          <td>{{ isset($module->roles[0]->created_at) ? date("j F Y H:i", strtotime($module->roles[0]->created_at)) : "-" }}</td>
          <td>
            @if (isset($module->roles[0]))
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" checked wire:click="check_module({{ $role->id }}, {{ $module->id }}, false)">
                <label class="form-check-label">Assign</label>
              </div>
            @else
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" wire:click="check_module({{ $role->id }}, {{ $module->id }}, true)">
                <label class="form-check-label">Assign</label>
              </div>
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

</div>
