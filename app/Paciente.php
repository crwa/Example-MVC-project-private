<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use Searchable;

    public $asYouType = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'data_consulta',
        'id_medico',
        'nome',
        'nascimento',
        'cpf',
        'rg',
        'uf',
        'sexo',
        'estado_civil',
        'escolaridade',
        'setor',
        'dor_3_meses',
        'tipo_atendimento',
        'opiniao_fibromialgia',
        'situacao_profissional',
        'auxilio_doenca',
        'renda_familiar',
        'ha_qto_tempo_tem_dor'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['nascimento','data_consulta'];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'pacientes_index';
    }


    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }

    /**
     * Get the Forms associated with the paciente.
     */
    public function forms()
    {
        return $this->hasMany('App\Form');
    }

    /**
     * Get the OutraDoenca record associated with the user.
     */
    public function outra_doenca()
    {
        return $this->hasMany('App\OutraDoenca');
    }

    /**
     * Get the SintomasComorbidades record associated with the user.
     */
    public function sintomas_comorbidades()
    {
        return $this->hasMany('App\SintomasComorbidades');
    }

    /**
     * Get the TerapeuticasMedicamentosa record associated with the user.
     */
    public function terapeuticas_medicamentosa()
    {
        return $this->hasMany('App\TerapeuticasMedicamentosa');
    }

    /**
     * Get the TerapeuticasMedicamentosa record associated with the user.
     */
    public function terapeuticas_medicamentosas_prescricao()
    {
        return $this->hasMany('App\TerapeuticasMedicamentosasPrescricao');
    }

    /**
     * Get the TerapeuticasNaoMedicamentosa record associated with the user.
     */
    public function terapeuticas_nao_medicamentosa()
    {
        return $this->hasMany('App\TerapeuticasNaoMedicamentosa');
    }
}
