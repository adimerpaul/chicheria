import Login from '../pages/Login';
import Cliente from "pages/Cliente";
import Producto from "pages/Producto";
import Venta from "pages/Venta";

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/Index.vue') },
      { path: 'login', component: Login },
      { path: 'cliente', component: Cliente,meta: {requiresAuth: true} },
      { path: 'producto', component: Producto,meta: {requiresAuth: true} },
      { path: 'venta', component: Venta,meta: {requiresAuth: true} },
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
