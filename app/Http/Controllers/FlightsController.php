<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlightsController extends Controller
{
    public function search(Request $request)
    {
        $tam = new \App\Repository\TAM(file_get_contents(__DIR__ . '/../../../TAM.json'));
        $tap = new \App\Repository\TAP(file_get_contents(__DIR__ . '/../../../TAP.xml'));

        $search = new \App\Service\FlightSearcher($tap, $tam);

        $tickets = $search->search(
            $request->get('from'),
            $request->get('to') ? $request->get('to') : '',
            new \DateTime($request->get('departure_date')),
            $request->get('price') ? $request->get('price') : null,
            $request->get('return_date') ? new \DateTime($request->get('return_date')) : null,
            true
        );

        return $tickets;
    }
}
