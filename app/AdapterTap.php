<?php

namespace App;

use App\Exceptions\NotExistFile;

class AdapterTap implements AdapterInterface
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
        if(!file_exists($this->sourceFilePath)){
            throw new NotExistFile('File não existe');
        }
        $xmlContent = file_get_contents($this->sourceFilePath);
        $this->data = simplexml_load_string($xmlContent);
    }

    private function readFile()
    {

        foreach ($this->data->row as $item) {
            $itemArray = (array) $item;

            $this->returnData[] = [
                "departure_airport" => $itemArray['from_location'],
                "destination_airport" => $itemArray['to_location'],
                "date" => $itemArray['date'],
                "price" => $itemArray['price'],
                "currency" => $itemArray['currency'],
            ];
        }

    }

    public function dataToArray() :array
    {
        return $this->returnData;
    }

}
