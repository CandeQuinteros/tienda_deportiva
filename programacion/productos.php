<?php
session_start();
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "tienda_deportiva");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT id, codigo_producto, descripcion, precio FROM productos";
$result = $conn->query($sql);
?>

<h2>Productos Disponibles</h2>
<form method="POST" action="carrito.php">
    <table>
        <tr>
            <th>Código Producto</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Comprar</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['codigo_producto']; ?></td>
                <td><?php echo $row['descripcion']; ?></td>
                <td>$<?php echo $row['precio']; ?></td>
                <td><button type="button" class="producto-agregar" data-id="<?php echo $row['id']; ?>" data-descripcion="<?php echo $row['descripcion']; ?>" data-precio="<?php echo $row['precio']; ?>">Agregar al Carrito</button></td>
            </tr>
        <?php endwhile; ?>
    </table>
</form>

<?php
$conn->close();
?>
