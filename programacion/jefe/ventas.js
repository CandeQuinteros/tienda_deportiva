function consultarProductos() {
    fetch('consultarProductos.php')
        .then(response => response.json())
        .then(data => {
            console.log(data);  // Verificar qué datos se están recibiendo

            const listaProductos = document.getElementById('lista-productos');
            listaProductos.innerHTML = ''; // Limpiar cualquier contenido previo

            if (Array.isArray(data) && data.length > 0) {
                const table = document.createElement('table');
                table.border = "1";

                const header = table.insertRow();
                header.insertCell().textContent = "Código";
                header.insertCell().textContent = "Descripción";
                header.insertCell().textContent = "Precio";

                data.forEach(producto => {
                    const row = table.insertRow();
                    row.insertCell().textContent = producto.codigo;
                    row.insertCell().textContent = producto.descripcion;
                    row.insertCell().textContent = `$${producto.precio.toFixed(2)}`;
                });

                listaProductos.appendChild(table);
            } else {
                listaProductos.textContent = data.message || "No se encontraron productos.";
            }
        })
        .catch(error => {
            console.error('Error al consultar los productos:', error);
        });
}

// Función para ver pedidos pendientes
function verPedidosPendientes() {
    const listaPedidos = document.getElementById('lista-pedidos');
    
    listaPedidos.innerHTML = '<div>Pedido 1: Cliente A - Pendiente</div><div>Pedido 2: Cliente B - Pendiente</div>';
    // Aquí se haría una llamada Ajax o Fetch para obtener los pedidos pendientes desde el servidor
}

// Función para anular un pedido
document.getElementById('form-anular-pedido').addEventListener('submit', function(e) {
    e.preventDefault();
    const codigoPedido = document.getElementById('codigo-pedido').value;

    fetch('anular_pedido.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `codigo_pedido=${encodeURIComponent(codigoPedido)}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data);  // Mostrar el mensaje devuelto por el servidor
    })
    .catch(error => {
        console.error('Error al anular el pedido:', error);
        alert('Hubo un error al intentar anular el pedido.');
    });
});

