<div class="row">
	<div class="col-md-12">
		<a href="index.php?view=users/new" class="btn btn-default pull-right"><i class="fas fa-plus"></i> Nuevo Usuario</a>
		<h1>Lista de Usuarios</h1>
		<br>
		<?php
		// Obtener todos los usuarios de la base de datos
		$users = UserData::getAll();

		// Verificar si hay usuarios
		if (count($users) > 0) {
		?>
			<table class="table table-bordered table-hover">
				<thead>
					<th>Nombre completo</th>
					<th>Nombre de usuario</th>
					<th>Email</th>
					<th>Activo</th>
					<th>Admin</th>
					<th>Fecha de nacimiento</th>
					<th>Número de teléfono</th>
					<th>Tipo de contacto</th>
					<th>Domicilio</th>
					<th>Contacto de emergencia</th>
					<th>Fecha de inscripción</th>
					<th>Acciones</th>
				</thead>
				<?php
				foreach ($users as $user) {
				?>
					<tr>
						<td><?php echo $user->name . " " . $user->lastname; ?></td>
						<td><?php echo $user->username; ?></td>
						<td><?php echo $user->email; ?></td>
						<td>
							<?php if ($user->is_active) : ?>
								<i class="glyphicon glyphicon-ok"></i>
							<?php endif; ?>
						</td>
						<td>
							<?php if ($user->user_type == "su") : ?>
								<i class="glyphicon glyphicon-ok"></i>
							<?php endif; ?>
						</td>
						<td><?php echo $user->birthdate; ?></td>
						<td><?php echo $user->phone; ?></td>
						<td><?php echo $user->type_contact; ?></td>
						<td><?php echo $user->residence; ?></td>
						<td><?php echo $user->emergency_contact; ?></td>
						<td><?php echo $user->inscription_date; ?></td>
						<td style="width:130px;">
							<a href="index.php?view=users/edit&id=<?php echo $user->id; ?>" style="background-color: #2471a3; color: white;" class="btn btn-xs"><i class="fas fa-pencil-alt"></i> Editar</a>
							<a href='index.php?action=users/update-status&id=<?php echo $user->id ?>&isActive=0' style="background-color: #5499c7; color: white;" class='btn btn-xs' onClick='return confirmDelete()'><i class="fas fa-trash"></i> Eliminar</a>
						</td>
					</tr>
				<?php
				}
				echo "</table>";
			} else {
				echo "<p>No hay usuarios registrados.</p>";
			}
		?>
	</div>
</div>

<script type="text/javascript">
	function confirmDelete() {
		return confirm("¿Seguro que deseas eliminar el usuario?");
	}
</script>
