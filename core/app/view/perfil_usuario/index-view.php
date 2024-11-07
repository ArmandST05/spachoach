<?php
// Suponiendo que UserData y su método getLoggedIn() están definidos y disponibles
$user = UserData::getLoggedIn();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <style>
        .disabled-input {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            cursor: not-allowed;
        }
        .hidden {
            display: none;
        }
        .centered-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
    </style>
</head>
<body>
    <div class="centered-form">
        <h2 class="mb-4">Datos del Usuario</h2>
        <form id="userForm" method="post" action="update_profile.php">
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" class="form-control disabled-input" value="<?php echo htmlspecialchars($user->name); ?>" disabled>
            </div>
            <div class="form-group">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" class="form-control disabled-input" value="<?php echo htmlspecialchars($user->username); ?>" disabled>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control disabled-input" value="<?php echo htmlspecialchars($user->password); ?>" disabled>
            </div>
            <div class="form-group">
                <button type="button" id="editButton" class="btn btn-primary">Editar</button>
                <button type="submit" id="saveButton" class="btn btn-success hidden">Guardar</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('editButton').addEventListener('click', function() {
            var inputs = document.querySelectorAll('#userForm input');
            inputs.forEach(function(input) {
                input.disabled = false;
                input.classList.remove('disabled-input');
            });
            document.getElementById('editButton').classList.add('hidden');
            document.getElementById('saveButton').classList.remove('hidden');
        });
    </script>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
