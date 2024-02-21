<?php

namespace App\Http\Livewire\Apps\Admin\Transaction;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\Cores\ErrorService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{

    public $product_id;
    public $pembayaran;

    public function simpan()
    {
        try {
            $transactions = Transaction::all();
            $order = Order::create([
                'no_order' => '00.' . date('Ymd') . rand(1111, 9999),
                'nama_kasir' => Auth::user()->name,
                'grand_total' => $transactions->sum('total'),
                'pembayaran' => $this->pembayaran,
                'kembalian' => $this->pembayaran - $transactions->sum('total'),
            ]);

            foreach ($transactions as $key => $value) {
                $product[] = [
                    'order_id' => $order->id,
                    'product_id' => $value->product_id,
                    'qty' => $value->qty,
                    'total' => $value->total,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            $orderDetail = OrderDetail::insert($product);

            if (!$orderDetail) {
                $response = redirect('/app/transaction/create')->with('message', 'transaksi gagal disimpan');
            }

            foreach ($transactions as $key => $value) {
                Transaction::where('id', $value->id)->delete();
            }

            $response = redirect('/app/transaction/' . $order->id)->with('message', 'transaksi berhasil disimpan');
        } catch (\Exception $e) {
            ErrorService::error($e, "Gagal update qty transaksi!");
            $response = \response_errors_default();
        }
        return $response;
    }

    public function tambahQty($id)
    {
        try {
            $transaction = Transaction::find($id);
            $transaction->update([
                'qty' => $transaction->qty + 1,
                'total' => $transaction->product->product_price_sell * ($transaction->qty + 1),

            ]);
            $response = redirect('/app/transaction/create')->with('message', 'qty produk berhasil ditambah');
        } catch (\Exception $e) {
            ErrorService::error($e, "Gagal update qty transaksi!");
            $response = \response_errors_default();
        }
        return $response;
    }

    public function kurangQty($id)
    {
        try {
            $transaction = Transaction::find($id);
            $transaction->update([
                'qty' => $transaction->qty - 1,
                'total' => $transaction->product->product_price_sell * ($transaction->qty - 1),

            ]);
            $response = redirect('/app/transaction/create')->with('message', 'qty produk berhasil dikurangi');
        } catch (\Exception $e) {
            ErrorService::error($e, "Gagal update qty transaksi!");
            $response = \response_errors_default();
        }
        return $response;
    }

    public function render()
    {
        $data = [
            'products' => Product::orderBy("product_name", "ASC")->get(),
            'transactions' => Transaction::orderBy("id", "DESC")->get(),
        ];
        return view('livewire.apps.admin.transaction.create', $data);
    }
}
