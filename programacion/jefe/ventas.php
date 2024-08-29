<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Ventas</title>
    <link rel="stylesheet" href="ventas.css">
    <style>
    #consultar-productos {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    h2 {
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 0 auto;
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
    .anular{
        margin-top: 20px;
    padding: 10px;
    background-color: #5cb85c;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    }
    #logout {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        #logout:hover {
            background-color: #c82333;
            text-decoration: none;
        }
        button a{
            text-decoration: none;
            color: white;
        }
</style>
</head>
<body>
    <a id="logout" href="../Registro/registro.html">Cerrar sesion</a>
    <div class="container">
        <h1>Panel de Ventas</h1>
        <nav>
            <ul>
                <li><a href="#cargar-producto">Cargar Producto</a></li>
                <li><a href="#consultar-productos">Consultar Productos</a></li>
                <li><a href="#pedidos-pendientes">Pedidos Pendientes</a></li>
                <li><a href="#anular-pedido">Anular Pedido</a></li>
            </ul>
        </nav>

        <section id="cargar-producto">
            <h2>Cargar Producto</h2>
            <form id="form-cargar-producto" action="registrarProductos.php" method="POST">
                <label for="codigo">Código de Producto:</label>
                <input type="text" id="codigo" name="codigo" required>

                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" required>

                <label for="precio">Precio Unitario:</label>
                <input type="number" id="precio" name="precio" step="0.01" required>

                <button type="submit">Cargar Producto</button>
            </form>
        </section>

    <section id="consultar-productos">
    <h2>Consultar Productos</h2>
    <div id="lista-productos">
        <?php
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

        $sql = "SELECT id, codigo_producto, descripcion, precio FROM productos";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<table border="1">';
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

        ?>
    </div>
</section>


<?php

        echo "<section id='pedidos-pendientes'>";
        echo"<h2>Pedidos Pendientes</h2>";
            
            echo"<div id='lista-pedidos'>";

$sql = "SELECT id, id_usuario, estado, fecha, total FROM pedidos";
$result = $conn->query($sql);

// Verificar si hay resultados y mostrarlos en una tabla
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>ID Usuario</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Total</th>
            </tr>";
    
    // Recorrer los resultados y mostrarlos en la tabla
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['id_usuario'] . "</td>
                <td>" . $row['estado'] . "</td>
                <td>" . $row['fecha'] . "</td>
                <td>$" . number_format($row['total'], 2) . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron registros en la tabla de pedidos.";
}

echo"</div>";
echo"</section>";

?>

        
        <section id="anular-pedido">
    <h2>Anular Pedido</h2>
    <form id="form-anular-pedido" method="POST" action="anular_pedido.php">
        <a href="anular_pedido.php" class="anular">Clic aqui para ir a Anular Pedido</a>
    </form>
</section>

    </div>
    <script src="ventas.js"></script>
</body>
</html>

