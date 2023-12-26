<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Models\Quote;
use http\Env\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = [];

        try {

            for ($i = 0; $i < 5; $i++) {

                $result = Http::get("https://api.kanye.rest")->body();
                array_push($quotes,json_decode($result));

            }

            return Inertia::render("Quotes/Index",[
                "quotes" => $quotes
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
        Quote::create($data);

        return redirect("quotes.index");
    }

    public function refresh()
    {
        $quotes = [];

        try {

            for ($i = 0; $i < 5; $i++) {

                $result = Http::get("https://api.kanye.rest")->body();
                array_push($quotes,json_decode($result));

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
    public function destroy(Quote $quote)
    {
        //
    }
}
