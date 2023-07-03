<?php 


namespace App\Service;


class Maths {

        public function add(float $param1, float $param2) : float   {
                return  $param1 + $param2;
        }

        public function subtract( float $param1, float $param2) : float   {
            return  $param1 - $param2;
        }

        public function multiply(float $param1, float $param2) : float   {
            return  $param1 * $param2;
        }

        public function divide( float $param1, float $param2) : float   {
            if($param2 == 0) throw new \Exception("Cannot divide by zero");
            return  $param1 / $param2;
        }

}