@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6"><strong>{{ translate('Export Product File') }}</strong></h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('product_exports.store') }}" method="POST">
                @csrf
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-info">{{ translate('Bulk Export') }}</button>
                </div>
            </form>
        </div>
            <div class="card-body">
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th data-breakpoints="lg">#</th>
                                <th data-breakpoints="lg">{{ translate('Created At') }}</th>
                                <th>{{ translate('Url') }}</th>
                                <th  class="text-left
                                ">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 + ($products->currentPage() - 1) * $products->perPage() }}</td>
                                    <td>{{ $product->created_at }}</td>

                                    <td>
                                        @if ($product->file_path)
                                            <a href="{{ url($product->file_path) }}" target="_blank">{{ translate('Download') }}</a>
                                        @else
                                            <span>{{ translate('Data is being processed, please check back later.') }}</span>
                                        @endif
                                    </td>
                                    <td class="d-flex">
                                            @if ($product->file_path)
                                            <a href="{{ route('product_exports.preview', $product->id) }}"class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            title="{{ translate('View') }}">
                                                <i class="las la-eye"></i>
                                            </a>
                                            @endif
                                            <form action="{{ route('product_exports.destroy', $product->id) }}" method="POST" onsubmit="return confirm('{{ translate('Are you sure you want to delete this item?') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-soft-danger btn-icon btn-circle btn-sm" title="{{ translate('Delete') }}">
                                                    <i class="las la-trash"></i>
                                                </button>
                                            </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $products->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
    </div>
@endsection
