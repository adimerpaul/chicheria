<template>
  <div class="q-pa-md">
    <q-btn
      label="Agregar o Retirar"
      color="positive"
      @click="alert = true"
      icon="add_circle"
      class="q-mb-xs"
    />
                <q-form @submit.prevent="misdatos">
            <div class="row">
            <div class="col-3  q-pa-xs"><q-input type="date" label="fecha" v-model="fecha1" outlined required/></div>
            <div class="col-3  q-pa-xs"><q-input type="date" label="fecha" v-model="fecha2" outlined required v-if="rango=='RANGO'"/></div>
            <div class="col-3" ><q-toggle v-model="rango" true-value="RANGO" false-value="DIA" :label="rango +' FECHA'" style="width:100%"/></div>
            <div class="col-3  q-pa-xs flex flex-center">
              <q-btn color="info"  label="Consultar" icon="search" type="submit" />

            </div>
            </div>
            </q-form>
     <q-badge class="full-width text-h5 flex flex-center" color="red" >TOTAL EN CAJA CHICA: {{cajachica.monto}} Bs.</q-badge>
    <q-dialog v-model="alert">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6"><q-icon name="add_circle" /> Caja Chica</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
            <div class="row">
              <div class="col-12">
                <q-input
                  filled
                  v-model="dato.monto"
                  type="number"
                  step="0.1"
                  label="Monto Bs "
                  lazy-rules
                  :rules="[(val) => (val && val > 0) || 'Por favor ingresa datos']"
                />

                <q-input
                  filled
                  v-model="dato.motivo"
                  type="text"
                  label="Motivo"
                />

                <q-select
                  filled
                  v-model="dato.tipo"
                  label="TIPO"
                  :options="['AGREGA','RETIRA']"
                  lazy-rules
                  :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
                />
              </div>
            </div>

            <div>
              <q-btn label="Crear" type="submit" color="positive" icon="add_circle" />
              <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <q-table :filter="filter" title="Caja Chica"
      :rows="data"
      :columns="columns"
      row-key="name"
      :rows-per-page-options="[0,50,100]">
      <template v-slot:top-right>
        <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
      <template v-slot:body-cell-motivo="props">
        <q-td key="motivo" :props="props">
          <q-btn
            dense
            round
            flat
            color="accent"
            @click="viewRow(props.row)"
            icon="list"
          ></q-btn>
        </q-td>

    </template>
      <template v-slot:body-cell-opcion="props">
          <q-td key="opcion" :props="props">
            <q-btn
              dense
              round
              flat
              color="red"
              @click="deleteRow(props.row)"
              icon="delete"
            ><q-tooltip>Eliminar</q-tooltip></q-btn>
          </q-td>

      </template>
    </q-table>



  </div>
</template>

<script>
import { date } from 'quasar'
import moment from 'moment'

export default {
  data() {
    return {
      alert: false,
      filter:'',
        fecha1:date.formatDate(Date.now(),'YYYY-MM-DD'),
        fecha2:date.formatDate( Date.now(),'YYYY-MM-DD'),
      model:'',
      rango:'RANGO',
      dato:{},
      options: [],
      props: [],
      cajachica:0,
      montogeneral:0,
      columns: [
        {name: "fecha", align: "left", label: "FECHA ", field: row=>moment(row.fecha).format('DD/MM/YYYY'), sortable: true,},
        {name: "monto", align: "left", label: "MONTO", field: "monto", sortable: true,},
        {name: "motivo", align: "left", label: "MOTIVO", field: "motivo", sortable: true,},
        {name: "glosa", align: "left", label: "GLOSA", field: row=>row.glosa==null?'':row.glosa.nombre, sortable: true,},
        {name: "tipo", align: "left", label: "TIPO", field: "tipo", sortable: true,},
        {name: "opcion", align: "left", label: "OPCION", field: "opcion" }

      ],
      data: [],
    };
  },
  created() {

    this.misdatos();
    this.totalcaja();

  },
  methods: {
    totalgeneral(){
      this.$axios.post(process.env.API + "/totalgeneral").then((res) => {
          this.montogeneral=parseFloat( res.data.monto);
      })
      },
      deleteRow(logcaja){
      this.$q.dialog({
        title: 'Confirmar',
        message: 'Esta seguro de eliminar',
        cancel: true,
        persistent: false
      }).onOk(() => {
               this.$axios.delete(process.env.API + "/logcaja/"+logcaja.id).then((res) => {
                 console.log(res.data)
                                  this.misdatos()
        })
      }).onOk(() => {
        // console.log('>>>> second OK catcher')
      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })

      },
      totalcaja(){
      this.$axios.post(process.env.API + "/totalcaja").then((res) => {
          this.cajachica=res.data;
      })
      },

    misdatos() {
      this.$q.loading.show();
      if(this.rango=='DIA'){
        this.fecha2=this.fecha1
      }
      this.$axios.post(process.env.API + "/listcaja",{fecha1:this.fecha1,fecha2:this.fecha2,user_id:0}).then((res) => {
         console.log(res.data)
        this.data = res.data;
        this.totalcaja();

        this.$q.loading.hide();
      });
    },
    viewRow(dato){
      this.$q.dialog({
        title: 'MOTIVO ',
        message: dato.motivo
      }).onOk(() => {
        // console.log('OK')
      }).onCancel(() => {
        // console.log('Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    },

    onSubmit() {
        if(this.dato.tipo=='RETIRA' && parseFloat(this.dato.monto) > parseFloat(this.cajachica.monto))
        {
                    this.$q.notify({
          message:'No debe ser Mayor a lo q esta en caja',
          icon:'close',
          color:'red'
        })
            return false
        }
        if(this.dato.tipo=='AGREGAR' && parseFloat(this.dato.monto) > parseFloat(this.montogeneral))
        {
                    this.$q.notify({
          message:'No debe ser Mayor a lo q esta en caja General',
          icon:'close',
          color:'red'
        })
            return false
        }
      this.$q.loading.show();
      // this.dato.unid_id=this.dato.unid_id.id;
      this.$axios.post(process.env.API + "/logcaja", {
        monto:this.dato.monto,
        motivo:this.dato.motivo,
        tipo:this.dato.tipo,
      }).then((res) => {
          this.onReset()
        this.$q.notify({
          color: "green-4",
          textColor: "white",
          icon: "cloud_done",
          message: "Creado correctamente",
        });
        this.alert = false;
        this.misdatos();
      }).catch(err=>{
        console.log(err.response.data);
        this.$q.notify({
          message:err.response.data.message,
          icon:'close',
          color:'red'
        })
        this.$q.loading.hide()
      })
    },


    onReset() {
      this.dato.monto = 0.0;
      this.dato.motivo = '';
      this.dato.tipo = 'AGREGA';
    },

  },
};
</script>
