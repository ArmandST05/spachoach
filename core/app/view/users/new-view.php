<?php
$user_types = UserTypeData::getAll();
?>
<div class="row">
  <div class="col-md-12">
    <h1>Agregar Usuario</h1>
    <br>
    <form class="form-horizontal" method="post" action="index.php?action=users/add" role="form">
      <div class="form-group">
        <label for="name" class="col-lg-2 control-label">Nombre*</label>
        <div class="col-md-6">
          <input type="text" name="name" class="form-control" id="name" placeholder="Nombre" required>
        </div>
      </div>
      
      <div class="form-group">
        <label for="lastname" class="col-lg-2 control-label">Apellido*</label>
        <div class="col-md-6">
          <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Apellido" required>
        </div>
      </div>
      
      <div class="form-group">
        <label for="username" class="col-lg-2 control-label">Nombre de Usuario*</label>
        <div class="col-md-6">
          <input type="text" name="username" class="form-control" id="username" placeholder="Nombre de Usuario" required>
        </div>
      </div>

      <div class="form-group">
        <label for="email" class="col-lg-2 control-label">Correo*</label>
        <div class="col-md-6">
          <input type="email" name="email" class="form-control" id="email" placeholder="Correo" required>
        </div>
      </div>

      <div class="form-group">
        <label for="password" class="col-lg-2 control-label">Contraseña</label>
        <div class="col-md-6">
          <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña">
        </div>
      </div>

      <div class="form-group">
        <label for="birthdate" class="col-lg-2 control-label">Fecha de nacimiento*</label>
        <div class="col-md-6">
          <input type="date" name="birthdate" class="form-control" id="birthdate" required>
        </div>
      </div>

      <div class="form-group">
        <label for="phone" class="col-lg-2 control-label">Número de teléfono*</label>
        <div class="col-md-6">
          <input type="tel" name="phone" class="form-control" id="phone" placeholder="Número de teléfono" required>
        </div>
      </div>

      <div class="form-group">
        <label for="type" class="col-lg-2 control-label">Tipo de contacto</label>
        <div class="col-md-6">
          <select name="type" id="type" class="form-control">
            <option value="Llamada telefónica">Llamada telefónica</option>
            <option value="Whatsapp">Whatsapp</option>
            <option value="Correo electrónico">Correo electrónico</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="address" class="col-lg-2 control-label">Domicilio*</label>
        <div class="col-md-6">
          <input type="text" name="address" class="form-control" id="address" placeholder="Domicilio" required>
        </div>
      </div>

      <div class="form-group">
        <label for="emergency_contact" class="col-lg-2 control-label">Contacto de emergencia*</label>
        <div class="col-md-6">
          <input type="text" name="emergency_contact" class="form-control" id="emergency_contact" placeholder="Contacto de emergencia" required>
        </div>
      </div>

      <div class="form-group">
        <label for="inscription_date" class="col-lg-2 control-label">Fecha de inscripción*</label>
        <div class="col-md-6">
          <input type="date" name="inscription_date" class="form-control" id="inscription_date" required>
        </div>
      </div>

      <div class="form-group">
        <label for="user_type" class="col-lg-2 control-label">Tipo de Usuario</label>
        <div class="col-md-6">
          <select class="form-control" name="user_type" id="user_type">
            <option value="">-- SELECCIONE --</option>
            <?php foreach ($user_types as $type) : ?>
              <option value="<?php echo $type->id; ?>"><?php echo $type->description; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
          <button type="submit" class="btn btn-primary">Agregar Usuario</button>
        </div>
      </div>
    </form>
  </div>
</div>

como quedaria mi codigo entonces?