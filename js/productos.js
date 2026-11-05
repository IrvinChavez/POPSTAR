const productos = window.popstarProductos;

if (!Array.isArray(productos)) {
    throw new Error("No se pudo cargar el catálogo de discos desde la base de datos.");
}
