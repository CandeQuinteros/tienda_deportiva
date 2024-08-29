<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Productos</title>
    <style>
        /* Estilos CSS */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            width: 100%;
            max-width: 400px;
            margin: 0 auto 20px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form input[type="text"],
        form input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        p {
            text-align: center;
            color: #ff0000;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <a href="ventas.php">Volver a cargar productos</a>

    <?php
    // Configuración de la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tienda_deportiva";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener los datos del formulario
    $codigo = $_POST['codigo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0;

    // Validar que no haya campos vacíos y cargar el producto
    if (!empty($codigo) && !empty($descripcion) && $precio > 0) {
        // Preparar la sentencia SQL
        $sql = "INSERT INTO productos (codigo_producto, descripcion, precio) VALUES (?, ?, ?)";

        // Preparar y vincular
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssd", $codigo, $descripcion, $precio);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            echo "<p>Producto cargado exitosamente.</p>";
        } else {
            echo "<p>Error al cargar el producto: " . $stmt->error . "</p>";
        }

        // Cerrar la declaración
        $stmt->close();
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<p>Todos los campos son obligatorios y el precio debe ser mayor que 0.</p>";
    }

    // Consulta para mostrar los productos
    echo '<h2>Ver Productos</h2>';
    echo '<section id="consultar-productos">';
    echo '<div id="lista-productos">';

    $sql = "SELECT id, codigo_producto, descripcion, precio FROM productos";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<table>';
        echo '<tr><th>ID</th><th>Código Producto</th><th>Descripción</th><th>Precio</th></tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['codigo_producto'] . '</td>';
            echo '<td>' . $row['descripcion'] . '</td>';
            echo '<td>$' . $row['precio'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No hay productos disponibles</p>';
    }

    // Cerrar la conexión
    mysqli_close($conn);

    echo '</div>';
    echo '</section>';
    ?>

</body>
</html>



