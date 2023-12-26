<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\Quote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class QuoteController extends Controller
{
    public function searchQuoteByText($text)
    {
        $result = Quote::where("text",$text)->get();

        if($result->count() > 0) {
            return true;
        }

        return false;
    }

    public function index()
    {
        $quotes = [];

        try {

            for ($i = 0; $i < 5; $i++) {

                $result = Http::get("https://api.kanye.rest")->body();
                $item = json_decode($result);

                $item->isFavorite = $this->searchQuoteByText($item->quote);

                array_push($quotes,$item);

            }

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

            for ($i = 0; $i < 5; $i++) {

                $result = Http::get("https://api.kanye.rest")->body();
                $item = json_decode($result);

                $item->isFavorite = $this->searchQuoteByText($item->quote);

                array_push($quotes,$item);

            }

            return response()->json([
                "status" => 200,
                "data" => $quotes,
                "message" => "Refresh quotes success"
            ]);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $text)
    {
        Quote::where("user_id",$id)
                        ->where("text",$text)
                        ->delete();

        return response()->json([
            "status" => 200,
            "message" => "Deleted quote success"
        ]);
    }
}
