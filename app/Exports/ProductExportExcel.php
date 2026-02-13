<?php

namespace App\Exports;

use App\Models\Product;
use Cache;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExportExcel implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	public function collection()
	{
		// return Product::all();

		return Cache::remember('products_export', 60, function () {
            return Product::get();
        });
	}

	public function headings(): array
	{
		return [
			'id',
			'shop_id',
			'name',
			'brand_id',
			'photos',
			'thumbnail_img',
			'tags',
			'description',
			'lowest_price',
			'buying_price',
			'highest_price',
			'discount',
			'discount_type',
			'discount_start_date',
			'discount_end_date',
			'stock',
			'published',
			'approved',
			'unit',
			'min_qty',
			'max_qty',
			'is_variant',
			'has_warranty',
			'for_pickup',
			'tax',
			'standard_delivery_time',
			'express_delivery_time',
			'weight',
			'height',
			'length',
			'width',
			'meta_title',
			'meta_description',
			'meta_image',
			'slug',
			'rating',
			'num_of_sale',
			'earn_point',
			'digital',
			'main_category',
			'file_name',
			'created_at',
			'updated_at',
			'deleted_at',
		];
	}
}
