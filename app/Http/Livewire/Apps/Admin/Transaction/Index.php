<?php

namespace App\Http\Livewire\Apps\Admin\Transaction;

use App\Models\Order;
use App\Models\OrderDetail;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $data = [
            'orderDetails' => OrderDetail::orderBy('id', 'desc')->get()
        ];
        return view('livewire.apps.admin.transaction.index', $data);
    }
}
