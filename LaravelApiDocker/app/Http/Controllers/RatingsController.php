<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Rating;
use Auth;
use Illuminate\Http\Request;

class RatingsController extends Controller
{

    public function rate(Request $request, $id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        // Check if the user has already rated this game
        $existingRating = Rating::where('user_id', Auth::user()->id)
            ->where('game_id', $id)
            ->first();

        if ($existingRating) {
            // If the user has already rated, update the existing rating
            $validatedData = $request->validate([
                'rating' => 'required|integer|min:1|max:10', 
            ]);

            $existingRating->rating = $validatedData['rating'];
            $existingRating->save();

            return response()->json(['message' => 'Rating updated successfully', 'data' => $existingRating]);
        } else {
            // If the user hasn't rated, create a new rating
            $validatedData = $request->validate([
                'rating' => 'required|integer|min:1|max:10', 
            ]);

            $rating = new Rating([
                'user_id' => Auth::user()->id,
                'game_id' => $id,
                'rating' => $validatedData['rating'],
            ]);

            $rating->save();

            return response()->json(['message' => 'Rating created successfully', 'data' => $rating], 201);
        }
    }

    public function delete_rate($id)
    {
        $rating = Rating::find($id);
    
        if (!$rating) {
            return response()->json(['message' => 'Rating not found'], 404);
        }
    
        // Check if the authenticated user is the owner of the rating
        if (auth()->user()->id !== $rating->user_id) {
            return response()->json(['message' => 'You are not authorized to delete this rating'], 403);
        }
    
        $rating->delete();
    
        return response()->json(['message' => 'Rating deleted successfully']);
    }
    
    public function admin_destroy_rating($id)
    {
        $rating = Rating::find($id);

        if (!$rating) {
            return response()->json(['message' => 'Rating not found'], 404);
        }

        if (Auth::user()->usertype !== 'admin') {
            return response()->json(['error' => 'You are not authorized, you are not admin'], 403);
        }

        $rating->delete();

        return response()->json(['message' => 'Rating deleted successfully'], 200);
    }
}
