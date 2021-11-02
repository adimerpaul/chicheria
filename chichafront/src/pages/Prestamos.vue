<template>
<q-page class="q-pa-xs">
          <q-tabs
            v-model="tab"
            dense
            class="text-grey"
            active-color="white"
            indicator-color="primary"
            align="justify"
            narrow-indicator
            @update:model-value="filtrarlista"
            active-bg-color="accent"
          >
            <q-tab name="local" label="Local" style="width:50%"/>
            <q-tab name="cliente" label="Cliente"  style="width:50%"/>
<!--            <q-tab name="movies" label="Movies" />-->
          </q-tabs>
  <q-form @submit.prevent="agregar">
  <div class="row">
    <div class="col-12 col-sm-3 q-pa-xs">
      <q-select v-if="tab=='local'" outlined label="Seleccionar local" v-model="cliente" :options="prestamos" option-label="titular"/>
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
      <q-btn label="agregar" icon="send" color="positive" type="submit"/>
    </div>
  </div>
  </q-form>
  <div v-if="tab=='cliente'">TOTAL EN CAJA: {{totalefectivo}} Bs.</div>
  <div><q-btn label="Imprimir Pendientes" color="amber" icon="print" @click="imprimir"/></div>
<!--  {{cliente}}-->
  <q-table            title="LISTA DE PRESTAMOS"
            :rows="listadop"
            :columns="colprestamo"
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
                  <q-badge color="negative" v-if="props.row.estado=='EN PRESTAMO'">
                    {{ props.row.estado }}
                  </q-badge>
                  <q-badge color="accent" v-else>
                    {{ props.row.estado }}
                  </q-badge>
                </q-td>
<!--              </q-tr>-->
            </template>
                        <template v-slot:body-cell-opcion="props" >
                <q-td key="opcion" :props="props" > 
                          <q-btn size="xs" @click="onDev(props.row)" v-if="props.row.estado=='EN PRESTAMO'"  color="primary" icon="refresh"/>
          <q-btn size="xs" @click="onList(props.row)"  color="green" icon="list"/>
          <q-btn size="xs" @click="onEliminar(props.row)"  color="negative" icon="delete"/>
                </q-td>
            </template>

  </q-table>
  <table class="table" style="width: 100%">
    <thead>
    <tr>
      <th>#</th>
      <th>Local</th>
      <th>Titular</th>
      <th>Telefono</th>
      <th>Inventario</th>
      <th>Fecha</th>
      <th>Estado</th>
      <th>Cantidad</th>
      <th>Pendiente</th>
      <th>Efectivo</th>
      <th>Fisico</th>
      <th>Observacion</th>
      <th>Opcion</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="(p,i) in listadop" :key="i">
      <td>{{i+1}}</td>
      <td>{{p.cliente.local}}</td>
      <td>{{p.cliente.titular}}</td>
      <td>{{p.cliente.telefono}}</td>
      <td>{{p.inventario.nombre}}</td>
      <td>{{p.fecha}}</td>
      <td><q-badge :color="p.estado=='EN PRESTAMO'?'negative':'aceent'">{{p.estado}}</q-badge></td>
      <td>{{p.cantidad}}</td>
      <td>{{p.prestado}}</td>
      <td>{{p.efectivo}}</td>
      <td>{{p.fisico}}</td>
      <td>{{p.observacion}}</td>
      <td>
        <q-btn-group>
          <q-btn size="xs" @click="onDev(p)" v-if="p.estado=='EN PRESTAMO'"  color="primary" icon="refresh"/>
          <q-btn size="xs" @click="onList(p)"  color="green" icon="list"/>
          <q-btn size="xs" @click="onEliminar(p)"  color="negative" icon="delete"/>
        </q-btn-group>
      </td>
    </tr>
    </tbody>
  </table>
  <hr>
  <table>
    <thead><tr><th>Local</th><th>Titular</th><th>Material</th><th>Total</th></tr></thead>
    <tbody>
      <tr v-for="r of reportepres" :key="r">
        <td>{{r.local}}</td>
        <td>{{r.titular}}</td>
        <td>{{r.nombre}}</td>
        <td>{{r.total}}</td>

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
      reportepres:[],
      filter:'',
      colum:[
  { name: 'fecha', align: 'center', label: 'fecha', field: 'fecha', sortable: true },
  { name: 'cantidad', label: 'cantidad', field: 'cantidad', sortable: true },
  { name: 'motivo', label: 'Observacion', field: 'motivo' },
],
      colprestamo:[
  { name: 'local', label: 'local', field: row=>row.cliente.local, sortable: true },
  { name: 'titular', label: 'titular', field: row=>row.cliente.titular, sortable: true },
  { name: 'telefono', label: 'telefono', field: row=>row.cliente.telefono, sortable: true },
  { name: 'Inventario', label: 'Inventario', field: row=>row.inventario.nombre, sortable: true },
  { name: 'fecha', label: 'fecha', field: 'fecha', sortable: true },
  { name: 'estado', label: 'estado', field: 'estado', sortable: true },
  { name: 'cantidad', label: 'cantidad', field: 'cantidad', sortable: true },
  { name: 'prestado', label: 'Pendiente', field: 'prestado', sortable: true },
  { name: 'efectivo', label: 'efectivo', field: 'efectivo', sortable: true },
  { name: 'fisico', label: 'fisico', field: 'fisico', sortable: true },
  { name: 'observacion', label: 'Observacion', field: 'observacion' },
  { name: 'opcion', label: 'opcion', field: 'opcion' },
],
    }
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
    reporte(){
      this.$axios.post(process.env.API+'/reportecliente').then(res=>{
        console.log(res.data);
        this.reportepres=[];
        res.data.forEach(element => {

            if(this.tab=='local' && element.tipocliente=='1')
              this.reportepres.push(element);
            if(this.tab=='cliente' && element.tipocliente=='2')
              this.reportepres.push(element);
        });
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
        this.$axios.delete(process.env.API+'/prestamo/'+p.id).then(res=>{
          // this.totalefectivo=res.data[0].total;
          this.listclientes()
          this.cajaprestamo()
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
    listclientes(){
      this.$q.loading.show();
      this.prestamos=[];
      this.$axios.get(process.env.API+'/cliente').then(res=>{
         console.log(res.data)
        res.data.forEach(r => {
            if(this.tab=='local' && r.tipocliente=='1'){
              r.titular=r.local
              this.prestamos.push(r);
            }
            if(this.tab=='cliente' && r.tipocliente=='2'){
              this.prestamos.push(r);
            }
        });
        this.$q.loading.hide();
        if(this.prestamos.length>0)
          this.cliente=this.prestamos[0];
      })
    }
    ,
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
      this.$q.loading.show();
      this.$axios.post(process.env.API+'/prestamo',{
        efectivo:this.efectivo,
        fisico:this.fisico,
        observacion:this.observacion,
        cantidad:this.cantidad,
        cliente_id:this.cliente.id,
        inventario_id:this.inventario.id,
      }).then(res=>{
        // console.log(res.data)
        let myWindow = window.open("", "Imprimir", "width=200,height=100");
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
        
        let myWindow = window.open("", "Imprimir", "width=200,height=100");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.focus();
        // setTimeout(function(){
          myWindow.print();
          myWindow.close();
        // this.prestamos=res.data
        this.dialog_dev=false;
        this.dev={};
        this.$q.loading.hide();
        this.filtrarlista();
        //this.listclientes();
        // this.cliente=this.prestamos[0]
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
        this.reportepres.forEach(r=>{
          // xx+=0.5
          y+=0.5
          doc.text(1, y+3, ''+r.local)
          doc.text(5, y+3, ''+r.titular)
          doc.text(11, y+3, ''+r.nombre)
          doc.text(16.5, y+3, ''+r.total,{align:'right'})
          if (y+3>25){
            doc.addPage();
            header()
            y=0
          }
        })
        window.open(doc.output('bloburl'), '_blank');
    },

  }
}
</script>

<style scoped>
.table , th , td  {
  border: 0.2px solid black;
  border-collapse: collapse;
}
</style>
