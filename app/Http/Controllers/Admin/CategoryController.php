<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected $categoryRepo;
    protected $productRepo;

    public function __construct(
        CategoryRepositoryInterface $categoryRepo,
        ProductRepositoryInterface $productRepo
    ) {
        $this->categoryRepo = $categoryRepo;
        $this->productRepo = $productRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepo->getAll();
        
        return view('admins.categories.showAll', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $file = $request->image;
        $new_name = time() . '-category-' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();

        if(!Storage::exists('categories')){
            Storage::makeDirectory('categories');
        }

        DB::transaction(function() use($request, $new_name, $file) {
            $category = $this->categoryRepo->create([
                'name' => $request->name,
                'desc' => $request->desc
            ]);
            $category->image()->create(['name' => $new_name]);

            $file->storeAs('categories', $new_name);

            return redirect()->route('categories.create')->with('success', __('create success', ['attr' => __('category')]));
        });

        return redirect()->route('categories.create')->with('error', __('create fail', ['attr' => __('category')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryRepo->find($id);

        return view('admins.categories.detail', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepo->find($id);

        return view('admins.categories.edit', compact('category'));
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
        $category = $this->categoryRepo->find($id);
        $currentFile = $category->image->name;

        DB::transaction(function() use($request, $category, $currentFile) {
            $file = $request->image;
            if (!empty($file)) {
                $new_name = time() . '-category-' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            }

            $category->update([
                'name' => $request->name,
                'desc' => $request->desc
            ]);

            if (!empty($file)) {
                $category->image()->update(['name' => $new_name]);
                Storage::delete('categories/' . $currentFile);
                $file->storeAs('categories', $new_name);
            }

            return redirect()->route('categories.index')->with('success', __('update success', ['attr' => __('category')]));
        });

        return redirect()->route('categories.index')->with('error', __('update fail', ['attr' => __('category')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepo->find($id);
        $products = $this->productRepo->getProductByWhere('category_id', $category->id);
        foreach ($products as $product) {
            if($product->orders->count() > 0) {
                return redirect()->route('categories.index')->with('error', __('delete fail', ['attr' => __('category')]));
            }
        }

        DB::transaction(function() use($category) {
            $category->delete();
            $category->image->delete();

            Storage::delete('categories/' . $category->image->name);

            return redirect()->route('categories.index')->with('success', __('delete success', ['attr' => __('category')]));
        });
            
        return redirect()->route('categories.index')->with('error', __('delete fail', ['attr' => __('category')]));
    }
}
