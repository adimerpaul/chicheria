<template>
    <div class="row">
      <div class="col-12">
            <div class="text-h6">
              <h5 style="text-align:center">INFORMACION DE PRODUCTOS</h5>
              <q-btn label="Registrar" icon="add" color="positive" @click="crear = true" />
            </div>
          <q-dialog v-model="crear" >
            <q-card style="width: 700px; max-width: 80vw;">
              <q-card-section>
                <div class="text-h6">Registro nuevo Producto</div>
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
                    v-model="producto.nombre"
                    label="Nombre"
                  />
                  <q-input
                    filled
                    type="number"
                    v-model="producto.precio"
                    label="Precio"
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
            title="Productos"
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
                    v-model="dato.nombre"
                    label="Nombre"
                  />
                  <q-input
                    filled
                    type="number"
                    v-model="dato.ci"
                    label="Precio"
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
      producto:{},
      color:'',
      dato:{},
      columns : [
  {
    name: 'nombre',
    label: 'Nombre',
    align: 'center',
    field: 'nombre',
    sortable: true
  },
  { name: 'precio', align: 'center', label: 'Precio', field: 'precio', sortable: true },
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
      this.$axios.get(process.env.API+'/producto').then(res=>{
        console.log(res.data)
        this.rows=res.data;
        this.$q.loading.hide();
      })
    },
    registrar(){
        this.$axios.post(process.env.API+'/producto', this.producto).then(res=>{
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
            message: 'Error al registrar'
          });
        })
      },


      activar(props){
        this.dato=props.row;
        this.$axios.post(process.env.API+'/activarprod', this.dato).then(res=>{
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
        this.$axios.put(process.env.API+'/producto/'+this.dato.id,this.dato).then(res=>{
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
        this.$axios.delete(process.env.API+'/producto/'+this.dato.id).then(res=>{
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
    this.producto={};
  }
    
  },



}
</script>
