<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Yajra\DataTables\DataTables;

class ProductRepository implements ProductRepositoryInterface
{
    private Product $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getAllProduct($request)
    {
        $query = $this->product;
        if ($request->load == 'index') {
            $query = $query->orderBy('updated_at', 'desc')->get();
            $results = $query;
        }
        return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn(
                    'action',
                    function ($results) {
                        $xhtml = '<td class="text-center ">';
                        $xhtml .= '<button type="button" value="'. $results->product_id .'" class="rounded-circle btn btn-sm btn-info m-1 editbtn-product " title="Chỉnh sửa" data-id="'. $results->product_id .'"><i class="fas fa-pencil-alt"></i></button>';
                        $xhtml .= '<button type="button" class="rounded-circle btn btn-sm btn-danger m-1 btn-delete-product "title="Xoá" data-id="'. $results->product_id .'" ><i class="fas fa-trash-alt"></i> </button></td>';
                        return $xhtml;
                    }
                )
                ->addColumn(
                    'product_name',
                    function ($results) {
                        if (!empty($results->product_image)) {
                            return '<a class="hoverDisplayImage">' . $results->product_name . ' <span><img loading="lazy" src="' . \URL::to('storage/backend/images/product/'. $results->product_image).'"  /></span> </a>';
                        } else {
                            return '<a class="hoverDisplayImage">' . $results->product_name . '</a>';
                        }
                    }
                )
                ->editColumn(
                    'product_price',
                    function ($results) {
                        return ('$ ' . $results->product_price);
                    }
                )
                ->editColumn(
                    'is_sales',
                    function ($results) {
                        $results->is_sales === 1 ? $status = 'Đang bán' : $status = 'Ngừng bán';
                        return $status;
                    }
                )
                ->rawColumns(['action', 'product_name'])
                ->make(true);
        // $search = @$requestAll['search'];
        // if (isset($search)) {
        //     $query = $query->where("product_name", "LIKE", '%' . $search . '%');
        // }
        // if (isset($requestAll['filter_status']) && $requestAll['filter_status'] != 'default') {
        //     $status = (int) ($requestAll['filter_status']);
        //     if ($status == 1) {
        //         $query = $query->where('ordering', '>', 0);
        //         $query = $query->where('is_sales', '=', 1);
        //     } elseif ($status == 2) {
        //         $query = $query->where('ordering', '=', 0);
        //         $query = $query->where('is_sales', '=', 1);
        //     } elseif ($status == 3) {
        //         $query = $query->where('ordering', '=', 0);
        //         $query = $query->where('is_sales', '=', 0);
        //     }
        // }
        // if (isset($requestAll['price_from']) || isset($requestAll['price_to'])) {
        //     if (empty($requestAll['price_from'])) {
        //         $query = $query->where('product_price', '>=', 0);
        //         $query = $query->where('product_price', '<=', $requestAll['price_to']);
        //     } elseif (empty($requestAll['price_to'])) {
        //         $query = $query->where('product_price', '>=', $requestAll['price_from']);
        //     } else {
        //         $query = $query->where('product_price', '>=', $requestAll['price_from']);
        //         $query = $query->where('product_price', '<=', $requestAll['price_to']);
        //     }
        // }
        // $query = $query->orderBy('updated_at', 'desc');
        // return $query->paginate(20);
    }

    public function getProduct($id)
    {
        return $this->product->where('product_id', $id)->first();
    }

    public function delete($id)
    {
        return $this->product->where('product_id', $id)->delete();
    }

    public function store($request)
    {
        // return this->product->save
    }
}
