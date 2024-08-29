<?php
            require 'index.php'; // Incluir el archivo de conexión a la base de datos

            // Consulta para mostrar los productos
            $sql = "SELECT id, codigo_producto, descripcion, precio FROM productos";
            $result = mysqli_query($index, $sql);

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

            mysqli_close($index); // Cerrar la conexión
            ?>