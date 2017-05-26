<?php

namespace  ED\BlogBundle\Util;

use ED\BlogBundle\Util\EDEncryption;

class IDEncrypt
{

    private $EDEncr;

    private $salt;

    /**
     * IDEncrypt constructor.
     * @param $salt
     */
    public function __construct($salt = 'commentsEncrypts')
    {
        $this->salt = $salt;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    private function getEDEncr()
    {
        if (!$this->EDEncr instanceof EDEncryption) {
            $this->EDEncr = new EDEncryption($this->salt);
        }
        return $this->EDEncr;
    }

    /**
     * @param $id
     * @return bool|string
     */
    public function encrypt($id)
    {
        return $this->getEDEncr()->encode($id);
    }

    /**
     * @param $encrypted
     * @return bool|string
     */
    public function decrypt($encrypted)
    {
        return $this->getEDEncr()->decode($encrypted);
    }

}
