<?php

namespace App\Actions\Checkout;

use Illuminate\Support\Str;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class RedirectToOrder
{
    public function redirect_to_order(): Response
    {
        $orderToken = Str::uuid()->toString();

        session(['orderToken' => $orderToken]);

        return Inertia::location(route('order.index', ['token' => $orderToken]));
    }
}
