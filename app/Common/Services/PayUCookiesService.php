<?php

namespace App\Common\Services;

class PayUCookiesService
{
    private $cookies;

    public function __construct() {}

    public function __destruct() {}

    public function add($cookie)
    {
        [$data, $etc] = explode(';', $cookie, 2);
        [$name, $value] = explode('=', $data);
        $this->cookies[trim($name)] = trim($value);
    }

    public function createHeader()
    {
        if (count($this->cookies) == 0 || ! is_array($this->cookies)) {
            return '';
        }
        $output = '';
        foreach ($this->cookies as $name => $value) {
            $output .= "$name=$value; ";
        }

        return "Cookies: $output\r\n";
    }
}
