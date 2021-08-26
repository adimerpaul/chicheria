<template>
    <div class="row">
      <div class="col-12">
            <div class="text-h6">
              <h5 style="text-align:center">INVENTARIO MATERIALES PRESTAMO</h5>
              <q-btn label="Registrar" icon="add" color="positive" @click="crear = true" />
            </div>
            <!--            <div class="text-subtitle2">by John Doe</div>-->
          <q-dialog v-model="crear" >
            <q-card style="width: 700px; max-width: 80vw;">
              <q-card-section>
                <div class="text-h6">Registro nuevo Material</div>
              </q-card-section>
              <q-card-section>
                <q-form
                  @submit="registrar"
                  @reset="onReset"
                  class="q-gutter-md"
                >
                <q-input
                    filled
                    type="text"
                    v-model="inventario.codigo"
                    label="Codigo"
                    lazy-rules
                    :rules="[ val => val.length > 0 || 'Por favor ingrese dato']"

                  />
                  <q-input
                    filled
                    type="text"
                    v-model="inventario.nombre"
                    label="Nombre"
                    lazy-rules
                    :rules="[ val => val.length > 0 || 'Por favor ingrese dato']"
                  />

                  <q-input
                    filled
                    type="number"
                    v-model="inventario.cantidad"
                    label="Cantidad"
                  />

                  <q-input
                    filled
                    v-model="inventario.detalle"
                    type="text"
                    label="Detalle"  
                  />
                  <q-select v-model="inventario.producto_id" :options="productos" label="Producto" />

 
                  <div>
                    <q-btn label="Registrar" type="submit" color="primary" />
                  </div>
                </q-form>
              </q-card-section>

            </q-card>
          </q-dialog>

        <div class="q-pa-md">
          <q-table
            title="INVENTARIO"
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
                <q-btn  dense round flat color="green" @click="addRow(props)" icon="add"></q-btn>
                <q-btn  dense round flat color="red" @click="substractRow(props)" icon="remove"></q-btn>
            
                <q-btn dense round flat color="yellow" @click="editRow(props)" icon="edit"></q-btn>
                <q-btn dense round flat color="red" @click="delRow(props)" icon="delete"></q-btn>
                </q-td>
            </template>
          </q-table>
        </div>

    <q-dialog v-model="dialog_mod">
      <q-card>
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6">Modificar Inventario</div>
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
                    lazy-rules
                    :rules="[ val => val.length > 0 || 'Por favor ingrese dato']"
                  />
                  <q-input
                    filled
                    type="text"
                    v-model="dato.detalle"
                    label="Detalle"
                  />
                  <q-select v-model="dato.producto_id" :options="productos" label="Producto" />


            <div>
              <q-btn label="Modificar" type="submit" color="positive" icon="add_circle"/>
                <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>


      </q-card>
    </q-dialog>

<q-dialog v-model="dialog_add">
      <q-card>
        <q-card-section class="bg-amber-14 text-white">
          <div class="text-h6">Agregar Cantidad Material</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form
            @submit="onAdd"
            class="q-gutter-md"
          >
            <q-input
              filled
              v-model="dato.nombre"
              type="text"
              label="Nombre"
              readonly
            />
            <q-input
              filled
              v-model="dato.motivo"
              type="text"
              label="Motivo Description"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor Valor']"
            />

            <q-input
              filled
              v-model="agregar"
              label="Cantidad a agregar"
              type="number"
              min=1
              lazy-rules
              :rules="[ val => val>0 && val < 500 || 'Por favor Valor']"
            />

             <div>
              <q-btn label="Agregar" type="submit" color="positive" icon="add_circle"/>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>


<q-dialog v-model="dialog_sub">
      <q-card>
        <q-card-section class="bg-amber-14 text-white">
          <div class="text-h6">Retirar Material </div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form
            @submit="onSub"
            class="q-gutter-md"
          >
            <q-input
              filled
              v-model="dato.nombre"
              type="text"
              label="Nombre"
              readonly
            />
            <q-input
              filled
              v-model="dato.motivo"
              type="text"
              label="Motivo Description"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor Valor']"
            />
            <q-input
              filled
              v-model="disminuir"
              label="Cantidad a retirar"
              type="number"
              min=1
              lazy-rules
              :rules="[ val => val>0 && val < 500 || 'Por favor Valor']"
            />

             <div>
              <q-btn label="Retirar" type="submit" color="red" icon="remove_circle"/>
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
      dialog_add:false,
      dialog_sub:false,
      agregar:0,
      disminuir:0,
      inventario:{},
      productos:[],
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
  { name: 'stock', align: 'center', label: 'Stock', field: 'stock', sortable: true },
  { name: 'detalle', align: 'center', label: 'Detalle', field: 'detalle', sortable: true },
  { name: 'estado', align: 'center', label: 'Estado', field: 'estado' },
  { name: 'opcion', label: 'Opciones', field: 'action' }
],
  rows:[]

    }
  },
  created() {
      this.listado();
      this.cargar();
  },
  methods: {
    listado(){
      this.$q.loading.show();
      this.$axios.get(process.env.API+'/inventario').then(res=>{
        console.log(res.data)
        this.rows=res.data;
        this.$q.loading.hide();
      })
    },
    cargar(){
      this.productos=[];
      this.$axios.get(process.env.API+'/listaproducto').then(res=>{
          res.data.forEach(element => {
            this.productos.push({label:element.nombre,value:element.id});
            
          });
      })
    },
    registrar(){
        this.$axios.post(process.env.API+'/inventario', this.inventario).then(res=>{
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
            message: 'Error al registrar '
          });
        })
      },


      activar(props){
        this.dato=props.row;
        this.$axios.post(process.env.API+'/activarinv', this.dato).then(res=>{
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
      addRow(props){
        this.dato= props.row;
        this.dialog_add=true;
    },
    substractRow(props){
        this.dato= props.row;
        this.dialog_sub=true;
    },
     onMod(){
        this.$q.loading.show();
        this.$axios.put(process.env.API+'/inventario/'+this.dato.id,this.dato).then(res=>{
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
        this.$axios.delete(process.env.API+'/inventario/'+this.dato.id).then(res=>{
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
        onAdd(){
        this.$q.loading.show();
        this.modprod={id:this.dato.id,cantidad:this.agregar,motivo:this.dato.motivo}
        this.$axios.post(process.env.API+'/inventarioadd',this.modprod).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Agregado correctamente'
        });
        this.dialog_add=false;
        this.agregar=0;
        this.listado();})
    },


    onSub(){
        this.$q.loading.show();
        this.modprod={id:this.dato.id,cantidad:this.disminuir,motivo:this.dato.motivo};
        this.$axios.post(process.env.API+'/inventariosub',this.modprod).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'modificado correctamente'
        });
        this.dialog_sub=false;
        this.disminuir=0;
        this.listado();})
    },
  onReset(){
    this.cliente={};
  }
    
  },



}
</script>
