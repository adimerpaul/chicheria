<template>
<q-page class="q-pa-xs">
          <q-tabs
            v-model="tab"
            dense
            class="text-grey"
            active-color="dark"
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
      <q-select outlined label="Seleccionar Cliente" v-model="cliente" :options="prestamos" option-label="titular"/>
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
  <div>TOTAL EN CAJA: {{totalefectivo}} Bs.</div>
<!--  {{cliente}}-->
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
      <th>Faltante</th>
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
          <q-input dense v-model="dev.cantidad" autofocus type="number" label="Cantidad"
          :rules="[ val => val > 1 && val<=datoprestamo.prestado || 'Ingrese la cantidad correcta' ]"
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
      colum:[
  { name: 'fecha', align: 'center', label: 'fecha', field: 'fecha', sortable: true },
  { name: 'cantidad', label: 'cantidad', field: 'cantidad', sortable: true },
  { name: 'motivo', label: 'Observacion', field: 'motivo' },
]
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
  },
  methods: {
        listadoprestamo(){
      this.$axios.get(process.env.API+'/prestamo').then(res=>{
        console.log(res.data);
        this.listadop=res.data;
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
      this.listclientes();
    },
    listclientes(){
      this.$q.loading.show();
      this.prestamos=[];
      this.$axios.get(process.env.API+'/cliente').then(res=>{
         console.log(res.data)
        res.data.forEach(element => {
            if(this.tab=='local' && element.tipocliente=='1')
              this.prestamos.push(element);
            if(this.tab=='cliente' && element.tipocliente=='2')
              this.prestamos.push(element);

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
        console.log(res.data)
        // this.prestamos=res.data
        this.dialog_dev=false;
        this.dev={};
        this.$q.loading.hide();
        this.listclientes();
        // this.cliente=this.prestamos[0]
      })
    }
  }
}
</script>

<style scoped>
.table , th , td  {
  border: 0.2px solid black;
  border-collapse: collapse;
}
</style>
