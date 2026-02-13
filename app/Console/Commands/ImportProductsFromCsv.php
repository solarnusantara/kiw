<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\ProductVariation;
use App\Models\ProductVariationCombination;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ShopBrand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Utilities\CategoryUtility;

use App\Models\Category;
use App\Models\CategoryTranslation;


use App\Models\ProductTax; 
use GuzzleHttp\Client;
use App\Models\Upload;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class ImportProductsFromCsv extends Command
{
    protected $signature = 'import:products {file}';
    protected $description = 'Import products from a CSV file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $filePath = $this->argument('file');
        if (!Storage::exists($filePath)) {
            $this->error("File not found: $filePath");
            return;
        }

        $file = Storage::get($filePath);
        $rows = array_map('str_getcsv', explode("\n", $file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            if (count($row) < count($header)) {
                continue;
            }

            $data = array_combine($header, $row);
            $this->storeProduct($data);
        }

        $this->info('Products imported successfully.');
    }

    protected function storeProduct($data)
    {
		$existingProduct = Product::where('name', $data['name'])->first();
		//  if ($existingProduct) {
		// 	 // Delete related thumbnails
		// 	 if ($existingProduct->thumbnail_img) {
		// 		 $thumbnail = Upload::find($existingProduct->thumbnail_img);
		// 		 if ($thumbnail) {
		// 		 Storage::delete($thumbnail->file_name);
		// 		 $thumbnail->delete();
		// 		 }
		// 	 }
		// 	 if ($existingProduct) {
		// 		 // Delete related photos
		// 		 $photos = explode(',', $existingProduct->photos);
		// 		 foreach ($photos as $photo_id) {
		// 		 $photo = Upload::find($photo_id);
		// 		 if ($photo) {
		// 			 Storage::delete($photo->file_name);
		// 			 $photo->delete();
		// 		 }
		// 		 }
		// 		 $existingProduct->delete();
		// 	 }
		// 	 // Delete related product taxes
		// 	 $existingProduct->product_taxes()->delete();
	 
		// 	 // Delete related categories
		// 	 $existingProduct->categories()->detach();
		// 	 $existingProduct->delete();
		//  }
		if(!$existingProduct){

			$product = new Product;
			$product->name = $data['name'];
			$product->shop_id = 6;
			$product->brand_id = $data['brand_id'];
			$product->unit = $data['unit'];
			$product->min_qty = $data['min_qty'];
			$product->max_qty = 0;
			
			// $product->photos = $data['photos_url'];
			$photos = explode(',', $data['photos_url']);
			$client = new Client();
			
			$photo_ids = [];
			foreach ($photos as $photo_url) {
				try {
				$response = $client->get($photo_url, ['timeout' => 10]);
				$photoContents = $response->getBody()->getContents();
				$photoName = pathinfo(basename($photo_url), PATHINFO_FILENAME) . '.webp';
	
				$manager = new ImageManager(new Driver());
				$image = $manager->read($photoContents);
				$encoded = $image->toWebp(80);
				$image = $encoded;
				$filePath = 'uploads/all/' . $photoName;
				Storage::put($filePath, $image);
	
				$upload = new Upload;
				$upload->file_original_name = pathinfo($photo_url, PATHINFO_FILENAME);
				$upload->file_name = $filePath;
				$upload->user_id = 1; // Assuming user_id is 1 for this example
				$upload->extension = pathinfo($filePath, PATHINFO_EXTENSION);
				$upload->type = 'image';
				$upload->file_size = Storage::size($filePath);
				$upload->save();
	
				$photo_ids[] = $upload->id;
				} catch (\Exception $e) {
				$this->error('Failed to store photo: ' . $e->getMessage());
				continue;
				}
			}
			$product->photos = implode(',', $photo_ids);
	
	
			
			if (!empty($data['thumbnail_img_url'])) {
				try {
					$response = $client->get($data['thumbnail_img_url'], ['timeout' => 10]);
					$thumbnailContents = $response->getBody()->getContents();
					$thumbnailName = pathinfo(basename($data['thumbnail_img_url']), PATHINFO_FILENAME) . '.webp';
	
					$manager = new ImageManager(new Driver());
					$image = $manager->read($thumbnailContents);
					$encoded = $image->toWebp(80);
					$image = $encoded;
					$filePath = 'uploads/all/' . $thumbnailName;
					Storage::put($filePath, $image);
	
					$upload = new Upload;
					$upload->file_original_name = pathinfo($data['thumbnail_img_url'], PATHINFO_FILENAME);
					$upload->file_name = $filePath;
					$upload->user_id = 1; // Assuming user_id is 1 for this example
					$upload->extension = pathinfo($filePath, PATHINFO_EXTENSION);
					$upload->type = 'image';
					$upload->file_size = Storage::size($filePath);
					$upload->save();
	
					$product->thumbnail_img = $upload->id;
					$product->meta_image = $upload->id;
				} catch (\Exception $e) {
					$this->error('Failed to store thumbnail image: ' . $e->getMessage());
				}
			}
	
			$product->description = $data['description'];
	
			$product->published = $data['published'];
	
			$product->main_category = $data['category_id'];
	
			// SEO meta
			$product->meta_title = $data['meta_title'] ?? $product->name;
			$product->meta_description = $data['meta_description'] ?? strip_tags($product->description);
			
			$product->slug = Str::slug($data['name'], '-') . '-' . strtolower(Str::random(5));
	
			// warranty
			$product->has_warranty = isset($data['has_warranty']) && $data['has_warranty'] == 'on' ? 1 : 0;
	
			// tag
			$tags = array();
			if (!empty($data['tags'])) {
				foreach (json_decode($data['tags']) as $tag) {
					array_push($tags, $tag->value);
				}
			}
			if (empty($tags)) {
				$suggestedTags = [
				'panel surya', 'energi terbarukan', 'tenaga surya', 'modul surya', 'sel surya',
				'sistem fotovoltaik', 'inverter surya', 'baterai surya', 'pembangkit listrik tenaga surya', 'efisiensi energi',
				'instalasi panel surya', 'pemeliharaan panel surya', 'biaya panel surya', 'manfaat panel surya', 'keuntungan energi surya',
				'teknologi surya', 'sistem tenaga surya', 'panel fotovoltaik', 'konversi energi surya', 'energi hijau',
				'energi bersih', 'sumber energi terbarukan', 'daya surya', 'sistem penyimpanan energi', 'panel surya rumah',
				'panel surya komersial', 'panel surya industri', 'panel surya portabel', 'panel surya fleksibel', 'panel surya monokristalin',
				'panel surya polikristalin', 'panel surya amorf', 'panel surya hibrida', 'panel surya transparan', 'panel surya atap',
				'panel surya dinding', 'panel surya taman', 'panel surya jalan', 'panel surya kendaraan', 'panel surya kapal',
				'panel surya pesawat', 'panel surya satelit', 'panel surya luar angkasa', 'panel surya pertanian', 'panel surya perikanan',
				'panel surya peternakan', 'panel surya perkebunan', 'panel surya tambang', 'panel surya pabrik', 'panel surya gudang'
				];
				shuffle($suggestedTags);
				$tags = array_slice($suggestedTags, 0, 5);
			}
			$product->tags = implode(',', $tags);
	
			// lowest highest price
			
			$product->lowest_price = $data['unit_price'];
			$product->highest_price = $data['unit_price'];
		
			$product->buying_price = $data['purchase_price'];
	
			// stock based on all variations
			$product->stock = $data['current_stock'];
	
			// discount
			$product->discount = $data['discount'];
			$product->discount_type = $data['discount_type'];
	
			
	
			// shipping info
			$product->weight = $data['weight'];
			$product->height = 0;
			$product->length = 0;
			$product->width = 0;
	
			$product->save();
	
			// Product Translations
			$product_translation = ProductTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'product_id' => $product->id]);
			$product_translation->name = $data['name'];
			$product_translation->unit = $data['unit'];
			$product_translation->description = $data['description'];
			$product_translation->save();
	
			// category
	
			// Handle categories, subcategories, and subsubcategories
			$categoryIds = [];
	
			// Main category
			$mainCategory = $data['category_id'];
			$categoryIds[] = $data['category_id'];
	
			// Subcategory
			if (!empty($data['subcategory_name'])) {
				\DB::beginTransaction();  
				// Category::where('name', $data['subcategory_name'])->where('parent_id',$data['category_id'])->delete();
				$existingSubCategory = Category::where('name', $data['subcategory_name'])->where('parent_id', $data['category_id'])->first();
				if (!$existingSubCategory) {
					$subCategory = new Category; 
					$subCategory->parent_id = $data['category_id'];
					$subCategory->level = 1;
					$subCategory->name = $data['subcategory_name'];
					$subCategory->order_level = 0; 
					$subCategory->featured = 0;
					$subCategory->digital = 0;
					$subCategory->top = 0;
					$subCategory->slug = Str::slug($data['subcategory_name'], '-');
					$subCategory->meta_title = $data['subcategory_name']; 
					$subCategory->sales_amount = 0;
					$subCategory->created_at = now();
					$subCategory->updated_at = now();
					$subCategory->deleted_at = null;
					$subCategory->save();
				} else {
					$subCategory = $existingSubCategory;
				}
	
				$category_translation = CategoryTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'category_id' => $subCategory->id]);
				$category_translation->name = $data['subcategory_name'];
				$category_translation->save();
				$existingSubCategory = Category::where('name', $data['subcategory_name'])->where('parent_id', $mainCategory)->first();
				$categoryIds[] = $existingSubCategory->id;
	 
				\DB::commit(); 
	
			}
			// Subsubcategory
			if (!empty($data['subsubcategory_name']) && !empty($data['subcategory_name'])) {
				\DB::beginTransaction();  
			 
				$existingSubSubCategory = Category::where('name', $data['subsubcategory_name'])->where('parent_id', $existingSubCategory->id)->first();
				if (!$existingSubSubCategory) {
					$subSubCategory = new Category;
					$subSubCategory->parent_id = $subCategory->id;
					$subSubCategory->level = 2;
					$subSubCategory->name = $data['subsubcategory_name'];
					$subSubCategory->order_level = 0;
					$subSubCategory->featured = 0;
					$subSubCategory->digital = 0;
					$subSubCategory->top = 0;
					$subSubCategory->slug = Str::slug($data['subsubcategory_name'], '-');
					$subSubCategory->meta_title = $data['subsubcategory_name'];
					$subSubCategory->sales_amount = 0;
					$subSubCategory->created_at = now();
					$subSubCategory->updated_at = now();
					$subSubCategory->deleted_at = null;
					$subSubCategory->save();
				} else {
					$subSubCategory = $existingSubSubCategory;
				}
	
				$category_translation = CategoryTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'category_id' => $subSubCategory->id]);
				$category_translation->name = $data['subsubcategory_name'];
				$category_translation->save();
	
				\DB::commit(); 
	
				$categoryIds[] = $subSubCategory->id;
			}
	
			// Subsubcategory
			if (!empty($data['subsubcategory'])) {
				$subSubCategory = CategoryUtility::getOrCreateCategory($data['subsubcategory'], $subCategory->id ?? $mainCategory->id);
				$categoryIds[] = $subSubCategory->id;
			}
			echo "\n\n  categoryIds = ".json_encode($categoryIds);
			$product->categories()->sync($categoryIds);
	
			// shop category ids
			$shop_category_ids = [];
			// foreach ($categoryIds as $id) {
			//     $shop_category_ids[] = CategoryUtility::get_grand_parent_id($id);
			// }
			$shop_category_ids = array_merge(array_filter($categoryIds), $product->shop->shop_categories->pluck('category_id')->toArray());
			$product->shop->categories()->sync($shop_category_ids);
	
		   
	  
			if (!empty($data['tax'])) { 
					$ptax = new ProductTax;
					$ptax->product_id = $product->id;
					$ptax->tax_id = 1;
					$ptax->tax = $data['tax'];
					$ptax->tax_type =  $data['tax_type'];
					$ptax->save();  
			}
			
			
			$product->save();
			$variation              = new ProductVariation;
			$variation->product_id  = $product->id;
			$variation->sku = 'SKU-' . strtoupper(Str::random(8));
			$variation->price       = $data['unit_price'];
			$variation->stock       =  1;
			$variation->current_stock       =  $data['current_stock'];
			$variation->save();
	
	
			echo "\n\n  success = ".$product->name;
		}else{
			echo "\n\n  exist = ".$existingProduct['name'];
		}
		// static $counter = 0;
		// $counter++;

		// if ($counter >= 10) {
		// 	$this->info('Processed 10 products, stopping.');
		// 	exit;
		// }

		
    }
}
