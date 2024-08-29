document.addEventListener('DOMContentLoaded', function () {
    const carrito = [];
    const carritoItems = document.getElementById('carritoItems');
    const totalElement = document.getElementById('total');
    const finalizarCompraBtn = document.getElementById('finalizarCompra');
    const productosList = document.getElementById('lista-productos');

    productosList.addEventListener('click', (e) => {
        if (e.target.classList.contains('add-to-cart')) {
            const id = e.target.dataset.id;
            const descripcion = e.target.dataset.descripcion;
            const precio = parseFloat(e.target.dataset.precio);

            agregarAlCarrito(id, descripcion, precio);
        }
    });

    finalizarCompraBtn.addEventListener('click', () => {
        if (carrito.length === 0) {
            alert("El carrito está vacío.");
            return;
        }

        fetch('finalizar_compra.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ carrito })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message); // Mostrar mensaje de éxito
                carrito.length = 0; // Limpiar carrito
                actualizarCarrito(); // Actualizar la vista del carrito
                window.location.href = 'pedidos.php'; // Redirigir a la página de pedidos
            } else {
                alert(data.message); // Mostrar mensaje de error
            }
        })
        .catch(error => console.error('Error:', error));
    });

    function agregarAlCarrito(id, descripcion, precio) {
        const producto = carrito.find(item => item.id === id);

        if (producto) {
            producto.cantidad++;
        } else {
            carrito.push({ id, descripcion, precio, cantidad: 1 });
        }

        actualizarCarrito();
    }

    function actualizarCarrito() {
        carritoItems.innerHTML = '';
        let total = 0;

        carrito.forEach(item => {
            const li = document.createElement('li');
            li.textContent = `${item.descripcion} - $${item.precio} x ${item.cantidad}`;
            carritoItems.appendChild(li);

            total += item.precio * item.cantidad;
        });

        totalElement.textContent = total.toFixed(2);
    }
});
