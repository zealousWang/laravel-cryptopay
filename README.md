# WIncashpay v1

## New transform coinpayment package

WincashPayment is a Laravel module for handling transactions from [**Wincashpay**](https://wincashpay.com) like a create transaction, history transaction, etc.


## Requirement
* Laravel ^5.8
* PHP >= ^7.2

## Installation
You can install this package via composer:
```
$ composer require wincash/payment
```

Publishing vendor
```
$ php artisan vendor:publish --tag=wincashpay
```

Install CoinPayment configuration
```
$ php artisan wincashpay:install
```

Installation finish.

## Getting Started
Create Button transaction. Example placed on your controller
```
  . . . 
  /*
  *   @required true
  */
  $transaction['amountTotal'] = (FLOAT) 37.5;
  $transaction['note'] = 'Note for your transaction';
  $transaction['buyer_email'] = 'buyer@mailinator.com';
  $transaction['redirect_url'] = url('/back_to_tarnsaction');

  /*
  *   @required true
  *   @example first item
  */
  $transaction['items'][] = [
    'itemDescription' => 'Product one',
    'itemPrice' => (FLOAT) 7.5, // USD
    'itemQty' => (INT) 1,
    'itemSubtotalAmount' => (FLOAT) 7.5 // USD
  ];

  /*
  *   @example second item
  */
  $transaction['items'][] = [
    'itemDescription' => 'Product two',
    'itemPrice' => (FLOAT) 10, // USD
    'itemQty' => (INT) 1,
    'itemSubtotalAmount' => (FLOAT) 10 // USD
  ];

  /*
  *   @example third item
  */
  $transaction['items'][] = [
    'itemDescription' => 'Product Three',
    'itemPrice' => (FLOAT) 10, // USD
    'itemQty' => (INT) 2,
    'itemSubtotalAmount' => (FLOAT) 20 // USD
  ];

  $transaction['payload'] = [
    'foo' => [
        'bar' => 'baz'
    ]
  ];

  return \CoinPayment::generatelink($transaction);
  . . . 
```

## Listening status transaction

Open the Job file `App\Jobs\CoinpaymentListener` for the listen the our transaction and proccess

## Manual check without IPN

This function will execute orders without having to wait for the process from IPN

We can also make cron to run this function if we don't use IPN

```
/**
* this is triger function for running Job proccess
*/
return \CoinPayment::getstatusbytxnid("CPDA4VUGSBHYLXXXXXXXXXXXXXXX");
/**
  output example: "celled / Timed Out"
*/
```

## Get histories transaction Eloquent
```
\CoinPayment::gettransactions()->where('status', 0)->get();
```

# IPN Route

Except this path `/coinpayment/ipn` into csrf proccess in `App\Http\Middleware\VerifyCsrfToken` 
```
. . .
/**
  * The URIs that should be excluded from CSRF verification.
  *
  * @var array
  */
protected $except = [
    '/coinpayment/ipn'
]; 
. . .
```
