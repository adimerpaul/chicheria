<template>
  <q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <div class="text-subtitle1 bg-primary text-center text-white">Control de empleados</div>
    </div>
    <div class="col-12">
      <q-form @submit.prevent="agregar">
        <div class="row">
          <div class="col-12 col-sm-2"><q-input outlined label="CI" v-model="empleado.ci" required/></div>
          <div class="col-12 col-sm-3"><q-input outlined label="Nombre" v-model="empleado.nombre" required/></div>
          <div class="col-12 col-sm-3"><q-input outlined label="Fecha Nacimiento" v-model="empleado.fechanac" required/></div>
          <div class="col-12 col-sm-2"><q-input outlined label="Celular" v-model="empleado.celular"/></div>
          <div class="col-12 col-sm-2 flex flex-center">
            <q-btn icon="send" :label="boolcrear?'CREAR':'MODIFICAR'" type="submit" :color="boolcrear?'positive':'warning'"/>
          </div>
        </div>
      </q-form>
    </div>
    <div class="col-12">
      <q-table
      :columns="columns"
      :rows="empleados"
      :rows-per-page-options="[50,100,0]"
      >
        <template v-slot:body-cell-action="props">
          <q-td :props="props">
            <q-btn
              color="warning"
              icon-right="edit"
              no-caps
              label="Modificar"
              flat
              dense
              @click="updateval(props.row)"
            />
            <q-btn
              color="negative"
              icon-right="delete"
              no-caps
              label="Eliminar"
              flat
              dense
              @click="deleteval(props.row)"
            />
            <q-btn
              color="info"
              icon-right="list"
              no-caps
              label="Sueldos"
              flat
              dense
              @click="pagosval(props.row)"
            />

            <!--              @click="deleteval(detalles.indexOf(props.row))"-->
          </q-td>
        </template>
      </q-table>
      <q-dialog v-model="pagos" full-width>
        <q-card>
          <q-card-section>
            <div class="text-h6">Historial de {{empleadohistorial.nombre}}</div>
          </q-card-section>
          <q-card-section class="q-pt-none">
            <q-form @submit.prevent="agregarpago">
              <div class="row">
                <div class="col-4">
                  <q-input outlined label="Monto" type="number" v-model="pago.monto" required/>
                </div>
                <div class="col-4">
                  <q-input outlined label="Detalle" v-model="pago.detalle"/>
                </div>
                <div class="col-4 flex flex-center">
                  <q-btn label="Agregar" type="submit" icon="send" color="info"/>
                </div>
              </div>
            </q-form>
            <q-table
            title="Hitorial de pagos"
            :rows-per-page-options="[50,100,0]"
            :columns="columns2"
            :rows="empleadohistorial.sueldos"
            ></q-table>
          </q-card-section>
          <q-card-actions align="right" class="bg-white text-teal">
            <q-btn flat label="OK" v-close-popup />
          </q-card-actions>
        </q-card>
      </q-dialog>
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
      pagos:false,
      pago:{},
      empleados:[],
      empleadohistorial:{},
      boolcrear:true,
      empleado:{fechanac:'2000-01-01'},

      columns:[
        {name:'ci',label:'ci',field:'ci'},
        {name:'nombre',label:'nombre',field:'nombre'},
        {name:'fechanac',label:'fechanac',field:'fechanac'},
        {name:'celular',label:'celular',field:'celular'},
        {name:'action',label:'action',field:'action'},
      ],
      columns2:[
        {name:'fecha',label:'fecha',field:'fecha'},
        {name:'hora',label:'hora',field:'hora'},
        {name:'monto',label:'monto',field:'monto'},
        {name:'detalle',label:'detalle',field:'detalle'},
        {name:'action',label:'action',field:'action'},
      ],
    }
  },
  mounted() {
    this.misempleados()
    // console.log(this.$store.state.login)
    // this.$axios.get(process.env.API+'/cliente').then(res=>{
    //   this.clientes=res.data
    //   this.cliente=res.data[0]
    // })
    // this.$axios.get(process.env.API+'/producto').then(res=>{
    //   this.productos=res.data
    //   this.producto=res.data[0]
    // })
    // this.$axios.post(process.env.API+'/misventas',{fecha:this.fecha2}).then(res=>{
    //   this.venta=res.data
    //   // console.log(this.venta)
    //   // this.producto=res.data[0]
    // })
    // this.$axios.post(process.env.API+'/me').then(res=>{
    //   // console.log(res.data)
    //   this.responsable=res.data.name
    // })
    // this.responsable=this.$store.getters["login/user"].name
  },
  methods:{
    agregarpago(){
      // console.log('a');
      this.pago.empleado_id=this.empleadohistorial.id
      // console.log(this.pago)
      // return false

      this.$axios.post(process.env.API+'/sueldo',this.pago).then(res=>{
        this.empleadohistorial=res.data
        this.pago={}
      })
    },
    misempleados(){
      this.$q.loading.show()
      this.$axios.get(process.env.API+'/empleado').then(res=>{
        // this.ventas=res.data
        // console.log(res.data)
        this.$q.loading.hide()
        this.empleados=res.data
        // res.data.forEach(r=>{
        //   this.ventas.push({
        //     total:r.total,
        //     acuenta:r.acuenta,
        //     saldo:r.saldo,
        //     estado:r.estado,
        //     cliente:r.cliente.local,
        //     user:r.user.name,
        //   })
        // })
      })
    },
    agregar(){
      this.$q.loading.show()
      if (this.boolcrear){
        this.$axios.post(process.env.API+'/empleado',this.empleado).then(res=>{
          // this.ventas=res.data
          // console.log(res.data)
          this.$q.loading.hide()
          // this.empleados=res.data
          this.misempleados()
          this.empleado={fechanac: '2000-01-01'}
          this.$q.notify({
            message:'Creado correctamente',
            icon:'info',
            color:'positive'
          })
        })
      }else{
        this.$axios.put(process.env.API+'/empleado/'+this.empleado.id,this.empleado).then(res=>{
          // this.ventas=res.data
          // console.log(res.data)
          this.$q.loading.hide()
          // this.empleados=res.data
          this.misempleados()
          this.boolcrear=true
          this.empleado={fechanac: '2000-01-01'}
          this.$q.notify({
            message:'Creado correctamente',
            icon:'info',
            color:'positive'
          })
        })
      }


    },
    guardar(){
      // console.log(this.detalles)
      // return  false
      if (this.detalles.length==0){
        this.$q.notify({
         message:'Tienes que tener un detalle de ventas',
         color:'red',
         icon:'error'
        })
        return false;
      }
      // return false
      this.$q.loading.show()
      this.$axios.post(process.env.API+'/venta',{
        total:this.total,
        acuenta:this.acuenta,
        saldo:this.saldo,
        estado:this.estado,
        cliente_id:this.cliente.id,
        detalles:this.detalles
      }).then(res=>{
        // console.log(res.data)
        this.$q.notify({
          message:'Venta exitosa',
          color:'green',
          icon:'info'
        })
        this.misventas()
      })
    },
    deleteval(index){
      // this.detalles.splice(index, 1);
      // console.log(index)
      this.$q.dialog({
        title:'Seguro de eliminar?',
        cancel:true,
      }).onOk(()=>{
        this.$q.loading.show()
        this.$axios.delete(process.env.API+'/empleado/'+index.id).then(res=>{
          this.$q.loading.hide()
          this.misempleados()
          this.$q.notify({
            message:'Borrado correctamente',
            icon:'info',
            color:'positive'
          })
        }).catch(err=>{
          // console.log(err.response)
          this.$q.loading.hide()
          this.$q.notify({
            message:err.response.data.message,
            icon:'error',
            color:'red'
          })
        })
      })

    },
    updateval(index){
      this.empleado=index
      this.boolcrear=false
      // this.detalles.splice(index, 1);
      // console.log(index)
      // this.$q.loading.show()
      // this.$axios.delete(process.env.API+'/empleado/'+index.id).then(res=>{
      //   this.$q.loading.hide()
      //   this.misempleados()
      // }).catch(err=>{
      //   // console.log(err.response)
      //   this.$q.loading.hide()
      //   this.$q.notify({
      //     message:err.response.data.message,
      //     icon:'error',
      //     color:'red'
      //   })
      // })
    },
    pagosval(index){
      // console.log('a')
      this.pagos=true
      this.$q.loading.show()
      this.$axios.get(process.env.API+'/empleado/'+index.id).then(res=>{
        // console.log(res.data);
        this.empleadohistorial=res.data
        this.$q.loading.hide()
      })
    }
  },
  // computed:{
  //   subtotal(){
  //     if (this.producto.precio!=undefined && this.producto.precio!=NaN){
  //       return parseFloat(this.producto.precio)* parseFloat(this.cantidad)
  //     }
  //     else{
  //       return 0
  //     }
  //   },
  //   total(){
  //     let total=0;
  //     this.detalles.forEach(r=>{
  //       total+= parseFloat(r.subtotal)
  //     })
  //     return total
  //   },
  //   estado(){
  //     if (this.acuenta<this.total)
  //       return 'POR COBRAR'
  //     else
  //       return 'CANCELADO'
  //   },
  //   saldo(){
  //     return this.total-this.acuenta
  //   }
  // }
}
</script>

<style scoped>

</style>
