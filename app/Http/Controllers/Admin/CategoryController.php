<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
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

        $path = public_path('images/categories/');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        DB::transaction(function() use($request, $new_name, $file, $path) {
            $category = $this->categoryRepo->create([
                'name' => $request->name,
                'desc' => $request->desc
            ]);
            $category->image()->create(['name' => $new_name]);

            $file->move($path, $new_name);

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
        $path = public_path('images/categories/');

        DB::transaction(function() use($request, $category, $path, $currentFile) {
            $file = $request->image;
            if (empty($file)) {
                $extension = pathinfo($path . $currentFile)['extension'];
                $new_name = time() . '-category-' . Str::slug($request->name) . '.' . $extension;
            } else {
                $new_name = time() . '-category-' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            }

            $category->update([
                'name' => $request->name,
                'desc' => $request->desc
            ]);
            $category->image()->update(['name' => $new_name]);

            if (empty($file)) {
                rename($path . $currentFile, $path . $new_name);
            } else {
                unlink($path . $currentFile);
                $file->move($path, $new_name);
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

        DB::transaction(function() use($category) {
            $category->delete();
            $category->image->delete();

            unlink(public_path('/images/categories/' .  $category->image->name));

            return redirect()->route('categories.index')->with('success', __('delete success', ['attr' => __('category')]));
        });
            
        return redirect()->route('categories.index')->with('error', __('delete fail', ['attr' => __('category')]));
    }
}
