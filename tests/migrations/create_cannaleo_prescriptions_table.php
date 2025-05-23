<?php

use AmaizingCompany\CannaleoClient\Support\DatabaseHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(DatabaseHelper::getTableName('prescriptions'), function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('path');
            $table->string('signature_city');
            $table->timestamp('signature_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(DatabaseHelper::getTableName('prescriptions'));
    }
};
