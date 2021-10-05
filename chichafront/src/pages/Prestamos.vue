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
            <q-tab name="local" label="Local" />
            <q-tab name="cliente" label="Cliente"  />
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
      <q-input outlined label="Efectivo" v-model="efectivo" />
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
<!--  {{cliente}}-->
  <table class="table" style="width: 100%">
    <thead>
    <tr>
      <th>#</th>
      <th>Inventario</th>
      <th>Fecha</th>
      <th>Estado</th>
      <th>Cantidad</th>
      <th>Efectivo</th>
      <th>Fisico</th>
      <th>Observacion</th>
      <th>Fecha Dev</th>
      <th>Devolver</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="(p,i) in cliente.prestamos" :key="i">
      <td>{{i+1}}</td>
      <td>{{p.inventario.nombre}}</td>
      <td>{{p.fecha}}</td>
      <td><q-badge :color="p.estado=='EN PRESTAMO'?'negative':'aceent'">{{p.estado}}</q-badge></td>
      <td>{{p.cantidad}}</td>
      <td>{{p.efectivo}}</td>
      <td>{{p.fisico}}</td>
      <td>{{p.observacion}}</td>
      <td>{{p.fechadev}}</td>
      <td>
        <q-btn @click="devolver(p)" v-if="p.estado=='EN PRESTAMO'" label="devolver" color="primary" icon="refresh"/>
      </td>
    </tr>
    </tbody>
  </table>
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


  },
  methods: {
    filtrarlista(){
      this.listclientes();
    },
    listclientes(){
      this.$q.loading.show();
      this.prestamos=[];
      this.$axios.get(process.env.API+'/cliente').then(res=>{
        // console.log(res.data)
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
      this.$q.loading.show();
      this.$axios.post(process.env.API+'/prestamo',{
        efectivo:this.efectivo,
        fisico:this.fisico,
        observacion:this.observacion,
        cantidad:this.cantidad,
        cliente_id:this.cliente.id,
        inventario_id:this.inventario.id,
      }).then(res=>{
        console.log(res.data)
        // this.prestamos=res.data
        this.$q.loading.hide();
        this.listclientes();
        // this.cliente=this.prestamos[0]
        this.cantidad=1;
        this.cliente=this.cliente[0];
        this.inventario=this.inventario[0];
      })
    },
    devolver(prestamo){
      this.$q.loading.show()
      this.$axios.put(process.env.API+'/prestamo/'+prestamo.id,{
        fechadev:date.formatDate(new Date(),'YYYY-MM-DD'),
        estado:'DEVUELTO',
      }).then(res=>{
        console.log(res.data)
        // this.prestamos=res.data
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
