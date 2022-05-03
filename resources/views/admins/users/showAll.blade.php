@extends('layouts.layoutAdmin')

@section('title')
    {{ __('list') . strtolower(__('users')) }}
@endsection

@section('breadcrumb')
    <div class="col-6">
        <h1 class="m-0">{{ __('list') . strtolower(__('users')) }}</h1>
    </div>
    <nav aria-label="breadcrumb" class="col-6">
        <ol class="breadcrumb justify-content-end">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('users') }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="d-flex justify-content-between mb-4">
        <a id="btn-create-brand" href="{{ route('users.create') }}" class="btn btn-info">
            <i class="fa-light fa-plus"></i> {{ __('create staff account') }}
        </a>
    </div>
    <table id="datatable" class="table table-striped table-bordered mb-3">
        <thead class="table-dark">
            <tr class="text-center">
                <th>{{ __('image') }}</th>
                <th>{{ __('fullname') }}</th>
                <th>{{ __('phone') }}</th>
                <th>{{ __('email') }}</th>
                <th>{{ __('role') }}</th>
                <th>{{ __('status') }}</th>
                <th>{{ __('function') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="text-center">
                        <img height="50" src="{{ asset('images/users/' . $user->image->name ) }}" alt="{{ $user->fullname }}">
                    </td>
                    <td>
                        <div class="overflow-hidden text-2">
                            {{ $user->fullname }}
                        </div>
                    </td>
                    <td class="text-center">
                        {{ $user->phone }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td class="text-center">
                        {{ __($user->role->role) }}
                    </td>
                    <td class="text-center">
                        @if ($user->status == 0)
                            <i class="fa-solid fa-user-lock"></i>
                        @else
                        <i class="fa-solid fa-user-tie"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center align-items-center">
                            <a class="px-1" href="{{ route('users.detail', $user->id) }}" title="{{ __('detail') }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
    
                            @if ($user->status == 0)
                                <form action="{{ route('users.updateStatus', $user->id) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="1">
                                    <button title="{{ __('unlock account') }}" class="btn" type="submit"><i style="color: #20c997" class="fa-solid fa-lock-open"></i></button>
                                </form>
                            @else
                                <form action="{{ route('users.updateStatus', $user->id) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="0">
                                    <button title="{{ __('lock account') }}" class="btn" type="submit"><i style="color: #20c997" class="fa-solid fa-lock"></i></button>
                                </form>
                            @endif
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
                    "targets": [ 6 ],
                    "searchable": false,
                    "orderable": false
                }
            ],
            "order": [[ 0, false ], [ 6, false ]]
        });
    </script>
@endsection

