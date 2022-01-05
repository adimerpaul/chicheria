<template>
<q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <div class="text-subtitle1 bg-blue-9 text-center text-white">Ventas</div>
    </div>

    <div class="col-12">
      <div class="row">
        <div class="col-12 col-sm-12">
          <div class="row">
            <div class="col-12">
              <div class="text-subtitle1 bg-info text-center text-white">Historial de ventas</div>
            </div>
            <q-form @submit.prevent="misventas">
            <div class="row">
            <div class="col-4 col-sm-4 q-pa-xs"><q-input type="date" label="fecha" v-model="fecha2" outlined required/></div>
            <div class="col-4 col-sm-4 q-pa-xs"><q-input type="date" label="fecha" v-model="fecha3" outlined required/></div>
            <div class="col-4 col-sm-4 q-pa-xs flex flex-center">
              <q-btn color="info"  label="Consultar" icon="search" type="submit" />

            </div>
            </div>
            </q-form>
            <div class="col-12">
<!--              <q-table-->
<!--                :columns="columns2"-->
<!--                :rows="ventas"-->
<!--                title="Historial de ventas"-->
<!--                :filter="filter"-->
<!--              >-->
<!--                &lt;!&ndash;        <template v-slot:top-right>&ndash;&gt;-->
<!--                &lt;!&ndash;          <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">&ndash;&gt;-->
<!--                &lt;!&ndash;            <template v-slot:append>&ndash;&gt;-->
<!--                &lt;!&ndash;              <q-icon name="search" />&ndash;&gt;-->
<!--                &lt;!&ndash;            </template>&ndash;&gt;-->
<!--                &lt;!&ndash;          </q-input>&ndash;&gt;-->
<!--                &lt;!&ndash;        </template>&ndash;&gt;-->
<!--            <template v-slot:top-right>-->
<!--              <q-input borderless dense debounce="300" v-model="filter" placeholder="Buscar">-->
<!--                <template v-slot:append>-->
<!--                  <q-icon name="search" />-->
<!--                </template>-->
<!--              </q-input>-->
<!--            </template>-->
<!--                <template v-slot:body="props">-->
<!--                  <q-tr :props="props">-->
<!--                    <q-td key="fecha" :props="props">-->
<!--                      {{ props.row.fecha }}-->
<!--                    </q-td>-->

<!--                    <q-td key="local" :props="props">-->
<!--                      {{ props.row.local }}-->
<!--                    </q-td>-->
<!--                    <q-td key="titular" :props="props">-->
<!--                      {{ props.row.titular }}-->
<!--                    </q-td>-->

<!--                    <q-td key="total" :props="props">-->
<!--                      {{ props.row.total }}-->
<!--                    </q-td>-->
<!--                    <q-td key="acuenta" :props="props">-->
<!--                      {{ props.row.acuenta }}-->
<!--                    </q-td>-->
<!--                    <q-td key="saldo" :props="props">-->
<!--                      {{ props.row.saldo }}-->
<!--                    </q-td>-->
<!--                    <q-td key="tipocliente" :props="props">-->
<!--                      <q-badge color="accent" v-if="props.row.tipocliente==1">LOCAL</q-badge>-->
<!--                      <q-badge color="teal" v-else>CLIENTE</q-badge>-->
<!--                    </q-td>-->
<!--                    <q-td key="estado" :props="props">-->
<!--                      <q-badge :color="props.row.estado=='CANCELADO'?'positive':'negative'">{{ props.row.estado }}</q-badge>-->
<!--                    </q-td>-->
<!--                  <q-td key="user" :props="props">-->
<!--                      {{ props.row.user }}-->
<!--                    </q-td>-->
<!--                      <q-td key="opcion" :props="props">-->
<!--                        <q-btn icon="segment" color="green"  @click="listpago(props.row)" />-->
<!--                        <q-btn icon="monetization_on" color="amber" v-if="props.row.estado=='POR COBRAR'" @click="pago(props.row)"/>-->
<!--                      </q-td>-->
<!--                  </q-tr>-->
<!--                </template>-->
<!--              </q-table>-->
              <div class=" responsive">
                  <table id="example" style="width:100%">
                    <thead>
                    <tr>
<!--                      <th>Nro</th>-->
                      <th>Fecha</th>
                      <th>Local</th>
                      <th>Titular</th>
                      <th>Cantidad</th>
                      <th>Producto</th>
                      <th>Total</th>
                      <th>A cuenta</th>
                      <th>Saldo</th>
                      <th>Tipo cliente</th>
                      <th>Estado</th>
                      <th>Usuario</th>
                      <th>Opcion</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="v in ventas" :key="v.id">
<!--                      <td>{{v.id}}</td>-->
                      <td>{{v.fecha}}</td>
                      <td>{{v.local}}</td>
                      <td>{{v.titular}}</td>
                      <td>{{v.cantidad}}</td>
                      <td>{{v.producto}}</td>
                      <td>{{v.total}}</td>
                      <td>{{v.acuenta}}</td>
                      <td>{{v.saldo}}</td>
                      <td>
                        <q-badge color="accent" v-if="v.tipocliente==1">LOCAL</q-badge>
                        <q-badge color="teal" v-else>CLIENTE</q-badge>
                      </td>
                      <td>
                        <q-badge :color="v.estado=='CANCELADO'?'positive':'negative'">{{ v.estado }}</q-badge>
                      </td>
                      <td>{{v.user}}</td>
                      <td>
                        <q-btn icon="segment" color="green"  @click="listpago(v)" />
                        <q-btn icon="monetization_on" color="amber" v-if="v.estado=='POR COBRAR'" @click="pago(v)"/>
                      </td>
                    </tr>
                    </tbody>
                  </table>
              </div>
              </div>
                <q-dialog v-model="alert">
                <q-card>
                    <q-card-section>
                    <div class="text-h6">Pagos Realizados</div>
                    </q-card-section>

                    <q-card-section class="q-pt-none">
                    <q-table title="Pagos" :rows="pagos" :columns="columns" row-key="name" />

                    </q-card-section>

                    <q-card-actions align="right">
                    <q-btn flat label="OK" color="primary" v-close-popup />
                    </q-card-actions>
                </q-card>
                </q-dialog>

                <q-dialog v-model="dialog_pago">
                <q-card>
                    <q-card-section>
                    <div class="text-h6">Registrar Pago</div>
                    </q-card-section>

                    <q-card-section class="q-pt-none">
                    <q-form @submit.prevent="onPago" class="q-gutter-md" >

                    <q-input filled v-model="regpago.monto"
                    label="Monto"
                    hint="Efectivo"
                    type="number"
                    lazy-rules
                    :rules="[ val => val && val > 0 && val <=regpago.saldo || 'Please type something']"
                    />
                    <q-input filled type="text"
                    v-model="regpago.observacion"
                    label="Observacion"
                    />
                    <div>
                    <q-btn label="Registrar" type="submit" color="green"/>
                    <q-btn flat label="Cancelar" color="primary" v-close-popup />
                    </div>
                    </q-form>

                    </q-card-section>

                </q-card>
                </q-dialog>

            <div class="col-12">
              <q-form>
                <div class="row">
                  <div class="col-4 q-pa-md">
                    <q-input type="text" label="Venta total" label-color="positive"  v-model="ventat"  outlined/>
                  </div>
                  <div class="col-4 q-pa-md">
                    <q-input type="text" label="Saldo caja" label-color="info"  v-model="porc"  outlined/>
                  </div>
                  <div class="col-4 q-pa-md">
                    <q-input type="text" label="Por cobrar" label-color="negative"  v-model="saldoc"  outlined/>
                  </div>
                </div>
              </q-form>
            </div>

          </div>
        </div>
      </div>


    </div>

  </div>
</q-page>
</template>

<script>

var $  = require( 'jquery' );
require( 'datatables.net-buttons/js/buttons.html5.js' )();
require( 'datatables.net-buttons/js/buttons.print.js' )();
require('datatables.net-buttons/js/dataTables.buttons');
require('datatables.net-dt/css/jquery.dataTables.min.css');
import print from 'datatables.net-buttons/js/buttons.print';
import jszip from 'jszip/dist/jszip';
import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
pdfMake.vfs=pdfFonts.pdfMake.vfs;
window.JSZip=jszip;


import {date} from 'quasar'
import { jsPDF } from "jspdf";

export default {
  name: "Venta",
  data(){
    return{
      fecha:date.formatDate(new Date(),'YYYY-MM-DD'),
      fecha2:date.formatDate(new Date(),'YYYY-MM-DD'),
      fecha3:date.formatDate(new Date(),'YYYY-MM-DD'),
      fecha4:date.formatDate(new Date(),'YYYY-MM-DD'),
      fecha5:date.formatDate(new Date(),'YYYY-MM-DD'),
      alert:false,
      responsable:'',
      clientes:[],
      clientes2:[],
      cliente:'',
      productos:[],
      inventarios:[],
      inventario:{},
      producto:'',
      cantidad:1,
      cantidades:[],
      acuenta:'',
      detalles:[],
      garantia:{},
      dialog_garantia:false,
      dialog_pago:false,
      cantidadprestamo:0,
      pagos:[],
      regpago:{},
      prestamo:{},
      columns:[
        {name:'fecha',label:'Fecha',field:'fecha'},
        {name:'monto',label:'Monto',field:'monto'},
        {name:'Observacion',label:'Observacion',field:'observacion'},
      ],
      columns2:[
        {name:'fecha',label:'Fecha',field:'fecha'},
        {name:'local',label:'Local',field:'local'},
        {name:'titular',label:'Titular',field:'titular'},
        {name:'cantidad',label:'Cantidad',field:'cantidad'},
        {name:'producto',label:'Producto',field:'producto'},
        {name:'total',label:'Total',field:'total'},
        {name:'acuenta',label:'A cuenta',field:'acuenta'},
        {name:'saldo',label:'Saldo',field:'saldo'},
        {name:'tipocliente',label:'Tipo cliente',field:'tipocliente'},
        {name:'estado',label:'Estado',field:'estado'},
        {name:'user',label:'Usuario',field:'user'},
        {name:'opcion',label:'Opcion',field:'opcion'},
      ],
            columns3:[
        {name:'fecha',label:'fecha',field:'fecha'},
        {name:'nombre',label:'Material',field:'nombre'},
        {name:'efectivo',label:'efectivo',field:'efectivo'},
        {name:'fisico',label:'fisico',field:'fisico'},
        {name:'observacion',label:'observacion',field:'observacion'},
        {name:'estado',label:'Estado',field:'estado'},
        {name:'user',label:'Usuario',field:'name'},
        {name:'opcion',label:'opcion',field:'opcion'},
      ],
      ventas:[],
      prestamos:[],
      filter:'',
      options:[],
      model:''
    }
  },
  mounted() {
    $('#example').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    } );

    //this.misventas()
    // console.log(this.$store.state.login)


    // })
    this.$axios.post(process.env.API+'/me').then(res=>{
      // console.log(res.data)
      this.responsable=res.data.name
    })
  },
  methods:{
      onPago(){
      this.$axios.post(process.env.API+'/pago',this.regpago).then(res=>{
          this.regpago={};
          this.dialog_pago=false;
          this.misventas();
                  this.$q.notify({
          message:'Registro correcto',
          color:'green',
          icon:'send'
        })
      })

      },
      pago(props){
          this.regpago.venta_id=props.id;
          this.regpago.saldo=props.saldo;
        this.dialog_pago=true;
      },
    listpago(dato){
        this.pagos=dato.pagos;
        this.alert=true;
    },

    misventas(){
      this.$q.loading.show()
      this.ventas=[];
      this.$axios.post(process.env.API+'/listadoventa',{ini:this.fecha2,fin:this.fecha3}).then(res=>{
        // this.ventas=res.data
        // console.log(res.data)
        this.$q.loading.hide()
        this.ventas=[]
          $('#example').DataTable().destroy();
        res.data.forEach(r=>{
           console.log(r)
          this.ventas.push({
            id:r.id,
            fecha:r.fecha,
            total:r.total,
            acuenta:r.acuenta,
            saldo:r.saldo,
            tipocliente:r.cliente.tipocliente,
            estado:r.estado,
            local:r.cliente.local,
            titular:r.cliente.titular,
            user:r.user.name,
            pagos:r.pagos,
            producto:r.detalle.nombreproducto,
            cantidad:r.detalle.cantidad
          })
          // console.log({
          //   id:r.id,
          //   fecha:r.fecha,
          //   total:r.total,
          //   acuenta:r.acuenta,
          //   saldo:r.saldo,
          //   tipocliente:r.cliente.tipocliente,
          //   estado:r.estado,
          //   local:r.cliente.local,
          //   titular:r.cliente.titular,
          //   user:r.user.name,
          //   pagos:r.pagos
          // })
        })


          this.$nextTick(()=>{
            $('#example').DataTable( {
              dom: 'Bfrtip',
              buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
              ]
            } );
          })
        // console.log(this.ventas)
      })
    },

    guardar(){
      if (this.model==0){
        this.$q.notify({
          message:'Tienes que seleccionar cliente',
          color:'red',
          icon:'error'
        })
        return false;
      }
            if (this.fecha==undefined){
        this.$q.notify({
          message:'Tienes que seleccionar fecha',
          color:'red',
          icon:'error'
        })
        return false;
      }
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
        fecha:this.fecha,
        total:this.subtotal,
        acuenta:this.acuenta,
        saldo:this.saldo,
        estado:this.estado,
        filtro:'',
        tipo:'LOCAL',
        cliente_id:this.model.id,
        detalles:[{
          nombreproducto:this.producto.nombre,
          precio:this.producto.precio,
          producto_id:this.producto.id,
          cantidad:this.cantidad,
          subtotal:this.subtotal,
        }],

      }).then(res=>{
        // console.log(res.data)
        this.$q.notify({
          message:'Venta exitosa',
          color:'green',
          icon:'info'
        })
                  let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
                  myWindow.document.write(res.data);
                  myWindow.document.close();
        this.misventas()

          this.subtotal=''
          this.acuenta=''
          this.saldo=''
          this.estado=''
          this.model=''
          this.producto=''
          this.cantidad=1
          this.subtotal=0
        this.fecha=date.formatDate(new Date(),'YYYY-MM-DD');
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
    },
    generar(){
      if (this.model==0){
        this.$q.notify({
          message:'Tienes que seleccionar cliente',
          color:'red',
          icon:'error'
        })
        return false;
      }

      console.log(this.model.id);
      if(this.model!=''){
      this.$axios.post(process.env.API+'/listaprestamo',{fecha1:this.fecha4,fecha2:this.fecha5,cliente_id:this.model.id
      }).then(res=>{
        console.log(res.data)
        this.prestamos=res.data;

      })}
    },
    regprestamo(){

      if(this.model!=''){
        // console.log('a')
        this.prestamo.cliente_id=this.model.id;
        this.prestamo.inventario_id=this.inventario.id;
       this.$axios.post(process.env.API+'/garantia',this.prestamo).then(res=>{
        console.log(res.data)
        this.$q.notify({
          message:'Prestamo exitosa',
          color:'green',
          icon:'info'
        })
        this.generar()
      }).catch(err=>{
        this.$q.loading.hide()
        console.error(err)
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'error'
        })
      })
      }else{
        this.$q.notify({
          message:'Debes seleccionar cliente',
          color:'red',
          icon:'error'
        })
      }
    },
    devolver1(props){
      this.garantia=props.row;
      console.log(this.garantia);
      this.dialog_garantia=true;
    },
    devolver(){
      console.log(this.garantia);
       this.$axios.post(process.env.API+'/devolver',this.garantia).then(res=>{
                this.$q.notify({
          message:'Devolucion exitosa',
          color:'green',
          icon:'info'
        })
       })
       this.dialog_garantia=false;

    },
    onReset(){},

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
    ventat(){
      let total=0;
      this.ventas.forEach(r=>{
        total+= parseFloat(r.total)
      })
      return total
    },
    porc(){
      let total=0;
      this.ventas.forEach(r=>{
        total+= parseFloat(r.acuenta)
      })
      return total
    },
    saldoc(){
      let total=0;
      this.ventas.forEach(r=>{
        total+= parseFloat(r.saldo)
      })
      return total
    },

  }
}
</script>

<style scoped>

</style>
