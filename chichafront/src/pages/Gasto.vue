<template>
  <q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <div class="text-subtitle1 bg-red text-center text-white">Control de gastos</div>
    </div>
    <div class="col-6 col-sm-4 q-pa-xs"><q-input type="date" label="fecha" v-model="fecha1" outlined required/></div>
    <div class="col-6 col-sm-4 q-pa-xs"><q-input type="date" label="fecha" v-model="fecha2" outlined required/></div>
    <div class="col-6 col-sm-4 q-pa-xs flex flex-center">
      <q-btn color="info"  label="Consultar" icon="search" type="submit" @click="misgastos" />
    </div>
    <div class="col-12">
      <q-form @submit.prevent="agregar">
        <div class="row">
          <div class="col-12 q-pa-xs col-sm-3"><q-input outlined type="number" label="Precio" v-model="empleado.precio" required/></div>
          <div class="col-12 q-pa-xs col-sm-3"><q-input outlined label="Observacion" v-model="empleado.observacion" style="text-transform: uppercase" required/></div>
<!--          <div class="col-12 q-pa-xs col-sm-2"><q-input outlined label="Fecha Nacimiento" v-model="empleado.fechanac" required/></div>-->
<!--          <div class="col-12 q-pa-xs col-sm-2"><q-input outlined label="Celular" v-model="empleado.celular"/></div>-->
<!--          <div class="col-12 q-pa-xs col-sm-2"><q-input outlined label="Salario" v-model="empleado.salario" type="number"/></div>-->
          <div class="col-12 q-pa-xs col-sm-2 flex flex-center">
            <q-btn icon="send" :label="boolcrear?'CREAR':'MODIFICAR'" type="submit" :color="boolcrear?'positive':'warning'"/>
          </div>
        </div>
      </q-form>
    </div>
    <div class="col-12">
      <q-table
      :columns="columns"
      :rows="gastos"
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
<!--            <q-btn-->
<!--              color="info"-->
<!--              icon-right="list"-->
<!--              no-caps-->
<!--              label="Sueldos"-->
<!--              flat-->
<!--              dense-->
<!--              @click="pagosval(props.row)"-->
<!--            />-->

            <!--              @click="deleteval(detalles.indexOf(props.row))"-->
          </q-td>
        </template>
      </q-table>

<!--      <div class="row">-->
<!--        <div class="col-12">-->
<!--&lt;!&ndash;          <div class="text-subtitle1 bg-accent text-center text-white">Historial de pagos</div>&ndash;&gt;-->
<!--        </div>-->

<!--        <div class="col-12">-->
<!--          <q-table-->
<!--            :columns="columns3"-->
<!--            :rows="gastos"-->
<!--            title="Historial de pagos"-->

<!--          >-->
<!--&lt;!&ndash;            :filter="filter"&ndash;&gt;-->

<!--            &lt;!&ndash;        <template v-slot:top-right>&ndash;&gt;-->
<!--            &lt;!&ndash;          <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">&ndash;&gt;-->
<!--            &lt;!&ndash;            <template v-slot:append>&ndash;&gt;-->
<!--            &lt;!&ndash;              <q-icon name="search" />&ndash;&gt;-->
<!--            &lt;!&ndash;            </template>&ndash;&gt;-->
<!--            &lt;!&ndash;          </q-input>&ndash;&gt;-->
<!--            &lt;!&ndash;        </template>&ndash;&gt;-->
<!--&lt;!&ndash;            <template v-slot:body="props">&ndash;&gt;-->
<!--&lt;!&ndash;              <q-tr :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                <q-td key="total" :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                  {{ props.row.total }}&ndash;&gt;-->
<!--&lt;!&ndash;                </q-td>&ndash;&gt;-->
<!--&lt;!&ndash;                <q-td key="acuenta" :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                  {{ props.row.acuenta }}&ndash;&gt;-->
<!--&lt;!&ndash;                </q-td>&ndash;&gt;-->
<!--&lt;!&ndash;                <q-td key="saldo" :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                  {{ props.row.saldo }}&ndash;&gt;-->
<!--&lt;!&ndash;                </q-td>&ndash;&gt;-->
<!--&lt;!&ndash;                <q-td key="estado" :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                  <q-badge :color="props.row.estado=='CANCELADO'?'positive':'negative'">{{ props.row.estado }}</q-badge>&ndash;&gt;-->
<!--&lt;!&ndash;                </q-td>&ndash;&gt;-->
<!--&lt;!&ndash;                <q-td key="local" :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                  {{ props.row.local }}&ndash;&gt;-->
<!--&lt;!&ndash;                </q-td>&ndash;&gt;-->
<!--&lt;!&ndash;                <q-td key="titular" :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                  {{ props.row.titular }}&ndash;&gt;-->
<!--&lt;!&ndash;                </q-td>&ndash;&gt;-->
<!--&lt;!&ndash;                <q-td key="user" :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                  {{ props.row.user }}&ndash;&gt;-->
<!--&lt;!&ndash;                </q-td>&ndash;&gt;-->
<!--&lt;!&ndash;              </q-tr>&ndash;&gt;-->
<!--&lt;!&ndash;            </template>&ndash;&gt;-->
<!--          </q-table>-->
<!--        </div>-->
<!--        <div class="col-12">-->
<!--          <q-btn label="Imprimir" icon="print" color="info" class="full-width" @click="imprimir"/>-->
<!--        </div>-->
<!--      </div>-->
      <div class="col-12">
        <q-btn label="Imprimir" icon="print" color="info" class="full-width" @click="imprimir"/>
      </div>

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
                  <q-select outlined label="Tipo" v-model="pago.tipo" :options="['DESCUENTO','ADELANTO','PAGO']"/>
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
import {jsPDF} from "jspdf";
export default {
  name: "Venta",
  data(){
    return{
      pagos:false,
      pago:{},
      empleados:[],
      empleadohistorial:{},
      boolcrear:true,
      gastos:[],
      empleado:{fechanac:'2000-01-01'},
      fecha1:date.formatDate( Date.now(),'YYYY-MM-DD'),
      fecha2:date.formatDate( Date.now(),'YYYY-MM-DD'),
      columns:[
        {name:'id',label:'Id',field:'id'},
        {name:'precio',label:'Precio',field:'precio'},
        {name:'observacion',label:'Observacion',field:'observacion'},
        {name:'fecha',label:'Fecha',field:'fecha'},
        {name:'hora',label:'Hora',field:'hora'},
        {name:'user',label:'Usuario',field:'user'},
        {name:'action',label:'Action',field:'action'},
      ],
      columns2:[
        {name:'fecha',label:'Fecha',field:'fecha'},
        {name:'hora',label:'Hora',field:'hora'},
        {name:'tipo',label:'Tipo',field:'tipo'},
        // {name:'detalle',label:'detalle',field:'detalle'},
        {name:'monto',label:'Monto',field:'monto'},
      ],
      columns3:[
        {name:'nombre',label:'Empleado',field:'nombre'},
        {name:'salario',label:'Sueldo',field:'salario'},
        {name:'pago',label:'Pago',field:'pago'},
        {name:'adelanto',label:'Adelanto',field:'adelanto'},
        // {name:'detalle',label:'detalle',field:'detalle'},
        {name:'descuento',label:'Descuento',field:'descuento'},
      ],
    }
  },
  mounted() {
    this.misgastos()
    // this.misempleados()
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
    imprimir(){
      let mc=this
      function header(){
        var img = new Image()
        img.src = 'logo.png'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'Historial de gastos')
        doc.text(5, 1.5,  'DE '+mc.fecha1+' AL '+mc.fecha2)
        doc.text(1, 3, 'Num')
        doc.text(3, 3, 'Precio')
        doc.text(5, 3, 'Observacion')
        doc.text(9, 3, 'Fecha')
        doc.text(11.5, 3, 'Hora')
        doc.text(13.5, 3, 'Usuario')
        // doc.text(18.5, 3, 'Usuario')
        doc.setFont(undefined,'normal')
      }
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
      doc.setFont("courier");
      doc.setFontSize(9);
      // var x=0,y=
      header()
      // let xx=x
      // let yy=y
      let y=0
      let cont=1
      this.gastos.forEach(r=>{
        console.log(r)
        // xx+=0.5
        y+=0.5
        // doc.text(1, y+3, r.total.toString())
        // doc.text(3, y+3, r.acuenta.toString())
        // doc.text(5, y+3, r.saldo.toString())
        // doc.text(7, y+3, r.estado.toString())
        // doc.text(9.5, y+3, r.local.toString())
        // doc.text(13.5, y+3, r.titular.toString())
        // doc.text(18.5, y+3, r.user.toString())
        doc.text(1, y+3, ''+cont)
        doc.text(3, y+3, r.precio)
        doc.text(5, y+3, r.observacion)
        doc.text(9, y+3, r.fecha)
        doc.text(11.5, y+3, r.hora)
        doc.text(13.5, y+3, r.user)

        cont++
        if (y+3>25){
          doc.addPage();
          header()
          y=0
        }
      })
      // doc.text(2, y+4, 'Ventas totales: ')
      // doc.text(5, y+4, this.ventat+'Bs')
      // doc.text(7, y+4, 'Por cobrar totales: ')
      // doc.text(11, y+4, this.porc+'Bs')
      // doc.text(14, y+4, 'Saldo totales: ')
      // doc.text(17, y+4, this.saldoc+'Bs')
      // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
      window.open(doc.output('bloburl'), '_blank');
    },
    misgastos(){
      this.$q.loading.show()
      this.gastos=[]
      this.$axios.post(process.env.API+'/misgastos',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
        console.log(res.data)
        // this.gastos=res.data
        res.data.forEach(r=>{
          this.gastos.push({
            id:r.id,
            observacion:r.observacion,
            precio:r.precio,
            fecha:r.fecha,
            hora:r.hora,
            user:r.user.name,
          })
        })
        this.$q.loading.hide()
      }).catch(err=>{
        this.$q.loading.hide()
        this.$q.notify({
          color:'red',
          icon:'error',
          message:err.response.data.message
        })
      })
    },
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
      this.empleado.observacion=this.empleado.observacion.toUpperCase()
      if (this.boolcrear){
        this.$axios.post(process.env.API+'/gasto',this.empleado).then(res=>{
          // this.ventas=res.data
          // console.log(res.data)
          this.$q.loading.hide()
          // this.empleados=res.data
          this.misgastos()
          this.empleado={}
          this.$q.notify({
            message:'Creado correctamente',
            icon:'info',
            color:'positive'
          })
        })
      }else{
        this.$axios.put(process.env.API+'/gasto/'+this.empleado.id,this.empleado).then(res=>{
          // this.ventas=res.data
          // console.log(res.data)
          this.$q.loading.hide()
          // this.empleados=res.data
          this.misgastos()
          this.boolcrear=true
          // this.empleado={fechanac: '2000-01-01'}
          this.empleado={}
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
        this.$axios.delete(process.env.API+'/gasto/'+index.id).then(res=>{
          this.$q.loading.hide()
          this.misgastos()
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
