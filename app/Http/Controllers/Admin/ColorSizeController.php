<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Color\ColorRepository;
use App\Repositories\Color\ColorRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorSizeController extends Controller
{
    protected $colorRepo;
    protected $sizeRepo;

    public function __construct(ColorRepositoryInterface $colorRepo, SizeRepositoryInterface $sizeRepo)
    {
        $this->colorRepo = $colorRepo;
        $this->sizeRepo = $sizeRepo;
    }

    public function showAll()
    {
        $colors = $this->colorRepo->getAll();
        $sizes = $this->sizeRepo->getAll();

        return view('admins.products.color-size.showAll', compact('colors', 'sizes'));
    }

    public function addColor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'color' => 'required|unique:colors',
        ], [
            'color.required' => __('required', ['attr' => __('color')]),
            'color.unique' => __('unique', ['attr' => __('color')]),
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $color = $this->colorRepo->create($request->all());

        return response()->json($color);
    }

    public function addSize(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'size' => 'required|numeric|unique:sizes',
        ], [
            'size.required' => __('required', ['attr' => __('size')]),
            'size.numeric' => __('numeric', ['attr' => __('size')]),
            'size.unique' => __('unique', ['attr' => __('size')]),
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $size = $this->sizeRepo->create($request->all());

        return response()->json($size);
    }
}
