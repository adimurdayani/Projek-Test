<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\Cores\ErrorService;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    private TransactionService $transaction_service;
    public $pembayaran;

    public function __construct()
    {
        $this->transaction_service = new TransactionService;
    }

    public function get(Request $request)
    {
        $transactions = $this->transaction_service->get_list_paged($request);
        $count = $this->transaction_service->get_list_count($request);

        $data = [];
        $no = $request->start;

        foreach ($transactions as $transaction) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = '#' . $transaction->no_order;
            $row[] = $transaction->nama_kasir;
            $row[] = number_format($transaction->grand_total, 0);
            $row[] = number_format($transaction->pembayaran, 0);
            $row[] = number_format($transaction->kembalian, 0);
            $button = "<a href='" . \route("app.transaction.show", $transaction->id) . "' class='btn btn-info btn-sm m-1'>Invoice</a>";
            $button .= form_delete("formTransaction$transaction->id", \route("app.transaction.destroy", $transaction->id));
            $row[] = $button;
            $data[] = $row;
        }

        $output = [
            "draw" => $request->draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $data
        ];

        return \response()->json($output, 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->view_admin('admin.transaction.index', 'List Transaksi', [], true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->view_admin('admin.transaction.create', 'Create Transaksi', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        try {
            $value = $request->validated();
            $product = Product::find($request->product_id);
            $transaction = Transaction::create($value);
            $transaction->qty = 1;
            $transaction->total = $product->product_price_sell;
            $transaction->save();

            $response = redirect('/app/transaction/create');
        } catch (\Exception $e) {
            ErrorService::error($e, "Gagal store transaksi!");
            $response = \response_errors_default();
        }
        return $response;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'order' => Order::find($id)
        ];
        return $this->view_admin('admin.transaction.invoice', 'Invoice Transaksi', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $transaction)
    {
        $transaction->delete();
        $response = \response_success_default("Berhasil hapus transaksi!", FALSE, \route("app.transaction.index"));
        return \response_json($response);
    }
}
