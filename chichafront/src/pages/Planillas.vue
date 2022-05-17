<template>
<q-page class="q-pa-xs">
<q-table dense flat bordered :rows="empleados" :rows-per-page-options="[0]" :columns="columsempleado">
  <template v-slot:body-cell-opcion="props">
    <q-td :props="props" auto-width>
      <q-btn-dropdown color="primary" label="Opciones">
        <q-list>
          <q-item clickable v-close-popup @click="clickmod(props.row)" >
            <q-item-section>
              <q-item-label>Modificar Empleado</q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-close-popup @click="deleteval(props.row)">
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
    <q-td :props="props"  >
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

<q-dialog v-model="dialogcreateempleado" >
<q-card>
  <q-card-section class="text-center text-subtitle2">Crear Empleado</q-card-section>
  <q-separator/>
  <q-card-section>
    <q-form @submit="createempleado">
      <div class="row">
        <div class="col-12">
          <q-input dense outlined label="ci" v-model="empleado.ci"/>
        </div>
        <div class="col-12">
          <q-input dense outlined label="nombre" v-model="empleado.nombre"/>
        </div>
        <div class="col-12">
          <q-input dense type="date" outlined label="fechanac" v-model="empleado.fechanac"/>
        </div>
        <div class="col-12">
          <q-input dense outlined label="celular" v-model="empleado.celular"/>
        </div>
        <div class="col-12">
          <q-select :options="['CONTRATO','EVENTUAL']" dense outlined label="tipo" v-model="empleado.tipo"/>
        </div>
        <div class="col-12">
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

<q-dialog v-model="dialogmodempleado" >
<q-card>
  <q-card-section class="text-center text-subtitle2">Modificar Empleado</q-card-section>
  <q-separator/>
  <q-card-section>
    <q-form @submit="modempleado">
      <div class="row">
        <div class="col-12">
          <q-input dense outlined label="ci" v-model="empleado2.ci"/>
        </div>
        <div class="col-12">
          <q-input dense outlined label="nombre" v-model="empleado2.nombre"/>
        </div>
        <div class="col-12">
          <q-input dense type="date" outlined label="fechanac" v-model="empleado2.fechanac"/>
        </div>
        <div class="col-12">
          <q-input dense outlined label="celular" v-model="empleado2.celular"/>
        </div>
        <div class="col-12">
          <q-select :options="['CONTRATO','EVENTUAL']" dense outlined label="tipo" v-model="empleado2.tipo"/>
        </div>
        <div class="col-12">
          <q-input dense outlined label="salario" type="number" v-model="empleado2.salario"/>
        </div>
        <div class="col-12">
          <q-btn label="Modificar empleado" class="full-width" type="submit" icon="add_circle" color="positive"  />
        </div>
      </div>
    </q-form>
  </q-card-section>
</q-card>
</q-dialog>

  <q-dialog v-model="dialogcreateplanilla" full-width full-height>
    <q-card>
      <q-card-section class="text-center text-subtitle2">Crear Planilla {{empleado.nombre}} {{empleado.tipo}}</q-card-section>
      <q-separator/>
      <q-card-section>
        <div class="row">
          <div class="col-12">
            <q-form @submit="createplanilla">
              <div class="row">
                <div class="col-3">
                  <q-input dense type="date" outlined label="fechainicio" v-model="fechainicio"/>
                </div>
                <div class="col-3">
                  <q-input dense type="date" outlined label="fechafin" v-model="fechafin"/>
                </div>
                <div class="col-3">
                  <q-input dense outlined label="monto" v-model="monto"/>
                </div>
                <div class="col-3">
                  <q-btn label="Crear planilla" class="full-width" type="submit" icon="add_circle" color="positive"  />
                </div>
              </div>
            </q-form>
          </div>
          <div class="col-12">
            <q-table :columns="columsmisplanillaempleado" title="Historial de planillas" :rows-per-page-options="[0]" :rows="misplanillaempleado">
              <template v-slot:body-cell-opcion="props">
                <q-td :props="props" auto-width>
                  <q-btn-dropdown color="info" label="Opciones">
                    <q-list>
                      <q-item clickable v-close-popup @click="clickupdateplanilla(props.row)">
                        <q-item-section avatar>
                          <q-avatar icon="edit_note" color="accent" text-color="white" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Modificar planilla</q-item-label>
                          <q-item-label caption>Modificar planilla</q-item-label>
                        </q-item-section>
                      </q-item>
                      <q-item clickable v-close-popup @click="eliminarplanilla(props.row)">
                        <q-item-section avatar>
                          <q-avatar icon="delete" color="negative" text-color="white" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Eliminar planilla</q-item-label>
                          <q-item-label caption>Eliminar planilla</q-item-label>
                        </q-item-section>
                      </q-item>
                      <q-item clickable v-close-popup @click="imprimirplanilla(props.row)">
                        <q-item-section avatar>
                          <q-avatar icon="print" color="primary" text-color="white" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Imprimir planilla</q-item-label>
                          <q-item-label caption>Imprimir planilla</q-item-label>
                        </q-item-section>
                      </q-item>
                    </q-list>
                  </q-btn-dropdown>
                </q-td>
              </template>
            </q-table>
          </div>
        </div>
      </q-card-section>
    </q-card>
  </q-dialog>
  <q-dialog v-model="dialogplanilla">
    <q-card>
      <q-card-section class="text-center text-bold">Planilla {{empleado.nombre}} {{empleado.tipo}}</q-card-section>
      <q-separator/>
      <q-card-section>
        <q-form @submit.prevent="updateplanilla">
          <div class="row">
            <div class="col-12">
              <q-input label="fechainicio" type="date" dense outlined v-model="planilla.fechainicio" />
            </div>
            <div class="col-12">
              <q-input label="fechafin" type="date" dense outlined v-model="planilla.fechafin" />
            </div>
            <div class="col-12">
              <q-input label="monto" dense outlined v-model="planilla.monto" />
            </div>
            <div class="col-12">
              <q-input label="adelanto" dense outlined v-model="planilla.adelanto" />
            </div>
            <div class="col-12">
              <q-input label="bono" dense outlined v-model="planilla.bono" />
            </div>
            <div class="col-12">
              <q-input label="restante" dense outlined v-model="planilla.restante" />
            </div>
            <div class="col-12">
              <q-input label="total" dense outlined v-model="planilla.total" />
            </div>
            <div class="col-12 flex flex-center">
              <q-btn type="submit" class="full-width" color="positive" icon="edith" label="Modificar planilla" />
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
      dialogplanilla:false,
      dialogcreateempleado:false,
      dialogmodempleado:false,
      dialogcreateplanilla:false,
      fechainicio:date.formatDate(new Date(),'YYYY-MM-DD'),
      fechafin:date.formatDate(new Date(),'YYYY-MM-DD'),
      monto:0,
      empleado:{tipo:'CONTRATO',fechanac:date.formatDate(new Date(),'YYYY-MM-DD')},
      empleado2:{},
      empleados:[],
      columsempleado:[
        {label:'opcion',name:'opcion',field:'opcion',align:'left'},
        {label:'ci',name:'ci',field:'ci',align:'left'},
        {label:'nombre',name:'nombre',field:'nombre',align:'left'},
        {label:'fechanac',name:'fechanac',field:'fechanac',align:'left'},
        {label:'tipo',name:'tipo',field:'tipo',align:'left'},
        {label:'celular',name:'celular',field:'celular',align:'left'},
        // {label:'planillas',name:'planillas',field:'planillas'},
        {label:'salario',name:'salario',field:'salario',align:'left'},
      ],
      misplanillaempleado:[],
      columsmisplanillaempleado:[
        {label:'opcion',name:'opcion',field:'opcion',align:'left'},
        {label:'fechainicio',name:'fechainicio',field:'fechainicio',align:'left'},
        {label:'fechafin',name:'fechafin',field:'fechafin',align:'left'},
        {label:'monto',name:'monto',field:'monto',align:'left'},
        {label:'adelanto',name:'adelanto',field:'adelanto',align:'left'},
        {label:'descuento',name:'descuento',field:'descuento',align:'left'},
        {label:'bono',name:'bono',field:'bono',align:'left'},
        {label:'restante',name:'restante',field:'restante',align:'left'},
        {label:'total',name:'total',field:'total',align:'left'},
        {label:'estado',name:'estado',field:'estado',align:'left'},
      ],
      planilla:{},
    }
  },
  created() {
    this.misempleados()
  },
  methods:{
    clickmod(empleado){
      this.empleado2=empleado
      this.dialogmodempleado=true
    },
    clickplanilla(empleado){
      this.empleado=empleado
      // console.log(empleado)
      this.monto=this.empleado.salario
      this.dialogcreateplanilla=true
      this.mihistorialplanilla()
    },
    mihistorialplanilla(){
      this.$q.loading.show()
      this.$axios.get(process.env.API+'/planilla/'+this.empleado.id).then(res=>{
        // console.log(res.data)
        this.$q.loading.hide()
        this.misplanillaempleado=res.data
      })
    },
    clickcreateempleado(){
      this.dialogcreateempleado=true
      this.empleado={tipo:'CONTRATO',fechanac:date.formatDate(new Date(),'YYYY-MM-DD')}
    },
    misempleados(){
      this.$q.loading.show()
      this.$axios.get(process.env.API+'/empleado/1/edit').then(res=>{
        // console.log(res.data)
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
        restante:this.monto,
        total:0,
        estado:'CREADO',
        empleado_id:this.empleado.id,
      }).then(res=>{
        // this.$q.loading.hide()
        // console.log(res.data)
        // this.$q.loading.hide()
        // this.empleado={tipo:'CONTRATO',fechanac:date.formatDate(new Date(),'YYYY-MM-DD')}
        // this.dialogcreateplanilla=false
        // this.misempleados()
        // this.misplanillaempleado()
        this.mihistorialplanilla()
      })
    },
    updateplanilla(){
      this.$q.loading.show()
      this.$axios.put(process.env.API+'/planilla/'+this.planilla.id,this.planilla).then(res=>{
        // this.$q.loading.hide()
        // console.log(res.data)
        // this.$q.loading.hide()
        // this.empleado={tipo:'CONTRATO',fechanac:date.formatDate(new Date(),'YYYY-MM-DD')}
        // this.dialogcreateplanilla=false
        // this.misempleados()
        // this.misplanillaempleado()
        this.mihistorialplanilla()
        this.dialogplanilla=false
      })
    },
    eliminarplanilla(planilla){
      this.$q.dialog({
        title:"Seguro eliminar planilla?",
        cancel:true
      }).onOk(()=>{
        this.$q.loading.show()
        this.$axios.delete(process.env.API+'/planilla/'+planilla.id).then(res=>{
          this.mihistorialplanilla()
        })
      })
    },
    imprimirplanilla(){
      this.$q.loading.show()
      this.$axios.post(process.env.URL + '/mercado',{fecha1:this.fechames1,fecha2:this.fechames2}).then(res=>{
        console.log(res.data)
        this.miscomprobantestotales=res.data
        // console.log(this.miscomprobantestotales)
        let cm=this;
        function header(fecha){
          var img = new Image()
          img.src = 'logo.jpg'
          doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
          doc.setFont(undefined,'bold')
          doc.setFontSize(8);
          doc.text(15, 0.5, 'fecha de proceso: '+cm.fechahoy)
          doc.setFontSize(11);
          doc.text(5, 1, 'RESUMEN DIARIO DE INGRESOS DE LA UNIDAD DE ')
          doc.text(5, 1.5, cm.$store.state.user.unid.nombre+' '+cm.fechames1+' AL '+cm.fechames2)
          doc.text(1, 3, '_____________________________________________________________________________________')
          doc.text(2, 3, 'FECHA DE PAGO')
          // doc.text(4, 3, 'Nº TRAMITE')
          doc.text(8, 3, 'N TRAMITES')
          // doc.text(13.5, 3, 'CI/RUN/RUC')
          doc.text(15, 3, 'MONTO PAGADO BS.')
          // doc.text(18, 3, 'OPERADOR')
          doc.setFont(undefined,'normal')
        }
        var doc = new jsPDF('p','cm','letter')
        doc.setFont("courier");
        doc.setFontSize(11);
        header(this.fecha)
        let y=0
        let sumtotal=0
        let sumcomp=0
        let con=0
        this.miscomprobantestotales.forEach(r=>{
          // if (r.nrocomprobante!=''){
          // console.log(r)
          y+=0.5
          con++
          doc.text(2, y+3, r.fecha)
          // doc.text(4, y+3, r.nrotramite)
          doc.text(8, y+3, r.num.toString())
          // // doc.text(13.5, y+3, r.ci)
          doc.text(15, y+3, r.total.toString())
          sumtotal+=parseInt(r.total)
          sumcomp+=parseInt(r.num)
          // // console.log(r.total)
          // // doc.text(18, y+3, r.user.codigo )
          if (con==55){
            con=0
            doc.addPage();
            header(this.fecha)
            y=0
          }
          // }
        })
        doc.setFont(undefined,'bold')
        doc.text(2, y+3.5, 'TOTALES:                  '+sumcomp+' ')
        doc.text(12, y+3.5, 'TOTAL RECAUDADCION: ')
        let ClaseConversor = conversor.conversorNumerosALetras;
        let miConversor = new ClaseConversor();
        let a = miConversor.convertToText(sumtotal);
        doc.text(1.5, y+4.4, 'SON: ')
        doc.setFont(undefined,'normal')
        doc.text(2.5, y+4.4, a.toUpperCase())
        doc.setFont(undefined,'bold')
        // console.log(a)
        doc.text(1.8, y+5.9, '___________________      __________________________        ____________________')
        doc.text(2, y+6.3, 'FIRMA SELLO CAJERO')
        doc.text(7.5, y+6.3, 'FIRMA SELLO CONTROL INTERNO')
        doc.text(15.5, y+6.3, 'FIRMA SELLO LIQUIDADOR')
        // doc.setFont(undefined,'normal')
        doc.text(18, y+3.5, sumtotal+ ' Bs')
        // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
        window.open(doc.output('bloburl'), '_blank');
        // console.log(res.data)
        this.$q.loading.hide()
      })
      // .catch(err=>{
      //   this.$q.loading.hide()
      //   // this.$q.notify({
      //   //   message:err.response.data.res,
      //   //   color:'red',
      //   //   icon:'error'
      //   // })
      // })
    },
    clickupdateplanilla(planilla){
      this.planilla=planilla
      console.log(planilla)
      this.dialogplanilla=true
    },
    createempleado(){
      console.log(this.empleado)
      this.$q.loading.show()
      // if (this.empleado.salario==undefined||this.empleados.salario==null||this.empleado.salario==''){
      //   this.empleado.salario=0
      // }
      this.$axios.post(process.env.API+'/empleado',this.empleado).then(res=>{
        // console.log(res.data)
        // this.$q.loading.hide()
        this.empleado={tipo:'CONTRATO',fechanac:date.formatDate(new Date(),'YYYY-MM-DD')}
        this.dialogcreateempleado=false
        this.misempleados()
      })
    },
    modempleado(){
    //  console.log(this.empleado)
      this.$q.loading.show()
      this.$axios.put(process.env.API+'/empleado/'+this.empleado2.id,this.empleado2).then(res=>{
        this.dialogmodempleado=false
        this.misempleados()
      })
    },
      deleteval(empleado){
      this.$q.dialog({
        title:'Seguro de eliminar?',
        cancel:true,
      }).onOk(()=>{
        this.$q.loading.show()
        this.$axios.delete(process.env.API+'/empleado/'+empleado.id).then(res=>{
          this.$q.loading.hide()
          this.misempleados()
          this.$q.notify({
            message:'Borrado correctamente',
            icon:'info',
            color:'positive'
          })
        }).catch(err=>{
          // console.log(err.response)
          this.$q.loading.hide()
          this.$q.notify({
            message:err.response.data.message,
            icon:'error',
            color:'red'
          })
        })
      })

    },
  }

}
</script>

<style scoped>

</style>
