@extends('layouts.layoutStaff')

@section('title')
    {{ __('list') . __('orders') }}
@endsection

@section('breadcrumb')    
    <div class="col-6">
        <h1 class="m-0">{{ __('list') . strtolower(__('orders')) }}</h1>
    </div>
    <nav aria-label="breadcrumb" class="col-6">
        <ol class="breadcrumb justify-content-end">
          <li class="breadcrumb-item"><a href="{{ route('staff') }}">{{ __('home') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('orders') }}</li>
        </ol>
    </nav>
@endsection

@section('content')
<table id="datatable" class="table table-striped table-bordered mb-3 table-hover">
    <thead class="table-dark">
        <tr class="text-center">
            <th style="width: 70px">{{ __('code') }}</th>
            <th style="width: 200px">{{ __('fullname') }}</th>
            <th>{{ __('address') }}</th>
            <th>{{ __('phone') }}</th>
            <th>{{ __('total price') }}</th>
            <th>{{ __('status') }}</th>
            <th>{{ __('last update') }}</th>
            <th class="w-10"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td class="text-center">#{{ $order->id }}</td>
                <td>{{ $order->fullname }}</td>
                <td>{{ $order->address }}</td>
                <td class="text-center">{{ $order->phone }}</td>
                <td class="text-center">{{ @money($order->order_price) }}</td>
                <td class="text-center">
                    @switch($order->orderStatus->id)
                        @case(config('orderstatus.waiting'))
                            <span class="badge bg-primary">{{ Str::ucfirst(__($order->orderStatus->status)) }}</span>
                            @break
                        @case(config('orderstatus.delivered'))
                            <span class="badge bg-success">{{ Str::ucfirst(__($order->orderStatus->status)) }}</span>
                            @break
                        @case(config('orderstatus.cancelled'))
                            <span class="badge bg-secondary">{{ Str::ucfirst(__($order->orderStatus->status)) }}</span>
                            @break
                        @default
                            <span class="badge bg-warning">{{ Str::ucfirst(__($order->orderStatus->status)) }}</span>
                    @endswitch
                </td>
                <td class="text-center">
                    {{ $order->updated_at }}
                </td>
                <td class="text-center">
                    <a href="{{ route('staff-orders.show', $order->id) }}" title="{{ __('detail') }}">
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
                "zeroRecords": "{{ __('not found') }}",
                "info": "{{ __('show page') }} _PAGE_ / _PAGES_",
                "infoEmpty": "{{ __('empty data') }}",
                "infoFiltered": "({{ __('filter from')}} _MAX_ {{ __('records') }})",
                "previous": "abc"
            },
            "lengthMenu": [[8, 15, 30, -1], [8, 15, 30, "All"]],
            "columnDefs": [
                {
                    "targets": [ 7 ],
                    "searchable": false,
                    "orderable": false
                }, {
                    "targets": [ 3 ],
                    "searchable": false,
                    "orderable": false
                }
            ],
            "order": [[ 7, false ], [ 5, 'asc' ], [ 3, false ]]
        });
    </script>
@endsection
