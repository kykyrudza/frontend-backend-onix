<?php

namespace App\Actions\Product;

use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AddReview
{
    public function add_review(Request $request, $id): JsonResponse|RedirectResponse
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Вы должны войти в аккаунт, чтобы оставить отзыв.'], 401);
        }

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string'
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->back();
    }
}
