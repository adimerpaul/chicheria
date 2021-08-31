<template>
    <div class="row">
      <div class="col-12">
            <div class="text-h6">
              <h5 style="text-align:center">Reporte de Ventas por Usuario</h5>
            </div>
 
                <q-form
                  @submit="generar"
                  >
                <div class="row">
                    <div class="col-3">
                        <q-select v-model="usuario" outlined :options="usuarios" option-label="name" option-value="id" label="Usuarios" required/>
                    </div>
                <div class="col-2">
                  <q-input
                    outlined
                    type="date"
                    v-model="fecha"
                    label="Fecha"
                    required
                  />
                  </div>

                  <div class="col-2 flex flex-center">
                    <q-btn label="Generar" type="submit" color="primary" icon="send" />
                  </div>
                  </div>

                </q-form>


        <div class="q-pa-md">
          <q-table
            title="Reporte Ventas"
            :rows="ventas"
            :columns="columns"
            row-key="local">

          </q-table>
        </div>

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

         <div class="q-pa-md">
          <q-table
            title="Reporte Deudores"
            :rows="deudas"
            :columns="columns2"
            row-key="local">

          </q-table>
        </div>

      </div>
    </div>

</template>
<script>
import {date} from 'quasar'
import { jsPDF } from "jspdf";
export default {
  data(){
    return{
      fecha:date.formatDate(new Date(),'YYYY-MM-DD'),
      usuarios:[],
      usuario:'',
      ventas:[],
      deudas:[],
      dato:{},
      columns : [
  {
    name: 'local',
    label: 'local',
    align: 'center',
    field: 'local',
    sortable: true
  },
  { name: 'titular', align: 'center', label: 'titular', field: 'titular', sortable: true },
  { name: 'total', align: 'center', label: 'total', field: 'total'},
  { name: 'cuenta', align: 'center', label: 'cuenta', field: 'cuenta' },
  { name: 'saldo', align: 'center', label: 'saldo', field: 'saldo' },
  { name: 'estado', align: 'center', label: 'Estado', field: 'estado' },
  { name: 'usuario', align: 'center', label: 'usuario', field: 'name' }
],
      columns2 : [
  {
    name: 'local',
    label: 'Local',
    align: 'center',
    field: 'local',
    sortable: true
  },
  { name: 'titular', align: 'center', label: 'Titular', field: 'titular', sortable: true },
  { name: 'total', align: 'center', label: 'Total', field: 'total'},
  { name: 'cuenta', align: 'center', label: 'Cuenta', field: 'cuenta' },
  { name: 'saldo', align: 'center', label: 'Saldo', field: 'saldo' },
  { name: 'fecha', align: 'center', label: 'fecha', field: 'fecha' },
  { name: 'estado', align: 'center', label: 'Estado', field: 'estado' },
  { name: 'usuario', align: 'center', label: 'usuario', field: 'name' }
],

    }
  },
  created() {
      this.listado();
      this.deudores();
  },
  methods: {
    listado(){
      this.$axios.post(process.env.API+'/listuser').then(res=>{
        console.log(res.data)
        this.usuarios=res.data;
        this.usuario=res.data[0];
      })
    },

    deudores(){
      this.deudas=[];
      this.$axios.post(process.env.API+'/listadodeudores').then(res=>{
        res.data.forEach(elem => {
          this.deudas.push({
            id:elem.id,
            id:elem.id,
            local:elem.cliente.local,
            titular:elem.cliente.titular,
            total:elem.total,
            cuenta:elem.acuenta,
            saldo:elem.saldo,
            fecha:elem.fecha,
            estado:elem.estado,
            name:elem.user.name
          });
          
        });
      })
    },

    generar(){
            this.ventas=[];
        this.$axios.post(process.env.API+'/listadoventa',{fecha:this.fecha,id:this.usuario.id}).then(res=>{
            console.log(res.data); 
            res.data.forEach(el => {
                this.ventas.push({
                    local:el.cliente.local,
                    titular:el.cliente.titular,
                    cuenta:el.acuenta,
                    saldo:el.saldo,
                    total:el.total,
                    estado:el.estado,
                    name:el.user.name

                })
            });
        
        })
    },

  },
computed:{
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
        total+= parseFloat(r.cuenta)
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
