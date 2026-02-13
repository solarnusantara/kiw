<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Invoice;
use App\Models\Language;
use App\Models\Order;
use App\Models\OrderUpdate;
use PDF;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:invoice_download'])->only('invoice_download');
    }

    //download invoice
    public function invoice_download($id)
    {
        if (session()->has('currency_code')) {
            $currency_code = session()->get('currency_code');
        } else {
            $currency_code = Currency::findOrFail(get_setting('system_default_currency'))->code;
        }
        $language_code = session()->get('locale', app()->getLocale());

        if (Language::where('code', $language_code)->first()->rtl == 1) {
            $direction = 'rtl';
            $default_text_align = 'right';
            $reverse_text_align = 'left';
        } else {
            $direction = 'ltr';
            $default_text_align = 'left';
            $reverse_text_align = 'right';
        }

        if ($currency_code == 'BDT' || $language_code == 'bd') {
            // bengali font
            $font_family = "'Hind Siliguri','sans-serif'";
        } elseif ($currency_code == 'KHR' || $language_code == 'kh') {
            // khmer font
            $font_family = "'Khmeros','sans-serif'";
        } elseif ($currency_code == 'AMD') {
            // Armenia font
            $font_family = "'arnamu','sans-serif'";
        } elseif ($currency_code == 'ILS') {
            // Israeli font
            $font_family = "'Taamey David CLM','sans-serif'";
        } elseif ($currency_code == 'AED' || $currency_code == 'EGP' || $language_code == 'sa' || $currency_code == 'IQD' || $language_code == 'ir') {
            // middle east/arabic font
            $font_family = "'XBRiyaz','sans-serif'";
        } else {
            // general for all
            $font_family = "'Roboto','sans-serif'";
        }

        $order = Order::findOrFail($id);
        return PDF::loadView('backend.invoices.invoice', [
            'order' => $order,
            'font_family' => $font_family,
            'direction' => $direction,
            'default_text_align' => $default_text_align,
            'reverse_text_align' => $reverse_text_align
        ], [], [])->download('order-' . $order->combined_order->code  . '.pdf');
    }

    public function seller_invoice_download($id)
    {
        if (session()->has('currency_code')) {
            $currency_code = session()->get('currency_code');
        } else {
            $currency_code = Currency::findOrFail(get_setting('system_default_currency'))->code;
        }
        $language_code = session()->get('locale', app()->getLocale());

        if (Language::where('code', $language_code)->first()->rtl == 1) {
            $direction = 'rtl';
            $default_text_align = 'right';
            $reverse_text_align = 'left';
        } else {
            $direction = 'ltr';
            $default_text_align = 'left';
            $reverse_text_align = 'right';
        }

        if ($currency_code == 'BDT' || $language_code == 'bd') {
            // bengali font
            $font_family = "'Hind Siliguri','sans-serif'";
        } elseif ($currency_code == 'KHR' || $language_code == 'kh') {
            // khmer font
            $font_family = "'Khmeros','sans-serif'";
        } elseif ($currency_code == 'AMD') {
            // Armenia font
            $font_family = "'arnamu','sans-serif'";
        } elseif ($currency_code == 'ILS') {
            // Israeli font
            $font_family = "'Taamey David CLM','sans-serif'";
        } elseif ($currency_code == 'AED' || $currency_code == 'EGP' || $language_code == 'sa' || $currency_code == 'IQD' || $language_code == 'ir') {
            // middle east/arabic font
            $font_family = "'XBRiyaz','sans-serif'";
        } else {
            // general for all
            $font_family = "'Roboto','sans-serif'";
        }


        // $config = ['instanceConfigurator' => function($mpdf) {
        //     $mpdf->showImageErrors = true;
        // }];
        // mpdf config will be used in 4th params of loadview

        $config = [];

        $order = Order::findOrFail($id);
        return PDF::loadView('backend.invoices.invoice', [
            'order' => $order,
            'font_family' => $font_family,
            'direction' => $direction,
            'default_text_align' => $default_text_align,
            'reverse_text_align' => $reverse_text_align
        ], [], $config)->download('order-' . $order->code . '.pdf');
    }

    public function invoice_print($id)
    {
        if (session()->has('currency_code')) {
            $currency_code = session()->get('currency_code');
        } else {
            $currency_code = Currency::findOrFail(get_setting('system_default_currency'))->code;
        }
        $language_code = session()->get('locale', app()->getLocale());

        if (Language::where('code', $language_code)->first()->rtl == 1) {
            $direction = 'rtl';
            $default_text_align = 'right';
            $reverse_text_align = 'left';
        } else {
            $direction = 'ltr';
            $default_text_align = 'left';
            $reverse_text_align = 'right';
        }

        if ($currency_code == 'BDT' || $language_code == 'bd') {
            // bengali font
            $font_family = "'Hind Siliguri','sans-serif'";
        } elseif ($currency_code == 'KHR' || $language_code == 'kh') {
            // khmer font
            $font_family = "'Khmeros','sans-serif'";
        } elseif ($currency_code == 'AMD') {
            // Armenia font
            $font_family = "'arnamu','sans-serif'";
        } elseif ($currency_code == 'ILS') {
            // Israeli font
            $font_family = "'Taamey David CLM','sans-serif'";
        } elseif ($currency_code == 'AED' || $currency_code == 'EGP' || $language_code == 'sa' || $currency_code == 'IQD' || $language_code == 'ir') {
            // middle east/arabic font
            $font_family = "'XBRiyaz','sans-serif'";
        } else {
            // general for all
            $font_family = "'Roboto','sans-serif'";
        }

        $order = Order::with(['payment', 'user', 'shop','combined_order' => function ($query) {
			$query->with('invoice');
		}])
		->find($id); 
		// return \response()->json($order);
        if ($order != null) {
            return view('backend.invoices.invoice_print', compact('order', 'font_family', 'direction', 'default_text_align', 'reverse_text_align'));
        }
    }
	public function handleInvoicePaid(Request $request)
    {
        $invoiceData = $request->all();

		// Check if an order with the given external_id exists
		$order = Order::whereHas('payment', function ($query) use ($invoiceData) {
			$query->where('external_id', $invoiceData['external_id']);
		})->first(); 

		if (!$order) {
			return response()->json(['message' => 'Order not found'], 404);
		}
		//update the order status
		
		try {
			
			$order->update(['payment_status' => 'paid']);
			OrderUpdate::create([
				'order_id' => $order->id,
				'user_id' => $order->user_id,
				'note' => 'Order status updated to ' . $request->status . '. Using ' . $request->payment_method .' - '.$request->bank_code. ' payment method. . At ' . now(),
			]);
			// Check if an invoice with the given external_id already exists
			$invoice = Invoice::where('external_id', $invoiceData['external_id'])->first();

			if ($invoice) {
				// Update the existing invoice
				$invoice->update($invoiceData);
				return response()->json(['message' => 'Invoice updated successfully'], 200);
			} else {
				// Save the new invoice data to the database
				Invoice::create($invoiceData);
				return response()->json(['message' => 'Invoice saved successfully'], 200);
			}
		} catch (\Exception $e) {
			\Log::error('Error saving invoice: ' . $e->getMessage());
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }
}
