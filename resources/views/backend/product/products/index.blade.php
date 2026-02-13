@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-4">
                <h1 class="h3">{{ translate('All products') }}</h1>
            </div>

            <div class="col-md-8 text-md-right">
                @can('add_products')
                    <a href="{{ route('product.create') }}" class="btn btn-primary">
                        <span>{{ translate('Add New Product') }}</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <form class="" id="sort_products" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col-md-4 text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Products') }}</h5>
                </div>
            </div>
            <div class="card-header row gutters-5">

                @can('product_delete')
                    <div class="dropdown mb-2 mb-md-0">
                        <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                            {{translate('Bulk Action')}}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item confirm-alert" href="javascript:void(0)"  data-target="#bulk-delete-modal"> {{translate('Delete selection')}}</a>
                            <!-- <a class="dropdown-item" href="javascript:void(0)" onclick="show_bulk_edit_modal()"> {{translate('Bulk Edit')}}</a> -->
                        </div>

                    </div>
                @endcan

                <div class="col-md-2 ml-auto">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="type" id="type"
                        onchange="sort_products()">
                        <option value="">{{ translate('Sort By') }}</option>
                        <option value="rating,desc" @isset($col_name, $query) @if ($col_name == 'rating' && $query == 'desc') selected @endif @endisset>
                            {{ translate('Rating (High > Low)') }}
                        </option>
                        <option value="rating,asc" @isset($col_name, $query) @if ($col_name == 'rating' && $query == 'asc') selected @endif @endisset>
                            {{ translate('Rating (Low > High)') }}
                        </option>
                        <option value="num_of_sale,desc" @isset($col_name, $query) @if ($col_name == 'num_of_sale' && $query == 'desc') selected @endif @endisset>
                            {{ translate('Num of Sale (High > Low)') }}
                        </option>
                        <option value="num_of_sale,asc" @isset($col_name, $query) @if ($col_name == 'num_of_sale' && $query == 'asc') selected @endif @endisset>
                            {{ translate('Num of Sale (Low > High)') }}
                        </option>
                        <option value="unit_price,desc" @isset($col_name, $query) @if ($col_name == 'unit_price' && $query == 'desc') selected @endif @endisset>
                            {{ translate('Base Price (High > Low)') }}
                        </option>
                        <option value="unit_price,asc" @isset($col_name, $query) @if ($col_name == 'unit_price' && $query == 'asc') selected @endif @endisset>
                            {{ translate('Base Price (Low > High)') }}
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="brand_id" id="brand_id" onchange="sort_products()">
                        <option value="">{{ translate('All') }}</option>
                        @foreach (\App\Models\Brand::all() as $brand)
                            <option value="{{ $brand->id }}" @if(request()->brand_id == $brand->id) selected @endif>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="category_id" id="category_id" onchange="sort_products()">
                        <option value="">{{ translate('All') }}</option>
                        @foreach (\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}" @if(request()->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" id="search" name="search"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type & Enter') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="page_size" id="page_size" onchange="sort_products()">
                        <option value="10" @if(request()->page_size == 10) selected @endif>10</option>
                        <option value="25" @if(request()->page_size == 25) selected @endif>25</option>
                        <option value="50" @if(request()->page_size == 50) selected @endif>50</option>
                        <option value="100" @if(request()->page_size == 100) selected @endif>100</option>
                        <option value="100" @if(request()->page_size == 500) selected @endif>500</option>
                    </select>
                </div>
            </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        @if(auth()->user()->can('delete_products'))
                            <th>
                                <div class="form-group">
                                    <div class="aiz-checkbox-inline">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-all">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                            </th>
                        @else
                        <th class="w-40px">#</th>
                        @endif
                        <th class="col-xl-2">{{ translate('Name') }}</th>
                        <th data-breakpoints="md">{{ translate('Info') }}</th>
                        <th data-breakpoints="md" >{{ translate('Stock') }}</th>
                        <th data-breakpoints="md" width="20%">{{ translate('Categories') }}</th>
                        <th data-breakpoints="md">{{ translate('Brand') }}</th>
                        <th data-breakpoints="md">{{ translate('Published') }}</th>
                        <th data-breakpoints="md" class="text-right">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            @if(auth()->user()->can('delete_products'))
                                <td>
                                    <div class="form-group d-inline-block">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-one" name="id[]" value="{{$product->id}}">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </td>
                            @else
                                <td>{{ $key + 1 + ($products->currentPage() - 1) * $products->perPage() }}</td>
                            @endif
                            <td>
                                <a href="{{ route('product', $product->slug) }}" target="_blank"
                                    class="text-reset d-block">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="Image"
                                            class="size-60px size-xxl-80px mr-2"
                                            onerror="this.onerror=null;this.src='{{ static_asset('/assets/img/placeholder.webp') }}';" />
                                        <span class="flex-grow-1 minw-0">
                                            <div class=" text-truncate-2 fs-12">
                                                {{ $product->getTranslation('name') }}</div>
                                        </span>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div>
                                    <div><span>{{ translate('Rating') }}</span>: <span
                                            class="rating rating-sm my-2">{{ renderStarRating($product->rating) }}</span>
                                    </div>
                                    <div><span>{{ translate('Total Sold') }}</span>: <span
                                            class="fw-600">{{ $product->num_of_sale }}</span></div>
                                    <div>
                                        <span>{{ translate('Price') }}</span>:
                                        @if ($product->highest_price != $product->lowest_price)
                                            <span class="fw-600">{{ format_price($product->lowest_price) }} -
                                                {{ format_price($product->highest_price) }}</span>
                                        @else
                                            <span
                                                class="fw-600">{{ format_price($product->lowest_price) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div>
                                        @foreach($product->variations as $variation)
                                        @if(count($variation->combinations) == 0)
                                        <span class="ml-2 font-weight-bold">{{ $variation->stock ==1 ? translate('In Stock') : translate('Out of Stock') }}</span>
                                        @else
                                            <div class="d-flex">
                                                <div >
                                                    @foreach($variation->combinations as $combination)
                                                        <span> {{ optional($combination->attribute_value)->name .' '  }} </span>
                                                    @endforeach
                                                </div>
                                                <div>
                                                     <span class="ml-2 font-weight-bold">- {{ $variation->current_stock ?? ($variation->stock ==1 ? translate('In Stock') : translate('Out of Stock'))}}</span>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                            <td>
                                @foreach ($product->categories as $category)
                                    <span
                                        class="badge badge-inline badge-md bg-soft-dark mb-1">{{ $category->getTranslation('name') }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if ($product->brand)
                                    <div class="h-50px w-100px d-flex align-items-center justify-content-center">
                                        <img src="{{ uploaded_asset($product->brand->logo) }}"
                                            alt="{{ translate('Brand') }}" class="mw-100 mh-100"
                                            onerror="this.onerror=null;this.src='{{ static_asset('/assets/img/placeholder.webp') }}';" />
                                    </div>
                                @else
                                    <span>{{ translate('No brand') }}</span>
                                @endif
                            </td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="update_published(this)" value="{{ $product->id }}" type="checkbox"
                                        @if ($product->published == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-right">
                                @can('view_products')
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="{{ route('product.show', $product->id) }}" title="{{ translate('View') }}">
                                        <i class="las la-eye"></i>
                                    </a>
                                @endcan
                                @can('edit_products')
                                    <a class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                        href="{{ route('product.edit', ['id' => $product->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                        title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                @endcan
                                @can('duplicate_products')
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="{{ route('product.duplicate', ['id' => $product->id, 'type' => $type]) }}"
                                        title="{{ translate('Duplicate') }}">
                                        <i class="las la-copy"></i>
                                    </a>
                                @endcan
                                @can('delete_products')
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('product.destroy', $product->id) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
            {{ $products->appends(request()->input())->links() }}
            </div>
        </div>
    </form>

    </div>

    @php

    @endphp
@endsection

@section('modal')
    <!-- Delete modal -->
    @include('backend.inc.delete_modal')
        <!-- Bulk Delete modal -->
        @include('modals.bulk_delete_modal')


    <!-- Bulk Edit modal -->
    <div class="modal fade" id="bulk-edit-modal" tabindex="-1" role="dialog" aria-labelledby="bulkEditModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkEditModalLabel">{{ translate('Bulk Edit') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="bulk-edit-form" action="{{ route('bulk-product-edit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_ids" id="product_ids">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('VAT & Tax') }}</h5>
                            </div>
                            <div class="card-body">
                                @foreach (\App\Models\Tax::all() as $tax)
                                    <label for="name">
                                        {{ $tax->name }}
                                        <input type="hidden" value="{{ $tax->id }}" name="tax_ids[]">
                                    </label>

                                    <div class="form-row">
                                        <div class="form-group col-6">
                                            <input type="number" lang="en" min="0" value="0" step="0.01"
                                                placeholder="{{ translate('Tax') }}" name="taxes[]" class="form-control"
                                                required>
                                        </div>
                                        <div class="form-group col-6">
                                            <select class="form-control aiz-selectpicker" name="tax_types[]" required>
                                                <option value="flat">{{ translate('Flat') }}</option>
                                                <option value="percent">{{ translate('Percent') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Add more fields as needed -->
                        <button type="submit" class="btn btn-primary">{{ translate('Save changes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
<script type="text/javascript">

//select all items or bulk delete
        $(document).on("change", ".check-all", function() {
            if(this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });

        function bulk_delete() {
            var data = new FormData($('#sort_products')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('bulk-product-delete')}}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response == 1) {
                        location.reload();
                    }
                }
            });
        }
//end of bulk delete

    $(document).ready(function() {
        //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
    });

    function update_published(el) {
        if (el.checked) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.post('{{ route('product.published') }}', {
            _token: '{{ csrf_token() }}',
            id: el.value,
            status: status
        }, function(data) {
            if (data == 1) {
                AIZ.plugins.notify('success', '{{ translate('Published products updated successfully') }}');
            } else {
                AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
            }
        });
    }

    function sort_products(el) {
        $('#sort_products').submit();
    }

    function show_bulk_edit_modal() {
        var selected = [];
        $('.check-one:checked').each(function() {
            selected.push($(this).val());
        });

        if (selected.length > 0) {
            $('#product_ids').val(selected.join(','));
            $('#bulk-edit-modal').modal('show');
        } else {
            alert('{{ translate('Please select at least one product') }}');
        }
    }
</script>
@endsection
