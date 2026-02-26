<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TranzilaService
{
    private string $terminalName;
    private string $apiKey;
    private string $apiUrl;

    public function __construct()
    {
        $this->terminalName = config('services.tranzila.terminal_name');
        $this->apiKey = config('services.tranzila.api_key');
        $this->apiUrl = config('services.tranzila.api_url', 'https://secure5.tranzila.com/cgi-bin/tranzila31.cgi');
    }

    public function createPaymentSession(float $amount, string $orderNumber, string $currency = 'ILS'): array
    {
        // Return iframe URL for Tranzila hosted payment page
        $params = http_build_query([
            'supplier' => $this->terminalName,
            'sum' => $amount,
            'currency' => $currency === 'ILS' ? '1' : '2',
            'cred_type' => '1',
            'order_id' => $orderNumber,
            'tranmode' => 'A',
            'nologo' => '1',
            'lang' => 'il',
            'trButtonColor' => '0A1628',
            'notify_url_address' => config('app.url') . '/api/v1/payments/callback',
            'success_url_address' => config('services.tranzila.success_url'),
            'fail_url_address' => config('services.tranzila.fail_url'),
        ]);

        return [
            'iframe_url' => "https://direct.tranzila.com/{$this->terminalName}/iframenew.php?{$params}",
            'order_number' => $orderNumber,
        ];
    }

    public function processCallback(array $data): array
    {
        $response = $data['Response'] ?? null;
        $confirmationCode = $data['ConfirmationCode'] ?? null;
        $orderNumber = $data['order_id'] ?? null;

        return [
            'success' => $response === '000',
            'order_number' => $orderNumber,
            'confirmation_code' => $confirmationCode,
            'response_code' => $response,
            'index_number' => $data['index'] ?? null,
        ];
    }

    public function verifyTransaction(string $index): array
    {
        $response = Http::withHeaders([
            'X-tranzila-api-app-key' => $this->apiKey,
        ])->get($this->apiUrl, [
            'supplier' => $this->terminalName,
            'TranzilaTK' => $index,
            'op' => '5',
        ]);

        return [
            'verified' => $response->successful(),
            'data' => $response->json(),
        ];
    }
}
