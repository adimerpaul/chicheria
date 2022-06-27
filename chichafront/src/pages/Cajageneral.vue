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
            <div class="col-4 col-sm-4 q-pa-xs"><q-input type="date" label="fecha" v-model="fecha1" outlined required/></div>
            <div class="col-4 col-sm-4 q-pa-xs"><q-input type="date" label="fecha" v-model="fecha2" outlined required/></div>
            <div class="col-4 col-sm-4 q-pa-xs flex flex-center">
              <q-btn color="info"  label="Consultar" icon="search" type="submit" />

            </div>
            </div>
            </q-form>
     <q-badge class="full-width text-h5 flex flex-center" color="red" >TOTAL EN CAJA GENERAL: {{cajageneral.monto}} Bs.</q-badge>

    <q-dialog v-model="alert">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6"><q-icon name="add_circle" /> Caja General</div>
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
                  :options="['AGREGAR','RETIRAR']"
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

    <q-table :filter="filter" title="Caja General" 
      :rows="data" 
      :columns="columns" 
      row-key="name" 
      :rows-per-page-options="[50,100]">
      <template v-slot:top-right>
        <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
            <template v-slot:body-cell-tipo="props">
          <q-td key="opcion" :props="props">
              <q-badge color="green" v-if="props.row.tipo=='INGRESO'">{{props.row.tipo}}</q-badge>
              <q-badge color="red" v-if="props.row.tipo=='EGRESO'">{{props.row.tipo}}</q-badge>
              <q-badge color="blue" v-if="props.row.tipo=='AGREGAR'">{{props.row.tipo}}</q-badge>
              <q-badge color="purple" v-if="props.row.tipo=='RETIRAR'">{{props.row.tipo}}</q-badge>
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
            ></q-btn>
          </q-td>

      </template>
    </q-table>



  </div>
</template>

<script>
import { date } from 'quasar'

export default {
  data() {
    return {
      alert: false,
      filter:'',
        fecha1:date.formatDate(Date.now(),'YYYY-MM-DD'),
        fecha2:date.formatDate( Date.now(),'YYYY-MM-DD'),
      model:'',
      dato:{},
      options: [],
      props: [],
      cajageneral:0,
      columns: [
        {name: "fecha", align: "left", label: "FECHA ", field: "fecha", sortable: true,},
        {name: "monto", align: "left", label: "MONTO", field: "monto", sortable: true,},
        {name: "detalle", align: "left", label: "DETALLE", field: "detalle", sortable: true,},
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
      deleteRow(logcaja){
      this.$q.dialog({
        title: 'Confirmar',
        message: 'Esta seguro de eliminar',
        cancel: true,
        persistent: false
      }).onOk(() => {
               this.$axios.delete(process.env.API + "/loggeneral/"+logcaja.id).then((res) => {
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
      this.$axios.post(process.env.API + "/totalgeneral").then((res) => {
          this.cajageneral=res.data;
      })
      },

    misdatos() {
      this.$q.loading.show();
      this.$axios.post(process.env.API + "/listgeneral",{fecha1:this.fecha1,fecha2:this.fecha2}).then((res) => {
         console.log(res.data)
        this.data = res.data;
        this.totalcaja();

        this.$q.loading.hide();
      });
    },


    onSubmit() {
        if(this.dato.tipo=='RETIRAR' && parseFloat(this.dato.monto) > parseFloat(this.cajageneral.monto))
        {
                    this.$q.notify({
          message:'No debe ser Mayor a lo q esta en caja',
          icon:'close',
          color:'red'
        })
            return false
        }
      this.$q.loading.show();
      // this.dato.unid_id=this.dato.unid_id.id;
      this.$axios.post(process.env.API + "/loggeneral", {
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
      this.dato.tipo = 'AGREGAR';
    },

  },
};
</script>
