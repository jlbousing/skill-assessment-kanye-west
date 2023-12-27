<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\Quote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use App\Helper\KanyeAPIHandler;

class QuoteController extends Controller
{


    public function index()
    {
        $quotes = [];

        try {

            $quotes = KanyeAPIHandler::getQuotesFromAPI();

            return Inertia::render("Quotes/Index",[
                "quotes" => $quotes,
                "user" => Auth::user()
            ]);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuoteRequest $request)
    {
        $data = $request->all();
        $quote = Quote::create($data);

        return response()->json([
            "status" => 201,
            "data" => $quote,
            "message" => "Quote created success"
        ],201);
    }

    public function refresh()
    {
        $quotes = [];

        try {

            $quotes = KanyeAPIHandler::getQuotesFromAPI();

            return response()->json([
                "status" => 200,
                "data" => $quotes,
                "message" => "Refresh quotes success"
            ]);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function favorites()
    {
        $quotes = Quote::where("user_id",Auth::id())->get();


        return Inertia::render("Quotes/Favorites",[
            "quotes" => $quotes,
            "user" => Auth::user()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        $quote->delete();

        return response()->json([
            "status" => 200,
            "message" => "Deleted quote success"
        ]);

    }

    public function destroyByText($text)
    {
        Quote::where("user_id",Auth::id())
                        ->where("text",$text)
                        ->delete();

        return response()->json([
            "status" => 200,
            "message" => "Deleted quote success"
        ]);
    }
}
