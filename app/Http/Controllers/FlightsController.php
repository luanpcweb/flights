<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlightsController extends Controller
{
    public function search(Request $request)
    {

        $from = $request->from;
        $to = $request->to;
        $departure_date = $request->departure_date;
        $return_date = $request->return_date;
        $max_price = $request->max_price;


    }
}
