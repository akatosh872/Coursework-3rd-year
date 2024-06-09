<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    /**
     * Повертає сторінку з усіма відгуками до готелів адміна
     *
     * @return Application|Factory|View
     */
    public function showReviewsForm()
    {
        $adminId = auth('admin')->id();

        $reviews = Review::whereHas('room.hotel', function ($query) use ($adminId) {
            $query->where('admin_id', $adminId);
        })->with('user', 'room.hotel')->get();

        return view('admin.reviews', compact('reviews'));
    }

    /**
     * Метод видаляє коментар
     *
     * @param Review $review
     * @return RedirectResponse
     */
    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return redirect()->route('admin.reviews.list')->with('status', 'Відгук успішно видалено!');
    }

    /**
     * Метод реалізує відповідь адміна на коментар
     * За біснес-лігікою можна ввести максимум 100 символів
     *
     * @param Request $request
     * @param Review $review
     * @return RedirectResponse
     */
    public function update(Request $request, Review $review): RedirectResponse
    {
        $request->validate([
            'response' => 'required|max:1000',
        ]);

        $review->response = $request->response;
        $review->save();

        return redirect()->route('admin.reviews.list')->with('status', 'Відповідь успішно збережено!');
    }

}
