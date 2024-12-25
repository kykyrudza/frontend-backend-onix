<?php

namespace App\Actions\PayPal;

use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Symfony\Component\HttpFoundation\Response as SymphonyResponse;

class CreatePaymentAction
{
    public function createPayment(Request $request): SymphonyResponse|InertiaResponse
    {
        $request->validate([
            'products' => 'required|array',
            'total_price' => 'required|numeric',
            'user' => 'required|array',
        ]);

        $data = session('data');

        $order = Order::create([
           'user_id' => $request->user['id'],
           'order_token' => session('orderToken'),
           'payment_method' => 'paypal',
           'notes' => $data['comments'],
           'total_price' => $request->total_price,
           'status' => 'pending',
       ]);

        DeliveryAddress::create([
            'order_id' => $order->id,
            'city' => $data['city'],
            'region' => $data['region'],
            'street' => $data['street'] ?? null,
            'house' => $data['house'] ?? null,
            'post_office' => $data['postOffices'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'date' => $data['date'] ?? null,
        ]);

        foreach ($request->products as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'] ?? 1,
                'price' => $product['price'] ?? 0,
            ]);
        }

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('services.paypal.client_id'),
                config('services.paypal.secret')
            )
        );

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $items = [];

        foreach ($request->products as $product) {
            $item = new Item();
            $item->setName($product['name'])
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($product['price']);
            $items[] = $item;
        }

        $itemList = new ItemList();
        $itemList->setItems($items);

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request['total_price']);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('Оплата замовлення');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('execute.paypal.payment'))
            ->setCancelUrl(route('cancel.paypal.payment'));

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($apiContext);
            return Inertia::location($payment->getApprovalLink());
        } catch (\Exception $ex) {
            return Inertia::render('Payment/Error', [
                'message' => $ex->getMessage(),
            ]);
        }
    }
}
