<template>
<q-page class="q-pa-xs">
  <div class="col-12">
    <div class="text-subtitle1 bg-blue-9 text-center text-white">PRESTAMOS DETALLE</div>
  </div>
  <q-form @submit.prevent="agregar">
  <div class="row">
    <div class="col-12 col-sm-3 q-pa-xs">
      <q-select dense use-input v-if="tab==1" outlined label="Seleccionar local" v-model="cliente" :options="prestamos" @filter="filterFn"/>
      <q-select dense use-input @filter="filterFn" v-else outlined label="Seleccionar Cliente" v-model="cliente" :options="prestamos" option-label="titular"/>
    </div>
    <div class="col-12 col-sm-3 q-pa-xs">
      <q-select dense outlined label="Seleccionar Inventario" v-model="inventario" :options="inventarios" option-label="nombre" @update:model-value="calcular"/>
    </div>
    <div class="col-12 col-sm-3 q-pa-xs">
      <!--<q-select dense outlined label="Seleccionar Cantidad" v-model="cantidad" :options="cantidades" @update:model-value="calcular"/>-->
      <q-input dense outlined label="Cantidad"  v-model="cantidad" type="number" @update:model-value="calcular" :rules="[val => val>0 || 'Ingrese valor']"/>
    </div>
        <div class="col-12 col-sm-3 q-pa-xs">
      <q-input dense outlined label="Fecha" v-model="fecha" type="date"/>
    </div>
    <div class="col-12 col-sm-3 q-pa-xs">
      <q-input dense outlined label="Efectivo" v-model="efectivo" type="number" step="0.01"/>
    </div>

    <div class="col-12 col-sm-3 q-pa-xs">
      <q-input dense outlined label="Fisico" v-model="fisico"  style="text-transform: uppercase"/>
    </div>
    <div class="col-12 col-sm-3 q-pa-xs">
      <q-input dense outlined label="Observacion" v-model="observacion"  style="text-transform: uppercase"/>
    </div>
    <div class="col-12 col-sm-3 q-pa-xs flex flex-center">
      <input type="radio" value="EN PRESTAMO" v-model="tipo" style="margin-right: 0.5em;font;height:35px; width:35px; "  /><b :style="tipo=='EN PRESTAMO'?'color:red':''"> EN PRESTAMO </b>
      <input type="radio" value="VENTA" v-model="tipo" style="margin-left: 1em;margin-right: 0.5em;height:35px; width:35px; "/><b :style="tipo=='VENTA'?'color:red':''"> VENTA </b>
    </div>
  </div>
  <div class="row">
    <div class="col-6  q-pa-xs ">
      <q-btn label="Imprimir Pendientes" color="amber" icon="print" @click="imprimir"/>
    </div>
    <div class="col-6  q-pa-xs " style=" text-align: right;">
      <q-btn label="Modficar" icon="edit" color="yellow" v-if="boolmod" @click="modificar"/>
      <q-btn label="agregar" icon="send" color="positive" type="submit" v-else/>
    </div>
  </div>
  </q-form>
  <q-badge class="full-width text-h5 flex flex-center" color="red" v-if="tab==2">TOTAL EN CAJA: {{totalefectivo}} Bs.</q-badge>

<!--  {{cliente}}-->
<div class="col-12 flex flex-center">
    <q-pagination  v-model="pagination.page"  :max="pagination.last_page" :min="1"
                   :total-pages="Math.ceil(pagination.rowsNumber / pagination.rowsPerPage)"
                   @click="listadoprestamo()"
                   :max-pages="6"
                   boundary-numbers
    />
  </div>
  <q-table            title="LISTA DE PRESTAMOS DETALLE"
            :rows="listadop"
            :columns="colprestamo"
            :filter="filter"
            v-model:pagination="pagination"
            :rows-per-page-options="[0]"
            row-key="name"
            wrap-cells
            hide-bottom
  >

          <template v-slot:top-right>
            <q-select v-model="estado" :options="estados" label="ESTADO" outlined dense @update:modelValue="listadoprestamo" />
              <q-input outlined dense debounce="300" v-model="filter" placeholder="Buscar" @update:modelValue="listadoprestamo">
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>
            <template v-slot:body-cell-prestado="props" >
              <q-td key="prestado" :props="props"  :style="props.row.prestado>0?'color:green;font-size:20px; font-weight: bold;':'color:red;font-size:20px; font-weight: bold;'">
                 {{props.row.prestado }}
              </q-td>
            </template>
            <template v-slot:body-cell-observacion="props" >
              <q-td key="observacion" :props="props">
                 <q-btn color="accent" icon="notes" @click="verObs(props.row)" v-if="props.row.observacion!='' && props.row.observacion!=null" dense/>
              </q-td>
            </template>
            <template v-slot:body-cell-estado="props" >
              <q-td key="estado" :props="props">
                <q-badge color="negative" v-if="props.row.estado=='ANULADO'" >
                  {{ props.row.estado }}
                </q-badge>
                <q-badge color="amber" v-if="props.row.estado=='DEVUELTO'">
                  {{ props.row.estado }}
                </q-badge>
                <q-badge color="positive" v-if="props.row.estado=='EN PRESTAMO'">
                  {{ props.row.estado }}
                </q-badge>
                <q-badge color="blue" v-if="props.row.estado=='VENTA'">
                  {{ props.row.estado }}
                </q-badge>
              </q-td>
            </template>
            <template v-slot:body-cell-logprestamos="props" >
              <q-td key="logprestamos" :props="props">
                <ul v-for="l in props.row.logprestamos" :key="l.id" style="margin: 0px;padding:0px;border: 0px;list-style: none">
                  <li style="margin: 0px;padding:0px;border: 0px;"> <b>Cant:</b> {{l.cantidad}} <b>Fecha:</b>{{l.fecha}} </li>
                </ul>
              </q-td>
            </template>
            <template v-slot:body-cell-telefono="props" >
              <q-td key="telfono" :props="props" >
                 <q-btn icon="call" color="accent" @click="verTelef(props.row)" dense v-if="props.row.telefono!=''"/>
              </q-td>
            </template>
            <template v-slot:body-cell-motivoanulacion="props" >
              <q-td key="motivoanulacion" :props="props" >
                 <q-btn icon="list" color="accent" @click="verAnulacion(props.row)" dense v-if="props.row.motivoAnulacion!='' && props.row.motivoAnulacion!=null"/>
              </q-td>
            </template>
            <template v-slot:body-cell-fisico="props" >
              <q-td key="fisico" :props="props" >
                 <q-btn icon="list" color="accent" @click="verFisico(props.row)" dense v-if="props.row.fisico!=''"/>
              </q-td>
            </template>
            <template v-slot:body-cell-opcion="props" >
                <q-td key="opcion" :props="props" >
                    <!-- dropdown content goes here -->
                    <q-btn-dropdown color="primary" label="Opcion">
                      <q-list>
                        <q-item clickable v-close-popup @click="onPrint(props.row)" v-if="props.row.estado=='EN PRESTAMO' || props.row.estado=='DEVUELTO'" dense>
                          <q-item-section avatar>
                            <q-avatar  icon="print" color="info" text-color="white" />
                          </q-item-section>
                          <q-item-section>
                            Imprimir
                          </q-item-section>
                        </q-item>
                        <q-item clickable v-close-popup @click="onDev(props.row)" v-if="props.row.estado=='EN PRESTAMO'" dense>
                          <q-item-section avatar>
                            <q-avatar  icon="refresh" color="primary" text-color="white" />
                          </q-item-section>
                          <q-item-section>
                            Devolver
                          </q-item-section>
                        </q-item>
                        <q-item clickable v-close-popup @click="onList(props.row)" dense>
                          <q-item-section avatar>
                            <q-avatar  icon="list" color="green" text-color="white" />
                          </q-item-section>
                          <q-item-section>
                            Listado
                          </q-item-section>
                        </q-item>
                        <q-item clickable v-close-popup @click="onMod(props.row)" v-if="props.row.estado=='EN PRESTAMO'" dense>
                          <q-item-section avatar>
                            <q-avatar  icon="edit" color="yellow" text-color="white" />
                          </q-item-section>
                          <q-item-section>
                            Modificar
                          </q-item-section>
                        </q-item>
                        <q-item clickable v-close-popup @click="onEliminar(props.row)"  v-if="props.row.estado=='EN PRESTAMO' && $store.state.login.anularprestamo"  dense>
                          <q-item-section avatar >
                            <q-avatar  icon="delete" color="red-12" text-color="white" />
                          </q-item-section>
                          <q-item-section>
                            Baja
                          </q-item-section>
                        </q-item>
                        <q-item clickable v-close-popup @click="ondelete(props.row)" v-if="(props.row.estado=='EN PRESTAMO' || props.row.estado=='VENTA') && $store.state.login.delprestamo" dense>
                          <q-item-section avatar>
                            <q-avatar  icon="delete" color="negative" text-color="white" />
                          </q-item-section>
                          <q-item-section>
                            Eliminar
                          </q-item-section>
                        </q-item>
                      </q-list>
                    </q-btn-dropdown>
                    <!--<q-btn size="xs" @click="onDev(props.row)" v-if="props.row.estado=='EN PRESTAMO'"  color="primary" icon="refresh"/>
                    <q-btn size="xs" @click="onList(props.row)"  color="green" icon="list"/>
                    <q-btn size="xs" @click="onMod(props.row)"  color="yellow" icon="edit" v-if="props.row.estado=='EN PRESTAMO'"/>
                    <q-btn size="xs" @click="onEliminar(props.row)" v-if="props.row.estado=='EN PRESTAMO' && $store.state.login.anularprestamo"  color="red-12"   label="BAJA"/>
                    <q-btn size="xs" @click="ondelete(props.row)" v-if="(props.row.estado=='EN PRESTAMO' || props.row.estado=='VENTA') && $store.state.login.delprestamo"  color="negative" icon="delete"/>-->
                </q-td>
            </template>

  </q-table>

  <hr>
  <table v-if="tab==1">
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
      :rows-per-page-options="[0]"
    >
    <template v-slot:body-cell-op="props" v-if="$store.state.login.delpago">
      <q-td key="op" :props="props">
         <q-btn color="info" icon="print" dense @click="printDevuelto(props.row)"  />
         <q-btn color="red" icon="delete" dense @click="delDevuelto(props.row)"  />
      </q-td>
    </template>
        </q-table>
        </q-card-section>


      </q-card>
    </q-dialog>

</q-page>
</template>
<script>

import {date} from 'quasar'
import { jsPDF } from "jspdf";
import moment from 'moment'

export default {
  name: "Venta",
  data(){
    return{
      tab:2,
      estados:['TODO','EN PRESTAMO','DEVUELTO','ANULADO','VENTA'],
      estado:'TODO',
      prestamos:[],
      cliente:'',
      inventarios:[],
      inventario:'',
      cantidades:[],
      cantidad:1,
      fisico:'',
      efectivo:0,
      observacion:'',
      tipo:'EN PRESTAMO',
      totalefectivo:0,
      dialog_dev:false,
      dialog_list:false,
      datoprestamo:{},
      prestamo_id:'',
      listado:[],
      listadop:[],
      dev:{},
      reportepres:[],
      options:[],
      boolmod:false,
      filter:'',
      fecha:date.formatDate(new Date(),'YYYY-MM-DD'),
      colum:[
  { name: 'op', label: 'OP', field: 'op', sortable: true },
  { name: 'fecha', align: 'center', label: 'fecha', field: row=>date.formatDate(row.fecha,'DD/MM/YYYY'), sortable: true },
  { name: 'cantidad', label: 'cantidad', field: 'cantidad', sortable: true },
  { name: 'motivo', label: 'Observacion', field: 'motivo' },
],
      colprestamo:[
  { name: 'opcion', label: 'OPCION', field: 'opcion' },
  { name: 'id', label: 'ID', field: 'id', sortable: true },
  { name: 'titular', label: 'TITULAR', field: row=>row.cliente.titular, sortable: true,align:'left'},
   { name: 'telefono', label: 'TELEFONO', field: row=>row.cliente.telefono, sortable: true },
  { name: 'Inventario', label: 'INVENTARIO', field: row=>row.inventario.nombre, sortable: true,align:'left' },
  { name: 'fecha', label: 'FECHA', field: row=>moment(row.fecha).format('DD/MM/YYYY'), sortable: true },
      { name: 'fechaAnulacion', label: 'FECHA ANULACION', field: row=>moment(row.fechaAnulacion).format('DD/MM/YYYY'), sortable: true },
      { name: 'motivoanulacion', label: 'MOTIVO ANULACION', field: row=>row.motivoAnulacion, sortable: true },
  { name: 'estado', label: 'ESTADO', field: 'estado', sortable: true },
  { name: 'cantidad', label: 'CANTIDAD', field: 'cantidad', sortable: true },
  { name: 'prestado', label: 'PENDIENTE', field: 'prestado', sortable: true },
  { name: 'efectivo', label: 'EFECTIVO', field: 'efectivo', sortable: true },
  { name: 'fisico', label: 'FISICO', field: 'fisico', sortable: true },
  { name: 'user', label: 'USUARIO', field: row=>row.user.name },
  { name: 'observacion', label: 'OBSERVACION', field: 'observacion' },
  { name: 'logprestamos', label: 'HISTORIAL', field: 'logprestamos' },
],

pagination: {
        // No longer using sort. if needed, this can now be done using the backend!
        // sortBy: 'name',
        // descending: false,
        page: 1,
        rowsPerPage: 20,
        // When using server side pagination, QTable needs
        // to know the "rows number" (total number of rows).
        // Why?
        // Because Quasar has no way of knowing what the last page
        // will be without this information!
        // Therefore, we now need to supply it with a "rowsNumber" ourself.
        rowsNumber: 0,
        last_page:0
      },
    }
  },
  created(){
    for (let i=1;i<=100;i++){
      this.cantidades.push(i);
    }
    // this.misprestamos()
    this.$axios.get(process.env.API+'/listInv').then(res=>{
      // console.log(res.data)
      this.inventarios=res.data;
      this.inventario=this.inventarios[0];
      console.log(this.inventario)
    this.efectivo=parseFloat(this.cantidad) * parseFloat(this.inventario.precio)
    })
      this.listclientes();
      this.cajaprestamo();
    this.listadoprestamo();
    this.reporte();

  },
  methods: {
    onPrint(prest){
      this.$axios.post(process.env.API+'/impresion/'+prest.id).then(res=>{
        // console.log(res.data)
        let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.print();
        myWindow.close();
      })
    },
    printDevuelto(devuelto){
      this.$axios.post(process.env.API+'/impdevolucion/'+devuelto.id).then(res=>{
        // console.log(res.data)
        let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.print();
        myWindow.close();
      })
    },
    delDevuelto(devol){
      this.$q.dialog({
        title: 'Eliminar',
        message: 'Esta seguro de Eliminar Devolucion'
      }).onOk(() => {
        this.$axios.delete(process.env.API+'/logprestamo/'+devol.id).then(res=>{
          this.dialog_list=false
          this.$axios.get(process.env.API+'/listInv').then(res=>{
      // console.log(res.data)
      this.inventarios=res.data;
        this.inventario=this.inventarios[0];
    this.efectivo=parseFloat(this.cantidad) * parseFloat(this.inventario.precio)
      })
        this.listclientes();
        this.cajaprestamo();
      this.listadoprestamo();
      this.reporte();
          this.$q.notify({
          message: 'Eliminado',
          color: 'red',
          icon:'info'
        })
})
      }).onCancel(() => {
        // console.log('Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    },
    verTelef(dato){
      this.$q.dialog({
        title: 'Telefono Cliente: '+dato.cliente.titular,
        message:  '<h6>'+dato.cliente.telefono+'</h6>',
        html: true
      }).onOk(() => {
        // console.log('OK')
      }).onCancel(() => {
        // console.log('Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    },
    verFisico(dato){
      this.$q.dialog({
        title: ' Cliente: '+dato.cliente.titular,
        message: dato.fisico
      }).onOk(() => {
        // console.log('OK')
      }).onCancel(() => {
        // console.log('Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    },
    verAnulacion(dato){
      this.$q.dialog({
        title: ' Cliente: '+dato.cliente.titular,
        message: dato.motivoAnulacion
      }).onOk(() => {
        // console.log('OK')
      }).onCancel(() => {
        // console.log('Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    },
    calcular(){
      this.efectivo=parseFloat(this.cantidad) * parseFloat(this.inventario.precio)
    },
    verObs(prest){
      this.$q.dialog({
        title: 'Observacion',
        message: prest.observacion
      }).onOk(() => {
        // console.log('OK')
      }).onCancel(() => {
        // console.log('Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    },
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
        fecha:this.fecha,
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
        // this.cliente=this.prestamos[0]
        this.cantidad=1;
      this.fecha=date.formatDate(new Date(),'YYYY-MM-DD')

        this.cliente=this.cliente[0];
        this.inventario=this.inventario[0];
        this.efectivo=0
        this.observacion=''
      })
      this.filtrarlista();
      this.cajaprestamo();
    },
    reporte(){
      this.$axios.post(process.env.API+'/reportecliente').then(res=>{
        // console.log(res.data);
        this.reportepres=[];
        res.data.forEach(element => {
            if(this.tab==1 && element.tipocliente==1)
              this.reportepres.push(element);
            if(this.tab==2 && element.tipocliente==2)
              this.reportepres.push(element);
        })
      })

    },
    listadoprestamo(){
      this.$axios.post(process.env.API+'/listPag',{estado:this.estado,tipo:this.tab,page:this.pagination.page,
        filter:this.filter}).then(res=>{
        console.log(res.data);
       // return false
        this.listadop=[];
        this.pagination.rowsNumber=res.data.total
        this.pagination.page=res.data.current_page
        this.pagination.last_page=res.data.last_page
        res.data.data.forEach(element => {
            if(element.estado=='ANULADO')
              element.estado='BAJA';
            this.listadop.push(element)
        });

      })
    },
    onDev(p){
      // console.log(p);
      this.datoprestamo=p;
      this.dialog_dev=true;
    },
    onEliminar(p){
      this.$q.dialog({
        title: 'Dar de Baja',
        message: 'Motivo de Baja',
        prompt: {
          model: '',
          type: 'textarea'
        }
      }).onOk((data) => {
          p.motivo=data;
          this.$axios.post(process.env.API+'/anularprestamo',p).then(res=>{
            // this.totalefectivo=res.data[0].total;
            this.cajaprestamo()
            this.listadoprestamo()
            console.log(res.data)
          })
      })
      // if (confirm('seguro de Anular?')){
      //   this.$axios.post(process.env.API+'/anularprestamo',p).then(res=>{
      //     // this.totalefectivo=res.data[0].total;
      //     this.cajaprestamo()
      //     this.listadoprestamo()
      //     console.log(res.data)
      //   })
      // }

    },
    ondelete(p){
           if (confirm('seguro de ELIMINAR?')){
        this.$axios.delete(process.env.API+'/prestamo/'+p.id).then(res=>{
          // this.totalefectivo=res.data[0].total;
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
    onMod(prop){
      console.log(prop)
        this.boolmod=true
        this.prestamo_id=prop.id
        this.efectivo=prop.efectivo;
        this.fecha=prop.fecha;
        this.fisico=prop.fisico;
        this.observacion=prop.observacion;
        this.cantidad=prop.cantidad;
        this.cliente=prop.cliente;
        this.inventario=prop.inventario;
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
      this.$axios.get(process.env.API+'/listacliente').then(res=>{
      this.prestamos=[];
         console.log(res.data)
        res.data.forEach(r => {
            if(this.tab==1 && r.tipocliente==1){
              r.titular=r.local
              r.label=r.titular
              this.prestamos.push(r);
            }
            if(this.tab==2 && r.tipocliente==2){
              r.label=r.titular
              this.prestamos.push(r);
            }
        });
        this.options=this.prestamos
        this.$q.loading.hide();
        //if(this.prestamos.length>0)
         // this.cliente=this.prestamos[0];
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
        fecha:this.fecha,
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
        // this.cliente=this.prestamos[0]
        this.cantidad=1;
        this.efectivo=0
        this.cliente=this.cliente[0];
        this.inventario=this.inventario[0];
        this.calcular
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
        // console.log(res.data);

        let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.focus();
        // setTimeout(function(){
          myWindow.print();
          myWindow.close();
        // this.prestamos=res.data
           this.listadoprestamo();
        this.cajaprestamo()
        this.dialog_dev=false;
        this.dev={};
        this.$q.loading.hide();
        this.filtrarlista();
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
          if(r.monto!=null && r.estado!='ANULADO'){
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
