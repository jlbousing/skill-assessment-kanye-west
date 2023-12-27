<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuoteCollection;
use App\Models\Quote;
use Illuminate\Http\Request;
use App\Models\User;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            "user" => "required|numeric"
        ]);

        $data = $request->all();

        $quotes = Quote::where("user_id",$data["user"])->paginate(10);

        $user = User::find($data["user"]);

        return response()->json([
            "status" => 200,
            "data" => new QuoteCollection($quotes),
            "message" => "Get favorites quote of "
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        //
    }
}
