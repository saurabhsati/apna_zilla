<?php

namespace App\Common\Services;

class PayUMiscService
{
    const SUCCESS = 1;

    const FAILURE = 0;

    public function __construct() {}

    public static function get_hash($params, $salt)
    {
        $posted = [];

        if (! empty($params)) {
            foreach ($params as $key => $value) {
                $posted[$key] = htmlentities($value, ENT_QUOTES);
            }
        }

        $hash_sequence = 'key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10';

        $hash_vars_seq = explode('|', $hash_sequence);
        $hash_string = null;

        foreach ($hash_vars_seq as $hash_var) {
            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
            $hash_string .= '|';
        }

        $hash_string .= $salt;

        return strtolower(hash('sha512', $hash_string));
    }

    public static function reverse_hash($params, $salt, $status)
    {
        $posted = [];
        $hash_string = null;

        if (! empty($params)) {
            foreach ($params as $key => $value) {
                $posted[$key] = htmlentities($value, ENT_QUOTES);
            }
        }

        $additional_hash_sequence = 'base_merchantid|base_payuid|miles|additional_charges';
        $hash_vars_seq = explode('|', $additional_hash_sequence);

        foreach ($hash_vars_seq as $hash_var) {
            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var].'|' : '';
        }

        $hash_sequence = 'udf10|udf9|udf8|udf7|udf6|udf5|udf4|udf3|udf2|udf1|email|firstname|productinfo|amount|txnid|key';
        $hash_vars_seq = explode('|', $hash_sequence);
        $hash_string .= $salt.'|'.$status;

        foreach ($hash_vars_seq as $hash_var) {
            $hash_string .= '|';
            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
        }

        return strtolower(hash('sha512', $hash_string));
    }

    public static function curl_call($url, $data)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0]);

        $o = curl_exec($ch);
        if (curl_errno($ch)) {
            $c_error = curl_error($ch);

            if (empty($c_error)) {
                $c_error = 'Server Error';
            }

            return ['curl_status' => 0, 'error' => $c_error];
        }

        $o = trim($o);

        return ['curl_status' => 1, 'result' => $o];
    }

    public static function show_page($result)
    {
        if ($result['status'] === 1) {
            header('Location:'.$result['data']);
        } else {
            throw new Exception($result['data']);
        }
    }

    public static function show_reponse($result)
    {
        if ($result['status'] === 1) {
            $result['data']();
        } else {
            return $result['data'];
        }
    }
}
