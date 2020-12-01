<?php

namespace App\Service;

class Calculate{

    const min = 0;
    const max = 100;

    public function addTwoValue($a, $b){

        return $a + $b;

    }


    public function addTwoValueWithThreshold($a, $b){

        $sum =  $a + $b;

        if($sum < self::min){
            return self::min;
        }

        if($sum > self::max){
            return self::max;
        }

        return $sum;

    }


}
