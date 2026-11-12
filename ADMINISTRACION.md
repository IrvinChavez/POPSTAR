# Administración de POPSTAR

1. Importa o vuelve a ejecutar `crear_usuarios_popstar.sql` en MySQL. El script agrega las columnas de roles e inventario activo sin borrar los datos existentes.
2. Registra desde la tienda la cuenta `admin@gmail.com` con la contraseña que elijas.
3. En PowerShell, desde la carpeta del proyecto, ejecuta `C:\xampp\php\php.exe .\promover-administrador.php`.
4. Inicia sesión con `admin@gmail.com`. En **Mi cuenta** aparecerá el enlace al panel de gestión.

El administrador y los empleados pueden agregar, editar, retirar y volver a publicar discos, además de crear cuentas de empleado. Las cuentas creadas desde el registro público siguen siendo cuentas de cliente y no pueden acceder al panel.
