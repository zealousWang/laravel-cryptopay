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


class WincashpayIPN extends Model
{
    public $fillable = [
        'ipn_id', 'merchant', 'ipn_type', 'address', 'txn_id', 'status', 'status_text',
        'currency', 'confirms', 'amount',  'fee'
    ];
}