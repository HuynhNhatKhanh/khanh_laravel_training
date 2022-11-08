<?php

namespace App\Repositories\Product;

use Storage;
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
        if ($request->load == 'search') {
            if (isset($request->name)) {
                $query = $query->where("product_name", "LIKE", '%' . $request->name . '%');
            }
            if (isset($request->status) && $request->status != 'default') {
                $query = $query->where("is_sales", '=', $request['status']);
            }
            if (isset($request->priceFrom) || isset($request->priceTo)) {
                if (empty($request->priceFrom)) {
                    $query = $query->where('product_price', '>=', 0);
                    $query = $query->where('product_price', '<=', $request->priceTo);
                } elseif (empty($request->priceTo)) {
                    $query = $query->where('product_price', '>=', $request->priceFrom);
                } else {
                    $query = $query->where('product_price', '>=', $request->priceFrom);
                    $query = $query->where('product_price', '<=', $request->priceTo);
                }
            }
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
    }

    public function getProduct($request)
    {
        return $this->product->where('product_id', $request->id)->first();
    }

    public function delete($id)
    {
        return $this->product->where('product_id', $id)->delete();
    }

    public function store($request)
    {
        $product_id = $request->product_name[0].fake()->regexify('[A-Z][A-Z][A-Z][A-Z]');
        $dataCreate = [
            'product_id' => $product_id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'description' => $request->description,
            'is_sales' => $request->is_sales,
        ];
        if (isset($request->product_image) && ($request->product_image) != 'image_default.jpg') {
            $fileNameImage = date_format(\Carbon\Carbon::now('Asia/Ho_Chi_Minh'), "YmdHis") . '_';
            $fileNameImage .= $request->product_image->getClientOriginalName();
            $path = $request->file('product_image')->storeAs('public/backend/images/product', $fileNameImage);
            $dataCreate['product_image']  =  $fileNameImage;
        };
        return $this->product->create($dataCreate);
    }

    public function edit($id, $request)
    {
        $dataUpdate = [
            'product_id' => $id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'description' => $request->description,
            'is_sales' => $request->is_sales,
        ];
        // $data = $this->customer->where('product_id', $request->product_id)->first();
        // if (isset($request->dataEdit['customer_name']) && $request->dataEdit['customer_name'] != $data['customer_name']) {
        //     $dataUpdate['customer_name'] = $request->dataEdit['customer_name'];
        // }
        if (isset($request->product_image) && ($request->product_image) != 'image_default.jpg') {
            $fileNameImage = date_format(\Carbon\Carbon::now('Asia/Ho_Chi_Minh'), "YmdHis") . '_';
            $fileNameImage .= $request->product_image->getClientOriginalName();
            $path = $request->file('product_image')->storeAs('public/backend/images/product', $fileNameImage);
            $dataUpdate['product_image']  =  $fileNameImage;

            $oldImage = $this->product->find($id)->product_image;
            $fileDelete = 'storage/backend/images/product/'.$oldImage;
            if (file_exists($fileDelete)) {
                unlink($fileDelete);
            }
        };
        return $this->product->where('product_id', $id)->update($dataUpdate);
    }
}
