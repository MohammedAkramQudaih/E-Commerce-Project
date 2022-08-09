<?php

namespace App\Services\Payments;

use Exception;
use Illuminate\Support\Facades\Http;

class Thawani
{
    const TEST_BASE_URL = 'https://uatcheckout.thawani.om/api/v1';
    const LIVE_BASE_URL = 'https://checkout.thawani.om/api/v1';

    protected $secritKey;
    protected $publishablekey;
    protected $baseUrl;
    protected $mode;

    public function __construct($secritKey, $publishablekey, $mode = 'test')
    {
        $this->mode = $mode;
        $this->secritKey = $secritKey;
        $this->publishablekey = $publishablekey;
        if ($mode == 'test') {
            $this->baseUrl = self::TEST_BASE_URL;
        } else
            $this->baseUrl = self::LIVE_BASE_URL;
    }

    public function createCheckoutSession($data)
    {
        $response = Http::baseUrl($this->baseUrl)->withHeaders([
            'thawani-api-key' => $this->secritKey,
            // 'content-type'=>'application/json',

        ])
            ->asJson()
            ->post('checkout/session', $data);

        $body = $response->json();
        if ($body['success'] == true && $body['code'] == 2004) {
            return $body['data']['session_id'];
        }
        throw new Exception($body['description'], $body['code']);
    }

    public function getPayUrl($session_id)
    {
        if ($this->mode == 'test') {
            return "https://uatcheckout.thawani.om/pay/{$session_id}?key={$this->publishablekey}";
        }

        return "https://checkout.thawani.om/pay/{$session_id}?key={$this->publishablekey}";
    }
}
