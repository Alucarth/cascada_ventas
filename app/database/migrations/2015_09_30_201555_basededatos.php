<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Basededatos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		 Schema::dropIfExists('users');
    	Schema::dropIfExists('sales');
    	Schema::dropIfExists('products');
		  Schema::create('users',function($table){
            $table->increments('id');
            $table->string('name',100);
            $table->string('username',100)->unique();
            $table->string('email',100)->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('sales', function($t)
        {
            $t->increments('id');
            $t->integer('client_id');
            $t->integer('user_id');
            $t->integer('branch_id');
            $t->integer('account_id');
            $t->integer('invoice_status_id')->default(1);
            $t->integer('country_id')->nullable();  
            $t->timestamps();
            $t->softDeletes();

            $t->string('invoice_number');
            $t->float('discount');
            $t->string('po_number');
            $t->date('invoice_date')->nullable();
            $t->date('due_date')->nullable();
            $t->text('terms');
            $t->text('public_notes');
            $t->boolean('is_deleted');            
            $t->boolean('is_recurring');
            $t->integer('frequency_id');
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->timestamp('last_sent_date')->nullable();  
            $t->integer('recurring_invoice_id')->nullable();

            $t->string('branch');

            $t->string('address1');
            $t->string('address2');
            $t->string('city');
            $t->string('state');
            $t->string('work_phone');
            
            $t->string('nit');
            $t->string('name');

            $t->string('number_autho');
            $t->date('deadline');
            $t->string('key_dosage');

            $t->string('activity_pri');
            $t->string('activity_sec1');
            $t->string('activity_sec2');

            $t->string('law');

            $t->string('title');
            $t->string('subtitle');

            $t->string('control_code');


            $t->string('tax_name');
            $t->decimal('tax_rate', 13, 6);

            $t->decimal('subtotal', 13, 6);//subtotal

            $t->decimal('amount', 13, 6);//total a pagar

            $t->decimal('fiscal', 13, 6);//Importe credito fiscal

            $t->decimal('balance', 13, 6);

            $t->decimal('ice', 13, 6);
        
            $t->longText('qr'); 
                                             
        });

        Schema::create('products', function($t)
        {
            $t->increments('id');
            $t->integer('account_id');
            $t->integer('user_id');
            $t->unsignedInteger('sale_id')->index();
            $t->integer('product_id')->nullable();
            $t->timestamps();
            $t->softDeletes();

            $t->string('product_key');
            $t->text('notes');

            $t->decimal('qty', 13, 6); 

            $t->decimal('cost', 13, 6);

            $t->decimal('boni', 13, 6);   

            $t->decimal('desc', 13, 6);     

            $t->decimal('line_total', 13, 6);

            $t->string('tax_name');
            $t->decimal('tax_rate', 13, 6);

            $t->foreign('sale_id')->references('id')->on('sales');                                  
        });
        
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		 Schema::dropIfExists('users');
    	Schema::dropIfExists('sales');
    	Schema::dropIfExists('products');
	}

}
