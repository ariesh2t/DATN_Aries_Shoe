@extends('layouts.layoutAdmin')

@section('title')
    {{ __('list') . __('products') }}
@endsection

@section('content')
    <div class="d-flex justify-content-between mb-4">
        <h4>{{ __('list') . __('products') }}</h4>
        <a id="btn-create-brand" href="{{ route('products.create') }}" class="btn btn-info">
            <i class="fa-light fa-plus"></i> {{ __('create new') }}
        </a>
    </div>
    <table id="datatable" class="table table-striped table-bordered mb-3">
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
                <tr>
                    <td class="text-center">
                        <img height="50" src="{{ asset('images/products/' . $product->images->first()->name ) }}" alt="{{ $product->name }}">
                    </td>
                    <td>
                        <div class="overflow-hidden text-2">
                            {{ $product->name }}
                        </div>
                    </td>
                    <td class="text-center">
                        {{ $product->cost }}
                    </td>
                    <td class="text-center">
                        {{ $product->price }}
                    </td>
                    <td class="text-center">
                        {{ $product->promotion }}
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
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            <div class="d-flex justify-content-center">
                                <a class="col-4" href="{{ route('products.show', $product->id) }}" title="{{ __('detail') }}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a class="col-4" href="{{ route('products.edit', $product->id) }}" title="{{ __('edit') }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a class="col-4" href="{{ route('products.edit', $product->id) }}" title="{{ __('add new info') }}">
                                    <i class="fa-regular fa-square-plus"></i>
                                </a>
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="col-4 btn-del btn m-0 p-0" title="{{ __('delete') }}" 
                                    data-confirm="{{ __('delete confirm', ['attr' => __('product'), 'id' => $product->id]) }}">
                                    <a href=""><i class="fa-solid fa-trash"></i></a>
                                </button>
                            </div>
                        </form>
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
            console.log($(this).attr("data-confirm"))
            return confirm($(this).attr("data-confirm"));    
        }); 
    </script>
@endsection
