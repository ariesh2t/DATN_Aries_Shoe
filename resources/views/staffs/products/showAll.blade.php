@extends('layouts.layoutStaff')

@section('title')
    {{ __('list') . strtolower(__('products')) }}
@endsection

@section('breadcrumb')
    <div class="col-6">
        <h1 class="m-0">{{ __('list') . strtolower(__('products')) }}</h1>
    </div>
    <nav aria-label="breadcrumb" class="col-6">
        <ol class="breadcrumb justify-content-end">
        <li class="breadcrumb-item"><a href="{{ route('staff') }}">{{ __('home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('products') }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="ajax-message btn btn-success">
    </div>
    <table id="datatable" class="table table-bordered mb-3">
        <thead class="table-dark align-content-center">
            <tr>
                <th class="text-center">{{ __('image') }}</th>
                <th style="width: 300px">{{ __('product name') }}</th>
                <th class="text-center" style="width: 100px">{{ __('cost') }}</th>
                <th class="text-center" style="width: 100px">{{ __('price') }}</th>
                <th class="text-center" style="width: 100px">{{ __('promotion') }}</th>
                <th style="width: 150px">{{ __('category') }}</th>
                <th style="width: 150px">{{ __('brand') }}</th>
                <th class="text-center">{{ __('function') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr
                    @php
                        $dem = 0;
                        foreach($product->productInfors as $productInfor) {
                            $dem++;
                        }
                        echo $dem==0 ? "class='table-warning' title='" . __('no data', ['attr' => __('product')]) . "'" : '';
                    @endphp
                >
                    <td class="text-center">
                        <img height="50" src="{{ asset('images/products/' . $product->images->first()->name ) }}" alt="{{ $product->name }}">
                    </td>
                    <td>
                        <div class="overflow-hidden text-2">
                            {{ $product->name }}
                        </div>
                    </td>
                    <td class="text-center">
                        {{ @money($product->cost) }}
                    </td>
                    <td class="text-center">
                        {{ @money($product->price) }}
                    </td>
                    <td class="text-center">
                        {{ @money($product->promotion) }}
                    </td>
                    <td>
                        <div class="overflow-hidden text-2">
                            {{ $product->category->name }}
                        </div>
                    </td>
                    <td>
                        <div class="overflow-hidden text-2">
                            {{ $product->brand->name }}
                        </div>
                    </td>
                    <td class="text-center px-0">
                        <a href="{{ route('staff-products.show', $product->id) }}" title="{{ __('detail') }}">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        // datatable
        $('#datatable').DataTable({
            "language": {
                "lengthMenu": "{{ __('display') }} _MENU_ {{ __('records per page') }}",
                "infoEmpty": "{{ __('empty data') }}",
                "zeroRecords": "{{ __('not found') }}",
                "info": "{{ __('show page') }} _PAGE_ / _PAGES_",
                "infoFiltered": "({{ __('filter from')}} _MAX_ {{ __('records') }})",
            },
            "lengthMenu": [[8, 15, 30, -1], [8, 15, 30, "All"]],
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "searchable": false,
                    "orderable": false
                }, {
                    "targets": [ 7 ],
                    "searchable": false,
                    "orderable": false
                }
            ],
            "order": [[ 0, false ], [ 7, false ]]
        });

        //confirm delete
        $('.btn-del').click(function(){
            return confirm($(this).attr("data-confirm"));    
        }); 
    </script>
@endsection
