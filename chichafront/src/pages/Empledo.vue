
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
        <div class="col-6 col-sm-4 q-pa-xs"><q-input type="date" label="fecha" v-model="fecha2" outlined required/></div>
        <div class="col-6 col-sm-4 q-pa-xs flex flex-center">
          <q-btn color="info"  label="Consultar" icon="search" type="submit" @click="missalarios" />
        </div>
        <div class="col-12">
            <div class=" responsive">
                <table id="example" style="width:100%">
                <thead>
                <tr>
                <th>EMPLEADO</th>
                <th>ADELANTO</th>
                <th>DESCUENTO</th>
                <th>EXTRA</th>
                <th>PAGO</th>
                <th>CANCELAR</th>
                <th>OPCION</th>
                </tr>
                </thead>
                  <tbody>
                  <tr v-for="v in salarios" :key="v.id">
                  <td>{{v.nombre}}</td>
                  <td>{{v.adelanto}}</td>
                  <td>{{v.descuento}}</td>
                  <td>{{v.extra}}</td>
                  <td>{{v.pago}}</td>
                  <td>{{v.cancelar}}</td>
                  <td>
                              <template v-if="$store.state.login.reimpresion" >
              <q-btn icon="print" dense color="yellow" @click="imprimirboleta(v)"/>
              <q-btn icon="money" dense color="green" @click="cancelar(v)" v-if="v.cancelar==undefined ||v.cancelar==0"/>
            </template></td>
                  </tr>
                  </tbody>
                </table>
            </div>
  <!--         <q-table
            :columns="columns3"
            :rows="salarios"
            title="Historial de pagos"

          >-->
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
   <!--   <template v-slot:body-cell-opcion="props">
        <q-td :props="props">
          <div>
            <template v-if="$store.state.login.reimpresion" >
              <q-btn icon="print" color="yellow" @click="imprimirboleta(props.row)"/>
            </template>
          </div>
        </q-td>
      </template>
          </q-table>-->
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
                <div class="col-2">
                  <q-select outlined label="Tipo" v-model="pago.tipo" :options="['DESCUENTO','ADELANTO','EXTRA','PAGO']"/>
                </div>
                <div class="col-2">
                  <q-input outlined label="Fecha" v-model="pago.fecha" type="date"/>
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
            >
                    <template v-slot:body-cell-opcion="props">
          <q-td :props="props">
            <q-btn  color="negative" icon-right="delete" no-caps flat dense @click="delsueldo(props.row)"/>
                <q-btn dense round flat color="teal" @click="printRow(props)" icon="print"></q-btn>

          </q-td>
        </template>
            </q-table>
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
import $ from "jquery";
import {date} from 'quasar'
import {jsPDF} from "jspdf";
export default {
  name: "Venta",
  data(){
    return{
      pagos:false,
      pago:{fecha:date.formatDate( Date.now(),'YYYY-MM-DD')},
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
        {name:'action',label:'Action',field:'action'},
      ],
      columns2:[
        {name:'fecha',label:'FECHA',field:'fecha',sortable: true},
        {name:'hora',label:'HORA',field:'hora'},
        {name:'tipo',label:'TIPO',field:'tipo',sortable: true},
        // {name:'detalle',label:'detalle',field:'detalle'},
        {name:'monto',label:'MONTO',field:'monto', sortable: true},
        {name:'opcion',label:'OPCION',field:'opcion'},
      ],
      columns3:[
        {name:'nombre',label:'Empleado',field:'nombre'},
        {name:'salario',label:'Sueldo',field:'salario'},
        {name:'adelanto',label:'Adelanto',field:'adelanto'},
        // {name:'detalle',label:'detalle',field:'detalle'},
        {name:'descuento',label:'Descuento',field:'descuento'},
        {name:'extra',label:'Extra',field:'extra'},
        {name:'pago',label:'Pago',field:'pago'},
        {name:'cancelar',label:'Cancelar',field:'cancelar'},
        {name:'opcion',label:'opcion',field:'opcion'},
      ],
    }
  },
  mounted() {
        $('#example').DataTable( {
      dom: 'Blfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    } );
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
        printRow(props){
      this.$axios.get(process.env.API + "/impade/"+props.row.id).then((res) => {
                let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.print();
        myWindow.close();
      })

    },
    delsueldo(sueldo){
      this.$axios.delete(process.env.API+'/sueldo/'+sueldo.id).then(res=>{
          this.$q.notify({
            message:'Eliminado',
            icon:'info',
            color:'green'
          })
          this.pagos=false
          this.misempleados()
      })

    },
    cancelar(boleta){
           let total=0;
      if(boleta.adelanto==null) boleta.adelanto=0;
      if(boleta.descuento==null) boleta.descuento=0;
      if(boleta.extra==null) boleta.extra=0;
      if(boleta.pago==null) boleta.pago=0;
      if(boleta.obs==null) boleta.obs='';
      total = boleta.salario - boleta.adelanto - boleta.descuento + boleta.pago; 
      this.$axios.post(process.env.API+'/cancelacion',{monto:total,fecha:this.fecha2,empleado_id:boleta.id,empleado_nombre:boleta.nombre}).then(res=>{
        this.missalarios();
        //console.log(res.data);
                  this.$q.notify({
            message:'Registro correctamente',
            icon:'info',
            color:'positive'
          })
      })

    },
    imprimirboleta(boleta){
      let total=0;
      if(boleta.adelanto==null) boleta.adelanto=0;
      if(boleta.descuento==null) boleta.descuento=0;
      if(boleta.extra==null) boleta.extra=0;
      if(boleta.pago==null) boleta.pago=0;
      if(boleta.obs==null) boleta.obs='';
      total = boleta.salario - boleta.adelanto - boleta.descuento + boleta.pago;
      let cadena="<div><img class='fondo' src='logo.png' style='height:20px'> Chicheria Doña Naty <span>"+date.formatDate( Date.now(),'YYYY-MM-DD')+"</span></div><br>";
      cadena+="<div style='text-align:center'>BOLETA DE PAGO "+date.formatDate( this.fecha1,'YYYY-MM')+"</div><hr>";
      cadena+="<div>Nombre: "+boleta.nombre+"</div><div>Salario Basico: "+boleta.salario+"</div>";
      cadena+="<div>CI: "+boleta.ci+"</div><div>Celular: "+boleta.celular+"</div><hr>";

      cadena+="<table style='width:100%'><thead><tr><th>INGRESOS</th><th>DESCUENTOS</th></tr></thead>";
      cadena+="<tbody><tr><td>Salario Basico:"+boleta.salario+"</td><td>Descuentos: "+boleta.descuento+"</td></tr>";
      cadena+="<tr><td>Extra:"+boleta.extra+"</td><td>Adelanto: "+boleta.adelanto+"</td></tr>";
      cadena+="<tr><td>Pago:"+boleta.pago+"</td><td> </td></tr>";
      cadena+="</tbody></table><hr>";
      cadena+="<div style='text-align:right'>Liquido Pagable: "+total+"</div>";
      cadena+="<div> "+boleta.obs+"</div>";

      cadena+="<br><br><div style='text-align:center; with:100%'>FIRMA</div>";
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
          doc.text(7, 3, 'Sueldo')
          doc.text(9, 3, 'Extra')
          doc.text(11, 3, 'Adelanto')
          doc.text(13, 3, 'Descuento')
          doc.text(16, 3, 'Pago')
          doc.text(19, 3, 'Cancelar')
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
        let sumatoria=0
        this.salarios.forEach(r=>{
          // xx+=0.5
          let extra=r.extra==null?0:r.extra;
          let adelanto=r.adelanto==null?0:r.adelanto;
          let descuento=r.descuento==null?0:r.descuento;
          let pago=r.pago==null?0:r.pago;
          let total= r.salario - adelanto - descuento + pago;
          y+=0.5
          doc.text(1, y+3, ''+r.nombre)
          doc.text(7, y+3, ''+r.salario)
          doc.text(9, y+3, ''+extra)
          doc.text(11, y+3, ''+adelanto)
          doc.text(13, y+3, ''+descuento)
          doc.text(16, y+3, ''+pago)
          doc.text(19, y+3, ''+total)
          sumatoria+=total;
          // doc.text(13.5, y+3, r.estado.toString())
          // doc.text(18.5, y+3, r.name.toString())
          if (y+3>25){
            doc.addPage();
            header()
            y=0
          }
        })
        y+=0.5
          doc.text(11, y+3, 'TOTAL')
          doc.text(14, y+3, ''+sumatoria)

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
        $('#example').DataTable().destroy();
        this.$nextTick(()=>{
          $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
            ]
          } );
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
      console.log(this.empleadohistorial)
      if((parseFloat(this.empleadohistorial.salario)- this.totaldescuento) < parseFloat( this.pago.monto) && (this.pago.tipo=='ADELANTO' || this.pago.tipo=='DESCUENTO'))
      {
          this.$q.notify({
            message:'El monto excede al salario ',
            icon:'info',
            color:'red'
          })
        return false;
      }
      //console.log(this.empleadohistorial);
      this.pago.empleado_id=this.empleadohistorial.id
      this.pago.empleado_nombre=this.empleadohistorial.nombre
      // console.log(this.pago)
      // return false

      this.$axios.post(process.env.API+'/sueldo',this.pago).then(res=>{
        this.empleadohistorial=res.data
        this.pago={fecha:date.formatDate( Date.now(),'YYYY-MM-DD')}
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
  computed:{
      totaldescuento(){
        let total=0;
      this.empleadohistorial.sueldos.forEach(element => {
        if(date.formatDate( element.fecha,'YYYY-MM') == date.formatDate(this.pago.fecha,'YYYY-MM'))
        if(element.tipo=='ADELANTO' || element.tipo=='DESCUENTO')
          total+=parseFloat(element.monto)
      });
      return total;
      }
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
   }
}
</script>

<style scoped>

</style>
