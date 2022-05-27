<template>
    <div class="row">
      <div class="col-12">
            <div class="text-h6">
              <h5 style="text-align:center">RESUMEN DE INGRESOS Y EGRESOS</h5>
            </div>

                <q-form @submit="listado" >
                <div class="row">
                <div class="col-2">
                  <q-input
                    outlined
                    type="date"
                    v-model="fecha1"
                    label="Fecha ini"
                    required
                  />
                  </div>
                  <div class="col-2">
                  <q-input
                    outlined
                    type="date"
                    v-model="fecha2"
                    label="Fecha fin"
                    required
                    :rules="[ val => val>=fecha1 || 'Fecha debe ser mayor o igual']"
                  />
                  </div>

                  <div class="col-2 flex flex-center">
                    <q-btn label="Generar" type="submit" color="primary" icon="send" />
                  </div>
                  </div>

                </q-form>


        <div class="q-pa-md">
          <div class=" responsive">
                <q-table title="INGRESOS" :rows="ingreso" :columns="columns" row-key="name" />
                <q-table title="EGRESOS" :rows="egreso" :columns="columns2" row-key="name" />
                
              </div>
    


        </div>

            <div class="col-12">
              <q-form>
                <div class="row">
                  <div class="col-4 q-pa-md">
                    <q-input type="text" label="Ingreso total" label-color="positive"  v-model="totalingreso"  outlined/>
                  </div>
                  <div class="col-4 q-pa-md">
                    <q-input type="text" label="Egreso Total" label-color="info"  v-model="totalegreso"  outlined/>
                  </div>

                </div>
              </q-form>
            </div>

      </div>
    </div>

</template>
<script>
import {date} from 'quasar'
import { jsPDF } from "jspdf";
import $ from "jquery";

export default {
  data(){
    return{
      fecha1:date.formatDate(new Date(),'YYYY-MM-DD'),
      fecha2:date.formatDate(new Date(),'YYYY-MM-DD'),
      usuarios:[],
      filter:'',
      usuario:'',
      ventas:[],
      deudas:[],
      ingreso:[],
      egreso:[],
      regpago:{},
      pagos:{},
      dato:{},
      alert:false,
      dialog_pago:false,

      columns : [

  { name: 'detalle', align: 'center', label: 'DETALLE', field: 'detalle', sortable: true },
  { name: 'total', align: 'center', label: 'total', field: 'total'},
],


      columns2 : [

  { name: 'detalle', align: 'center', label: 'DETALLE', field: 'detalle', sortable: true },
  { name: 'total', align: 'center', label: 'total', field: 'total'},
],

    }
  },
  mounted() {
  },
  created() {
      this.listado();
  },
  methods: {
          onPago(){
      this.$axios.post(process.env.API+'/pago',this.regpago).then(res=>{
          this.regpago={};
          this.dialog_pago=false;
          this.deudores();
                  this.$q.notify({
          message:'Registro correcto',
          color:'green',
          icon:'send'
        })
      })

      },
    listado(){
      this.ingreso=[]
          $('#example').DataTable().destroy();
      this.$axios.post(process.env.API+'/repventa',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
        //console.log(res.data)
        //return false
        res.data.forEach(r=>{
        if(r.total!=null && r.total!=undefined)
          this.ingreso.push({detalle:'Venta '+r.tipo,total:r.total})
        })
      })

     this.$axios.post(process.env.API+'/repventpago',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
        console.log(res.data)
        if(res.data.total!=null && res.data.total!=undefined)
          this.ingreso.push({detalle:'CxC pagos',total:res.data.total})
      })

      this.$axios.post(process.env.API+'/repingprestamo',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
        console.log(res.data)
        res.data.forEach(r=>{
        if(r.total!=null && r.total!=undefined)
          this.ingreso.push({detalle:'Prest/mat '+r.estado,total:r.total})
        })
      })

    this.$axios.post(process.env.API+'/repgastos',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
        console.log(res.data)
        res.data.forEach(r=>{
        if(r.total!=null && r.total!=undefined)
          this.egreso.push({detalle:r.glosa,total:r.total})
        })
      })

      //console.log(this.ingreso)
    },


  },
computed:{
    totalingreso(){
      let total=0;
      this.ingreso.forEach(r=>{
        total+= parseFloat(r.total)
      })
      return total
    },
    totalegreso(){
      let total=0;
      this.egreso.forEach(r=>{
        total+= parseFloat(r.total)
      })
      return total
    },

}

}
</script>
