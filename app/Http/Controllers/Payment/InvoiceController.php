<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Currency;
use App\Models\Language;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Str;
use PDF;
use GuzzleHttp\Client;


class InvoiceController extends Controller
{
    //
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

        // ...existing code...
    }

    public function createInvoice(Request $request)
    { 
			$payment = Payment::where('order_id',$request->order_id)->first();
			if($payment){
				return response()->json([
					'message' => 'Invoice already created',
					'checkout_link' => $payment->checkout_link,
				]);
			}else{
				try {
					$order = Order::where('id',$request->order_id)->first(); 
					// dd($order);
					$code = $order->combined_order->code ?? Str::random(10);
					$cust = User::where('id',$order->user_id)->first(); 
					$order = new Payment;
					$order->user_id = $request->user_id;
					$order->order_id = $request->order_id;
					$order->external_id = $code;
					$order->amount = $request->amount;
					$order->payer_email = $cust->email;
					$order->description = 'Order Placed. Order Code ' . $code;

					$client = new Client();
					$response = $client->post('https://api.xendit.co/v2/invoices', [
						'auth' => [env('XENDIT_ACCESS_TOKEN'), ''],
						'json' => [
							'external_id' => $code,
							'amount' => $request->amount,
							'payer_email' => $cust->email,
							'description' => 'Order Placed. Order Code ' . $code,
							'invoice_duration' => 172800,
						],
					]);

					$generateInvoice = json_decode($response->getBody(), true);
					// dd($generateInvoice);
					$order->checkout_link = $generateInvoice['invoice_url'];
					$order->save();

					return response()->json([
						'message' => 'Invoice created',
						'checkout_link' => $order->checkout_link,
					]);
				} catch (\Throwable $th) {
					throw $th;
				}
			}
		
    }
}
