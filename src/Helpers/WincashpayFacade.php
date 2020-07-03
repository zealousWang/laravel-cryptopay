<?php
namespace Wincash\Payment\Helpers;

use Illuminate\Support\Facades\Facade;

class WincashpayFacade extends Facade {
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return 'Wincashpay'; }
}