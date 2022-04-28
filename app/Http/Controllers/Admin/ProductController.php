<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Color\ColorRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductInfor\ProductInforRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $productRepo;
    protected $productInforRepo;
    protected $brandRepo;
    protected $categoryRepo;
    protected $colorRepo;
    protected $sizeRepo;
    protected $imageRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        ProductInforRepositoryInterface $productInforRepo,
        BrandRepositoryInterface $brandRepo,
        CategoryRepositoryInterface $categoryRepo,
        ColorRepositoryInterface $colorRepo,
        SizeRepositoryInterface $sizeRepo,
        ImageRepositoryInterface $imageRepo,
    ) {
        $this->productRepo = $productRepo;
        $this->productInforRepo = $productInforRepo;
        $this->brandRepo = $brandRepo;
        $this->categoryRepo = $categoryRepo;
        $this->colorRepo = $colorRepo;
        $this->sizeRepo = $sizeRepo;
        $this->imageRepo = $imageRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepo->getAll();

        return view('admins.products.showAll', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = $this->brandRepo->getAll();
        $categories = $this->categoryRepo->getAll();

        return view('admins.products.create', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $files = $request->images;

        if(!Storage::exists('products')){
            Storage::makeDirectory('products');
        }

        DB::transaction(function() use($request, $files) {
            $product = $this->productRepo->create([
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'cost' => $request->cost,
                'price' => $request->price,
                'promotion' => $request->promotion,
                'desc' => $request->desc,
            ]);

            foreach($files as $key => $file) {
                $new_name = time() . "-product-$key-" . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
                $product->images()->create(['name' => $new_name]);
                $file->storeAs('products', $new_name);
            }

            return redirect()->route('products.create')->with('success', __('create success', ['attr' => __('product')]));
        });

        return redirect()->route('products.create')->with('error', __('create fail', ['attr' => __('product')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $colors = $this->colorRepo->getAll();
        $sizes = $this->sizeRepo->getAll();
        $product = $this->productRepo->find($id);

        return view('admins.products.detail', compact('product', 'colors', 'sizes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brands = $this->brandRepo->getAll();
        $categories = $this->categoryRepo->getAll();
        $product = $this->productRepo->find($id);

        return view('admins.products.edit', compact('product', 'brands', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $product = $this->productRepo->find($id);
        $files = '';

        if (!$product->images) {
            $request->validate([
                'images' => 'required',
            ], [
                'images.required' => __('required', ['attr' => __('image')]),
            ]);
        }

        DB::transaction(function() use($request, $product, $files) {
            $files = $request->images;
            $product->update([
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'cost' => $request->cost,
                'price' => $request->price,
                'promotion' => $request->promotion,
                'desc' => $request->desc,
            ]);

            if ($files) {
                foreach($files as $key => $file) {
                    $new_name = time() . "-product-$key-" . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
                    $product->images()->create(['name' => $new_name]);
                    $file->storeAs('products', $new_name);
                }
            }

            return redirect()->route('products.index')->with('success', __('update success', ['attr' => __('product')]));
        });

        return redirect()->route('products.index')->with('error', __('update fail', ['attr' => __('product')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->productRepo->find($id);

        DB::transaction(function() use($product) {
            foreach($product->images as $image) {
                $image->delete();

                Storage::delete('products/' . $image->name);
            }
            $product->delete();

            return redirect()->route('products.index')->with('success', __('delete success', ['attr' => __('product')]));
        });
            
        return redirect()->route('products.index')->with('error', __('delete fail', ['attr' => __('product')]));
    }
    
    public function deleteImage(Request $request)
    {
        $image = $this->imageRepo->find($request->id);
        $image->delete();

        Storage::delete('products/' . $image->name);

        return response()->json(['success' => 'delete success']);
    }
}
