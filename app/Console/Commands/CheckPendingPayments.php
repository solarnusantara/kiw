<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\FixedVirtualAccount;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentStatusUpdated;

class CheckPendingPayments extends Command
{
    protected $signature = 'payments:check-pending';
    protected $description = 'Check and update the status of pending payments';

    private $apiKey;

    public function __construct()
    {
        parent::__construct();
        $this->apiKey = env('XENDIT_ACCESS_TOKEN');
    }

    public function handle()
    {
        $this->checkPendingPayments();
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

                    // Send email notification
                    Mail::to('user@example.com')->send(new PaymentStatusUpdated($payment));
                }
            } catch (\Exception $e) {
                // Log the error or handle it as needed
                \Log::error('Error checking payment status: ' . $e->getMessage());
            }
        }
    }
}
