<?php

namespace App\Http\Livewire\Apps\Admin\Role;

use App\Models\Module;
use App\Models\ModuleRole;
use App\Models\Role;
use Livewire\Component;

class ModuleAssign extends Component
{
    public $role;
    public $modules;

    public function render()
    {
        return view('livewire.apps.admin.role.module-assign');
    }

    public function mount()
    {
        $role = $this->role;
        $this->modules = Module::query()->with(["roles" => function($q) use ($role) {
            return $q->where("role_id", $role->id);
        }])->get();
    }

    public function check_module(Role $role, Module $module, $checked = FALSE)
    {
        if ($checked) {
            ModuleRole::create([
                "role_id" => $role->id,
                "module_id" => $module->id,
                "user_assign" => auth()->user()->id,
            ]);
        } else {
            ModuleRole::query()->where("role_id", $role->id)->where("module_id", $module->id)->delete();
        }

        $this->modules = Module::query()->with(["roles" => function($q) use ($role) {
            return $q->where("role_id", $role->id);
        }])->get();
    }
}
