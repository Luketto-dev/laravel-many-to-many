<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();

            //colonna che rappresenta la foreign key
            //il nome deve esser composto_
            //-nome tabella a cui fa riferimento, al singolare
            //-nome colonna a cui fa riferimento
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")  // la colonna user_id sarà una foreign key
                ->references("id") // la foreign key farà riferimento ad una colonna "id"
                ->on("users"); // presente nella tabella "users"

            //versione semplificata per creare una fk
            //$table-> foreignId("user_id")
                //->constrained();
            
            $table->string("address")->nullable();
            $table->string("city")->nullable();
            $table->string("province")->nullable();
            $table->string("phone")->nullable();
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
        Schema::dropIfExists('user_details');
    }
}
