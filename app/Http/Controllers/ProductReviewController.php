<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        $review = new ProductReview();
        $review->product_id = $productId;
        $review->user_id = Auth::id();
        $review->comment = $request->comment;
        $review->rating = $request->rating;
        $review->save();
        return back()->with('success', 'تمت إضافة المراجعة بنجاح');
    }
}
