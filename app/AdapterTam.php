<?php

namespace App;

use App\Exceptions\NotExistFile;

class AdapterTam implements AdapterInterface
{

    private $sourceFilePath;
    private $data;
    private $returnData = [];

    public function __construct(string $sourceFilePath)
    {
        $this->sourceFilePath = $sourceFilePath;
        $this->loadFile();
        $this->readFile();
    }

    private function loadFile()
    {
        if (!file_exists($this->sourceFilePath)) {
            throw new NotExistFile('File não existe');
        }
        $this->data = file_get_contents($this->sourceFilePath);
    }

    private function readFile()
    {
        $this->data = json_decode($this->data);
        foreach ($this->data as $data) {
            $this->returnData[] = [
                "departure_airport" => $data->departure_airport,
                "destination_airport" => $data->destination_airport,
                "date" => $data->date,
                "price" => $data->price,
                "currency" => $data->currency,
            ];
        }
    }

    public function dataToArray() :array
    {
        return $this->returnData;
    }
}
