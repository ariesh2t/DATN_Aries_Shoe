<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\StoreRequest;
use App\Http\Requests\Brand\UpdateRequest;
use App\Repositories\Brand\BrandRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    protected $brandRepo;

    public function __construct(BrandRepositoryInterface $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = $this->brandRepo->getAll();
        
        return view('admins.brands.showAll', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.brands.create');
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
        $new_name = time() . '-brand-' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();

        if(!Storage::exists('brands')){
            Storage::makeDirectory('brands');
        }

        DB::transaction(function() use($request, $new_name, $file) {
            $brand = $this->brandRepo->create([
                'name' => $request->name,
                'desc' => $request->desc
            ]);
            $brand->image()->create(['name' => $new_name]);

            $file->storeAs('brands', $new_name);

            return redirect()->route('brands.create')->with('success', __('create success', ['attr' => __('brand')]));
        });

        return redirect()->route('brands.create')->with('error', __('create fail', ['attr' => __('brand')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = $this->brandRepo->find($id);

        return view('admins.brands.detail', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = $this->brandRepo->find($id);

        return view('admins.brands.edit', compact('brand'));
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
        $brand = $this->brandRepo->find($id);
        $currentFile = $brand->image->name;

        DB::transaction(function() use($request, $brand, $currentFile) {
            $file = $request->image;
            if (!empty($file)) {
                $new_name = time() . '-brand-' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            }

            $brand->update([
                'name' => $request->name,
                'desc' => $request->desc
            ]);

            if (!empty($file)) {
                $brand->image()->update(['name' => $new_name]);
                Storage::delete('brands/' . $currentFile);
                $file->storeAs('brands', $new_name);
            }

            return redirect()->route('brands.index')->with('success', __('update success', ['attr' => __('brand')]));
        });

        return redirect()->route('brands.index')->with('error', __('update fail', ['attr' => __('brand')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = $this->brandRepo->find($id);

        DB::transaction(function() use($brand) {
            $brand->delete();
            $brand->image->delete();

            Storage::delete('brands/' . $brand->image->name);

            return redirect()->route('brands.index')->with('success', __('delete success', ['attr' => __('brand')]));
        });
            
        return redirect()->route('brands.index')->with('error', __('delete fail', ['attr' => __('brand')]));
    }
}
