<?php

namespace  ED\BlogBundle\Util;

class EDEncryption
{

    /**
     * @var
     */
    private $salt;

    private $method;

    /**
     * EDEncryption constructor.
     * @param $salt
     * @param string $method
     */
    public function __construct($salt, $method = 'AES-256-CBC')
    {
        $this->salt = $salt;
        $this->method = $method;
    }

    public function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    public function safe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    /**
     * @param $value
     * @return bool|string
     */
    public function encode($value)
    {
        if (!$value) {
            return false;
        }
        $text = $value;
        $iv_size = openssl_cipher_iv_length($this->method);
        $iv = openssl_random_pseudo_bytes($iv_size);
        $cryptText = openssl_encrypt($text, $this->method, $this->salt, 0, $iv);

        return trim($this->safe_b64encode($cryptText));
    }

    /**
     * @param $value
     * @return bool|string
     */
    public function decode($value)
    {
        if (!$value) {
            return false;
        }

        $cryptText = $this->safe_b64decode($value);
        $iv_size = openssl_cipher_iv_length($this->method);
        $iv = openssl_random_pseudo_bytes($iv_size);
        $decryptText = openssl_encrypt($cryptText, $this->method, $this->salt, 0, $iv);

        return trim($decryptText);
    }

}
