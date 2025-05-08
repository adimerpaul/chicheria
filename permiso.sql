-- 🧑‍💼 Gestión de Usuarios y Empleados
UPDATE permisos SET grupo = 'Usuarios y Empleados' WHERE id IN (1, 9, 10, 32, 44);

-- 👥 Gestión de Clientes
UPDATE permisos SET grupo = 'Clientes' WHERE id = 2;

-- 📦 Gestión de Productos e Inventario
UPDATE permisos SET grupo = 'Productos e Inventario' WHERE id IN (3, 4, 24, 25, 28, 23, 29, 40, 42, 41, 43);

-- 💰 Ventas
UPDATE permisos SET grupo = 'Ventas' WHERE id IN (5, 6, 7, 8, 13, 14, 17, 15);

-- 📊 Cuentas por Cobrar y Finanzas
UPDATE permisos SET grupo = 'Finanzas' WHERE id IN (19, 20, 21, 22, 30, 33, 35);

-- 💸 Gastos y Pagos
UPDATE permisos SET grupo = 'Gastos y Pagos' WHERE id IN (11, 18, 26, 31, 34);

-- 📑 Préstamos
UPDATE permisos SET grupo = 'Préstamos' WHERE id IN (12, 16, 27);

-- 🧱 Materia Prima y Proveedores
UPDATE permisos SET grupo = 'Materia Prima y Proveedores' WHERE id IN (36, 37, 38, 39);


alter table productos
    add grupo varchar(255) null;

-- CHICHA
UPDATE productos SET grupo = 'CHICHA' WHERE id IN (1, 4, 5, 6, 7, 8, 9, 18, 19, 22, 64, 65, 66, 67, 68);

-- GARAPIÑA
UPDATE productos SET grupo = 'GARAPIÑA' WHERE id IN (39, 54, 56, 57, 58, 59, 60);

INSERT INTO `permisos` (`id`, `nombre`, `created_at`, `updated_at`, `orden`, `descripcion`, `grupo`) VALUES
(45, 'Editar Caja Chica', NULL, NULL, 45, 'eliminar registro de caja', 'Finanzas'),
(46, 'Editar Cliente', NULL, NULL, 46, 'modificar o eliminar ', 'Clientes');
