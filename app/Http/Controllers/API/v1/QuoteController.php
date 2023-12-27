<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuoteCollection;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;

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

    public function index(Request $request)
    {
        $data = $request->all();

        if(isset($data["qtx"]) && isset($data["user"])) {

            //GET USER`S FAVORITES QUOTES AND QTX

            $quotes = Quote::where("user_id",$data["user"])
                            ->take($data["qtx"])
                            ->get();

            return response()->json([
                "status" => 200,
                "data" => $quotes,
                "message" => "Get favorites quote of"
            ]);

        }else if(!isset($data["qtx"]) && isset($data["user"])) {

            //GET ALL USER`S FAVORITES QUOTES WITH PAGINATION TO DONT BE SO HEAVY DATA

            $quotes = Quote::where("user_id",$data["user"])->paginate(10);

            return response()->json([
                "status" => 200,
                "data" => new QuoteCollection($quotes),
                "message" => "Get favorites quote"
            ]);

        }else if(isset($data["qtx"]) && !isset($data["user"])) {

            //GET RANDOM QUOTES FROM KANYE WEST API AND SPECIFIC QTX
            $quotes = [];

            for ($i = 0; $i < $data["qtx"]; $i++) {

                $result = Http::get("https://api.kanye.rest")->body();
                $item = json_decode($result);

                $item->isFavorite = $this->searchQuoteByText($item->quote);

                array_push($quotes,$item);

            }

            return response()->json([
                "status" => 200,
                "data" => $quotes,
                "message" => "Get random quotes from API Kanye West"
            ]);

        }else {

            //GET 5 RANDOM QUOTES

            $quotes = [];

            for ($i = 0; $i < 5; $i++) {

                $result = Http::get("https://api.kanye.rest")->body();
                $item = json_decode($result);

                $item->isFavorite = $this->searchQuoteByText($item->quote);

                array_push($quotes,$item);

            }

            return response()->json([
                "status" => 200,
                "data" => $quotes,
                "message" => "Get ramdom quotes from API Kanye West"
            ]);

        }



    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        return response()->json([
            "status" => 200,
            "data" => new QuoteResource($quote),
            "message" => "Get Quote success"
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
            "message" => "Delete favorite quote success"
        ]);
    }
}
