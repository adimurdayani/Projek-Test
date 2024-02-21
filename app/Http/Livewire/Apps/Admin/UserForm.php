<?php

namespace App\Http\Livewire\Apps\Admin;

use Livewire\Component;

class UserForm extends Component
{
    public $roles;
    public $user;
    public $show_password = FALSE;
    public $text_password = "";

    public function show_password_toggle()
    {
        $this->show_password = !$this->show_password;
    }

    public function render()
    {
        return view('livewire.apps.admin.user-form');
    }
}
