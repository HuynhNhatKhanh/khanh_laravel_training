<?php
/**
 * Product Controller
 *
 * PHP version 8
 *
 * @category  Controllers
 * @package   App
 * @author    Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      http://localhost/
 */
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CreateProductRequest;
use App\Repositories\Product\ProductRepositoryInterface;

/**
 * ProductController class
 *
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @author Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 */
class ProductController extends Controller
{

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->productRepository->getAllProduct($request);
            }
            return view('admin.pages.product.dashboard');
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse($message = 'Đã xảy ra lỗi', 500);
        }
        // $requestAll = $request->all();
        // $items = $this->productRepository->getAllProduct($requestAll);
        // return view('admin.pages.product.dashboard', ['items' => $items, 'requestAll' => $requestAll]);
    }

    /**
     * Display a form of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateProductRequest $requestProduct, Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $product = new Product;
        $product->product_id = fake()->regexify('[A-Z][A-Z][A-Z][A-Z]');
        $product->product_name = $request->input('product_name_detail');
        $product->product_price = $request->input('product_price_detail');
        $product->description = $request->all()['product_description_detail'];
        $product->ordering = $request->all()['product_ordering_detail'];
        if ($request->all()['product_status_detail'] == '0') {
            $product->is_sales = 0;
        } elseif ($request->all()['product_status_detail'] == '1') {
            $product->is_sales = 1;
        }
        if ($request->all()['product_image_detail']) {
            $fileNameImage = date_format(\Carbon\Carbon::now('Asia/Ho_Chi_Minh'), "YmdHis") . '_';
            $fileNameImage .= $request->all()['product_image_detail']->getClientOriginalName();
            $path = $request->file('product_image_detail')->storeAs('public/backend/images/product', $fileNameImage);
            $product->product_image  =  $fileNameImage;
        };
        $product->save();
        // $this->productRepository->store($request);
        return redirect()->back()->with('status', 'Thêm sản phẩm thành công');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $productEdit = $this->productRepository->getProduct($id);
        return response()
            ->json(['status' => 200, 'product' => $productEdit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
    //     var_dump((int)$request->all()['product_status_detail']);
    //     dd($request->all());
        $prod_id = $request->input('prod_id');
        $product = Product::where('product_id', $prod_id)->update(
            [
                'product_name' => ($request->input('product_name_detail')),
                'product_price' => $request->input('product_price_detail'),
                'description' => $request->all()['product_description_detail'],
                'is_sales' => (int)$request->all()['product_status_detail'],
                'ordering' => (int)$request->all()['product_ordering_detail'],
                //$product->product_image = $request->all()['product_image_detail'];
            ]
        );
        // $this->productRepository->store($request);
        return redirect()->back()->with('status', 'Cập nhật sản phẩm thành công');
    }

    /**
     * Delte the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        try {
            $id = $request->id;
            $data = $this->productRepository->delete($id);
            return $this->successResponse($data, $message = 'Xoá người dùng thành công');
        } catch (\Exception $e) {
            return $this->errorResponse($message = 'Đã xảy ra lỗi', 500);
        }
    }

    public function file()
    {
        return view('admin.pages.test_upload_file');
    }

    public function upload(Request $request)
    {
        // dd($request);
        $data = $request->all();
        $fileNameImage = date_format(\Carbon\Carbon::now('Asia/Ho_Chi_Minh'), "YmdHis") . '_';
        $fileNameImage .= $request->product_image->getClientOriginalName();
        $path = $request->file('product_image')->storeAs('public/backend/images/product', $fileNameImage);
        $data['product_image'] = 'backend/images/product/' . $fileNameImage;
        dd($data['product_image']);
    }

     /**
     * Get data 1 product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProduct(Request $request)
    {
        try {
            // $requestAll = $request->all();
            // return $request;
            return $this->productRepository->getProduct($request);
        } catch (\Exception $e) {
            return $this->errorResponse($message = 'Đã xảy ra lỗi', 500);
        }
    }
}
