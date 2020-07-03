<?php

namespace Wincash\Payment\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class WincashpayTransaction extends Model {

    use SoftDeletes;

    protected $fillable = [
        'address',
        'amount',
        'currency',
        'confirms_needed',
        'payment_address',
        'qrcode_url',
        'received',
        'recv_confirms',
        'status',
        'status_text',
        'status_url',
        'timeout',
        'txn_id',
        'type',
        'payload'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'double',
        'received' => 'double',
        'payload' => 'array'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];
}
