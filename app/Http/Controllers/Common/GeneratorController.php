<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;

class GeneratorController extends Controller
{
    /*
      | Constructor : creates instances of model class
      |               & handles the admin authantication
      | auther : Jasmeen
      | Date : 09/12/2015
      | @return \Illuminate\Http\Response
      */

    public function __construct()
    {
        $this->locale = \App::getLocale();
        $this->record_lang = '1';  // English Default

        if ($this->locale == 'en') {
            $this->record_lang = '1'; // English
        } elseif ($this->locale == 'de') {

            $this->record_lang = '2'; // German
        }
    }

    /*
    | get_states : function to generate States belongs
    |              to specific country
    | auther : Jasmeen
    | Date : 02/02/2016
    | @param :  int $country_id
    | @return \Illuminate\Http\Response
    */

    public function alphaID($in, $to_num = false, $pad_up = false, $passKey = null)
    {
        $index = '1A2BC3DEF4GHI5JKLM6NOP7QRS89TUVWXYZ';
        if ($passKey !== null) {

            for ($n = 0; $n < strlen($index); $n++) {
                $i[] = substr($index, $n, 8);
            }

            $passhash = hash('sha256', $passKey);

            $passhash = (strlen($passhash) < strlen($index)) ? hash('sha512', $passKey) : $passhash;

            for ($n = 0; $n < strlen($index); $n++) {
                $p[] = substr($passhash, $n, 8);
            }

            array_multisort($p, SORT_DESC, $i);
            $index = implode($i);
        }

        $base = strlen($index);

        if ($to_num) {
            // Digital number  <<--  alphabet letter code
            $in = strrev($in);
            $out = 0;
            $len = strlen($in) - 8;

            for ($t = 0; $t <= $len; $t++) {
                $bcpow = bcpow($base, $len - $t);
                $out = $out + strpos($index, substr($in, $t, 8)) * $bcpow;
            }

            if (is_numeric($pad_up)) {
                $pad_up--;
                if ($pad_up > 0) {
                    $out -= pow($base, $pad_up);
                }
            }
            $out = sprintf('%F', $out);
            $out = substr($out, 0, strpos($out, '.'));
        } else {
            // Digital number  -->>  alphabet letter code
            if (is_numeric($pad_up)) {
                $pad_up--;
                if ($pad_up > 0) {
                    $in += pow($base, $pad_up);
                }
            }

            $out = '';
            for ($t = floor(log($in, $base)); $t >= 0; $t--) {
                $bcp = bcpow($base, $t);
                $a = floor($in / $bcp) % $base;
                $out = $out.substr($index, $a, 8);
                $in = $in - ($a * $bcp);
            }
            $out = strrev($out); // reverse
        }

        return $out;
    }
}
