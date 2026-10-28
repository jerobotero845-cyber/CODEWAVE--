<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de satisfacción - Resultado</title>
    <style type="text/css">
      body {
        font-family: Arial, sans-serif;
        background-color: #121212;
        color: #ffffff;
        padding: 20px;
      }
      table {
        border: solid 2px #7e7c7c;
        border-collapse: collapse;
        width: 100%;
        max-width: 800px;
        margin: 20px 0;
      }
      th {
        background-color: #edf797;
        color: #000;
        border: solid 1px #7e7c7c;
        padding: 8px;
      }
      td {
        border: solid 1px #7e7c7c;
        padding: 8px;
        text-align: center;
      }
      a {
        color: #edf797;
        text-decoration: none;
        font-weight: bold;
      }
    </style>
</head>
<body>

<?php
// Validamos datos del servidor
$user = "root";
$pass = "";
$host = "localhost";
$datab = "satisfaccion";

// Conectamos a la base de datos
$connection = mysqli_connect($host, $user, $pass, $datab);

// Verificamos la conexión
if (!$connection) 
    {
      echo "No se pudo conectar con el servidor" . mysql_error();
    }
  else
    {
      echo "<b><h3>Hemos conectado al servidor y seleccionado la base de datos correctamente.</h3></b>";
    }


// Capturamos y sanitizamos los datos recibidos del formulario
$nombre       = isset($_POST["nombre"]) ? mysqli_real_escape_string($connection, $_POST["nombre"]) : '';
$apellido     = isset($_POST["apellido"]) ? mysqli_real_escape_string($connection, $_POST["apellido"]) : '';
$util         = isset($_POST["util"]) ? mysqli_real_escape_string($connection, $_POST["util"]) : '';
$comentario   = isset($_POST["comentario"]) ? mysqli_real_escape_string($connection, $_POST["comentario"]) : '';
$calificacion = isset($_POST["calificacion"]) ? (int)$_POST["calificacion"] : 0;

// Insertamos datos en la tabla 'musica'
if (!empty($nombre) && !empty($apellido)) {
    $instruccion_SQL = "INSERT INTO musica (nombre, apellido, util, comentario, calificacion)
                        VALUES ('$nombre', '$apellido', '$util', '$comentario', '$calificacion')";
    
    $resultado = mysqli_query($connection, $instruccion_SQL);

    if ($resultado) {
        echo "<p style='color: #4CAF50;'><b>¡Registro guardado exitosamente!</b></p>";
    } else {
        echo "<p style='color: #f44336;'><b>Error al guardar los datos:</b> " . mysqli_error($connection) . "</p>";
    }
}

// Consultamos todos los registros de la tabla 'musica'
$consulta = "SELECT * FROM musica";
$result = mysqli_query($connection, $consulta);

if (!$result) {
    echo "No se ha podido realizar la consulta: " . mysqli_error($connection);
} 
    echo "<h3>Registros guardados:</h3>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Nombre</th>";
    echo "<th>Apellido</th>";
    echo "<th>Útil</th>";
    echo "<th>Comentario</th>";
    echo "<th>Calificación</th>";
    echo "</tr>";

    while ($colum = mysqli_fetch_array($result)) 
      {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($colum['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($colum['apellido']) . "</td>";
        echo "<td>" . htmlspecialchars($colum['util']) . "</td>";
        echo "<td>" . htmlspecialchars($colum['comentario']) . "</td>";
        echo "<td>" . htmlspecialchars($colum['calificacion']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";


mysqli_close($connection);

echo '<br><a href="contactos.html">Volver Atrás</a>';
?>

</body>
</html>