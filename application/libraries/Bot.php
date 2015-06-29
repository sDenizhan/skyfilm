<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bot {

    public function __construct(){}

    public function patlat($start, $end, $content, $deger = 0)
    {
        $c = explode($start, $content);
        $c = explode($end, $c[1]);
        $v = (empty($deger)) ? 0 : $deger;
        return $c[$v];
    }

    public function getElementByID($tag, $content)
    {
        $rules = '#<(div|p|a|span|strong)\s+id=\"'.$tag.'\">(.*?)<\/(div|p|a|span|strong)>#i';
        @preg_match_all($rules, $content, $output);
        return $output;
    }


}