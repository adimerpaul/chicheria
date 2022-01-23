
<template>
  <q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <div class="text-subtitle1 bg-primary text-center text-white">Control de empleados</div>
    </div>
    <div class="col-12">
      <q-form @submit.prevent="agregar">
        <div class="row">
          <div class="col-12 q-pa-xs col-sm-1"><q-input outlined label="CI" v-model="empleado.ci" required/></div>
          <div class="col-12 q-pa-xs col-sm-3"><q-input outlined label="Nombre" v-model="empleado.nombre" required/></div>
          <div class="col-12 q-pa-xs col-sm-2"><q-input outlined label="Fecha Nacimiento" type="date" v-model="empleado.fechanac" required/></div>
          <div class="col-12 q-pa-xs col-sm-2"><q-input outlined label="Celular" v-model="empleado.celular"/></div>
          <div class="col-12 q-pa-xs col-sm-2"><q-input outlined label="Salario" v-model="empleado.salario" type="number"/></div>
          <div class="col-12 q-pa-xs col-sm-2 flex flex-center">
            <q-btn icon="send" label="CREAR" type="submit" color="positive"/>
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
      <div class="row">
        <div class="col-12">
          <div class="text-subtitle1 bg-accent text-center text-white">Historial de pagos</div>
        </div>
        <div class="col-6 col-sm-4 q-pa-xs"><q-input type="date" label="fecha" v-model="fecha1" outlined required/></div>
        <div class="col-6 col-sm-4 q-pa-xs flex flex-center">
          <q-btn color="info"  label="Consultar" icon="search" type="submit" @click="missalarios" />
        </div>
        <div class="col-12">
          <q-table
            :columns="columns3"
            :rows="salarios"
            title="Historial de pagos"

          >
<!--            :filter="filter"-->

            <!--        <template v-slot:top-right>-->
            <!--          <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">-->
            <!--            <template v-slot:append>-->
            <!--              <q-icon name="search" />-->
            <!--            </template>-->
            <!--          </q-input>-->
            <!--        </template>-->
<!--            <template v-slot:body="props">-->
<!--              <q-tr :props="props">-->
<!--                <q-td key="total" :props="props">-->
<!--                  {{ props.row.total }}-->
<!--                </q-td>-->
<!--                <q-td key="acuenta" :props="props">-->
<!--                  {{ props.row.acuenta }}-->
<!--                </q-td>-->
<!--                <q-td key="saldo" :props="props">-->
<!--                  {{ props.row.saldo }}-->
<!--                </q-td>-->
<!--                <q-td key="estado" :props="props">-->
<!--                  <q-badge :color="props.row.estado=='CANCELADO'?'positive':'negative'">{{ props.row.estado }}</q-badge>-->
<!--                </q-td>-->
<!--                <q-td key="local" :props="props">-->
<!--                  {{ props.row.local }}-->
<!--                </q-td>-->
<!--                <q-td key="titular" :props="props">-->
<!--                  {{ props.row.titular }}-->
<!--                </q-td>-->
<!--                <q-td key="user" :props="props">-->
<!--                  {{ props.row.user }}-->
<!--                </q-td>-->
<!--              </q-tr>-->
<!--            </template>-->
      <template v-slot:body-cell-opcion="props">
        <q-td :props="props">
          <div>
            <template v-if="$store.state.login.reimpresion" >
              <q-btn icon="print" color="yellow" @click="imprimirboleta(props.row)"/>
            </template>
          </div>
        </q-td>
      </template>
          </q-table>
        </div>
        <div class="col-12">
          <q-btn label="Imprimir" icon="print" color="info" class="full-width" @click="imprimir"/>
        </div>
      </div>

    <q-dialog v-model="modempleado" >
      <q-card style="min-width: 350px">
    <div class="col-12">
      <div class="text-subtitle1 bg-primary text-center text-white">Modificar empleados</div>
    </div>
    <div class="col-12">
      <q-form @submit.prevent="modificar">
          <div class="col-12 q-pa-xs col-sm-2"><q-input outlined label="CI" v-model="empleado2.ci" required/></div>
          <div class="col-12 q-pa-xs col-sm-3"><q-input outlined label="Nombre" v-model="empleado2.nombre" required/></div>
          <div class="col-12 q-pa-xs col-sm-2"><q-input outlined label="Fecha Nacimiento" type="date" v-model="empleado2.fechanac" required/></div>
          <div class="col-12 q-pa-xs col-sm-2"><q-input outlined label="Celular" v-model="empleado2.celular"/></div>
          <div class="col-12 q-pa-xs col-sm-2"><q-input outlined label="Salario" v-model="empleado2.salario" type="number"/></div>
          <div class="col-12 q-pa-xs col-sm-2 flex flex-center">
            <q-btn icon="edit" label="MODIFICAR" type="submit" color="warning"/>
          </div>
      </q-form>
    </div>
      </q-card>
    </q-dialog>

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
                  <q-select outlined label="Tipo" v-model="pago.tipo" :options="['DESCUENTO','ADELANTO','EXTRA']"/>
                </div>
                <div class="col-4">
                  <q-input outlined type="text" label="observacion" v-model="pago.observacion" />
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
      empleados2:[],
      empleadohistorial:{},
      boolcrear:true,
      salarios:[],
      modempleado:false,
      empleado:{fechanac:'2000-01-01'},
      fecha1:date.formatDate( Date.now(),'YYYY-MM-DD'),
      fecha2:date.formatDate( Date.now(),'YYYY-MM-DD'),
      columns:[
        {name:'ci',label:'CI',field:'ci'},
        {name:'nombre',label:'Nombre',field:'nombre'},
        {name:'fechanac',label:'Fechanac',field:'fechanac'},
        {name:'celular',label:'Celular',field:'celular'},
        {name:'salario',label:'Salario',field:'salario'},
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
        {name:'adelanto',label:'Adelanto',field:'adelanto'},
        // {name:'detalle',label:'detalle',field:'detalle'},
        {name:'descuento',label:'Descuento',field:'descuento'},
        {name:'extra',label:'Extra',field:'extra'},
        {name:'opcion',label:'opcion',field:'opcion'},
      ],
    }
  },
  mounted() {
    this.missalarios()
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
    imprimirboleta(boleta){
      let total=0;
      total = boleta.salario - boleta.adelanto - boleta.descuento;
      let cadena='<div>nombre: '+boleta.nombre+'</div><div>Salario: '+boleta.salario+'</div><div>adelanto: '+boleta.adelanto+'</div><div>descuento: '+boleta.descuento+'</div> <div>Total: '+total+'</div><br><br><div style="text-align:center">FIRMA</div>';
            let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
            myWindow.document.write(cadena);
            myWindow.document.close();
            myWindow.focus();
            setTimeout(function(){
              myWindow.print();
              myWindow.close();
              // impDetalle(response);
              //    impAniv(response);
            },500);
    },
      imprimir(){

        let mc=this
        function header(){
          var img = new Image()
          img.src = 'logo.png'
          doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
          doc.setFont(undefined,'bold')
          doc.text(5, 1, 'Historial de prestmos Sueldos pagos Adelantos')
          doc.text(5, 1.5,  'DE '+mc.fecha1)
          doc.text(1, 3, 'Empleado')
          doc.text(5, 3, 'Sueldo')
          doc.text(7, 3, 'Extra')
          doc.text(9, 3, 'Adelanto')
          doc.text(11, 3, 'Descuento')
          doc.text(14, 3, 'Pago')
          // doc.text(13.5, 3, 'Estado')
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
        this.salarios.forEach(r=>{
          // xx+=0.5
          let extra=r.extra==null?0:r.extra;
          let adelanto=r.adelanto==null?0:r.adelanto;
          let descuento=r.descuento==null?0:r.descuento;
          let total= r.salario - adelanto - descuento;
          y+=0.5
          doc.text(1, y+3, ''+r.nombre)
          doc.text(5, y+3, ''+r.salario)
          doc.text(7, y+3, r.extra==null?'':''+r.extra)
          doc.text(9, y+3, r.adelanto==null?'':''+r.adelanto)
          doc.text(11, y+3, r.descuento==null?'':''+r.descuento)
          doc.text(14, y+3, ''+total)
          // doc.text(13.5, y+3, r.estado.toString())
          // doc.text(18.5, y+3, r.name.toString())
          if (y+3>25){
            doc.addPage();
            header()
            y=0
          }
        })
        // doc.text(2, y+4, 'Ventas totales: ')
        // doc.text(5, y+4, this.ventat+'Bs')
        // doc.text(7, y+4, 'Por cobrar totales: ')
        // doc.text(11, y+4, this.ventat+'Bs')
        // doc.text(14, y+4, 'Saldo totales: ')
        // doc.text(17, y+4, this.ventat+'Bs')
        // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
        window.open(doc.output('bloburl'), '_blank');
    },
    missalarios(){
      this.$q.loading.show()
      this.$axios.post(process.env.API+'/missueldos',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
        console.log(res.data)
        this.salarios=res.data
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
    modificar(){
              this.$axios.put(process.env.API+'/empleado/'+this.empleado2.id,this.empleado2).then(res=>{
          this.misempleados()
          this.boolcrear=true
          this.empleado2=[]
          this.modempleado=false;
          this.$q.notify({
            message:'Modificado correctamente',
            icon:'info',
            color:'positive'
          })
        })
    },
    agregar(){
      this.$q.loading.show()
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
      this.empleado2=index
      this.modempleado=true
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
