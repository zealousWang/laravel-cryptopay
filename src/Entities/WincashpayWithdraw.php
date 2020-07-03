<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 19/09/2017
 * Time: 12:31 PM
 */

namespace Wincash\Payment\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class WincashpayWithdraw extends Model
{
    public $fillable = [
        'amount', 'currency', 'address',
        'auto_confirm',
        'note',  'status', 'status_text', 'txn_id',
    ];
}