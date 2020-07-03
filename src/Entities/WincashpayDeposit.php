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

/**
 * Class Transaction
 *
 * @package Wincash\Payment\Models
 * @property number         id
 * @property string         address
 * @property string         txn_id
 * @property int            status
 * @property string         status_text
 * @property string         currency
 * @property int            confirms
 * @property string         amount
 * @property string         amountf
 * @property string         fee
 * @property string         feef
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class WincashpayDeposit extends Model
{
    public $fillable = [
        'address', 'txn_id', 'status', 'status_text',
        'currency', 'confirms', 'amount', 'fee'
    ];
}