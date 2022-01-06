<template>
<q-page class="q-pa-xs">
  <q-form @submit.prevent="agregar">
  <div class="row">
    <div class="col-12 col-sm-3 q-pa-xs">
      <q-select use-input @filter="filterFn" v-if="tab=='local'" outlined label="Seleccionar local" v-model="cliente" :options="prestamos" option-label="local" />
      <q-select v-else outlined label="Seleccionar Cliente" v-model="cliente" :options="prestamos" option-label="titular"/>
    </div>
    <div class="col-12 col-sm-3 q-pa-xs">
      <q-select outlined label="Seleccionar Inventario" v-model="inventario" :options="inventarios" option-label="nombre"/>
    </div>
    <div class="col-12 col-sm-3 q-pa-xs">
      <q-select outlined label="Seleccionar Cantidad" v-model="cantidad" :options="cantidades"/>
    </div>
    <div class="col-12 col-sm-3 q-pa-xs">
      <q-input outlined label="Efectivo" v-model="efectivo" type="number"/>
    </div>
    <div class="col-12 col-sm-3 q-pa-xs">
      <q-input outlined label="Fisico" v-model="fisico" />
    </div>
    <div class="col-12 col-sm-3 q-pa-xs">
      <q-input outlined label="Observacion" v-model="observacion" />
    </div>
    <div class="col-12 col-sm-3 q-pa-xs flex flex-center">
      <q-btn label="Modficar" icon="edit" color="yellow" v-if="boolmod" @click="modificar"/>
      <q-btn label="agregar" icon="send" color="positive" type="submit" v-else/>
    </div>
  </div>
  </q-form>
  <div class="text-h5" v-if="tab=='cliente'">TOTAL EN CAJA: {{totalefectivo}} Bs.</div>
  <div><q-btn label="Imprimir Pendientes" color="amber" icon="print" @click="imprimir"/></div>
<!--  {{cliente}}-->
  <q-table            title="LISTA DE PRESTAMOS LOCAL"
            :rows="listadop"
            :columns="colprestamo"
            :pagination="pagination"
            :filter="filter"

            row-key="name">

          <template v-slot:top-right>
              <q-input borderless dense debounce="300" v-model="filter" placeholder="Buscar">
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>

              <template v-slot:body-cell-estado="props" >
                <q-td key="estado" :props="props">
                  <q-badge color="negative" v-if="props.row.estado=='ANULADO'">
                    {{ props.row.estado }}
                  </q-badge>
                  <q-badge color="amber" v-if="props.row.estado=='DEVUELTO'">
                    {{ props.row.estado }}
                  </q-badge>
                  <q-badge color="positive" v-if="props.row.estado=='EN PRESTAMO'">
                    {{ props.row.estado }}
                  </q-badge>
                </q-td>
            </template>
                        <template v-slot:body-cell-opcion="props" >
                <q-td key="opcion" :props="props" >
                    <q-btn size="xs" @click="onDev(props.row)" v-if="props.row.estado=='EN PRESTAMO'"  color="primary" icon="refresh"/>
                    <q-btn size="xs" @click="onList(props.row)"  color="green" icon="list"/>
                    <q-btn size="xs" @click="onMod(props.row)"  color="yellow" icon="edit"/>
                    <q-btn size="xs" @click="onEliminar(props.row)" v-if="props.row.estado=='EN PRESTAMO' && $store.state.login.anularprestamo"  color="negative" icon="delete" />
                </q-td>
            </template>

  </q-table>

  <hr>
  <table id="example" style="width:100%" v-if="tab=='local'">
    <thead><tr><th>Local</th><th>Titular</th><th>Material</th><th>Total</th> <th>Monto</th></tr></thead>
    <tbody>
      <tr v-for="r of reportepres" :key="r">
        <td>{{r.local}}</td>
        <td>{{r.titular}}</td>
        <td>{{r.nombre}}</td>
        <td>{{r.total}}</td>
        <td>{{r.monto}}</td>
      </tr>
    </tbody>
  </table>
      <q-dialog v-model="dialog_dev" >
      <q-card style="min-width: 350px">
        <q-card-section>
          <div class="text-h6">Devolucion de prestamo</div>
        </q-card-section>

        <q-form
          @submit="devolver"
          class="q-gutter-md"
        >

        <q-card-section class="q-pt-none">
          <q-input dense v-model="dev.cantidad" autofocus type="number" label="Cantidad" required min=1
          :rules="[ val => val<=datoprestamo.prestado || 'Ingrese la cantidad correcta' ]"
          />

          <q-input dense v-model="dev.motivo" label="Observacion"

          />
        </q-card-section>
          <div>
            <q-btn label="Devolver" type="submit" color="primary"/>
            <q-btn label="Cancel"  color="red" v-close-popup/>
          </div>
        </q-form>


      </q-card>
    </q-dialog>

          <q-dialog v-model="dialog_list" >
      <q-card style="min-width: 350px">
        <q-card-section>
          <div class="text-h6">Listado Devolucion </div>
        </q-card-section>

        <q-card-section class="q-pt-none">

        <q-table
      title="Datos de Devolucion"
      :rows="listado"
      :columns="colum"
      row-key="name"
    />
        </q-card-section>


      </q-card>
    </q-dialog>

</q-page>
</template>
-
<script>
import {date} from 'quasar'
import { jsPDF } from "jspdf";
import $ from "jquery";
export default {
  name: "Venta",
  data(){
    return{
      tab:'local',
      prestamos:[],
      cliente:'',
      inventarios:[],
      inventario:'',
      cantidades:[],
      cantidad:1,
      fisico:'',
      efectivo:'',
      observacion:'',
      totalefectivo:0,
      dialog_dev:false,
      dialog_list:false,
      datoprestamo:{},
      listado:[],
      listadop:[],
      dev:{},
      tipo:'EN PRESTAMO',
      reportepres:[],
      options:[],
      boolmod:false,
      filter:'',

      pagination: { rowsPerPage: 20 },
      colum:[
  { name: 'fecha', align: 'center', label: 'fecha', field: 'fecha', sortable: true },
  { name: 'cantidad', label: 'cantidad', field: 'cantidad', sortable: true },
  { name: 'motivo', label: 'Observacion', field: 'motivo' },
],
      colprestamo:[
  { name: 'local', label: 'LOCAL', field: row=>row.cliente.local, sortable: true },
  { name: 'titular', label: 'TITULAR', field: row=>row.cliente.titular, sortable: true },
  { name: 'telefono', label: 'TELEFONO', field: row=>row.cliente.telefono, sortable: true },
  { name: 'Inventario', label: 'INVENTARIO', field: row=>row.inventario.nombre, sortable: true },
  { name: 'fecha', label: 'FECHA', field: 'fecha', sortable: true },
  { name: 'estado', label: 'ESTADO', field: 'estado', sortable: true },
  { name: 'cantidad', label: 'CANTIDAD', field: 'cantidad', sortable: true },
  { name: 'prestado', label: 'PENDIENTE', field: 'prestado', sortable: true },
  { name: 'efectivo', label: 'EFECTIVO', field: 'efectivo', sortable: true },
  { name: 'fisico', label: 'FISICO', field: 'fisico', sortable: true },
  { name: 'observacion', label: 'OBSERVACION', field: 'observacion' },
  { name: 'opcion', label: 'OPCION', field: 'opcion' },
],
    }
  },
  mounted() {
    $('#example').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    } );



  },
  created(){
    for (let i=1;i<=100;i++){
      this.cantidades.push(i);
    }
    // this.misprestamos()
    this.$axios.get(process.env.API+'/inventario').then(res=>{
      // console.log(res.data)
      this.inventarios=res.data;
      this.inventario=this.inventarios[0];
    })
      this.listclientes();
      this.cajaprestamo();
    this.listadoprestamo();
    this.reporte();
  },
  methods: {
            filterFn (val, update) {
      if (val === '') {
        update(() => {
          this.prestamos = this.options
          // with Quasar v1.7.4+
          // here you have access to "ref" which
          // is the Vue reference of the QSelect
        })
        return
      }
      update(() => {
        const needle = val.toLowerCase()
        this.prestamos = this.prestamos.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    reporte(){
      this.$axios.post(process.env.API+'/reportecliente').then(res=>{
        // console.log(res.data);
        this.reportepres=[];
        $('#example').DataTable().destroy();

        res.data.forEach(element => {
            if(this.tab=='local' && element.tipocliente=='1')
              this.reportepres.push(element);
            if(this.tab=='cliente' && element.tipocliente=='2')
              this.reportepres.push(element);
        });
        this.$nextTick(()=>{
          $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
            ]
          } );
        })


      })

    },
    listadoprestamo(){
      this.$axios.get(process.env.API+'/prestamo').then(res=>{
        console.log(res.data);
        this.listadop=[];
        res.data.forEach(element => {
            if(this.tab=='local' && element.cliente.tipocliente=='1')
              this.listadop.push(element);
            if(this.tab=='cliente' && element.cliente.tipocliente=='2')
              this.listadop.push(element);
        });

      })
    },
    onDev(p){
      // console.log(p);
      this.datoprestamo=p;
      this.dialog_dev=true;
    },
    onEliminar(p){
      if (confirm('seguro de eliminar?')){
        this.$axios.post(process.env.API+'/anularprestamo/'+p.id).then(res=>{
          // this.totalefectivo=res.data[0].total;
          this.listclientes()
          this.cajaprestamo()
          this.listadoprestamo()
          console.log(res.data)
        })
      }

    },
    onList(p){
      this.listado=p.logprestamos;
      this.dialog_list=true;
    },
    cajaprestamo(){
      this.$axios.post(process.env.API+'/tefectivo').then(res=>{
        this.totalefectivo=res.data[0].total;
      })

    },
        filtrarlista(){
      this.listadoprestamo();
      this.listclientes();
      this.reporte();
    },
        modificar(){
      if(this.inventario.cantidad<this.cantidad)
      {
                this.$q.notify({
          message: 'No ay sufuciente en Inventario',
          color: 'red',
          icon:'warning'
        })
        return false;
      }
      this.$q.loading.show();
      this.$axios.post(process.env.API+'/modprestamo',{
        id:this.prestamo_id,
        efectivo:this.efectivo,
        fisico:this.fisico,
        observacion:this.observacion,
        cantidad:this.cantidad,
        cliente_id:this.cliente.id,
        inventario_id:this.inventario.id,
      }).then(res=>{
        // console.log(res.data)
        this.listadoprestamo();
        this.boolmod=false
        this.$q.loading.hide();
        this.listclientes();
        // this.cliente=this.prestamos[0]
        this.cantidad=1;
        this.cliente=this.cliente[0];
        this.inventario=this.inventario[0];
        this.efectivo=0
        this.observacion=''
      })
      this.filtrarlista();
      this.cajaprestamo();
    },
    listclientes(){
      this.$q.loading.show();
      this.prestamos=[];
      this.$axios.get(process.env.API+'/listacliente').then(res=>{
         console.log(res.data)
        res.data.forEach(r => {
            if(this.tab=='local' && r.tipocliente=='1'){
              r.titular=r.local
              r.label=r.titular
              this.prestamos.push(r);
            }
            if(this.tab=='cliente' && r.tipocliente=='2'){
              r.label=r.titular
              this.prestamos.push(r);
            }
        });
        this.options=this.prestamos
        this.$q.loading.hide();
        if(this.prestamos.length>0)
          this.cliente=this.prestamos[0];
      })
    },
    misprestamos(){
      this.$q.loading.show()
      this.$axios.get(process.env.API+'/cliente').then(res=>{
        // console.log(res.data)
        this.prestamos=res.data;
        this.$q.loading.hide();
        this.cliente=this.prestamos[0];
      })
    },
    agregar(){
      if(this.inventario.cantidad<this.cantidad)
      {
                this.$q.notify({
          message: 'No ay sufuciente en Inventario',
          color: 'red',
          icon:'warning'
        })
        return false;
      }
            if (this.cliente==null ){
        this.$q.notify({
          message:'Tienes que seleccionar cliente',
          color:'red',
          icon:'error'
        })
        return false;
      }
      this.$q.loading.show();
      this.$axios.post(process.env.API+'/prestamo',{
        efectivo:this.efectivo,
        fisico:this.fisico,
        observacion:this.observacion,
        cantidad:this.cantidad,
        cliente_id:this.cliente.id,
        tipo:this.tipo,
        inventario_id:this.inventario.id,
      }).then(res=>{
        // console.log(res.data)
        let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.print();
        myWindow.close();
        // this.prestamos=res.data
        this.listadoprestamo();
        this.$q.loading.hide();
        this.listclientes();
        // this.cliente=this.prestamos[0]
        this.cantidad=1;
        this.cliente=this.cliente[0];
        this.inventario=this.inventario[0];
      })
      this.filtrarlista();
      this.cajaprestamo();
    },
        onMod(prop){
      console.log(prop)
        this.boolmod=true
        this.prestamo_id=prop.id
        this.efectivo=prop.efectivo;
        this.fisico=prop.fisico;
        this.observacion=prop.observacion;
        this.cantidad=prop.cantidad;
        this.cliente=prop.cliente;
        this.inventario=prop.inventario;
    },

    devolver(){
      this.$q.loading.show()
      this.$axios.post(process.env.API+'/logprestamo',{
        fecha:date.formatDate(new Date(),'YYYY-MM-DD'),
        cantidad:this.dev.cantidad,
        motivo:this.dev.motivo,
        inventario_id:this.datoprestamo.inventario_id,
        id:this.datoprestamo.id,
      }).then(res=>{
        console.log(res.data);

        let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.focus();
        // setTimeout(function(){
          myWindow.print();
          myWindow.close();
        // this.prestamos=res.data
        this.dialog_dev=false;
        this.listadoprestamo();
        this.cajaprestamo()
        this.dev={};
        this.$q.loading.hide();
      })
    },
    imprimir(){

        let mc=this
        function header(){
          var img = new Image()
          img.src = 'logo.png'
          doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
          doc.setFont(undefined,'bold')
          doc.text(5, 1, 'Historial de prestamos Pendientes')

          doc.text(1, 3, 'Local')
          doc.text(5, 3, 'Titular')
          doc.text(11, 3, 'Material')
          doc.text(15, 3, 'Cantidad')
           doc.text(17.5, 3, 'Monto')
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
        let suma=0
        this.reportepres.forEach(r=>{
          // xx+=0.5
          y+=0.5
          doc.text(1, y+3, ''+r.local)
          doc.text(5, y+3, ''+r.titular)
          doc.text(11, y+3, ''+r.nombre)
          doc.text(16.5, y+3, ''+r.total,{align:'right'})
          if(r.monto!=null){
          doc.text(18, y+3,''+r.monto,{align:'right'})
          suma+=r.monto;
          }
          else
          doc.text(17, y+3, 'sin garantía')
          if (y+3>25){
            doc.addPage();
            header()
            y=0
          }
        })
          doc.setFont(undefined,'bold')
                  doc.text(16.5, y+3.5, 'TOTAL')
          doc.text(18, y+3.5,''+suma+' Bs');
          doc.setFont(undefined,'normal')
        window.open(doc.output('bloburl'), '_blank');
    },

  }
}
</script>

<style scoped>
/*.table , th , td  {*/
/*  border: 0.2px solid black;*/
/*  border-collapse: collapse;*/
/*}*/
</style>
