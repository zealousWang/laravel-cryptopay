<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetupWincashpayTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $prefix = 'wincashpay_';

        Schema::create($prefix . 'transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('txn_id')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('amount')->nullable();
            $table->string('currency')->nullable();
            $table->integer('confirms_needed')->nullable();
            $table->string('payment_address')->nullable();
            $table->string('qrcode_url')->nullable();
            $table->string('received')->nullable();
            $table->string('recv_confirms')->nullable();
            $table->string('status')->nullable();
            $table->string('status_text')->nullable();
            $table->string('status_url')->nullable();
            $table->string('timeout')->nullable();
            $table->string('type')->nullable();
            $table->text('payload')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($prefix . 'transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('amount');
            $table->string('currency', 10);
            $table->string('merchant')->nullable();
            $table->boolean('auto_confirm')->default(0);
            $table->string('txn_id', 128)->unique();
            $table->unsignedTinyInteger("status");
            $table->timestamps();
        });

        Schema::create($prefix . 'withdrawals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('amount');
            $table->string('currency', 10);
            $table->string('address')->nullable();
            $table->boolean('auto_confirm')->default(0);
            $table->text('note')->nullable();
            $table->string('txn_id', 128)->unique();
            $table->unsignedTinyInteger("status");
            $table->timestamps();
        });

        Schema::create($prefix . 'callback_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address', 128);
            $table->string('currency', 10);
            $table->text('public_key')->nullable();
            $table->unique(['address', 'currency']);
            $table->timestamps();
        });

        Schema::create($prefix . 'deposits', function (Blueprint $table) use ($prefix) {
            $table->bigIncrements('id');

            $table->string('address', 128)->index();

            $table->string('txn_id', 128)->unique();
            $table->tinyInteger('status');
            $table->string('status_text');

            $table->string('currency', 10);
            $table->unsignedTinyInteger('confirms');
            $table->string('amount');
            $table->string('fee')->nullable();
            $table->timestamps();
        });

        Schema::create($prefix . 'ipns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ipn_id', 128)->unique();
            $table->string('merchant');
            $table->string('ipn_type', 32);
            $table->string('txn_id')->indexed();
            $table->tinyInteger('status')->indexed();
            $table->string('status_text');
            $table->string('currency1');
            $table->string('currency2');
            $table->string('amount1');
            $table->string('amount2');
            $table->string('fee');
            $table->string('buyer_name')->nullable();
            $table->string('item_name')->nullable();
            $table->string('item_number')->nullable();
            $table->text('custom')->nullable();
            $table->string('send_tx')->nullable();
            $table->string('received_amount')->nullable();
            $table->string('received_confirms')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $prefix = 'wincashpay_';
        
        Schema::dropIfExists($prefix . 'ipns');
        Schema::dropIfExists($prefix . 'withdrawals');
        Schema::dropIfExists($prefix . 'transfers');
        Schema::dropIfExists($prefix . 'transactions');
        Schema::dropIfExists($prefix . 'callback_addresses');
        Schema::dropIfExists($prefix . 'deposits');
    }
}
