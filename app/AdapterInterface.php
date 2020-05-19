<?php

namespace App;

interface AdapterInterface
{
    public function __construct(string $sourceFilePath);

    public function dataToArray() :array;

}
