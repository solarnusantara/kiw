<?php

namespace App\Jobs;

use App\Imports\ProductTaxesImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class UpdateProductTaxJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $filePath;
    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        //
		$this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
		try {
			Log::info('=======================');
            $data = Excel::toArray(new ProductTaxesImport(), $this->filePath);

            if (empty($data) || count($data) == 0) {
                return;
            }

            collect(head($data))->each(function ($row) {
                // Update or create taxes
                Log::info('run tax: ');
                $productTax = DB::table('product_taxes')
                                ->where('product_id', $row['id'])
                                ->where('tax_id', $row['tax_id'])
                                ->first(); 
                if ($productTax) {
                    DB::table('product_taxes')
                        ->where('product_id', $row['id'])
                        ->where('tax_id', $row['tax_id'])
                        ->update([
                            'tax' => $row['tax'],
                            'tax_type' => $row['tax_type'],
                            'updated_at' => now(),
                        ]);
                	Log::info('Product tax: update tax');
                } else {
                    DB::table('product_taxes')->insert([
                        'product_id' => $row['id'],
                        'tax_id' => $row['tax_id'],
                        'tax' => $row['tax'],
                        'tax_type' => $row['tax_type'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                	Log::info('Product tax: create tax');

                } 
            });

            // Optionally, delete the file after processing
            Storage::delete($this->filePath);
			Log::info('=======================');

        } catch (\Exception $e) {
            Log::error('Error processing product taxes import: ' . $e->getMessage());
			Log::info('=======================');
        }
    }
}
