<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Pendientes - Tienda Deportiva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        h2 {
            color: #007BFF;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #007BFF;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #e9ecef;
        }

        input[type="number"] {
            width: 60px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
            text-align: center;
        }

        input[type="checkbox"] {
            margin: 0;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Pedidos Pendientes</h2>
    <form method="POST" action="actualizar_pedido.php">
        <table>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Modificar</th>
                <th>Eliminar</th>
            </tr>
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

            // Consulta para obtener los detalles del pedido
            $sql = "SELECT detalles_pedido.id_pedido AS pedido_id, productos.descripcion AS producto, detalles_pedido.precio, detalles_pedido.cantidad, productos.id AS producto_id 
                    FROM pedidos
                    JOIN detalles_pedido ON pedidos.id = detalles_pedido.id_pedido
                    JOIN productos ON productos.id = detalles_pedido.id_producto
                    WHERE pedidos.estado = 'pendiente'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['producto']) . '</td>';
                    echo '<td>$' . htmlspecialchars($row['precio']) . '</td>';
                    echo '<td><input type="number" name="cantidad[' . htmlspecialchars($row['pedido_id']) . '][' . htmlspecialchars($row['producto_id']) . ']" value="' . htmlspecialchars($row['cantidad']) . '" min="1"></td>';
                    echo '<td><input type="checkbox" name="modificar[]" value="' . htmlspecialchars($row['producto_id']) . '"></td>';
                    echo '<td><input type="checkbox" name="eliminar[]" value="' . htmlspecialchars($row['producto_id']) . '"></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5">No hay pedidos pendientes</td></tr>';
            }

            // Cerrar la conexión
            $conn->close();
            ?>
        </table>
        <button type="submit"href="pedidos.php">Actualizar Pedidos</button>
        <
    </form>
</body>
</html>
