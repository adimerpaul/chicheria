<template>
<q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <div class="text-subtitle1 bg-blue-9 text-center text-white">Ventas</div>
    </div>
    <div class="col-12">
      <q-form @submit.prevent="agregar">
        <div class="row">
          <div class="col-6 col-sm-6 q-pa-xs"><q-input type="date" label="fecha" v-model="fecha" outlined required/></div>
          <div class="col-6 col-sm-6 q-pa-xs"><q-input type="text" label="Responsable" v-model="responsable" outlined required/></div>
        </div>
        <div class="row">
          <div class="col-6 col-sm-2 q-pa-xs"><q-select v-model="cliente" outlined :options="clientes" option-label="local" option-value="id" label="Local" required/></div>
          <div class="col-6 col-sm-2 q-pa-xs"><q-select v-model="producto" outlined :options="productos" option-label="nombre" option-value="id" label="Producto" required/></div>
          <div class="col-6 col-sm-2 q-pa-xs">
            <q-input
            type="number"
            label="precio"
            v-model="producto.precio"
            outlined
            required />
          </div>
          <div class="col-6 col-sm-2 q-pa-xs"><q-input type="number" label="Cantidad" v-model="cantidad" outlined/></div>
          <div class="col-6 col-sm-2 q-pa-xs"><q-input type="text" disable label="Subtotal" v-model="subtotal" outlined/></div>
          <div class="col-6 col-sm-2 q-pa-xs flex flex-center">
            <q-btn color="primary"  label="Agregar" icon="send" type="submit" />
          </div>
        </div>
      </q-form>
    </div>
    <div class="col-12">
<!--      <div class="text-subtitle1 bg-blue-9 text-center text-white">Venta</div>-->
<!--      {{productos}}-->
      <q-table
      :columns="columns"
      :rows="detalles"
      >
        <template v-slot:body-cell-action="props">
          <q-td :props="props">
            <q-btn
              color="negative"
              icon-right="delete"
              no-caps
              flat
              dense
              @click="deleteval(detalles.indexOf(props.row))"
            />
          </q-td>
        </template>
      </q-table>
    </div>

    <div class="col-12">
      <q-form @submit.prevent="agregar">
        <div class="row">
          <div class="col-6 col-sm-2 q-pa-xs"><q-input type="text" label="Total" v-model="total" outlined/></div>
          <div class="col-6 col-sm-2 q-pa-xs"><q-input type="text" label="Acuenta" v-model="acuenta" outlined/></div>
          <div class="col-6 col-sm-2 q-pa-xs"><q-input type="text" label="Saldo" v-model="saldo" outlined/></div>
          <div class="col-6 col-sm-2 q-pa-xs"><q-input type="text" label="Estado" v-model="estado" outlined/></div>
          <div class="col-6 col-sm-2 q-pa-xs flex flex-center">
            <q-btn color="positive"  label="Venta" icon="shop" type="submit" />
          </div>
        </div>
      </q-form>
    </div>
    <div class="col-12">
      <div class="text-subtitle1 bg-blue-9 text-center text-white">Historial de ventas</div>
    </div>
  </div>
</q-page>
</template>

<script>
import {date} from 'quasar'
export default {
  name: "Venta",
  data(){
    return{
      fecha:date.formatDate(new Date(),'YYYY-MM-DD'),
      fecha2:date.formatDate(new Date(),'YYYY-MM-DD'),
      responsable:'',
      clientes:[],
      cliente:'',
      productos:[],
      producto:'',
      cantidad:1,
      acuenta:0,
      detalles:[],
      columns:[
        {name:'nombreproducto',label:'Nombre producto',field:'nombreproducto'},
        {name:'precio',label:'Precio',field:'precio'},
        {name:'cantidad',label:'Cantidad',field:'cantidad'},
        {name:'subtotal',label:'Subtotal',field:'subtotal'},
        { name: 'action', label: 'Borrar', field: 'action' }
      ]
    }
  },
  mounted() {
    // console.log(this.$store.state.login)
    this.$axios.get(process.env.API+'/cliente').then(res=>{
      this.clientes=res.data
      this.cliente=res.data[0]
    })
    this.$axios.get(process.env.API+'/producto').then(res=>{
      this.productos=res.data
      this.producto=res.data[0]
    })
    this.$axios.post(process.env.API+'/me').then(res=>{
      // console.log(res.data)
      this.responsable=res.data.name
    })
    // this.responsable=this.$store.getters["login/user"].name
  },
  methods:{
    agregar(){
      // console.log('a')
      this.detalles.push({
        nombreproducto:this.producto.nombre,
        precio:this.producto.precio,
        cantidad:this.cantidad,
        subtotal:this.subtotal,
      })
    },
    deleteval(index){
      this.detalles.splice(index, 1);
    }
  },
  computed:{
    subtotal(){
      if (this.producto.precio!=undefined && this.producto.precio!=NaN){
        return parseFloat(this.producto.precio)* parseFloat(this.cantidad)
      }
      else{
        return 0
      }
    },
    total(){
      let total=0;
      this.detalles.forEach(r=>{
        total+= parseFloat(r.subtotal)
      })
      return total
    },
    estado(){
      if (this.acuenta<this.total)
        return 'POR COBRAR'
      else
        return 'CANCELADO'
    },
    saldo(){
      return this.total-this.acuenta
    }
  }
}
</script>

<style scoped>

</style>
