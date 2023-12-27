<?php

namespace App\Helper;

use App\Models\Quote;
use Illuminate\Support\Facades\Http;

class KanyeAPIHandler
{

    public static function searchQuoteByText($text)
    {
        $result = Quote::where("text",$text)->get();

        if($result->count() > 0) {
            return true;
        }

        return false;
    }

    public static function getQuotesFromAPI($qtx = 5)
    {
        $quotes = [];

        try {

            for ($i = 0; $i < $qtx; $i++) {

                $result = Http::get("https://api.kanye.rest")->body();
                $item = json_decode($result);

                $item->isFavorite = self::searchQuoteByText($item->quote);

                array_push($quotes,$item);

            }

            return $quotes;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
