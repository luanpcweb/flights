<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FlightSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'searchFlight:do {from} {departure_date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search flight tickets';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tam = new \App\Repository\TAM(file_get_contents(__DIR__ . '/../../../TAM.json'));
        $tap = new \App\Repository\TAP(file_get_contents(__DIR__ . '/../../../TAP.xml'));

        $search = new \App\Service\FlightSearcher($tap, $tam);

        $tickets = $search->search(
            $this->argument('from'),
            '',
            new \DateTime($this->argument('departure_date')),
            null,
            null
        );

        print_r(json_encode($tickets));

    }
}
