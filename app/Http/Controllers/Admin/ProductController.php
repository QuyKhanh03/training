<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
class ProductController extends Controller
{

    protected $category;
    protected $product;
    protected $productDetail;
    public function __construct(Category $category, Product $product, ProductDetail $productDetail)
    {
        $this->category = $category;
        $this->product = $product;
        $this->productDetail = $productDetail;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->product->latest('id')->paginate(5);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->category->all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required|unique:products,name',
            'image' => 'required',
            'price' => 'required|numeric',
            'sale' => 'required|numeric',
            'description' => 'required',
            'category_ids' => 'required'
        ],
            [
                'name.required' => 'Tên sản phẩm không được để trống',
                'name.unique' => 'Tên sản phẩm đã tồn tại',
                'image.required' => 'Ảnh sản phẩm không được để trống',
                'price.required' => 'Giá sản phẩm không được để trống',
                'price.numeric' => 'Giá sản phẩm phải là số',
                'sale.required' => 'Giảm giá sản phẩm không được để trống',
                'sale.numeric' => 'Giảm giá sản phẩm phải là số',
                'description.required' => 'Mô tả sản phẩm không được để trống',
                'category_ids.required' => 'Danh mục sản phẩm không được để trống'
            ]
        );
        $data = $request->except('sizes');
        $sizes = $request->sizes ? json_decode($request->sizes) : [];
        $product = Product::create($data);
        $data['image'] = $this->product->saveImage($request);
        $product->images()->create(['url' => $data['image']]);
        $product->categories()->attach($data['category_ids']);
        $sizeArr = [];
        foreach ($sizes as $size) {
            $sizeArr[] = ['size' => $size->size, 'quantity' => $size->quantity, 'product_id' => $product->id];
        }
        $this->productDetail->insert($sizeArr);

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->product->with(['details','categories'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = $this->product->findOrFail($id);
        $model->categories()->detach();
        $model->images()->delete();
        $product_img = $this->product->findOrFail($id)->images()->first();
        $this->product->deleteImg($product_img->url);
        $model->productDetail()->delete();
        $model->delete();
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công');
    }
}
