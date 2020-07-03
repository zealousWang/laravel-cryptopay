<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 19/09/2017
 * Time: 12:50 PM
 */

namespace Wincash\Payment\Exceptions;


use Wincash\Payment\Entities\WincashpayIPN;
use Throwable;

class IpnIncompleteException extends \Exception
{
    /**
     * @var Ipn
     */
    private $ipn;

    public function __construct ($message = "", WincashpayIPN $ipn, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->ipn = $ipn;
    }

    /**
     * @return Ipn
     */
    public function getIpn ()
    {
        return $this->ipn;
    }
}