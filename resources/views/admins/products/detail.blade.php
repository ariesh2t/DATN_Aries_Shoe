@extends('layouts.layoutAdmin')

@section('title')
    {{ __('detail') }}
@endsection

@section('content')
    <h4 class="mb-3">{{ __('product detail', ['attr' => $product->id]) }}</h4>
    <div class="d-flex align-items-center mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('product name') }}</div>
        <div class="col-6">{{ $product->name }}</div>
    </div>
    <div class="d-flex align-items-center mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('image') }}</div>
        <div class="col d-flex flex-wrap">
            @foreach ($product->images as $image)
                <div class="col-3 p-2">
                    <div class="img-product">
                        <img src="{{ asset('images/products/' . $image->name) }}" alt="">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="d-flex mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('cost') }}</div>
        <div class="col-6">
            {{ $product->cost }}
        </div>
    </div><div class="d-flex mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('price') }}</div>
        <div class="col-6">
            {{ $product->price }}
        </div>
    </div><div class="d-flex mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('promotion') }}</div>
        <div class="col-6">
            {{ $product->promotion }}
        </div>
    </div>
    <div class="d-flex mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('desc') }}</div>
        <div class="col-6">
            {!! $product->desc !!}
        </div>
    </div>
    <div class="d-flex mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('product info') }}</div>
        <div class="col-6">
            <table class="table table-stripe text-center">
                <thead class="table-dark">
                    <tr>
                        <th>{{ __('colors') }}</th>
                        <th>{{ __('sizes') }}</th>
                        <th>{{ __('quantity') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $dem = 0;
                        foreach($product->productInfors as $productInfor) {
                            $dem++;
                        }
                        if ($dem==0) {
                            echo "<tr> <td colspan='3'>" . __('no data', ['attr' => __('product')]) . "</td> </tr>";
                        }
                    @endphp
                    @foreach ($product->productInfors as $productInfor)
                        <tr>
                            <td>
                                <div style="height: 20px; background: {{ $productInfor->color->color }}"></div>
                            </td>
                            <td>
                                {{ $productInfor->size->size }}
                            </td>
                            <td>
                                {{ $productInfor->quantity }}
                            </td>
                            <td>
                                <form action="{{ route('product-infors.destroy', $productInfor->id) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="col-5 btn-del btn m-0 p-0" title="{{ __('delete') }}" 
                                        data-confirm="{{ __('delete', ['attr' => __('product info')]) }}">
                                        <a href=""><i class="fa-solid fa-trash"></i></a>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex mt-5">
        <div class="col-6 text-start">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                <i class="fa-solid fa-pen-to-square"></i> {{ __('edit') }}
            </a>
        </div>
        <div class="col-6 text-right">
            <a href="{{ route('products.index') }}" class="btn btn-danger">
                <i class="fa-solid fa-rotate-left"></i> {{ __('back') }}
            </a>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.btn-del').click(function(){
            return confirm($(this).attr("data-confirm"));    
        }); 
    </script>
@endsection
