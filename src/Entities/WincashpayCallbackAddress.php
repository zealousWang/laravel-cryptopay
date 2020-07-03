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
 * @property string         currency
 * @property string         public_key
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class WincashpayCallbackAddress extends Model
{
    public $fillable = [
        'address', 'currency', 'public_key'
    ];
}