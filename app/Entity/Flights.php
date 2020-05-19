<?php

namespace App\Entity;

class Flights implements \Countable, \Iterator
{
    private $list = [];
    private $map = [];
    private $position = 0;

    public function addFlight(Flight $flight)
    {
        $this->list[] = $flight;
    }

    public function count()
    {
        return count($this->list);
    }

    public function current()
    {
        return $this->list[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        return ++$this->position;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return isset($this->list[$this->position]);
    }
}
