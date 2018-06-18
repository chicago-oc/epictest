<?php
namespace app\components\calculator;

class TariffRateStep {
    private $low;
    private $high;
    private $price;

    public function __construct($low, $high, $price) {
        $this->low = $low;
        $this->high = $high;
        $this->price = $price;
    }

    public function getPrice($start, $end) {
        if (($end <= $this->low) || ($start >= $this->high)) {
            return 0;
        }
        if ($end >= $this->high) {
            $end = $this->high;
        }
        if ($start <= $this->low) {
            $start = $this->low;
        }
        $result = ($end - $start) * $this->price;
        return $result;
    }

}