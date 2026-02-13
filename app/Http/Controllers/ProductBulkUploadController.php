<?php

namespace App\Http\Controllers;

use App\Imports\EditProductsImport;
use App\Jobs\EditBulkUploadJob;
use App\Jobs\ExportProductJob;
use App\Jobs\ImportProductTaxesJob;
use App\Jobs\ImportTaxesJob;
use App\Jobs\UpdateProductTaxJob;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductExport;
use App\Models\ProductsExport;
use App\Models\ProductsImport;
use App\Models\ProductTranslation;
use App\Models\Tax;
use App\Models\User;
use Auth;
use Cache;
use DB;
use Excel;
use Illuminate\Http\Request;
use PDF;
use Storage;

class ProductBulkUploadController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:product_bulk_import'])->only('index');
        $this->middleware(['permission:product_bulk_export'])->only('export');
    }

    public function index()
    {
        if (Auth::user()->user_type == 'seller') {
            if (Auth::user()->shop->verification_status) {
                return view('seller.product_bulk_upload.index');
            } else {
                flash(translate('Your shop is not verified yet!'))->warning();
                return back();
            }
        } elseif (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            return view('backend.product.bulk_upload.index');
        }
    }
    public function index2()
    {
        if (Auth::user()->user_type == 'seller') {
            if (Auth::user()->shop->verification_status) {
                return view('seller.bulk_update.index');
            } else {
                flash(translate('Your shop is not verified yet!'))->warning();
                return back();
            }
        } elseif (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            return view('backend.product.bulk_update.index');
        }
    }

    public function export()
    {
        // return Excel::download(new ProductsExport, 'products.xlsx');
		$col_name = null;
        $query = null;
        $sort_search = null;
        $products = ProductExport::orderBy('created_at', 'desc');

        $products = $products->paginate(15);
        
		// dd($products);

        return view('backend.product.bulk_export.index', compact('products',  'col_name', 'query', 'sort_search'));
    }
	public function storeExport(Request $request)
    {
		        // Create a new ProductExport record
        $productExport = ProductExport::create();

        // Dispatch the job to handle the export in the background
		ExportProductJob::dispatch($productExport);

        // Return a response indicating that the export is in progress
        // return response()->json(['message' => 'Export is in progress', 'export_id' => $productExport->id], 202);
    
        flash(translate('Export is in progress'))->success();
        return redirect()->route('product_bulk_export.index');

    }
	public function destroy($id)
    {
        $productExport = ProductExport::findOrFail($id);

        // Delete the file from storage
        if ($productExport->file_path) {
            Storage::delete($productExport->file_path);
        }

        // Delete the record from the database
        $productExport->delete();
        flash(translate('Export file deleted successfully.'))->success();
        return redirect()->route('product_bulk_export.index'); 
    }
	public function preview($id)
    {
        $productExport = ProductExport::findOrFail($id);

        if (!$productExport->file_path || !Storage::exists($productExport->file_path)) {
            return redirect()->route('product_bulk_export.index')->with('error', 'File not found.');
        }

        $path = Storage::path($productExport->file_path);
        $data = Excel::toArray([], $path);

        return view('backend.product.bulk_export.preview', compact('data'));
    }
	

    public function download($id)
    {
        $productExport = ProductExport::findOrFail($id);
        return Storage::download($productExport->file_path);
    }


    public function pdf_download_category()
    {
        $categories = Category::where('parent_id','0')->with('children')->get();
    	$categoryTree = $this->buildCategoryTree($categories);
		// dd($categoryTree);
		// return view('backend.downloads.category', [
		// 	'categories' => $categoryTree,
		// ]);
        return PDF::loadView('backend.downloads.category', [
            'categories' => $categoryTree,
        ], [], [])->download('category.pdf');
    }
	private function buildCategoryTree($categories)
	{
		$tree = [];
		foreach ($categories as $category) {
			$tree[] = [
				'id' => $category->id,
				'name' => $category->name,
				'children' => $this->buildCategoryTree($category->children)
			];
		}
		return $tree;
	}
    public function pdf_download_brand()
    {
        $brands = Brand::all();

        return PDF::loadView('backend.downloads.brand', [
            'brands' => $brands,
        ], [], [])->download('brands.pdf');
    }
    public function pdf_download_tax()
    {
        $taxes = Tax::all();

        return PDF::loadView('backend.downloads.tax', [
            'taxes' => $taxes,
        ], [], [])->download('tax.pdf');
    }

    public function pdf_download_seller()
    {
        $users = User::where('user_type', 'seller')->get();

        return PDF::loadView('backend.downloads.user', [
            'users' => $users,
        ], [], [])->download('user.pdf');
    }

    public function bulk_upload(Request $request)
    {
        if ($request->hasFile('bulk_file')) {
            $import = new ProductsImport;
            Excel::import($import, request()->file('bulk_file'));
        }

        return back();
    }
	public function edit_bulk_upload(Request $request)
    {
		if (!$request->hasFile('bulk_file')) {
			flash(translate('No file uploaded'))->warning();
			return back();
		}

		$filePath = $request->file('bulk_file')->store('bulk_uploads');

		EditBulkUploadJob::dispatch($filePath);

		flash(translate('Products are being edited in the background'))->success();
		return back();
    }
	public function edit_bulk_upload_taxes(Request $request)
	{
		if (!$request->hasFile('bulk_file')) {
			flash(translate('No file uploaded'))->warning();
			return back();
		} 
		$filePath = $request->file('bulk_file')->store('bulk_uploads');
		UpdateProductTaxJob::dispatch($filePath);

		flash(translate('Product taxes are being updated in the background'))->success();
 
		return back();
	}
		
}
