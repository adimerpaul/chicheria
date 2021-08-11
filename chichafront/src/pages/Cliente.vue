<template>
    <div class="row">
      <div class="col-12">
            <div class="text-h6">
              <h5 style="text-align:center">INFORMACION DE CLIENTES</h5>
              <q-btn label="Registrar" icon="add" color="positive" @click="crear = true" />
            </div>
            <!--            <div class="text-subtitle2">by John Doe</div>-->
          <q-dialog v-model="crear" >
            <q-card style="width: 700px; max-width: 80vw;">
              <q-card-section>
                <div class="text-h6">Registro nuevo cliente</div>
              </q-card-section>
              <q-card-section class="q-pt-none">
                <q-form
                  @submit="registrar"
                  @reset="onReset"
                  class="q-gutter-md"
                >
                  <q-input
                    filled
                    type="text"
                    v-model="cliente.local"
                    label="Local"
                  />
                  <q-input
                    filled
                    type="text"
                    v-model="cliente.ci"
                    label="Cedula Identidad"
                  />
                  <q-input
                    filled
                    v-model="cliente.titular"
                    type="text"
                    label="Nombre Completo"
                    lazy-rules
                    :rules="[ val => val && val.length > 0 || 'Por favor ingresar dato']"
                  />
                  <q-select v-model="cliente.tipo" :options="['PROPIETARIO','INQUILINO']" label="Tipo" />
                  
                  <q-input
                    filled
                    type="text"
                    v-model="cliente.telefono"
                    label="Telefono o Celular"
                  />
                  <q-input
                    type="date"
                    filled
                    v-model="cliente.fecnac"
                    label="Fecha Nac"
                  />
                  <q-input
                    type="text"
                    filled
                    v-model="cliente.direccion"
                    label="Direccion*"
                  />
                  <q-select v-model="cliente.legalidad" :options="['CON LICENCIA','SIN LICENCIA']" label="Legalidad" />
                  <q-select v-model="cliente.categoria" :options="['GENERAL','SIMPLIFICADO','SIN NIT']" label="Legalidad" />
                  <q-input
                    type="text"
                    filled
                    v-model="cliente.razon"
                    label="Razon Social"
                  />

                  <q-input
                    filled
                    v-model="cliente.nit"
                    label="NIT"
                    type="text"
                  />
                  <div>
                    <q-btn label="Registrar" type="submit" color="primary" />
                  </div>
                </q-form>
              </q-card-section>

            </q-card>
          </q-dialog>

        <div class="q-pa-md">
          <q-table
            title="CLIENTES"
            :rows="rows"
            :columns="columns"
            row-key="name">
            <template v-slot:body-cell-estado="props" >
              <q-tr :props="props" >
                <q-td key="estado" :props="props" @click="activar(props)">
                  <q-badge color="green" v-if="props.row.estado=='ACTIVO'">
                    {{ props.row.estado }}
                  </q-badge>
                  <q-badge color="red" v-else>
                    {{ props.row.estado }}
                  </q-badge>
                </q-td>
              </q-tr>
            </template>
            <template v-slot:body-cell-opcion="props" >
                <q-td key="opcion" :props="props" >
                <q-btn dense round flat color="yellow" @click="editRow(props)" icon="edit"></q-btn>
                <q-btn dense round flat color="red" @click="delRow(props)" icon="delete"></q-btn>
                </q-td>
            </template>
          </q-table>
        </div>

    <q-dialog v-model="dialog_mod">
      <q-card>
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6">Modificar Cliente</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form
            @submit="onMod"
            class="q-gutter-md"
          >
                  <q-input
                    filled
                    type="text"
                    v-model="dato.local"
                    label="Local"
                  />
                  <q-input
                    filled
                    type="text"
                    v-model="dato.ci"
                    label="Cedula Identidad"
                  />
                  <q-input
                    filled
                    v-model="dato.titular"
                    type="text"
                    label="Nombre Completo"
                    lazy-rules
                    :rules="[ val => val && val.length > 0 || 'Por favor ingresar dato']"
                  />
                  <q-select v-model="dato.tipo" :options="['PROPIETARIO','INQUILINO']" label="Tipo" />
                  
                  <q-input
                    filled
                    type="text"
                    v-model="dato.telefono"
                    label="Telefono o Celular"
                  />
                  <q-input
                    type="date"
                    filled
                    v-model="dato.fecnac"
                    label="Fecha Nac"
                  />
                  <q-input
                    type="text"
                    filled
                    v-model="dato.direccion"
                    label="Direccion*"
                  />
                  <q-select v-model="dato.legalidad" :options="['CON LICENCIA','SIN LICENCIA']" label="Legalidad" />
                  <q-select v-model="dato.categoria" :options="['GENERAL','SIMPLIFICADO','SIN NIT']" label="Legalidad" />
                  <q-input
                    type="text"
                    filled
                    v-model="dato.razon"
                    label="Razon Social"
                  />

                  <q-input
                    filled
                    v-model="dato.nit"
                    label="NIT"
                    type="text"
                  />

            <div>
              <q-btn label="Modificar" type="submit" color="positive" icon="add_circle"/>
                <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>


      </q-card>
    </q-dialog>

    <q-dialog v-model="dialog_del" >
      <q-card>
        <q-card-section class="row items-center">
          <q-avatar icon="clear" color="red" text-color="white" />
          <span class="q-ml-sm">Seguro de eliminar Registro.</span>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="Eliminar" color="deep-orange" @click="onDel"/>
          <q-btn flat label="Cancelar" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>


      </div>
    </div>

</template>
<script>

export default {
  data(){
    return{
      crear:false,
      dialog_mod:false,
      dialog_del:false,
      cliente:{},
      color:'',
      dato:{},
      columns : [
  {
    name: 'local',
    label: 'Codigo',
    align: 'center',
    field: 'local',
    sortable: true
  },
  { name: 'ci', align: 'center', label: 'CI', field: 'ci', sortable: true },
  { name: 'titular', align: 'center', label: 'Titular', field: 'titular', sortable: true },
  { name: 'tipo', label: 'Tipo', field: 'tipo' },
  { name: 'telefono', label: 'telefono', field: 'telefono' },
  { name: 'fecha nac', label: 'Fecha Nac', field: 'fechanac' },
  { name: 'direccion', label: 'Direccion', field: 'direccion' },
  { name: 'legalidad', label: 'Legalidad', field: 'legalidad' },
  { name: 'categoria', label: 'Categoria NIT', field: 'categoria' },
  { name: 'razon', label: 'Razon Social', field: 'razon' },
  { name: 'nit', label: 'Numero NIT', field: 'nit' },
  { name: 'estado', align: 'center', label: 'Estado', field: 'estado' },
  { name: 'opcion', label: 'Opciones', field: 'action' }
],
  rows:[]

    }
  },
  created() {
      this.listado();
  },
  methods: {
    listado(){
      this.$q.loading.show();
      this.$axios.get(process.env.API+'/cliente').then(res=>{
        console.log(res.data)
        this.rows=res.data;
        this.$q.loading.hide();
      })
    },
    registrar(){
        this.$axios.post(process.env.API+'/cliente', this.cliente).then(res=>{
        this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Creado correctamente'
        });
        this.crear=false;
        this.onReset();
        this.listado();
      }).catch(err=>{
          
          this.$q.notify({
            color: 'red-4',
            textColor: 'white',
            icon: 'error',
            message: 'Error al registrar o ya esta registrado'
          });
        })
      },


      activar(props){
        this.dato=props.row;
        this.$axios.post(process.env.API+'/activar', this.dato).then(res=>{
          this.listado();
        });

      },
  editRow(props){
    this.dato=props.row;
    this.dialog_mod=true;
  },
  delRow(props){
    this.dato=props.row;
    this.dialog_del=true;
  },
     onMod(){
        this.$q.loading.show();
        this.$axios.put(process.env.API+'/cliente/'+this.dato.id,this.dato).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Modificado correctamente'
        });
        this.dialog_mod=false;
        this.listado();
       }).catch(err=>{

          this.$q.notify({
            color: 'red-4',
            textColor: 'white',
            icon: 'error',
            message: 'Error al Modificar'
          });
        })
        this.$q.loading.hide();
    },
    onDel(){
        this.$q.loading.show();
        this.$axios.delete(process.env.API+'/cliente/'+this.dato.id).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Eliminado correctamente'
        });
        this.dialog_del=false;
        this.listado();
        })
        this.$q.loading.hide();
    },
  onReset(){
    this.cliente={};
  }
    
  },



}
</script>
