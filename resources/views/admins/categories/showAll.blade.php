@extends('layouts.layoutAdmin')

@section('title')
    {{ __('list') . __('categories') }}
@endsection

@section('content')
    <div class="d-flex justify-content-between mb-4">
        <h4>{{ __('list') . __('categories') }}</h4>
        <a id="btn-create-brand" href="{{ route('categories.create') }}" class="btn btn-info">
            <i class="fa-light fa-plus"></i> {{ __('create new') }}
        </a>
    </div>
    <table id="datatable" class="table table-striped table-bordered mb-3">
        <thead class="table-dark">
            <tr>
                <th class="text-center">{{ __('image') }}</th>
                <th style="width: 500px">{{ __('category name') }}</th>
                <th class="text-center">{{ __('created at') }}</th>
                <th class="text-center">{{ __('function') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td class="text-center">
                        <img height="50" src="{{ asset('images/categories/' . $category->image->name ) }}" alt="{{ $category->name }}">
                    </td>
                    <td>
                        <div class="overflow-hidden text-2">
                            {{ $category->name }}
                        </div>
                    </td>
                    <td class="text-center">
                    {{ $category->created_at }}
                    </td>
                    <td class="text-center">
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                            <a class="px-1" href="{{ route('categories.show', $category->id) }}" title="{{ __('detail') }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a class="px-1" href="{{ route('categories.edit', $category->id) }}" title="{{ __('edit') }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn-del btn m-0 px-1" title="{{ __('delete') }}" 
                                data-confirm="{{ __('delete confirm', ['attr' => __('category'), 'child' => __('product'), 'id' => $category->id]) }}">
                                <a href=""><i class="fa-solid fa-trash"></i></a>
                            </button>
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
                "zeroRecords": "{{ __('not found') }}",
                "info": "{{ __('show page') }} _PAGE_ / _PAGES_",
                "infoEmpty": "{{ __('empty data') }}",
                "infoFiltered": "({{ __('filter from')}} _MAX_ {{ __('records') }})",
                "previous": "abc"
            },
            "lengthMenu": [[8, 15, 30, -1], [8, 15, 30, "All"]],
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "searchable": false,
                    "orderable": false
                }, {
                    "targets": [ 3 ],
                    "searchable": false,
                    "orderable": false
                }
            ],
            "order": [[ 0, false ], [ 2, 'desc' ], [ 3, false ]]
        });

        //confirm delete
        $('.btn-del').click(function(){
            console.log($(this).attr("data-confirm"))
            return confirm($(this).attr("data-confirm"));    
        }); 
    </script>
@endsection

