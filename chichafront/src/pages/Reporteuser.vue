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
                    :rules="[ val => val>=fecha || 'Fecha debe ser mayor o igual']"
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
                      
                <q-dialog v-model="alert">
                <q-card>
                    <q-card-section>
                    <div class="text-h6">Pagos Realizados</div>
                    </q-card-section>

                    <q-card-section class="q-pt-none">
                    <q-table title="Pagos" :rows="pagos" :columns="colrep" row-key="name" />
                    
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
      <template v-slot:body-cell-opcion="props">
        <q-td :props="props">
                        <q-btn icon="segment" color="green"  @click="listpago(props.row)" />
                        <q-btn icon="monetization_on" color="amber" v-if="props.row.estado=='POR COBRAR'" @click="pago(props.row)"/>
        </q-td>
      </template>
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
      fecha2:date.formatDate(new Date(),'YYYY-MM-DD'),
      usuarios:[],
      usuario:'',
      ventas:[],
      deudas:[],
      regpago:{}, 
      pagos:{},
      dato:{},
      alert:false,
      dialog_pago:false,
            colrep:[
        {name:'fecha',label:'Fecha',field:'fecha'},
        {name:'monto',label:'Monto',field:'monto'},
        {name:'Observacion',label:'Observacion',field:'observacion'},
      ],
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
  { name: 'tipo', align: 'center', label: 'Tipo', field: 'tipo' },
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
  { name: 'tipo', align: 'center', label: 'tipo', field: 'tipocliente' },
  { name: 'usuario', align: 'center', label: 'usuario', field: 'name' },
  { name: 'opcion', align: 'center', label: 'opcion' ,field:'opcion'}
],

    }
  },
  created() {
      this.listado();
      this.deudores();
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
      this.$axios.post(process.env.API+'/listuser').then(res=>{
        console.log(res.data)
        this.usuarios.push({id:'0',name:'Todos'})
        res.data.forEach(r=>{
          this.usuarios.push(r)
        })
        if (this.usuarios.length>0)
        this.usuario=res.data[0];
      })
    },

    deudores(){
      this.deudas=[];
      this.$axios.post(process.env.API+'/listadodeudores').then(res=>{
        console.log(res.data)
        res.data.forEach(elem => {
          let tip=''
          if(elem.cliente.tipocliente==1) tip='LOCAL'; else tip='DETALLE';
          this.deudas.push({
            // id:elem.id,
            id:elem.id,
            local:elem.cliente.local,
            titular:elem.cliente.titular,
            total:elem.total,
            cuenta:elem.acuenta,
            saldo:elem.saldo,
            tipocliente:tip,
            fecha:elem.fecha,
            estado:elem.estado,
            name:elem.user.name,
            pagos:elem.pagos
          });

        });
      })
    },

    generar(){
            this.ventas=[];
            this.$q.loading.show()
        this.$axios.post(process.env.API+'/listadoventa',{fecha:this.fecha,fin:this.fecha2,id:this.usuario.id}).then(res=>{
            console.log(res.data);
          this.$q.loading.hide()
            res.data.forEach(el => {
                this.ventas.push({
                    local:el.cliente.local,
                    tipo:el.tipo,
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
          pago(props){
          this.regpago.venta_id=props.id;
          this.regpago.saldo=props.saldo;
        this.dialog_pago=true;
      },
    listpago(dato){
        this.pagos=dato.pagos;
        this.alert=true;
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
