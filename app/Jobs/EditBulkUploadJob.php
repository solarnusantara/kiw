<?php

namespace App\Jobs;

use App\Imports\EditProductsImport;
use App\Models\ProductTranslation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class EditBulkUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = Excel::toArray(new EditProductsImport(), $this->filePath);

        if (empty($data) || count($data) == 0) {
            return;
        }

        collect(head($data))->each(function ($row) {
            DB::table('products')
                ->where('id', $row['id'])
                ->update([
                    'name' => $row['name'],
					'main_category' => $row['main_category'],
					'brand_id' => $row['brand_id'],
					'photos' => $row['photos'],
					'thumbnail_img' => $row['thumbnail_img'],
					'tags' => $row['tags'],
					'description' => $row['description'],
					'buying_price' => $row['buying_price'],
					'lowest_price' => $row['price'],
					'highest_price' => $row['price'],
					'discount' => $row['discount'],
					'discount_type' => $row['discount_type'],
					'stock' => $row['stock'],
					'published' => $row['published'],
					'unit' => $row['unit'],
					'min_qty' => $row['min_qty'],
					'max_qty' => $row['max_qty'],
					'meta_title' => $row['meta_title'],
					'meta_description' => $row['meta_description'],
					'meta_image' => $row['meta_image'],
					'slug' => $row['slug'],
                ]);


			$product_translation = ProductTranslation::updateOrCreate(
				['lang' => env('DEFAULT_LANGUAGE'), 'product_id' => $row['id']],
				[
					'name' => $row['name'],
					'unit' => $row['unit'],
					'description' => $row['description']
				]
			);

			DB::table('product_variations')
				->where('product_id', $row['id'])
				->update(
					[
						'price' => $row['price'],
						'stock' => $row['stock'] > 0 ? 1 : 0,
						'current_stock' => $row['stock']
					]
					);
			Cache::forget("product_{$row['slug']}");
        });

		Storage::delete($this->filePath);
    }
}
