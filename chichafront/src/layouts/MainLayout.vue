<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          {{this.$store.state.login.user.name}}
        </q-toolbar-title>

        <div>Chicha doña nati</div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      class="bg-grey-1"
    >
      <q-list>
        <q-item-label
          header
          class="text-grey-8"
        >
          Opciones del menu
        </q-item-label>

        <q-item
          clickable
          active-class="my-menu-link"
          to="/"
          exact>
          <q-item-section
            avatar>
            <q-icon name="home" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Home</q-item-label>
            <q-item-label caption>
              Pagina principal
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          v-if="!$store.getters['login/isLoggedIn']"
          active-class="my-menu-link"
          clickable
          exact
          to="/login"
        >
          <q-item-section
            avatar
          >
            <q-icon name="login"  size="lg"/>
          </q-item-section>

          <q-item-section>
            <q-item-label>Login</q-item-label>
            <q-item-label caption>
              Ingreso al sistema
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          v-if="$store.state.login.usuarios"
          active-class="my-menu-link"
          clickable
          exact
          to="user"
        >
          <q-item-section
            avatar
          >
            <q-icon name="engineering" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Usuarios</q-item-label>
            <q-item-label caption>
              Control de usuarios
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          v-if="$store.state.login.clientes"
          active-class="my-menu-link"
          clickable
          exact
          to="cliente"
        >
          <q-item-section
            avatar
          >
            <q-icon name="people" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Clientes Detalle</q-item-label>
            <q-item-label caption>
              Control de cLientes
            </q-item-label>
          </q-item-section>
        </q-item>

                <q-item
          v-if="$store.state.login.clientes"
          active-class="my-menu-link"
          clickable
          exact
          to="clientelocal"
        >
          <q-item-section
            avatar
          >
            <q-icon name="contact_phone" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Clientes Local</q-item-label>
            <q-item-label caption>
              Control de cLientes Local
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          v-if="$store.state.login.productos"
          active-class="my-menu-link"
          clickable
          exact
          to="producto"
        >
          <q-item-section
            avatar
          >
            <q-icon name="sports_bar" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Productos</q-item-label>
            <q-item-label caption>
              Informacion de Productos
            </q-item-label>
          </q-item-section>
        </q-item>


        <q-item
          v-if="$store.state.login.inventario"
          active-class="my-menu-link"
          clickable
          exact
          to="inventario"
        >
          <q-item-section
            avatar
          >
            <q-icon name="list" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Inventario</q-item-label>
            <q-item-label caption>
              Informacion de Materiales
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          v-if="$store.state.login.ventadetalle"
          active-class="my-menu-link"
          clickable
          exact
          to="venta"
        >
          <q-item-section
            avatar
          >
            <q-icon name="shopping_cart" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Venta Detalle</q-item-label>
            <q-item-label caption>
              Historial de ventas
            </q-item-label>
          </q-item-section>
        </q-item>

<!--                        <q-item-->
<!--          v-if="$store.getters['login/isLoggedIn']"-->
<!--          clickable-->
<!--          exact-->
<!--          to="ventadirecta"-->
<!--        >-->
<!--          <q-item-section-->
<!--            avatar-->
<!--          >-->
<!--            <q-icon name="shop" />-->
<!--          </q-item-section>-->

<!--          <q-item-section>-->
<!--            <q-item-label>Venta Local</q-item-label>-->
<!--            <q-item-label caption>-->
<!--              Historial de ventas-->
<!--            </q-item-label>-->
<!--          </q-item-section>-->
<!--        </q-item>-->
        <q-item
          v-if="$store.state.login.ventalocal"
          active-class="my-menu-link"
          clickable
          exact
          to="ventalocal"
        >
          <q-item-section
            avatar
          >
            <q-icon name="local_shipping" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Venta Local </q-item-label>
            <q-item-label caption>
              Historial de ventas
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          v-if="$store.state.login.historialprestamo"
          active-class="my-menu-link"
          clickable
          exact
          to="prestamos"
        >
          <q-item-section
            avatar
          >
            <q-icon name="task" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Prestamos Detalle</q-item-label>
            <q-item-label caption>
              Historial de prestamos
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          v-if="$store.state.login.historialprestamo"
          active-class="my-menu-link"
          clickable
          exact
          to="prestamoslocal"
        >
          <q-item-section
            avatar
          >
            <q-icon name="task" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Prestamos Local</q-item-label>
            <q-item-label caption>
              Historial de prestamos
            </q-item-label>
          </q-item-section>
        </q-item>





        <q-item
          v-if="$store.state.login.cobrardetalle"
          active-class="my-menu-link"
          clickable
          exact
          to="cxcdetalle"
        >
          <q-item-section
            avatar
          >
            <q-icon name="task" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>CxC DETALLE</q-item-label>
            <q-item-label caption>
              Historial de ventas
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          v-if="$store.state.login.cobrarlocal"
          active-class="my-menu-link"
          clickable
          exact
          to="cxclocal"
        >
          <q-item-section
            avatar
          >
            <q-icon name="task" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>CxC LOCAL</q-item-label>
            <q-item-label caption>
              Historial de venta
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          v-if="$store.state.login.cobrarruta"
          active-class="my-menu-link"
          clickable
          exact
          to="cxcruta"
        >
          <q-item-section
            avatar
          >
            <q-icon name="task" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>CxC RUTA</q-item-label>
            <q-item-label caption>
              Historial de venta
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          v-if="$store.state.login.historialventa"
          active-class="my-menu-link"
          clickable
          exact
          to="historial"
        >
          <q-item-section
            avatar
          >
            <q-icon name="task" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Historial de Venta </q-item-label>
            <q-item-label caption>
              Historial de venta
            </q-item-label>
          </q-item-section>
        </q-item>
        

        <q-item
          v-if="$store.state.login.historialventa"
          active-class="my-menu-link"
          clickable
          exact
          to="historialruta"
        >
          <q-item-section
            avatar
          >
            <q-icon name="task" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Historial de Rutas </q-item-label>
            <q-item-label caption>
              Historial de venta Ruta
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          v-if="$store.state.login.empleados"
          active-class="my-menu-link"
          clickable
          exact
          to="empleado"
        >
          <q-item-section
            avatar
          >
            <q-icon name="people" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Empleado</q-item-label>
            <q-item-label caption>
              Controlde empleados
            </q-item-label>
          </q-item-section>
        </q-item>



        <q-item
          v-if="$store.getters['login/isLoggedIn']"
          active-class="my-menu-link"
          clickable
          exact
          to="gasto"
        >
          <q-item-section
            avatar
          >
            <q-icon name="paid" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Gastos</q-item-label>
            <q-item-label caption>
              Control de gastos
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item
          v-if="$store.state.login.reportes"
          active-class="my-menu-link"
          clickable
          exact
          to="reporteuser"
        >
          <q-item-section
            avatar
          >
            <q-icon name="shop" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Reporte Usuario</q-item-label>
            <q-item-label caption>
              reporte de Ventas
            </q-item-label>
          </q-item-section>
        </q-item>
<!--<q-item-->
<!--          v-if="$store.getters['login/isLoggedIn']"-->
<!--          clickable-->
<!--          exact-->
<!--          to="usuario"-->
<!--        >-->
<!--          <q-item-section-->
<!--            avatar-->
<!--          >-->
<!--            <q-icon name="person" />-->
<!--          </q-item-section>-->

<!--          <q-item-section>-->
<!--            <q-item-label>Usuarios</q-item-label>-->
<!--            <q-item-label caption>-->
<!--              Datos de Usuarios-->
<!--            </q-item-label>-->
<!--          </q-item-section>-->
<!--        </q-item>-->

        <q-item
          v-if="$store.getters['login/isLoggedIn']"
          clickable
          @click="logout"
        >
          <q-item-section
            avatar
          >
            <q-icon name="logout" size="lg" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Salir</q-item-label>
            <q-item-label caption>
              Salir del sistema
            </q-item-label>
          </q-item-section>
        </q-item>

<!--        <EssentialLink-->
<!--          v-for="link in essentialLinks"-->
<!--          :key="link.title"-->
<!--          v-bind="link"-->
<!--        />-->
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
// import EssentialLink from 'components/EssentialLink.vue'
//
// const linksList = [
//   {
//     title: 'Docs',
//     caption: 'quasar.dev',
//     icon: 'school',
//     link: 'https://quasar.dev'
//   },
//   {
//     title: 'Github',
//     caption: 'github.com/quasarframework',
//     icon: 'code',
//     link: 'https://github.com/quasarframework'
//   },
//   {
//     title: 'Discord Chat Channel',
//     caption: 'chat.quasar.dev',
//     icon: 'chat',
//     link: 'https://chat.quasar.dev'
//   },
//   {
//     title: 'Forum',
//     caption: 'forum.quasar.dev',
//     icon: 'record_voice_over',
//     link: 'https://forum.quasar.dev'
//   },
//   {
//     title: 'Twitter',
//     caption: '@quasarframework',
//     icon: 'rss_feed',
//     link: 'https://twitter.quasar.dev'
//   },
//   {
//     title: 'Facebook',
//     caption: '@QuasarFramework',
//     icon: 'public',
//     link: 'https://facebook.quasar.dev'
//   },
//   {
//     title: 'Quasar Awesome',
//     caption: 'Community Quasar projects',
//     icon: 'favorite',
//     link: 'https://awesome.quasar.dev'
//   }
// ];

import { defineComponent, ref } from 'vue'

export default defineComponent({
  name: 'MainLayout',

  components: {
    // EssentialLink
  },

  setup () {
    const leftDrawerOpen = ref(false)

    return {
      // essentialLinks: linksList,
      leftDrawerOpen,
      toggleLeftDrawer () {
        leftDrawerOpen.value = !leftDrawerOpen.value
      }
    }
  },
  methods:{
    logout(){
      this.$q.loading.show()
      this.$store.dispatch('login/logout')
        .then(() => {
          this.$q.loading.hide()
          this.$router.push('/login')
        })
    }
  },
  mounted() {
    // console.log(this.$store.state.login.user.name)
  }
})
</script>
<style lang="sass">
.my-menu-link
  color: white
  background: #4a148c
</style>
