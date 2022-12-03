<template>
<q-page>
<div class="row">
  <div class="col-12">
    <div :class="`q-pa-xs bg-${type=='detalle'?'red':'green'} text-center text-bold text-white`">{{ type=='detalle'?'VENTA POR DETALLE':'VENTA POR LOCAL' }}</div>
  </div>
  <div class="col-7">
    <div class="row">
      <div class="col-2" v-for="p in products" :key="p.id">
        <q-card style="height: 80px" @click="saleAdd(p)" class="no_selection">
          <q-card-section class="row items-center q-pb-none">
            <div class="text-bold text-grey">{{p.precio}}Bs.</div>
            <q-space />
            <div v-if="p.cantidad>0">
              <q-chip color="primary" class=" q-ma-none text-bold text-white" dense :label="p.cantidad"/>
            </div>
          </q-card-section>
          <q-card-section class="q-pa-none">
            <div class="text-subtitle2 flex-center flex text-center">{{p.nombre}}</div>
          </q-card-section>
        </q-card>
      </div>
    </div>
  </div>
  <div class="col-5">
    <q-card>
      <q-card-section class="row items-center q-pb-none">
        <div class="col-2">
          <div class="text-bold text-grey">Total: <span class="text-red">{{total}}Bs.</span> </div>
        </div>
        <div class="col-9">
          <q-select
            outlined
            dense
            v-model="client"
            use-input
            input-debounce="0"
            label="Cliente"
            :options="clients"
            @filter="filterFn"
            behavior="menu"
          >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey">
                  No results
                </q-item-section>
              </q-item>
            </template>
          </q-select>
        </div>
        <div class="col-1">
          <q-btn icon="delete_outline" dense  color="negative" @click="saleClear" />
        </div>
      </q-card-section>
      <q-card-section class="q-pa-none">
        <div class="text-subtitle2 flex-center flex text-center bg-primary text-white">PRODUCTOS</div>
      </q-card-section>
      <q-card-section class="q-pa-none">
        <div class="row items-center bg-primary text-white">
          <div class="col-2 text-center text-bold">Cantidad</div>
          <div class="col-6 text-center text-bold">Nombre</div>
          <div class="col-2 text-center text-bold">Precio</div>
          <div class="col-2 text-center text-bold">Subtotal</div>
        </div>
        <div class="row items-center" v-for="p in productSales" :key="p.id">
          <div class="col-2 text-center text-bold">
            <q-input v-model="p.cantidad" dense type="number" step="0.25" />
          </div>
          <div class="col-6 text-grey">{{p.nombre}}</div>
          <div class="col-2 text-right text-grey">
            <q-input v-model="p.precio" dense type="number" step="0.1">
              <template v-slot:append>
                <div class="text-subtitle1">Bs.</div>
              </template>
            </q-input>
          </div>
          <div class="col-2 text-right q-pr-xs text-bold">{{p.precio*p.cantidad}}Bs.</div>
        </div>
      </q-card-section>
    </q-card>
    <q-form>
      <div class="row">
        <div class="col-4">
          <q-input v-model="monto" dense outlined label="Monto" type="number" step="0.1">
            <template v-slot:append>
              <div class="text-subtitle1">Bs.</div>
            </template>
          </q-input>
        </div>
        <div class="col-4">
          <div :class="`bg-${porCobrar>0?'red':'green'}-3 text-${porCobrar>0?'red':'green'}-8 text-bold q-ma-xs q-pa-xs`" :style="`border: 1px solid ${porCobrar>0?'red':'green'};border-radius: 5px`">
            {{porCobrar>0?'POR COBRAR':'CANCELADO'}}
          </div>
        </div>
        <div class="col-4"><q-btn color="green" icon="check_circle" label="Guardar" @click="saleSave" /></div>
        <div class="col-12">
          {{porCobrar}}
        </div>
      </div>

    </q-form>
  </div>
  <div class="col-12">
<!--    <pre>{{clients}}</pre>-->
  </div>
</div>
</q-page>
</template>

<script>
export default {
  name: `Sale`,
  data() {
    return {
      monto: 0,
      products: [],
      product: {},
      clients2: [],
      clients: [],
      client: '',
      productSales:[],
      type: this.$route.params.type
    }
  },
  mounted() {
    this.$watch(
      () => this.$route.params.type,
      (toParams, previousParams) => {
        console.log('nuevo', toParams)
        console.log('antiguo', previousParams)
        if (toParams == undefined) {
          return false
        }
        this.datosGet(toParams)
        this.type = toParams
      }
    )
    this.datosGet(this.type)
  },
  methods: {
    saleSave(){

    },
    datosGet(type){
      this.products = []
      this.$api.get(`/listaproducto/${type}`).then(res => {
        res.data.forEach(p => {
          p.cantidad=0
          this.products.push(p)
        })
      })
      this.clients = []
      this.clients2 = []
      this.$api.get(`/listacliente/${type}`).then(res => {
        res.data.forEach(c => {
          c.label=c.titular
          this.clients2.push(c)
          this.clients.push(c)
        })
      })
    },
    filterFn (val, update) {
      if (val === '') {
        update(() => {
          this.clients = this.clients2
        })
        return
      }
      update(() => {
        const needle = val.toLowerCase()
        this.clients = this.clients2.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    saleClear(){
      this.productSales=[]
      this.products.forEach(p => {
        p.cantidad=0
      })
    },
    saleAdd(p) {
      p.cantidad++
      let find = this.productSales.find(ps => ps.id == p.id)
      if (find) {
        find.cantidad++
      } else {
        this.productSales.push({
          id: p.id,
          nombre: p.nombre,
          precio: p.precio,
          cantidad: 1
        })
      }
    }
  },
  computed: {
    total() {
      let total = 0
      this.productSales.forEach(p => {
        total += p.precio * p.cantidad
      })
      return total
    },
    porCobrar() {
      return this.total - this.monto
    }
  }
}
</script>

<style scoped>
.no_selection {
  -webkit-user-select: none;
  -moz-user-select: none;
  -khtml-user-select: none;
  -ms-user-select:none;
  cursor: pointer;
}
</style>
