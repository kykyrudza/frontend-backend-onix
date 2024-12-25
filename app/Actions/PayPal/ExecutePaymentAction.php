<?php

namespace App\Actions\PayPal;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class ExecutePaymentAction
{
    public function executePayment(Request $request): Response
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('services.paypal.client_id'),
                config('services.paypal.secret')
            )
        );

        $paymentId = $request->query('paymentId');

        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();

        $execution->setPayerId($request->query('PayerID'));

        $result = $payment->execute($execution, $apiContext);

        $transactionId = $result->transactions[0]->related_resources[0]->sale->id;

        try {
            $payment->execute($execution, $apiContext);

            Order::where('order_token', session('orderToken'))->update([
                'transaction_id' => $transactionId,
                'status' => 'paid'
            ]);

            return Inertia::render('Payment/Success', [
                'message' => 'Оплата успішна',
            ]);
        } catch (\Exception $ex) {
            return Inertia::render('Payment/Error', [
                'message' => 'Помилка при оплаті: ' . $ex->getMessage(),
            ]);
        }
    }
}
