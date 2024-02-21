<?php

namespace App\Services;

use App\Http\Requests\TransactionRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\SessionToken;
use App\Models\Transaction;
use App\Services\Cores\BaseService;
use App\Services\Cores\ErrorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionService extends BaseService
{
    private function generate_query_get(Request $request)
    {
        $column_search = [
            "orders.id",
            "orders.qty",
            "orders.total",
        ];
        $column_order = [
            NULL,
            "orders.id",
            "orders.qty",
            "orders.total",
        ];
        $order = ["orders.id" => "DESC"];

        $results = Order::query()
            ->where(function ($query) use ($request, $column_search) {
                $i = 1;
                if (isset($request->search)) {
                    foreach ($column_search as $column) {
                        if ($request->search["value"]) {
                            if ($i == 1) {
                                $query->where($column, "LIKE", "%{$request->search["value"]}%");
                            } else {
                                $query->orWhere($column, "LIKE", "%{$request->search["value"]}%");
                            }
                        }
                        $i++;
                    }
                }
            });

        if (isset($request->order) && !empty($request->order)) {
            $results = $results->orderBy($column_order[$request->order["0"]["column"]], $request->order["0"]["dir"]);
        } else {
            $results = $results->orderBy(key($order), $order[key($order)]);
        }

        return $results;
    }

    public function get_list_paged(Request $request)
    {
        $results = $this->generate_query_get($request);
        if ($request->length != -1) {
            $limit = $results->offset($request->start)->limit($request->length);
            return $limit->get();
        }
    }

    public function get_list_count(Request $request)
    {
        return $this->generate_query_get($request)->count();
    }

    public function update(TransactionRequest $request, Transaction $transaction)
    {
        try {
            $transaction_id = $transaction->id;
            $values = $request->validated();

            // dd($values);
            $transaction->update($values);

            $response = \response_success_default(
                "Berhasil update data transaksi!",
                $transaction_id,
                route("app.transaction.show", $transaction->id)
            );
        } catch (\Exception $e) {
            ErrorService::error($e, "Gagal update transaksi!");
            $response = \response_errors_default();
        }

        return $response;
    }

    public function get_admin_online()
    {
        $query = SessionToken::query()
            ->select([
                "u.name", "session_tokens.active_time", "u.id",
                DB::raw("MAX(session_tokens.active_time) AS max_time")
            ])
            ->join("users AS u", "u.id", "session_tokens.user_id")
            ->where("is_login", 1)
            ->having("max_time", ">", DB::raw("(NOW() - INTERVAL 15 MINUTE)"))
            ->groupBy("session_tokens.user_id")
            ->get()
            ->map(function ($item) {
                $to_time = strtotime(date("Y-m-d H:i:s"));
                $from_time = strtotime($item->max_time);
                $last_active = round(abs($to_time - $from_time) / 60);
                if ($last_active <= 0) {
                    $last_active = "Active";
                } else {
                    $last_active .= "m ago";
                }

                $item->last_active = $last_active;
                return $item;
            });

        return $query;
    }
}
