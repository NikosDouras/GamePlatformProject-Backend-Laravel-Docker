<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Auth;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function create_review(StoreReviewRequest $request, $game_id)
    {
        //$request->validated($request->all());

        $review = Review::create([
            'user_id' => Auth::user()->id,
            'game_id' => $game_id,
            'content' => $request->content
        ]);

        return new ReviewResource($review);
    }

    
    
    public function destroy_review($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        if (Auth::user()->id !== $review->user_id) {
            return response()->json(['error' => 'You are not authorized'], 403);
        }
        

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully'], 200);
    }

    public function admin_destroy_review($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        if (Auth::user()->usertype !== 'admin') {
            return response()->json(['error' => 'You are not authorized, you are not admin'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully'], 200);
    }
}
