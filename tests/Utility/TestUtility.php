<?php

namespace Tests\Utility;


class TestUtility {
    public function graphMatching($a, $b) {
        if(is_array($a) && is_array($b)) {
            foreach($a as $k => $v) {
                if(!isset($b[$k]) || !$this->graphMatching($v, $b[$k])) {
                    return false;
                }
            }
            return true;
        }
        return ($a === $b);
    }
}