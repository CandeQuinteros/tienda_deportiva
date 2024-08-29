<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - Tienda Deportiva</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h1 {
            text-align: center;
            color: white;
        }
        #contenedor {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        #carrito {
            width: 40%;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        #carrito h2 {
            margin-top: 0;
            color: #007BFF;
        }
        #carritoItems {
            list-style-type: none;
            padding: 0;
        }
        #carritoItems li {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        #finalizarCompra {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #finalizarCompra:hover {
            background-color: #218838;
        }
        #consultar-productos {
            width: 50%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
        table tr:hover {
            background-color: #f1f1f1;
        }
        .add-to-cart {
            background-color: #007BFF;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .add-to-cart:hover {
            background-color: #0056b3;
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
        #pedidos:hover {
            background-color: #c82333;
            text-decoration: none;
        }
        #pedidos {
            position: absolute;
            top: 60px;
            right: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <a id="logout" href="Registro/registro.html">Cerrar sesion</a>
    
    <h1>Tienda Deportiva</h1>
    
    <div id="contenedor">
        <!-- Carrito de Compras -->
        <form id="carrito">
            <h2>Carrito de Compras</h2>
            <ul id="carritoItems">
                <!-- Aquí se mostrarán los productos agregados al carrito -->
            </ul>
            <p>Total: $<span id="total">0.00</span></p>
            <button id="finalizarCompra">Finalizar Compra</button>
        </form>

        <!-- Tabla de Productos -->
        <div id="consultar-productos">
            <h2>Productos</h2>
            <div id="lista-productos">
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

                // Consulta para mostrar los productos
                $sql = "SELECT id, codigo_producto, descripcion, precio FROM productos";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    echo '<table>';
                    echo '<tr><th>Código Producto</th><th>Descripción</th><th>Precio</th><th>Comprar</th></tr>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['codigo_producto'] . '</td>';
                        echo '<td>' . $row['descripcion'] . '</td>';
                        echo '<td>$' . $row['precio'] . '</td>';
                        echo '<td><button class="add-to-cart" data-id="' . $row['id'] . '" data-descripcion="' . $row['descripcion'] . '" data-precio="' . $row['precio'].'">Agregar al carrito</button></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo '<p>No hay productos disponibles</p>';
                }

                // Cerrar la conexión
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>

    <!-- Vincular el archivo JavaScript -->
    <script src="main.js"></script>
</body>
</html>
