<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Payments\Thawani;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class paymentsController extends Controller
{



    // /** 
    //  * @var \PayPalCheckoutSdk\Core\PayPalHttpClient;
    //  */


    // protected $client;

    // public function __construct()
    // {
    //     $this->client = App::make('paypal.client');
    // }

    // public function create(Order $order)
    // {
    //     // if ($order->payment_status == 'paid') {
    //     //     return redirect('orders')->with('status', 'Order already paid!');
    //     // }




    //     // Construct a request object and set desired parameters
    //     // Here, OrdersCreateRequest() creates a POST request to /v2/checkout/orders
    //     /************************************************************************************************************************************************************ */






    //     $request = new OrdersCreateRequest();
    //     $request->prefer('return=representation');
    //     $request->body = [
    //         "intent" => "CAPTURE",
    //         "purchase_units" => [[
    //             "reference_id" => $order->id,
    //             "amount" => [
    //                 "value" => $order->total,
    //                 "currency_code" => "USD"
    //             ]
    //         ]],
    //         "application_context" => [
    //             "cancel_url" => "https://example.com/cancel",
    //             "return_url" => "https://example.com/return"
    //         ]
    //     ];

    //     try {
    //         // Call API with your client and get a response for your call
    //         $response = $client->execute($request);

    //         // If call returns body in response, you can get the deserialized version from the result attribute of the response
    //         print_r($response);
    //     } catch (HttpException $ex) {
    //         echo $ex->statusCode;
    //         print_r($ex->getMessage());
    //     }
    // }


    public function create()
    {
        $client = new Thawani(
            config('services.thawani.secret_key'),
            config('services.thawani.Publishable_Key'),
            'test'
        );
        $data = [
            'client_reference_id' => 'Test Payment',
            'mode' => 'payment',
            'products' => [
                [
                    'name' => 'Test Product'  , 
                    'unit_amount' => 100*1000,
                    'quantity' => 2
                ],
            ],
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
        ];
        try {
            $session_id = $client->createCheckoutSession($data);

            return redirect()->away($client->getPayUrl($session_id));

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
