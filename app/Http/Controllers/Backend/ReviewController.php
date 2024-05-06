<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function showReviewsForm()
    {
        $adminId = auth('admin')->id();

        $reviews = Review::whereHas('room.hotel', function ($query) use ($adminId) {
            $query->where('admin_id', $adminId);
        })->with('user', 'room.hotel')->get();

        return view('admin.reviews', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.showReviewsForm')->with('status', 'Відгук успішно видалено!');
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'response' => 'required|max:1000',
        ]);

        $review->response = $request->response;
        $review->save();

        return redirect()->route('admin.reviews.showReviewsForm')->with('status', 'Відповідь успішно збережено!');
    }

}
