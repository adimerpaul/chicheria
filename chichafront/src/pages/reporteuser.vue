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

    }
  },
  created() {
      this.listado();
  },
  methods: {
    listado(){
      this.$axios.post(process.env.API+'/listuser').then(res=>{
        console.log(res.data)
        this.usuarios=res.data;
        this.usuario=res.data[0];
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



}
</script>
