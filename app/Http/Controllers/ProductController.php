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
use App\Http\Requests\AddProductRequest;
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
            return $this->errorResponse(__('MESSAGE_ERROR'), 500);
        }
        // $requestAll = $request->all();
        // $items = $this->productRepository->getAllProduct($requestAll);
        // return view('admin.pages.product.dashboard', ['items' => $items, 'requestAll' => $requestAll]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddProductRequest $request)
    {
        try {
            $this->productRepository->store($request);
            return $this->successResponse('', __('MESSAGE_ADD_PRODUCT_SUCCESS'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('MESSAGE_ERROR'), 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, AddProductRequest $request)
    {
        try {
            $data = $this->productRepository->edit($id, $request);
            return $this->successResponse($data, __('MESSAGE_UPDATE_PRODUCT_SUCCESS'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('MESSAGE_ERROR'), 500);
        }
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
            return $this->successResponse($data, __('MESSAGE_DELETE_PRODUCT_SUCCESS'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('MESSAGE_ERROR'), 500);
        }
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
            return $this->productRepository->getProduct($request);
        } catch (\Exception $e) {
            return $this->errorResponse(__('MESSAGE_ERROR'), 500);
        }
    }
}
