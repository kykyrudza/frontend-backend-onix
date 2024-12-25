<?php

namespace App\Http\Controllers;

use App\Actions\PayPal\CreatePaymentAction;
use App\Actions\PayPal\ExecutePaymentAction;
use App\Models\Order;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PayPalController extends Controller
{
    public function createPayment(Request $request, CreatePaymentAction $action)
    {
        return $action->createPayment($request);
    }
    public function executePayment(Request $request, ExecutePaymentAction $action)
    {
        return $action->executePayment($request);
    }
    public function cancelPayment()
    {
        Order::where('order_token', session('orderToken'))->update([
            'status' => 'cancelled'
        ]);

        return Inertia::render('Payment/Cancel', [
            'message' => 'Платіж скасовано',
        ]);
    }
}

