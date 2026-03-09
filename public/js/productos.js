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
    
    // Manejar formulario de edición
    const editForm = document.getElementById('editForm');
    if (editForm) {
        editForm.addEventListener('submit', editarProducto);
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
    
    tbody.innerHTML = productos.map(producto => {
        // Lógica de alerta visual para stock bajo
        const isLowStock = parseInt(producto.stock) <= parseInt(producto.stock_minimo);
        const stockStyle = isLowStock ? 'color: red; font-weight: bold;' : '';
        const stockIcon = isLowStock ? ' ⚠️' : '';
        
        const prodJSON = JSON.stringify(producto).replace(/"/g, '&quot;');
        return `
        <tr>
            <td>${producto.id}</td>
            <td>${producto.codigo}</td>
            <td><small>${producto.categoria}<br><b>${producto.marca_proveedor}</b></small></td>
            <td>${producto.nombre}</td>
            <td>${formatearPrecio(producto.precio)}</td>
            <td style="${stockStyle}">${producto.stock}${stockIcon}</td>
            <td>
                <button class="btn btn-secondary" onclick="abrirModalEdicion(${prodJSON})" style="padding: 5px 10px; font-size: 0.9em;">✏️ Editar</button>
            </td>
        </tr>
    `}).join('');
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
    
    // Obtener campos avanzados
    const stock = document.getElementById('insertStock').value;
    const stockMinimo = document.getElementById('insertStockMinimo').value;
    
    // Lógica para 'Otro' en Categoría
    const catSelect = document.getElementById('insertCategoria').value;
    const catOtro = document.getElementById('insertCategoriaOtro').value;
    const categoria = (catSelect === 'Otro' && catOtro.trim() !== '') ? catOtro : catSelect;

    // Lógica para 'Otro' en Marca
    const marcaSelect = document.getElementById('insertMarca').value;
    const marcaOtro = document.getElementById('insertMarcaOtro').value;
    const marca = (marcaSelect === 'Otro' && marcaOtro.trim() !== '') ? marcaOtro : marcaSelect;
    
    const datos = {
        codigo: parseInt(codigo),
        nombre: nombre,
        precio: parseFloat(precio),
        stock: parseInt(stock),
        stock_minimo: parseInt(stockMinimo),
        categoria: categoria,
        marca_proveedor: marca,
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

/**
 * Abre el modal de edición y carga los datos del producto
 */
function abrirModalEdicion(producto) {
    document.getElementById('editCodigoOriginal').value = producto.codigo;
    document.getElementById('editCodigo').value = producto.codigo;
    document.getElementById('editNombre').value = producto.nombre;
    document.getElementById('editPrecio').value = producto.precio;
    document.getElementById('editStock').value = producto.stock;
    document.getElementById('editStockMinimo').value = producto.stock_minimo;
    
    // Configurar selectores de Categoría
    const selectCat = document.getElementById('editCategoria');
    const optionsCat = Array.from(selectCat.options).map(opt => opt.value);
    if (optionsCat.includes(producto.categoria)) {
        selectCat.value = producto.categoria;
        document.getElementById('editCategoriaOtro').style.display = 'none';
    } else {
        selectCat.value = 'Otro';
        document.getElementById('editCategoriaOtro').style.display = 'block';
        document.getElementById('editCategoriaOtro').value = producto.categoria;
    }
    
    // Configurar selectores de Marca
    const selectMarca = document.getElementById('editMarca');
    const optionsMarca = Array.from(selectMarca.options).map(opt => opt.value);
    if (optionsMarca.includes(producto.marca_proveedor)) {
        selectMarca.value = producto.marca_proveedor;
        document.getElementById('editMarcaOtro').style.display = 'none';
    } else {
        selectMarca.value = 'Otro';
        document.getElementById('editMarcaOtro').style.display = 'block';
        document.getElementById('editMarcaOtro').value = producto.marca_proveedor;
    }
    
    document.getElementById('editModal').style.display = 'block';
}

/**
 * Cierra el modal de edición
 */
function cerrarModalEdicion() {
    document.getElementById('editModal').style.display = 'none';
    document.getElementById('editForm').reset();
}

/**
 * Envía la petición PUT para actualizar un producto
 */
async function editarProducto(e) {
    e.preventDefault();
    
    // Extraer categoría
    const catSelect = document.getElementById('editCategoria').value;
    const catOtro = document.getElementById('editCategoriaOtro').value;
    const categoria = (catSelect === 'Otro' && catOtro.trim() !== '') ? catOtro : catSelect;

    // Extraer marca
    const marcaSelect = document.getElementById('editMarca').value;
    const marcaOtro = document.getElementById('editMarcaOtro').value;
    const marca = (marcaSelect === 'Otro' && marcaOtro.trim() !== '') ? marcaOtro : marcaSelect;
    
    const datos = {
        codigo_original: parseInt(document.getElementById('editCodigoOriginal').value),
        codigo: parseInt(document.getElementById('editCodigo').value),
        nombre: document.getElementById('editNombre').value,
        precio: parseFloat(document.getElementById('editPrecio').value),
        stock: parseInt(document.getElementById('editStock').value),
        stock_minimo: parseInt(document.getElementById('editStockMinimo').value),
        categoria: categoria,
        marca_proveedor: marca
    };
    
    try {
        const response = await fetch('../api/productos.php', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify(datos)
        });
        
        const data = await response.json();
        if (data.exito) {
            mostrarNotificacion(data.mensaje, 'success');
            cerrarModalEdicion();
            cargarProductos();
        } else {
            mostrarNotificacion(data.mensaje, 'error');
        }
    } catch (error) {
        console.error('Error al editar producto:', error);
        mostrarNotificacion('Error al actualizar el producto', 'error');
    }
}

/**
 * Rellena la base de datos con productos de prueba
 */
async function seedDatabase() {
    if (!confirm('¿Seguro que deseas insertar datos de prueba? Esto agregará múltiples productos automáticamente para pruebas.')) return;
    
    try {
        const response = await fetch('../api/admin_db.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify({ accion: 'seed' })
        });
        
        const data = await response.json();
        if (data.exito) {
            mostrarNotificacion(data.mensaje, 'success');
            cargarProductos();
        } else {
            mostrarNotificacion(data.mensaje, 'error');
        }
    } catch (error) {
        console.error('Error en seed:', error);
        mostrarNotificacion('Error de conexión al rellenar BD', 'error');
    }
}

/**
 * Vacía la base de datos (Requiere contraseña por seguridad)
 */
async function wipeDatabase() {
    const password = document.getElementById('adminPasswordWipe').value;
    
    if (!password) {
        mostrarNotificacion('Debes ingresar la contraseña de Admin para poder vaciar la BD', 'error');
        return;
    }
    
    if (!confirm('⚠️ Peligro: ¿Estás ABSOLUTAMENTE SEGURO de querer borrar TODOS los productos de la base de datos? Esta acción no se puede deshacer.')) return;
    if (!confirm('⚠️ Confirmación FINAL: Se borrarán los datos para siempre. ¿Continuar?')) return;
    
    try {
        const response = await fetch('../api/admin_db.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify({ accion: 'wipe', password: password })
        });
        
        const data = await response.json();
        if (data.exito) {
            mostrarNotificacion(data.mensaje, 'success');
            document.getElementById('adminPasswordWipe').value = '';
            cargarProductos();
        } else {
            mostrarNotificacion(data.mensaje, 'error');
        }
    } catch (error) {
        console.error('Error en wipe:', error);
        mostrarNotificacion('Error de conexión al vaciar BD', 'error');
    }
}
