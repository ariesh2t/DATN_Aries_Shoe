<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ProductInfor\ProductInforRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductInforController extends Controller
{
    protected $productInforRepo;

    public function __construct(ProductInforRepositoryInterface $productInforRepo)
    {
        $this->productInforRepo = $productInforRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'quantity' => 'required|numeric|min:1',
        ], [
            'product_id.required' => __('required', ['attr' => __('product')]),
            'product_id.exists' => __('exists', ['attr' => __('product')]),
            'color_id.required' => __('required', ['attr' => __('color')]),
            'color_id.exists' => __('exists', ['attr' => __('color')]),
            'size_id.required' => __('required', ['attr' => __('size')]),
            'size_id.exists' => __('exists', ['attr' => __('size')]),
            'quantity.required' => __('required', ['attr' => __('quantity')]),
            'quantity.numeric' => __('numeric', ['attr' => __('quantity')]),
            'quantity.min' => __('min numeric', ['attr' => __('quantity'), 'value' => 1]),
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        } 

        // $exists = $this->productInforRepo->checkExist($request->product_id, $request->color_id, $request->size_id);
        // if ($exists) {
        //     return response()->json(['errors' => __('exists', ['attr' => __('product info')])]);
        // }

        $productInfor = $this->productInforRepo->create($request->all());

        return response()->json($productInfor);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->productInforRepo->delete($id);
        
        return redirect()->back()->with('success', __('delete success', ['attr' => __('product info')]));
    }
}
