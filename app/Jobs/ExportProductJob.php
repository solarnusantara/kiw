<?php

namespace App\Jobs;

use App\Exports\ProductExportExcel;
use App\Models\ProductExport;
use Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	protected $productExport;
    /**
     * Create a new job instance.
     */
    public function __construct(ProductExport $productExport)
    {
        $this->productExport = $productExport;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filePath = 'exports/' . $this->productExport->id . '.xlsx';
        Excel::store(new ProductExportExcel, $filePath, 'local');
		\Log::info('Product export file created', ['file_path' => $filePath]);
        $this->productExport->update(['file_path' => $filePath]);
    }
}
