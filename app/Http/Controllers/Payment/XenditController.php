<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\FixedVirtualAccount;

class XenditController extends Controller
{
    public function __construct()
    {
        // Set your Xendit API key
        $this->apiKey = env('XENDIT_ACCESS_TOKEN');
    }

    public function createFixedVirtualAccount(Request $request)
    {
        $validatedData = $request->validate([
            'external_id' => 'required|string|unique:fixed_virtual_accounts,external_id',
            'bank_code' => 'required|string',
            'name' => 'required|string',
            'is_single_use' => 'required|boolean',
            'expected_amount' => 'required|integer',
        ]);

        try {
            $client = new Client();
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':'),
            ];

            $body = json_encode([
                'currency' => 'IDR',
                'amount' => $validatedData['expected_amount'],
                'payment_method' => [
                    'type' => 'VIRTUAL_ACCOUNT',
                    'reusability' => $validatedData['is_single_use'] ? 'ONE_TIME_USE' : 'MULTIPLE_USE',
                    'reference_id' => $validatedData['external_id'],
                    'virtual_account' => [
                        'channel_code' => $validatedData['bank_code'],
                        'channel_properties' => [
                            'customer_name' => $validatedData['name'],
                            'expires_at' => now()->addDays(7)->toISOString(), // Set an expiration date
                        ],
                    ],
                ],
                'metadata' => [
                    'description' => 'Payment for order ' . $validatedData['external_id'],
                ],
            ]);

            $request = new \GuzzleHttp\Psr7\Request('POST', 'https://api.xendit.co/payment_requests', $headers, $body);
            $response = $client->send($request);

            $fixedVA = json_decode($response->getBody(), true);

            // Save to database
            FixedVirtualAccount::create([
                'external_id' => $fixedVA['reference_id'],
                'bank_code' => $fixedVA['payment_method']['virtual_account']['channel_code'],
                'name' => $fixedVA['payment_method']['virtual_account']['channel_properties']['customer_name'],
                'is_single_use' => $validatedData['is_single_use'],
                'expected_amount' => $fixedVA['amount'],
                'account_number' => $fixedVA['payment_method']['virtual_account']['channel_properties']['virtual_account_number'],
                'status' => $fixedVA['status'],
            ]);

            return response()->json($fixedVA, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getFixedVirtualAccount(Request $request, $id)
    {
        try {
            $client = new Client();
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':'),
            ];

            $request = new \GuzzleHttp\Psr7\Request('GET', 'https://api.xendit.co/payment_requests/' . $id, $headers);
            $response = $client->send($request);

            $fixedVA = json_decode($response->getBody(), true);
			// Update the database if the status has changed
			$fixedVARecord = FixedVirtualAccount::where('external_id', $fixedVA['reference_id'])->first();
			if ($fixedVARecord && $fixedVARecord->status !== $fixedVA['status']) {
				$fixedVARecord->update([
					'status' => $fixedVA['status'],
				]);
			}

            return response()->json($fixedVA, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
public function checkPendingPayments()
{
	$pendingPayments = FixedVirtualAccount::where('status', '!=', 'SUCCESSED')->get();

	foreach ($pendingPayments as $payment) {
		try {
			$client = new Client();
			$headers = [
				'Content-Type' => 'application/json',
				'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':'),
			];

			$request = new \GuzzleHttp\Psr7\Request('GET', 'https://api.xendit.co/payment_requests/' . $payment->external_id, $headers);
			$response = $client->send($request);

			$fixedVA = json_decode($response->getBody(), true);

			if ($payment->status !== $fixedVA['status']) {
				$payment->update([
					'status' => $fixedVA['status'],
				]);
			}
			if ($payment->status !== $fixedVA['status']) {
				$payment->update([
					'status' => $fixedVA['status'],
				]);

				// Send mail notification
				\Mail::to($payment->user->email)->send(new \App\Mail\PaymentStatusUpdated($payment));
			}
		} catch (\Exception $e) {
			// Log the error or handle it as needed
		}
	}
}

public function createInvoice(Request $request)
{
	$client = new Client();
	$headers = [
		'Content-Type' => 'application/json',
		'Authorization' => 'Basic ' . base64_encode(config('xendit.api_key') . ':')
	];
	$body = json_encode([
		'external_id' => 'invoice-' . time(),
		'amount' => $request->amount,
		'payer_email' => $request->email,
		'description' => 'Invoice for Order #' . time(),
	]);

	$response = $client->post('https://api.xendit.co/v2/invoices', [
		'headers' => $headers,
		'body' => $body
	]);

	return response()->json(json_decode($response->getBody(), true));
}
}
