<?php

namespace Models;
use DateTime;
class Post
{
    public function __construct(public string $name, public string $text, public float $rate = 0, public int $rateCount = 0, public $createdAt = null, public $id = null) {

        if ($createdAt === null) {
            $this->createdAt = (new DateTime())->format("Y-m-d");
        }
        else {
            $this->createdAt = $createdAt;
        }
    }
    public function calcRate(float $rate)
    {
        $this->rate = (($this->rate)*($this->rateCount)+$rate)/($this->rateCount+1);
        $this->rateCount++;
    }

}