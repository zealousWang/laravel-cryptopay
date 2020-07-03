<?php

namespace Wincash\Payment\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Wincash\Payment\Enums\WincashpayCommand;
use Wincash\Payment\Exceptions\JsonParseException;
use Wincash\Payment\Exceptions\MessageSendException;
use Wincash\Payment\Exceptions\WincashpayException;
use Wincash\Payment\Traits\ApiCallTrait;


class CoinPaymentController extends Controller {

    use ApiCallTrait;

    public function __construct() {
      $this->middleware(config('wincashpay.middleware'));
    }

    /**
     * Gets the current CoinPayments.net exchange rate. Output includes both crypto and fiat currencies.
     *
     * @param bool $short short == true (the default), the output won't include the currency names and confirms needed
     *                    to save bandwidth.
     * @param bool $accepted
     * @return array|mixed
     * @throws WincashpayException
     * @throws JsonParseException
     * @throws MessageSendException\
     */
    public function getRates ($short = true, $accepted = true)
    {
        return $this->api_call(WincashpayCommand::RATES, ['short' => (int)$short, 'accepted' => (int)$accepted]);
    }

    /**
     * Gets your current coin balances (only includes coins with a balance unless all = true).<br />
     *
     * @param bool $all all = true then it will return all coins, even those with a 0 balance.
     * @return array|mixed
     * @throws WincashpayException
     * @throws JsonParseException
     * @throws MessageSendException
     */
    public function getBalances ($all = false)
    {
        return $this->api_call(WincashpayCommand::BALANCES, ['all' => $all ? 1 : 0]);
    }

    

    /**
     * @param $req
     * @return array|mixed
     * @throws WincashpayException
     * @throws JsonParseException
     * @throws MessageSendException
     */
    public function createTransaction ($req)
    {
        // See https://www.coinpayments.net/apidoc-create-transaction for parameters
        return $this->api_call(WincashpayCommand::CREATE_TRANSACTION, $req);
    }

    /**
     * @param $amount
     * @param $from
     * @param $to
     * @param $address
     * @return Receipt
     * @throws WincashpayException
     * @throws JsonParseException
     * @throws MessageSendException
     */
    public function convertCoins ($amount, $from, $to, $address = null)
    {
        $req = [
            'amount'  => $amount,
            'from'    => $from,
            'to'      => $to,
            'address' => $address,
        ];
        return $this->api_call(WincashpayCommand::CONVERT, $req);
    }

    /**
     * @param $withdrawals
     * @return Receipt
     * @throws WincashpayException
     * @throws JsonParseException
     * @throws MessageSendException
     */
    public function createMassWithdrawal (array $withdrawals)
    {
        $req = collect($withdrawals)->flatMap(function ($withdrawal, $index) {
            // the minimum required values for it to work.
            app('validator')->validate($withdrawal, [
                'amount'   => 'required|numeric',
                'address'  => 'required|string',
                'currency' => 'required|string',
            ]);

            return collect($withdrawal)->flatMap(function ($value, $key) use ($index) {
                return ["wd[wd$index][$key]" => $value];
            })->toArray();
        })->toArray();

        return $this->api_call(WincashpayCommand::CREATE_MASS_WITHDRAWAL, $req);
    }

    /**
     * Get transaction information via transaction ID
     *
     * @param string $txID
     * @param bool   $all
     * @return array|mixed
     * @throws WincashpayException
     * @throws JsonParseException
     * @throws MessageSendException
     */
    public function getTransactionInfo ($txID, $all = true)
    {
        $req = [
            'txid' => $txID,
            'full' => (int)$all,
        ];

        return $this->api_call(WincashpayCommand::GET_TX_INFO, $req);
    }

    /**
     * Creates an address for receiving payments into your CoinPayments Wallet.<br />
     *
     * @param string $currency The cryptocurrency to create a receiving address for.
     * @param string $ipnUrl   Optionally set an IPN handler to receive notices about this transaction. If ipn_url is
     *                         empty then it will use the default IPN URL in your account.
     * @return array|mixed
     * @throws WincashpayException
     * @throws JsonParseException
     * @throws MessageSendException
     */
    public function getCallbackAddress ($currency)
    {
        $req = [
            'currency' => $currency,
        ];

        return $this->api_call(WincashpayCommand::GET_CALLBACK_ADDRESS, $req);
    }

    /**
     * Creates a withdrawal from your account to a specified address.<br />
     *
     * @param number $amount      The amount of the transaction (floating point to 8 decimals).
     * @param string $currency    The cryptocurrency to withdraw.
     * @param string $address     The address to send the coins to.
     * @param bool   $autoConfirm If auto_confirm is true, then the withdrawal will be performed without an email
     *                            confirmation.
     * @param string $ipnUrl      Optionally set an IPN handler to receive notices about this transaction. If ipn_url
     *                            is empty then it will use the default IPN URL in your account.
     * @return array|mixed
     * @throws WincashpayException
     * @throws JsonParseException
     * @throws MessageSendException
     */
    public function createWithdrawal ($amount, $currency, $address, $autoConfirm = false)
    {
        $req = [
            'amount'       => $amount,
            'currency'     => $currency,
            'address'      => $address,
            'auto_confirm' => $autoConfirm ? 1 : 0,
        ];

        return $this->api_call(WincashpayCommand::CREATE_WITHDRAWAL, $req);
    }

    /**
     * Get withdrawal information via withdrawal ID
     *
     * @param string $refID the withdrawal ID
     * @return array|mixed
     * @throws WincashpayException
     * @throws JsonParseException
     * @throws MessageSendException
     */
    public function getWithdrawalInfo ($refID)
    {
        $req = [
            'id' => $refID
        ];

        return $this->api_call(WincashpayCommand::GET_WITHDRAWAL_INFO, $req);
    }

    /**
     * Get withdrawal information via withdrawal ID
     *
     * @param string $refID the conversion ID
     * @return array|mixed
     * @throws WincashpayException
     * @throws JsonParseException
     * @throws MessageSendException
     */
    public function getConversionInfo ($refID)
    {
        $req = [
            'id' => $refID
        ];

        return $this->api_call(WincashpayCommand::GET_CONVERSION_INFO, $req);
    }

    /**
     * Creates a transfer from your account to a specified merchant.<br />
     *
     * @param number $amount      The amount of the transaction (floating point to 8 decimals).
     * @param string $currency    The cryptocurrency to withdraw.
     * @param string $merchant    The merchant ID to send the coins to.
     * @param bool   $autoConfirm If auto_confirm is true, then the transfer will be performed without an email
     *                            confirmation.
     * @return array|mixed
     * @throws WincashpayException
     * @throws JsonParseException
     * @throws MessageSendException
     */
    public function createTransfer ($amount, $currency, $merchant, $autoConfirm = false)
    {
        $req = [
            'amount'       => $amount,
            'currency'     => $currency,
            'merchant'     => $merchant,
            'auto_confirm' => $autoConfirm ? 1 : 0,
        ];

        return $this->api_call(WincashpayCommand::CREATE_TRANSFER, $req);
    }
    

}
