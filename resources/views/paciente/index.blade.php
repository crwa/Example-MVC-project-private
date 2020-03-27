@extends('layouts.admin')

@section('content')
<div class="pacientes">
<h1><i class="fas fa-diagnoses text-secondary"></i> Lista de Pacientes Cadastrados</h1>
<hr>
	<div class="table-responsive">
	<?php if(!isset($_GET['page']) || $_GET['page'] == "1"): ?>
		<h3 class="text-uppercase t-800 text-gray" style="    margin-bottom: 10px;">Total de Pacientes: <span><?php echo count($totalPacientes); ?></span> </h3>
	<?php endif; ?>
	<table class="table table-sm">
		<thead>
			<tr>
				<th>Médico</th>
				<th>Centro</th>
				<th>Nome</th>
				<th>Nascimento</th>
				<th>Data da Consulta</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$userId = Auth::id();
			if($userId == '8' || $userId == '57'){
			?>
			<input type="hidden" name="adm-total" id="admin-total" value="<?php echo count($totaladm); ?>">
			@foreach($pacientesadmin as $padm)
			<?php

			foreach ($medicos as $medico) {
			 	if($medico->user_id == $padm->id_medico){
			 		$med = 0;
			 		$un = 0;
			 		foreach ($users as $user) {
			 			if($user->id == $medico->user_id ){
			 				$nome_med = $user->name;
			 				
							//$userId = Auth::id();
							//if($userId == $padm->id_medico): 
							?>
							<tr>
								<td>{{ $nome_med }}</td>
								<td class="centro-medico-<?php echo $user->id; ?>-<?php echo $med++; ?>"></td>
								<td>{{ $padm->nome }}</td>
								<td>{{ $padm->nascimento->format('d/m/Y') }}</td>
								<td>{{ $padm->data_consulta->format('d/m/Y') }}</td>
								<td class="text-right">
									<form action="{{ route('pacientes.edit', ['id' => $padm->id ]) }}" method="POST">
				    					@csrf
										<button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Ver/Editar</a>
				    				</form>
								</td>
								<td class="text-right">
									<form action="{{ route('pacientes.destroy', ['id' => $padm->id ]) }}" method="POST">
				    					@method('DELETE')
				    					@csrf
										<button type="submit" class="btn btn-primary btn-sm btn-secondary"><i class="fas fa-times-circle"></i> Apagar</a>
				    				</form>
				    			</td>
							</tr>
							<script type="text/javascript">
								var idm = '<?php echo $medico->id; ?>';
								$.get( "https://www.reumatologia.org.br/epifibro/ajaxUnidade?idm="+idm, function( data ) {
								  $( ".centro-medico-<?php echo $user->id; ?>-<?php echo $un++; ?>" ).html( data );
								});
								var totaladm = jQuery('#admin-total').val();
								jQuery('h3.text-uppercase.t-800.text-gray span').text(totaladm);
							</script>
							<?php //endif; ?>
			<?php
							
						}
			 		}

			 	}
			 } 

			?>
			@endforeach
			<?php 
				}else{
			?>
			@foreach($pacientes as $paciente)
			<?php

			foreach ($medicos as $medico) {
			 	if($medico->user_id == $paciente->id_medico){
			 		$med = 0;
			 		$un = 0;
			 		foreach ($users as $user) {
			 			if($user->id == $medico->user_id ){
			 				$nome_med = $user->name;
			 				
							$userId = Auth::id();
							if($userId == $paciente->id_medico || $userId == '8' || $userId == '57'): 
							?>
							<tr>
								<td>{{ $nome_med }}</td>
								<td class="centro-medico-<?php echo $user->id; ?>-<?php echo $med++; ?>"></td>
								<td>{{ $paciente->nome }}</td>
								<td>{{ $paciente->nascimento->format('d/m/Y') }}</td>
								<td>{{ $paciente->data_consulta->format('d/m/Y') }}</td>
								<td class="text-right">
									<form action="{{ route('pacientes.edit', ['id' => $paciente->id ]) }}" method="POST">
				    					@csrf
										<button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Ver/Editar</a>
				    				</form>
								</td>
								<td class="text-right">
									<form action="{{ route('pacientes.destroy', ['id' => $paciente->id ]) }}" method="POST">
				    					@method('DELETE')
				    					@csrf
										<button type="submit" class="btn btn-primary btn-sm btn-secondary"><i class="fas fa-times-circle"></i> Apagar</a>
				    				</form>
				    			</td>
							</tr>
							<script type="text/javascript">
								var idm = '<?php echo $medico->id; ?>';
								$.get( "https://www.reumatologia.org.br/epifibro/ajaxUnidade?idm="+idm, function( data ) {
								  $( ".centro-medico-<?php echo $user->id; ?>-<?php echo $un++; ?>" ).html( data );
								});
							</script>
							<?php endif; ?>
			<?php
							
						}
			 		}

			 	}
			 } 

			?>
			@endforeach
		<?php }?>
		</tbody>
	</table>
	</div>
	<?php if($userId == '8' || $userId == '57'): ?>
	{{ $pacientesadmin->links() }}
	<?php endif; ?>
</div>
@endsection
