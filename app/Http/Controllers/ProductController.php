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

use App\Http\Requests\CreateProductRequest;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;

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
        $requestAll = $request->all();
        $items = $this->productRepository->getAllProduct($requestAll);
        return view('admin.pages.dashboard', ['items' => $items, 'requestAll' => $requestAll]);
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
        dd($request->all());
        // $requestAll = $request->all();
        // $items = $this->productRepository->createProduct($requestAll);
        // return view('admin.pages.dashboard', ['items' => $items, 'requestAll' => $requestAll]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->hasFile('photo')) {
            dd('Mời chọn file cần upload');
        } else {
            dd('as');
        }
        $request->file('photo')->store('public.backend.images');

        //dd(  $request->all()['product_image_detail']);
        $product = new Product;
        $product->product_id = fake()->regexify('[A-Z][A-Z][A-Z][A-Z]');
        //$product->product_id= Str::random(5);
        $product->product_name = $request->input('product_name_detail');
        $product->product_price = $request->input('product_price_detail');

        $product->description = $request->all()['product_description_detail'];
        //$product->product_image = $request->all()['product_image_detail'];
        //$product->created_at = datetime();

        if ($request->all()['product_status_detail'] == '3') {
            $product->is_sales = 0;
            $product->ordering = 1;
        } elseif ($request->all()['product_status_detail'] == '1') {
            $product->is_sales = 1;
            $product->ordering = 1;
        } elseif ($request->all()['product_status_detail'] == '2') {
            $product->is_sales = 1;
            $product->ordering = 0;
        }

        $product->save();

        // $this->productRepository->store($request);
        return redirect()->back()->with('status', 'Thêm sản phẩm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd($this->productRepository->getProduct($id)->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $productEdit = Product::where('product_id', $id)->get();
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
        $prod_id = $request->input('prod_id');
        //    if($request->all()['product_status_detail'] == '3')
        //    {
        //        $product->is_sales = 0;
        //        $product->ordering = 1;
        //    } else if($request->all()['product_status_detail'] == '1')
        //    {
        //        $product->is_sales = 1;
        //        $product->ordering = 1;
        //    } else if($request->all()['product_status_detail'] == '2')
        //    {
        //        $product->is_sales = 1;
        //        $product->ordering = 0;
        //    }
        $product = Product::where('product_id', $prod_id)->update(
            [
                'product_name' => ($request->input('product_name_detail')),
                'product_price' => $request->input('product_price_detail'),
                'description' => $request->all()['product_description_detail'],
                //$product->product_image = $request->all()['product_image_detail'];
                //'created_at' => time(),

            ]
        );
        // $this->productRepository->store($request);
        return redirect()->back()->with('status', 'Cập nhật sản phẩm thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Delte the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $this->productRepository->delete($id);
        return redirect()->route('product');
    }
}
