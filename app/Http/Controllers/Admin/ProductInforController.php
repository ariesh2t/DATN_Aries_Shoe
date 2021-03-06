<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\OrderProduct\OrderProductRepositoryInterface;
use App\Repositories\ProductInfor\ProductInforRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductInforController extends Controller
{
    protected $productInforRepo;
    protected $orderProductRepo;

    public function __construct(ProductInforRepositoryInterface $productInforRepo, OrderProductRepositoryInterface $orderProductRepo)
    {
        $this->productInforRepo = $productInforRepo;
        $this->orderProductRepo = $orderProductRepo;
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

        $productExists = $this->productInforRepo->getProductInfor($request->product_id, $request->color_id, $request->size_id);
        if ($productExists) {
            $productExists->update([
                'quantity' => $productExists->quantity + $request->quantity,
            ]);

            return response()->json(['success' => 'success']);
        } elseif ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            $productInfor = $this->productInforRepo->create($request->all());

            return response()->json($productInfor);
        }
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
        $productInfor = $this->productInforRepo->find($id);
        if ($this->orderProductRepo->checkExists($productInfor->product_id, $productInfor->color->color, $productInfor->size->size)) {
            return redirect()->back()->with('error', __('cannot delete'));
        }
        
        return redirect()->back()->with('success', __('delete success', ['attr' => __('product info')]));
    }
}
