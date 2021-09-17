import Login from '../pages/Login';
import Cliente from "pages/Cliente";
import Producto from "pages/Producto";
import Venta from "pages/Venta";
import Garantia from "pages/Garantia";
import Inventario from "pages/Inventario";
import Empledo from "pages/Empledo";
import Ventadirecta from "pages/Ventadirecta";
import Ventalocal from "pages/Ventalocal";
import Reporteuser from "pages/Reporteuser";
import User from "pages/User";
import Gasto from "pages/Gasto";
import Ventadetalle from "pages/Ventadetalle";
// <<<<<<< HEAD
// import User from "pages/User";
// =======
// import Usuario from "pages/Usuario";
// import Gasto from "pages/Gasto";
// >>>>>>> a64c39b0b8007f2636b9bda84ee6276a638bee19

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/Index.vue') },
      { path: 'login', component: Login },
      { path: 'cliente', component: Cliente,meta: {requiresAuth: true} },
      { path: 'producto', component: Producto,meta: {requiresAuth: true} },
      { path: 'venta', component: Ventadetalle,meta: {requiresAuth: true} },
      // { path: 'ventadirecta', component: Ventadirecta,meta: {requiresAuth: true} },
      { path: 'ventalocal', component: Ventalocal,meta: {requiresAuth: true} },
      { path: 'garantia', component: Garantia,meta: {requiresAuth: true} },
      { path: 'inventario', component: Inventario,meta: {requiresAuth: true} },
      { path: 'empleado', component: Empledo,meta: {requiresAuth: true} },
      { path: 'reporteuser', component: Reporteuser,meta: {requiresAuth: true} },
      { path: 'user', component: User,meta: {requiresAuth: true} },
      { path: 'gasto', component: Gasto,meta: {requiresAuth: true} },

// <<<<<<< HEAD
//       { path: 'user', component: User,meta: {requiresAuth: true} },
// =======
//       { path: 'usuario', component: Usuario,meta: {requiresAuth: true} },
//       { path: 'gasto', component: Gasto,meta: {requiresAuth: true} },
// >>>>>>> a64c39b0b8007f2636b9bda84ee6276a638bee19
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
