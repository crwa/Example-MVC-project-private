<?php

namespace App\Http\Controllers;

use App\Paciente;
use App\Medico;
use App\User;
use App\Unidades;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['role:admin|medico|diretor']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $pacientes = Paciente::latest()->paginate(9999)->where('id_medico', $id);
        $pacientesadmin = Paciente::latest()->paginate(15);
        $totalPacientes = Paciente::latest()->paginate(9999)->where('id_medico', $id);
        $totaladm = Paciente::latest()->paginate(9999);
        $medicos = DB::table('medicos')->get();
        $users =  DB::table('users')->get();
        return view('paciente.index', ['pacientes' => $pacientes, 'medicos' => $medicos, 'users' => $users, 'totalPacientes' => $totalPacientes, 'pacientesadmin' => $pacientesadmin, 'totaladm' => $totaladm]);
        //return view('paciente.index', compact('pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pacientes = new Paciente;
        return view('paciente.create', compact('pacientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'paciente.data_consulta' => 'required|date_format:d/m/Y',
            'paciente.id_medico' => 'required|max:255',
            'paciente.nome' => 'required|max:255',
            'paciente.sexo' => 'required',
            'paciente.uf' => 'required|max:2',
            'paciente.nascimento' => 'required|date_format:d/m/Y',
            'paciente.rg' => 'required',
            'paciente.estado_civil' => 'required',
            'paciente.escolaridade' => 'required',
            'paciente.setor' => 'required'
        ]);
        try {
            $paciente = collect($request->paciente)->toArray();
            $paciente['nascimento'] = Carbon::createFromFormat('d/m/Y', $paciente['nascimento']);
            $paciente['data_consulta'] = Carbon::createFromFormat('d/m/Y', $paciente['data_consulta']);
            $paciente = Paciente::create($paciente);
            $paciente->searchable();
            $msg = 'Registro salvo com sucesso.';
        } catch (\Exception $e) {
            $msg = 'Erro ao gravar o registro.';
            Log::error($e->getMessage());
        }
        flash($msg)->overlay();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function show(Paciente $paciente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function edit(Paciente $paciente)
    {
        $id = $_GET['id'];
        $pacientes = DB::table('pacientes')->where('id',$id)->get();
        
        return view('paciente.edit', ['pacientes' => $pacientes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paciente $paciente)
    {
        $id = $request->get('id_m');

        try {
            // abrindo a requisição para metodos
            $paciente = \App\Paciente::find($id);
            // coletando os paremetros
            //$paciente->id_medico = $request->get('id_medico');
            $paciente->data_consulta = $request->get('data_consulta');
            $paciente->nome = $request->get('nome');
            $paciente->nascimento = $request->get('nascimento');
            $paciente->rg = $request->get('rg');
            $paciente->cpf = $request->get('cpf');
            $paciente->uf = $request->get('uf');
            $paciente->sexo = $request->get('sexo');
            $paciente->estado_civil = $request->get('estado_civil');
            $paciente->escolaridade = $request->get('escolaridade');
            $paciente->setor = $request->get('setor');
            /*$paciente->dor_3_meses = $request->get('name');
            $paciente->tipo_atendimento = $request->get('name');
            $paciente->opiniao_fibromialgia = $request->get('name');
            $paciente->situacao_profissional = $request->get('name');
            $paciente->auxilio_doenca = $request->get('name');
            $paciente->renda_familiar = $request->get('name');
            $paciente->ha_qto_tempo_tem_dor = $request->get('name');
            $paciente->data_consulta = $request->get('data_consulta');*/
            
            // salvando dados no banco
            $paciente->save();
            
            // enviando mensagem de sucesso
            $msg = 'Paciente atualizado com sucesso.';
        } catch (\Exception $e) {
            $msg = 'Erro ao gravar o registro.';
            Log::error($e->getMessage());
        }
            flash($msg)->overlay();
            // fazendo o GET dos dados novamente para retornar atualizados
            $pacientes = DB::table('pacientes')->where('id',$id)->get();
            
            // retornando para a página
        return view('paciente.edit', ['pacientes' => $pacientes]);
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Paciente::findOrFail($id)->delete()) {
            flash('Registro apagado com sucesso.')->overlay();
        } else {
            flash('Erro ao apagar o registro.')->overlay();
        }

        return back();
    }

    /**
     * List pacientes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function list(Request  $request)
    {
        $pacientes = Paciente::search($request->q)->get();
        return $pacientes;
    }

    public function ajaxUnidade()
    {
        $id_medico = $_GET['idm'];
        $unidadesId = DB::table('medico_unidades')->where('medico_id', $id_medico)->value('unidades_id');
        $unidades = DB::table('unidades')->where('id', $unidadesId)->value('razao_social');

        return $unidades;
    }
}
