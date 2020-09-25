<?php

namespace Tests\Utility;


class TestUtility {
    public function graphMatching($a, $b) {
        if(is_array($a) && is_array($b)) {
            foreach($a as $k => $v) {
                if(isset($b[$k])) {
                    return $this->graphMatching($v, $b[$k]);
                } else {
                    return false;
                }
            }
        }
        return ($a === $b);
    }
}