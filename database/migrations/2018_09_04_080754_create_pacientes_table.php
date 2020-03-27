<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->int('id_medico');
            $table->string('nome');
            $table->date('nascimento');
            $table->string('cpf',14);
            $table->string('rg',14);
            $table->string('uf',2);
            $table->string('sexo',1);
            $table->string('estado_civil',15);
            $table->string('escolaridade',50);
            $table->string('setor',15);
            $table->string('dor_3_meses')->nullable();
            $table->string('tipo_atendimento')->nullable();
            $table->string('opiniao_fibromialgia')->nullable();
            $table->string('situacao_profissional')->nullable();
            $table->string('auxilio_doenca')->nullable();
            $table->string('renda_familiar')->nullable();
            $table->string('ha_qto_tempo_tem_dor')->nullable();
            $table->date('data_consulta');
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
        Schema::dropIfExists('pacientes');
    }
}
