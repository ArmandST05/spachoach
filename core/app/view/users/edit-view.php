<?php
$user = UserData::getById($_GET["id"]);
$userTypes = UserTypeData::getAll();
?>
 
<div class="row">
  <div class="col-md-12">
    <h1>Editar Usuario</h1>
    <br>
    <form class="form-horizontal" method="post" id="editUser" action="index.php?action=users/update" role="form">
      <!-- Nombre -->
      <div class="form-group">
        <label for="name" class="col-lg-2 control-label">Nombre*</label>
        <div class="col-md-6">
          <input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control" id="name" placeholder="Nombre" required>
        </div>
      </div>

      <!-- Apellido -->
      <div class="form-group">
        <label for="lastname" class="col-lg-2 control-label">Apellido</label>
        <div class="col-md-6">
          <input type="text" name="lastname" value="<?php echo $user->lastname; ?>" class="form-control" id="lastname" placeholder="Apellido">
        </div>
      </div>

      <!-- Nombre de Usuario -->
      <div class="form-group">
        <label for="username" class="col-lg-2 control-label">Nombre de usuario*</label>
        <div class="col-md-6">
          <input type="text" name="username" value="<?php echo $user->username; ?>" class="form-control" id="username" placeholder="Nombre de usuario" required>
        </div>
      </div>

      <!-- Correo Electrónico -->
      <div class="form-group">
        <label for="email" class="col-lg-2 control-label">Correo Electrónico</label>
        <div class="col-md-6">
          <input type="email" name="email" value="<?php echo $user->email; ?>" class="form-control" id="email" placeholder="Correo Electrónico">
        </div>
      </div>

      <!-- Contraseña -->
      <div class="form-group">
        <label for="password" class="col-lg-2 control-label">Contraseña</label>
        <div class="col-md-6">
          <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña">
          <p class="help-block">La contraseña sólo se modificará si escribes algo, en caso contrario no se modifica.</p>
        </div>
      </div>

      <!-- Imagen de Perfil -->
      <div class="form-group">
        <label for="image" class="col-lg-2 control-label">Imagen de Perfil</label>
        <div class="col-md-6">
          <input type="text" name="image" value="<?php echo $user->image; ?>" class="form-control" id="image" placeholder="URL de la imagen">
        </div>
      </div>

      <!-- Tipo de Usuario -->
      <div class="form-group">
        <label for="user_type" class="col-lg-2 control-label">Tipo de usuario</label>
        <div class="col-md-6">
          <select class="form-control" name="user_type" id="user_type">
            <option value="">-- SELECCIONE --</option>
            <?php foreach ($userTypes as $type) : ?>
              <option value="<?php echo $type->id; ?>" <?php echo ($user->user_type == $type->id) ? "selected" : "" ?>>
                <?php echo $type->description; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <!-- Teléfono -->
      <div class="form-group">
        <label for="phone" class="col-lg-2 control-label">Teléfono</label>
        <div class="col-md-6">
          <input type="text" name="phone" value="<?php echo $user->phone; ?>" class="form-control" id="phone" placeholder="Teléfono">
        </div>
      </div>

      <!-- Tipo de Contacto -->
      <div class="form-group">
        <label for="type_contact" class="col-lg-2 control-label">Tipo de Contacto</label>
        <div class="col-md-6">
          <input type="text" name="type_contact" value="<?php echo $user->type_contact; ?>" class="form-control" id="type_contact" placeholder="Tipo de Contacto">
        </div>
      </div>

      <!-- Fecha de Inscripción -->
      <div class="form-group">
        <label for="inscription_date" class="col-lg-2 control-label">Fecha de Inscripción</label>
        <div class="col-md-6">
          <input type="date" name="inscription_date" value="<?php echo $user->inscription_date; ?>" class="form-control" id="inscription_date">
        </div>
      </div>

      <!-- Fecha de Nacimiento -->
      <div class="form-group">
        <label for="birthdate" class="col-lg-2 control-label">Fecha de Nacimiento</label>
        <div class="col-md-6">
          <input type="date" name="birthdate" value="<?php echo $user->birthdate; ?>" class="form-control" id="birthdate">
        </div>
      </div>

      <!-- Residencia -->
      <div class="form-group">
        <label for="residence" class="col-lg-2 control-label">Residencia</label>
        <div class="col-md-6">
          <input type="text" name="residence" value="<?php echo $user->residence; ?>" class="form-control" id="residence" placeholder="Residencia">
        </div>
      </div>

      <!-- Contacto de Emergencia -->
      <div class="form-group">
        <label for="emergency_contact" class="col-lg-2 control-label">Contacto de Emergencia</label>
        <div class="col-md-6">
          <input type="text" name="emergency_contact" value="<?php echo $user->emergency_contact; ?>" class="form-control" id="emergency_contact" placeholder="Contacto de Emergencia">
        </div>
      </div>

      <!-- Estado Activo -->
      <div class="form-group">
        <label for="is_active" class="col-lg-2 control-label">¿Activo?</label>
        <div class="col-md-6">
          <input type="checkbox" name="is_active" value="1" <?php echo ($user->is_active == 1) ? 'checked' : ''; ?>>
        </div>
      </div>

      <!-- Botón de Enviar -->
      <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
          <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
          <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
        </div>
      </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </div>
</div>
