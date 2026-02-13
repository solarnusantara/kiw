<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateMetaProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-meta-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
		$products = \App\Models\Product::all();

		foreach ($products as $product) {
			// Update meta information for each product 
			// if (!empty($product->meta_description)) {
			// 	$product->meta_description = strip_tags(str_replace('<br>', ', ', $product->meta_description));
			// }
			// else{
				if($product->description){
					$product->meta_description = strip_tags(str_replace('<br>', ', ', $product->description));
				}
				else{
					$product->meta_description = strip_tags($product->tags);
				} 
			// }
			$product->save();
			echo "Product meta updated for product id: ".$product->id."\n";
		}
    }
}
