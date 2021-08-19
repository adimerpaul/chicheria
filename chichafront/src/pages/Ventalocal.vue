<template>
<q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <div class="text-subtitle1 bg-blue-9 text-center text-white">Ventas</div>
    </div>
    <div class="col-12">
      <q-form @submit.prevent="guardar">
        <div class="row">
          <div class="col-6 col-sm-6 q-pa-xs"><q-input type="date" label="fecha" v-model="fecha" outlined required/></div>
          <div class="col-6 col-sm-6 q-pa-xs"><q-input type="text" label="Responsable" v-model="responsable" outlined required/></div>
        </div>
        <div class="row">
          <div class="col-6 col-sm-2 q-pa-xs"><q-select v-model="cliente" outlined :options="clientes" option-label="local" option-value="id" label="Local" required/></div>
          <div class="col-6 col-sm-2 q-pa-xs"><q-select v-model="producto" outlined :options="productos" option-label="nombre" option-value="id" label="Producto" required/></div>
          <div class="col-6 col-sm-1 q-pa-xs">
            <q-input
            type="number"
            label="precio"
            v-model="producto.precio"
            outlined
            required />
          </div>
          <div class="col-6 col-sm-2 q-pa-xs">
<!--            <q-input type="number" label="Cantidad" v-model="cantidad" outlined/>-->
            <q-select label="Cantidad" :options="cantidades" v-model="cantidad" outlined/>
          </div>
          <div class="col-6 col-sm-1 q-pa-xs"><q-input type="text" disable label="Subtotal" label-color="white"  bg-color="positive" v-model="subtotal" outlined/></div>
          <div class="col-6 col-sm-1 q-pa-xs"><q-input type="text" label="A cuenta" label-color="white" bg-color="accent" v-model="acuenta" outlined/></div>
          <div class="col-6 col-sm-1 q-pa-xs"><q-input type="text" label="Saldo" v-model="saldo" label-color="white" :bg-color="subtotal>acuenta?'negative':'positive'" disable outlined/></div>
          <div class="col-6 col-sm-2 q-pa-xs"><q-input type="text" label="Estado" v-model="estado" label-color="white" :bg-color="subtotal>acuenta?'negative':'positive'" outlined/></div>
          <div class="col-12 col-sm-12 q-pa-xs flex flex-center">
            <q-btn color="warning" class="full-width"  label="Agregar" icon="send" type="submit" />
          </div>
        </div>
      </q-form>
    </div>
<!--    <div class="col-12">-->
<!--      <q-table-->
<!--      :columns="columns"-->
<!--      :rows="detalles"-->
<!--      >-->
<!--        <template v-slot:body-cell-action="props">-->
<!--          <q-td :props="props">-->
<!--            <q-btn-->
<!--              color="negative"-->
<!--              icon-right="delete"-->
<!--              no-caps-->
<!--              flat-->
<!--              dense-->
<!--              @click="deleteval(detalles.indexOf(props.row))"-->
<!--            />-->
<!--          </q-td>-->
<!--        </template>-->
<!--      </q-table>-->
<!--    </div>-->

<!--    <div class="col-12">-->
<!--      <q-form @submit.prevent="guardar">-->
<!--        <div class="row">-->
<!--          <div class="col-6 col-sm-2 q-pa-xs"><q-input type="text" label="Total" v-model="total" disable outlined/></div>-->
<!--          <div class="col-6 col-sm-2 q-pa-xs"><q-input type="text" label="Acuenta" v-model="acuenta" outlined/></div>-->
<!--          <div class="col-6 col-sm-2 q-pa-xs"><q-input type="text" label="Saldo" v-model="saldo" disable outlined/></div>-->
<!--          <div class="col-6 col-sm-2 q-pa-xs"><q-input type="text" label="Estado" v-model="estado" outlined/></div>-->
<!--          <div class="col-6 col-sm-2 q-pa-xs flex flex-center">-->
<!--            <q-btn color="positive"  label="Venta" icon="shop" type="submit" />-->
<!--          </div>-->
<!--        </div>-->
<!--      </q-form>-->
<!--    </div>-->
    <div class="col-12">
      <div class="text-subtitle1 bg-info text-center text-white">Historial de ventas</div>
    </div>
    <div class="col-6 col-sm-4 q-pa-xs"><q-input type="date" label="fecha" v-model="fecha2" outlined required/></div>
    <div class="col-6 col-sm-4 q-pa-xs"><q-input type="date" label="fecha" v-model="fecha3" outlined required/></div>
    <div class="col-6 col-sm-4 q-pa-xs flex flex-center">
      <q-btn color="info"  label="Consultar" icon="search" type="submit" @click="misventas" />
    </div>
    <div class="col-12">
      <q-table
        :columns="columns2"
        :rows="ventas"
        title="Historial de ventas"
        :filter="filter"
      >
<!--        <template v-slot:top-right>-->
<!--          <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">-->
<!--            <template v-slot:append>-->
<!--              <q-icon name="search" />-->
<!--            </template>-->
<!--          </q-input>-->
<!--        </template>-->
        <template v-slot:body="props">
          <q-tr :props="props">
            <q-td key="total" :props="props">
              {{ props.row.total }}
            </q-td>
            <q-td key="acuenta" :props="props">
              {{ props.row.acuenta }}
            </q-td>
            <q-td key="saldo" :props="props">
              {{ props.row.saldo }}
            </q-td>
            <q-td key="estado" :props="props">
              <q-badge :color="props.row.estado=='CANCELADO'?'positive':'negative'">{{ props.row.estado }}</q-badge>
            </q-td>
            <q-td key="cliente" :props="props">
              {{ props.row.cliente }}
            </q-td>
            <q-td key="user" :props="props">
              {{ props.row.user }}
            </q-td>
          </q-tr>
        </template>
      </q-table>
    </div>
    <div class="col-12">
      <q-form>
        <div class="row">
          <div class="col-4 q-pa-md">
            <q-input type="text" label="Venta total" label-color="positive"  v-model="acuenta"  outlined/>
          </div>
          <div class="col-4 q-pa-md">
            <q-input type="text" label="Saldo caja" label-color="info"  v-model="acuenta"  outlined/>
          </div>
          <div class="col-4 q-pa-md">
            <q-input type="text" label="Por cobrar" label-color="negative"  v-model="acuenta"  outlined/>
          </div>
        </div>

      </q-form>
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
      fecha3:date.formatDate(new Date(),'YYYY-MM-DD'),
      responsable:'',
      clientes:[],
      cliente:'',
      productos:[],
      producto:'',
      cantidad:1,
      cantidades:[],
      acuenta:0,
      detalles:[],
      columns:[
        {name:'nombreproducto',label:'Nombre producto',field:'nombreproducto'},
        {name:'precio',label:'Precio',field:'precio'},
        {name:'cantidad',label:'Cantidad',field:'cantidad'},
        {name:'subtotal',label:'Subtotal',field:'subtotal'},
        { name: 'action', label: 'Borrar', field: 'action' }
      ],
      columns2:[
        {name:'total',label:'Total',field:'total'},
        {name:'acuenta',label:'A cuenta',field:'acuenta'},
        {name:'saldo',label:'Saldo',field:'saldo'},
        {name:'estado',label:'Estado',field:'estado'},
        {name:'cliente',label:'Cliente',field:'cliente'},
        {name:'user',label:'Usuario',field:'user'},
      ],
      ventas:[],
      filter:''
    }
  },
  mounted() {
    for (let i=1;i<=100;i++){
      this.cantidades.push(i)
    }
    this.misventas()
    // console.log(this.$store.state.login)
    this.$axios.get(process.env.API+'/cliente').then(res=>{
      this.clientes=res.data
      this.cliente=res.data[0]
    })
    this.$axios.get(process.env.API+'/producto').then(res=>{
      this.productos=res.data
      this.producto=res.data[0]
    })
    // this.$axios.post(process.env.API+'/misventas',{fecha:this.fecha2}).then(res=>{
    //   this.venta=res.data
    //   // console.log(this.venta)
    //   // this.producto=res.data[0]
    // })
    this.$axios.post(process.env.API+'/me').then(res=>{
      // console.log(res.data)
      this.responsable=res.data.name
    })
    // this.responsable=this.$store.getters["login/user"].name
  },
  methods:{
    misventas(){
      this.$q.loading.show()
      this.$axios.post(process.env.API+'/misventas',{fecha1:this.fecha2,fecha2:this.fecha3}).then(res=>{
        // this.ventas=res.data
        // console.log(res.data)
        this.$q.loading.hide()
        this.ventas=[]
        res.data.forEach(r=>{
          this.ventas.push({
            total:r.total,
            acuenta:r.acuenta,
            saldo:r.saldo,
            estado:r.estado,
            cliente:r.cliente.local,
            user:r.user.name,
          })
        })
      })
    },
    agregar(){
      // console.log('a')
      // this.detalles.push({
      //   nombreproducto:this.producto.nombre,
      //   precio:this.producto.precio,
      //   producto_id:this.producto.id,
      //   cantidad:this.cantidad,
      //   subtotal:this.subtotal,
      // })
    },
    guardar(){
      // if (this.detalles.length==0){
      //   this.$q.notify({
      //     message:'Tienes que tener un detalle de ventas',
      //     color:'red',
      //     icon:'error'
      //   })
      //   return false;
      // }
      // console.log(this.detalles)
      // return  false
      // return false
      this.$q.loading.show()
      // console.log({
      //   nombreproducto:this.producto.nombre,
      //   precio:this.producto.precio,
      //   producto_id:this.producto.id,
      //   cantidad:this.cantidad,
      //   subtotal:this.subtotal,
      // })
      // return false
      this.$axios.post(process.env.API+'/venta',{
        total:this.subtotal,
        acuenta:this.acuenta,
        saldo:this.saldo,
        estado:this.estado,
        tipo:'LOCAL',
        cliente_id:this.cliente.id,
        detalles:[{
          nombreproducto:this.producto.nombre,
          precio:this.producto.precio,
          producto_id:this.producto.id,
          cantidad:this.cantidad,
          subtotal:this.subtotal,
        }]
      }).then(res=>{
        console.log(res.data)
        this.$q.notify({
          message:'Venta exitosa',
          color:'green',
          icon:'info'
        })
        this.misventas()
      }).catch(err=>{
        this.$q.loading.hide()
        console.error(err)
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'error'
        })
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
      if (this.acuenta<this.subtotal)
        return 'POR COBRAR'
      else
        return 'CANCELADO'
    },
    saldo(){
      return this.subtotal-this.acuenta
    },
  }
}
</script>

<style scoped>

</style>
