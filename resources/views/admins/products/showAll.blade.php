@extends('layouts.layoutAdmin')

@section('title')
    {{ __('list') . __('products') }}
@endsection

@section('content')
    <div class="ajax-message btn btn-success">
    </div>
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
                                <a class="col-5" href="{{ route('products.show', $product->id) }}" title="{{ __('detail') }}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a class="col-5" href="{{ route('products.edit', $product->id) }}" title="{{ __('edit') }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </div>
                            <div class="d-flex justify-content-center">
                                <!-- Button trigger modal -->
                                <a class="col-5" data-toggle="modal" data-target="#product_{{ $product->id }}"  title="{{ __('add info') }}">
                                    <i class="fa-regular fa-square-plus"></i>
                                </a>
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="col-5 btn-del btn m-0 p-0" title="{{ __('delete') }}" 
                                    data-confirm="{{ __('delete confirm', ['attr' => __('product'), 'id' => $product->id]) }}">
                                    <a href=""><i class="fa-solid fa-trash"></i></a>
                                </button>
                            </div>
                        </form>
                        <div class="modal fade" id="product_{{ $product->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title">{{ __('form add info') . " $product->name" }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <form action="{{ route('product-infors.store') }}" data-id="{{ $product->id }}" class="js-form-add" method="POST">
                                        <small class="text-danger text-left" id="list_error_{{ $product->id }}"></small>
                                        @csrf
                                        <div class="modal-body row">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="col-4">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">{{ __('colors') }}</button>
                                                        <div class="dropdown-menu" style="height: 200px; overflow: auto">
                                                            @foreach ($colors as $color)
                                                                <div class="dropdown-item" data-value="{{ $color->color }}" data-product-id={{ $product->id }} data-color-id={{ $color->id }}
                                                                    style="margin: 5px auto !important; height: 20px; width: 75%; background: {{ $color->color }}"></div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="color_{{ $product->id }}" name="color_id" value="{{ $color->first()->id }}">
                                                    <input type="color" class="form-control" value="{{ $color->first()->color }}" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <select id="size_{{ $product->id }}" class="form-control">
                                                        <option disabled selected>{{ __('sizes') }}</option>
                                                        @foreach ($sizes as $size)
                                                            <option value="{{ $size->id }}">{{ $size->size }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <input id="quantity_{{ $product->id }}" class="form-control" placeholder="{{ __('quantity') }}" type="number" name="quantity">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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

        $('.dropdown-item').click(function() {
            let id = $(this).attr('data-product-id')
            $('#color_'+id).val($(this).attr('data-color-id'))
            $("input[type='color']").val($(this).attr('data-value'))
        })

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.js-form-add').submit(function(e) {
            e.preventDefault()
            let id = $(this).attr('data-id')
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: {
                    product_id: id,
                    color_id: $("#color_"+ id).val(),
                    size_id: $("#size_"+ id +" :selected").val(),
                    quantity: $("#quantity_"+ id).val()
                },
                success: function(result){
                    if(result.errors) {
                        $('#list_error_'+id).html('');

                        $.each(result.errors, function(key, value){
                            $('#list_error_'+id).show();
                            $('#list_error_'+id).append(value + "<br>");
                        });
                    }
                    else {
                        $('#list_error').html('')
                        $('.ajax-message').html('Thêm thành công')
                        $('.ajax-message').addClass('ajax-message-active');

                        //Set thời gian timeout để auto ẩn message trên sau 3 giây
                        setTimeout(function() {
                            $('.ajax-message').removeClass('ajax-message-active');
                        }, 6000);
                        $('.close').click();
                    }
                }
            })
        })
    </script>
@endsection
