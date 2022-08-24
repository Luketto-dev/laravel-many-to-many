<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryFkToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger("category_id")->nullable()->after("user_id");
            
            $table->foreign("category_id")->references("id")->on("categories");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            
            // per cancellare la foreign key non posso fare solo il dropcolumn, devo annullare prima la fk e poi togliere la colonna
            $table->dropForeign("posts_category_id_foreign");// richiede il nome della relazione che è stata creata
            $table->dropColumn("category_id");
        });
    }
}
