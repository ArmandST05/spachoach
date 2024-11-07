<?php
if(count($_POST) > 0){
    // Crear objeto UserData
    $user = new UserData();
    
    // Asignar los valores del formulario a las propiedades del objeto
    $user->name = $_POST["name"];
    $user->lastname = $_POST["lastname"];
    $user->username = $_POST["username"];
    $user->email = $_POST["email"];
    $user->password = sha1(md5($_POST["password"])); // Seguridad básica (considera mejorar la seguridad del almacenamiento de contraseñas)
    $user->birthdate = $_POST["birthdate"];
    $user->phone = $_POST["phone"];
    $user->type_contact = isset($_POST["type"]) ? $_POST["type"] : ''; // Verificación de campo opcional
    $user->address = $_POST["address"];
    $user->emergency_contact = $_POST["emergency_contact"];
    $user->inscription_date = $_POST["inscription_date"];
    $user->user_type = $_POST["user_type"];
    
    // Verificar si el campo de imagen fue enviado (opcional)
    $user->image = isset($_POST["image"]) ? $_POST["image"] : ''; 
    
    // Verificar si el campo de token de autenticación fue enviado (opcional)
    $user->authentication_token = isset($_POST["authentication_token"]) ? $_POST["authentication_token"] : '';

    // Llamada al método para guardar el usuario en la base de datos
    $user->add();
    
    // Redirigir a la vista de usuarios después de agregar
    print "<script>window.location='index.php?view=users/index';</script>";
}
?>
