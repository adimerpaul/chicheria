<template>
<q-page class="q-pa-xs">
<q-table dense flat bordered :rows="empleados" :columns="columsempleado">
  <template v-slot:body-cell-opcion="props">
    <q-td :props="props" auto-width>
      <q-btn-dropdown color="primary" label="Opciones">
        <q-list>
          <q-item clickable v-close-popup >
            <q-item-section>
              <q-item-label>Modificar Empleado</q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-close-popup >
            <q-item-section>
              <q-item-label>Eliminar Empleado</q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-close-popup @click="clickplanilla(props.row)">
            <q-item-section avatar>
              <q-avatar icon="add_task" color="primary" text-color="white" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Generar planilla</q-item-label>
              <q-item-label caption>Generar planilla</q-item-label>
            </q-item-section>
<!--            <q-item-section side>-->
<!--              <q-icon name="info" color="amber" />-->
<!--            </q-item-section>-->
          </q-item>
        </q-list>
      </q-btn-dropdown>
    </q-td>
  </template>
  <template v-slot:body-cell-tipo="props">
    <q-td :props="props" auto-width>
      <q-badge :color="props.row.tipo=='CONTRATO'?'green':'EVENTUAL'">{{props.row.tipo}}</q-badge>
    </q-td>
  </template>
  <template v-slot:body-cell-nombre="props">
    <q-td :props="props" auto-width >
      {{props.row.nombre}}
    </q-td>
  </template>
  <template v-slot:body-cell-planillas="props">
    <q-td :props="props" auto-width >
<!--      <pre>{{}}</pre>-->
      <q-list dense bordered padding class="rounded-borders">
        <q-item v-for="p in props.row.planillas" :key="p.id" clickable v-ripple>
          <q-item-section>
            {{ p.fechainicio }}
            {{ p.fechafin }}
            {{ p.monto }}
          </q-item-section>
        </q-item>
      </q-list>
    </q-td>
  </template>
  <template v-slot:body-cell-celular="props">
    <q-td :props="props" auto-width >
      {{props.row.celular}}
    </q-td>
  </template>
  <template v-slot:top-right>
    <q-btn @click="clickcreateempleado" color="positive" icon="add_circle" label="Crear Empleado"/>
    <q-input dense outlined placeholder="Buscar"/>
  </template>
</q-table>
<q-dialog v-model="dialogcreateempleado" full-width>
<q-card>
  <q-card-section class="text-center text-subtitle2">Crear Empleado</q-card-section>
  <q-separator/>
  <q-card-section>
    <q-form @submit="createempleado">
      <div class="row">
        <div class="col-4">
          <q-input dense outlined label="ci" v-model="empleado.ci"/>
        </div>
        <div class="col-4">
          <q-input dense outlined label="nombre" v-model="empleado.nombre"/>
        </div>
        <div class="col-4">
          <q-input dense type="date" outlined label="fechanac" v-model="empleado.fechanac"/>
        </div>
        <div class="col-4">
          <q-input dense outlined label="celular" v-model="empleado.celular"/>
        </div>
        <div class="col-4">
          <q-select :options="['CONTRATO','EVENTUAL']" dense outlined label="tipo" v-model="empleado.tipo"/>
        </div>
        <div class="col-4">
          <q-input dense outlined label="salario" type="number" v-model="empleado.salario"/>
        </div>
        <div class="col-12">
          <q-btn label="Crear empleado" class="full-width" type="submit" icon="add_circle" color="positive"  />
        </div>
      </div>
    </q-form>
  </q-card-section>
</q-card>
</q-dialog>
  <q-dialog v-model="dialogcreateplanilla" full-width>
    <q-card>
      <q-card-section class="text-center text-subtitle2">Crear Planilla</q-card-section>
      <q-separator/>
      <q-card-section>
        <q-form @submit="createplanilla">
          <div class="row">
            <div class="col-4">
              <q-input dense type="date" outlined label="fechainicio" v-model="fechainicio"/>
            </div>
            <div class="col-4">
              <q-input dense type="date" outlined label="fechafin" v-model="fechafin"/>
            </div>
            <div class="col-4">
              <q-input dense outlined label="monto" v-model="monto"/>
            </div>
<!--            <div class="col-4">-->
<!--              <q-input dense type="date" outlined label="fechanac" v-model="empleado.fechanac"/>-->
<!--            </div>-->
<!--            <div class="col-4">-->
<!--              <q-input dense outlined label="celular" v-model="empleado.celular"/>-->
<!--            </div>-->
<!--            <div class="col-4">-->
<!--              <q-select :options="['CONTRATO','EVENTUAL']" dense outlined label="tipo" v-model="empleado.tipo"/>-->
<!--            </div>-->
<!--            <div class="col-4">-->
<!--              <q-input dense outlined label="salario" type="number" v-model="empleado.salario"/>-->
<!--            </div>-->
            <div class="col-12">
              <q-btn label="Crear planilla" class="full-width" type="submit" icon="add_circle" color="positive"  />
            </div>
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
</q-page>
</template>

<script>
import {date} from "quasar";

export default {
  name: `Planillas`,
  data(){
    return{
      dialogcreateempleado:false,
      dialogcreateplanilla:false,
      fechainicio:date.formatDate(new Date(),'YYYY-MM-DD'),
      fechafin:date.formatDate(new Date(),'YYYY-MM-DD'),
      monto:0,
      empleado:{tipo:'CONTRATO',fechanac:date.formatDate(new Date(),'YYYY-MM-DD')},
      empleados:[],
      columsempleado:[
        {label:'opcion',name:'opcion',field:'opcion',align:'left'},
        {label:'nombre',name:'nombre',field:'nombre',align:'left'},
        {label:'tipo',name:'tipo',field:'tipo',align:'left'},
        {label:'celular',name:'celular',field:'celular',align:'left'},
        {label:'planillas',name:'planillas',field:'planillas'},
        {label:'salario',name:'salario',field:'salario',align:'left'},
      ]
    }
  },
  created() {
    this.misempleados()
  },
  methods:{
    clickplanilla(empleado){
      this.empleado=empleado
      console.log(empleado)
      this.monto=this.empleado.salario
      this.dialogcreateplanilla=true
    },
    clickcreateempleado(){
      this.dialogcreateempleado=true
      this.empleado={tipo:'CONTRATO',fechanac:date.formatDate(new Date(),'YYYY-MM-DD')}
    },
    misempleados(){
      this.$q.loading.show()
      this.$axios.get(process.env.API+'/empleado/1/edit').then(res=>{
        console.log(res.data)
        this.$q.loading.hide()
        this.empleados=res.data
      })
    },
    createplanilla(){
      this.$q.loading.show()
      this.$axios.post(process.env.API+'/planilla',{
        fechainicio:this.fechainicio,
        fechafin:this.fechafin,
        fechapago:null,
        monto:this.monto,
        adelanto:0,
        descuento:0,
        bono:0,
        restante:0,
        total:0,
        estado:'CREADO',
        empleado_id:this.empleado.id,
      }).then(res=>{
        this.$q.loading.hide()
        // console.log(res.data)
        // this.$q.loading.hide()
        // this.empleado={tipo:'CONTRATO',fechanac:date.formatDate(new Date(),'YYYY-MM-DD')}
        this.dialogcreateplanilla=false
        this.misempleados()
      })
    },
    createempleado(){
      this.$q.loading.show()
      if (this.empleado.salario==undefined||this.empleados.salario==null||this.empleado.salario==''){
        this.empleado.salario=0
      }
      this.$axios.post(process.env.API+'/empleado',this.empleado).then(res=>{
        // console.log(res.data)
        // this.$q.loading.hide()
        this.empleado={tipo:'CONTRATO',fechanac:date.formatDate(new Date(),'YYYY-MM-DD')}
        this.dialogcreateempleado=false
        this.misempleados()
      })
    }
  }

}
</script>

<style scoped>

</style>
