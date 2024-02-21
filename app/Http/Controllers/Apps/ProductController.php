<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    private ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService;
    }

    public function get(Request $request)
    {
        $products = $this->productService->get_list_paged($request);
        $count = $this->productService->get_list_count($request);

        $data = [];
        $no = $request->start;

        foreach ($products as $product) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $product->product_name;
            $row[] = $product->product_price_capital;
            $row[] = number_format($product->product_price_sell, 0);
            $button = "<a href='" . \route("app.product.show", $product->id) . "' class='btn btn-info btn-sm m-1'>Detail</a>
            <a href='" . \route("app.product.edit", $product->id) . "' class='btn btn-warning btn-sm m-1'>Edit</a>";
            $button .= form_delete("formProduct$product->id", \route("app.product.destroy", $product->id));
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
        return $this->view_admin("admin.product.index", "List Product", [], true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->view_admin("admin.product.create", "Create Product", []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $response = $this->productService->store($request);
        return \response_json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $data = [
            "product" => $product
        ];
        return $this->view_admin("admin.product.show", "Detail Produk", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data = [
            "product" => $product
        ];
        return $this->view_admin("admin.product.edit", "Edit Produk", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $response = $this->productService->update($request, $product);
        return \response_json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        $response = \response_success_default(
            "Berhasil hapus produk!",
            FALSE,
            \route("app.product.index")
        );
        return \response_json($response);
    }
}
