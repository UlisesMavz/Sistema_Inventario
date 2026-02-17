/**
 * productos.js
 * Maneja todas las operaciones de productos
 */

// Cargar productos al iniciar
document.addEventListener('DOMContentLoaded', function() {
    cargarProductos();
    
    // Manejar formulario de inserción
    const insertForm = document.getElementById('insertForm');
    if (insertForm) {
        insertForm.addEventListener('submit', insertarProducto);
    }
});

/**
 * Carga todos los productos desde la API
 */
async function cargarProductos() {
    try {
        const response = await fetch('../api/productos.php', {
            method: 'GET',
            credentials: 'include'
        });
        
        const data = await response.json();
        
        if (data.exito) {
            mostrarProductos(data.productos);
            document.getElementById('totalProductos').textContent = data.total;
        } else {
            mostrarNotificacion(data.mensaje, 'error');
        }
    } catch (error) {
        console.error('Error al cargar productos:', error);
        mostrarNotificacion('Error al cargar productos', 'error');
    }
}

/**
 * Muestra los productos en la tabla
 */
function mostrarProductos(productos) {
    const tbody = document.getElementById('productosTableBody');
    
    if (productos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center">No hay productos registrados</td></tr>';
        return;
    }
    
    tbody.innerHTML = productos.map(producto => `
        <tr>
            <td>${producto.id}</td>
            <td>${producto.codigo}</td>
            <td>${producto.nombre}</td>
            <td>${formatearPrecio(producto.precio)}</td>
            <td>${formatearFecha(producto.fecha_creacion)}</td>
        </tr>
    `).join('');
}

/**
 * Inserta un nuevo producto
 */
async function insertarProducto(e) {
    e.preventDefault();
    
    const codigo = document.getElementById('insertCodigo').value;
    const nombre = document.getElementById('insertNombre').value;
    const precio = document.getElementById('insertPrecio').value;
    const tipo = document.getElementById('insertTipo').value;
    const posicion = document.getElementById('insertPosicion').value;
    
    const datos = {
        codigo: parseInt(codigo),
        nombre: nombre,
        precio: parseFloat(precio),
        tipo: tipo
    };
    
    if (tipo === 'posicion') {
        datos.posicion = parseInt(posicion);
    }
    
    try {
        const response = await fetch('../api/productos.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include',
            body: JSON.stringify(datos)
        });
        
        const data = await response.json();
        
        if (data.exito) {
            mostrarNotificacion(data.mensaje, 'success');
            document.getElementById('insertForm').reset();
            cargarProductos();
        } else {
            mostrarNotificacion(data.mensaje, 'error');
        }
    } catch (error) {
        console.error('Error al insertar producto:', error);
        mostrarNotificacion('Error al insertar producto', 'error');
    }
}

/**
 * Elimina un producto según el tipo
 */
async function eliminarProducto(tipo) {
    if (!confirm(`¿Está seguro de eliminar el producto del ${tipo}?`)) {
        return;
    }
    
    try {
        const response = await fetch('../api/productos.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include',
            body: JSON.stringify({ tipo: tipo })
        });
        
        const data = await response.json();
        
        if (data.exito) {
            mostrarNotificacion(data.mensaje, 'success');
            cargarProductos();
        } else {
            mostrarNotificacion(data.mensaje, 'error');
        }
    } catch (error) {
        console.error('Error al eliminar producto:', error);
        mostrarNotificacion('Error al eliminar producto', 'error');
    }
}

/**
 * Elimina un producto por código
 */
async function eliminarPorCodigo() {
    const codigo = document.getElementById('deleteCodigo').value;
    
    if (!codigo) {
        mostrarNotificacion('Ingrese un código válido', 'error');
        return;
    }
    
    if (!confirm(`¿Está seguro de eliminar el producto con código ${codigo}?`)) {
        return;
    }
    
    try {
        const response = await fetch('../api/productos.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include',
            body: JSON.stringify({
                tipo: 'codigo',
                codigo: parseInt(codigo)
            })
        });
        
        const data = await response.json();
        
        if (data.exito) {
            mostrarNotificacion(data.mensaje, 'success');
            document.getElementById('deleteCodigo').value = '';
            cargarProductos();
        } else {
            mostrarNotificacion(data.mensaje, 'error');
        }
    } catch (error) {
        console.error('Error al eliminar producto:', error);
        mostrarNotificacion('Error al eliminar producto', 'error');
    }
}

/**
 * Busca un producto usando algoritmos personalizados
 */
async function buscarProducto() {
    const algoritmo = document.getElementById('searchAlgoritmo').value;
    const campo = document.getElementById('searchCampo').value;
    const valor = document.getElementById('searchValor').value;
    
    if (!valor) {
        mostrarNotificacion('Ingrese un valor a buscar', 'error');
        return;
    }
    
    try {
        const url = `../api/buscar.php?tipo=${algoritmo}&campo=${campo}&valor=${encodeURIComponent(valor)}`;
        const response = await fetch(url, {
            method: 'GET',
            credentials: 'include'
        });
        
        const data = await response.json();
        const resultBox = document.getElementById('searchResult');
        
        if (data.exito) {
            const producto = data.producto;
            resultBox.className = 'result-box success';
            resultBox.innerHTML = `
                <strong>✅ Producto Encontrado</strong><br>
                <strong>Código:</strong> ${producto.codigo}<br>
                <strong>Nombre:</strong> ${producto.nombre}<br>
                <strong>Precio:</strong> ${formatearPrecio(producto.precio)}<br>
                <br>
                <small>
                    <strong>Algoritmo:</strong> ${data.algoritmo === 'lineal' ? 'Búsqueda Lineal O(n)' : 'Búsqueda Binaria O(log n)'}<br>
                    <strong>Tiempo de ejecución:</strong> ${data.tiempo_ms} ms
                </small>
            `;
            resultBox.style.display = 'block';
        } else {
            resultBox.className = 'result-box error';
            resultBox.innerHTML = `
                <strong>❌ Producto No Encontrado</strong><br>
                <small>
                    <strong>Algoritmo:</strong> ${data.algoritmo === 'lineal' ? 'Búsqueda Lineal O(n)' : 'Búsqueda Binaria O(log n)'}<br>
                    <strong>Tiempo de ejecución:</strong> ${data.tiempo_ms} ms
                </small>
            `;
            resultBox.style.display = 'block';
        }
    } catch (error) {
        console.error('Error al buscar producto:', error);
        mostrarNotificacion('Error al buscar producto', 'error');
    }
}

/**
 * Ordena los productos usando algoritmos personalizados
 */
async function ordenarProductos() {
    const algoritmo = document.getElementById('sortAlgoritmo').value;
    const campo = document.getElementById('sortCampo').value;
    
    try {
        const response = await fetch('../api/ordenar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include',
            body: JSON.stringify({
                algoritmo: algoritmo,
                campo: campo
            })
        });
        
        const data = await response.json();
        
        if (data.exito) {
            // Mostrar productos ordenados
            mostrarProductos(data.productos);
            
            // Mostrar información del ordenamiento
            const resultBox = document.getElementById('sortResult');
            const algoritmoNombre = algoritmo === 'burbuja' ? 'Bubble Sort O(n²)' : 'Quick Sort O(n log n)';
            const campoNombre = campo === 'precio' ? 'Precio' : 'Nombre';
            
            resultBox.className = 'result-box success';
            resultBox.innerHTML = `
                <strong>✅ Productos Ordenados</strong><br>
                <strong>Algoritmo:</strong> ${algoritmoNombre}<br>
                <strong>Campo:</strong> ${campoNombre}<br>
                <strong>Total de productos:</strong> ${data.total}<br>
                <strong>Tiempo de ejecución:</strong> ${data.tiempo_ms} ms
            `;
            resultBox.style.display = 'block';
            
            mostrarNotificacion('Productos ordenados correctamente', 'success');
        } else {
            mostrarNotificacion(data.mensaje, 'error');
        }
    } catch (error) {
        console.error('Error al ordenar productos:', error);
        mostrarNotificacion('Error al ordenar productos', 'error');
    }
}
