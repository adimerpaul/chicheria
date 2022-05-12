<template>
    <div class="row">
      <div class="col-12">
            <div class="text-h5 " style="text-align:center" ><b >INVENTARIO DE  MATERIAL</b></div>
             <q-btn color="accent" label="Nuevo Proveedor" @click="dialog_prov=true; proveedor={}"/>
        <div class="row">
        <div class="col-6"><q-select square outlined v-model="proveedor" :options="proveedores" label="Provedores" /></div>
        <div class="col-6"> <q-btn color="teal" label="Registrar Material" />
        </div>
        </div>  
        
        <div class="q-pa-md">
          <q-table
            title="LISTA DE MATERIALES "
            :rows="rows"
            :columns="columns"
            :filter="filter"

            row-key="name">
            <template v-slot:top-right>
              <q-input borderless dense debounce="300" v-model="filter" placeholder="Buscar">
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
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
          <div class="text-h7">MODIFICAR REGISTRO PRODUCTO</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form
            @submit="onMod"
            class="q-gutter-md"
          >
                  <q-input outlined type="text" v-model="dato.nombre" label="Nombre"/>

                  <q-input outlined type="number" step="0.1" v-model="dato.precio" label="Precio" />

                  <q-input outlined  type="text"  v-model="dato.observacion" label="Observacion" />
                    <q-select outlined v-model="dato.tipo" :options="['LOCAL','DETALLE']" label="TIPO" />
            <q-input outlined               type="number" v-model="dato.orden"               label="N° Orden"            />
            <div>
              <q-btn label="Modificar" type="submit" color="positive" icon="add_circle"/>
                <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <q-dialog v-model="dialog_prov">
      <q-card>
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h7">REGISTRO PROVEEDOR</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onReg" class="q-gutter-md" >
                  <q-input outlined type="text" v-model="proveedor.razon" label="Razon Social"/>
                  <q-input outlined type="text" v-model="proveedor.nit" label="NIT / CI"/>
                  <q-input outlined type="text" v-model="proveedor.direccion" label="DIRECCION"/>
                  <q-input outlined type="text" v-model="proveedor.email" label="Email"/>
                  <q-input outlined type="text" v-model="proveedor.telefono" label="telefono"/>
            <div>
              <q-btn label="REGISTRAR" type="submit" color="positive" icon="add_circle"/>
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

<q-dialog v-model="dialog_add">
      <q-card>
        <q-card-section class="bg-amber-14 text-white">
          <div class="text-h6">Agregar Cantidad Producto</div>
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
          <div class="text-h6">Retirar cantidad Producto </div>
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
        proveedor:{},
        dialog_prov:false,
        proveedores:[],
      crear:false,
      filter:'',
      dialog_mod:false,
      dialog_del:false,
      dialog_add:false,
      dialog_sub:false,
      dialog_log:false,
      agregar:0,
      disminuir:0,
      producto:{},
      color:'',
      dato:{},
      columns : [
  {
    name: 'nombre',
    label: 'NOMBRE',
    align: 'center',
    field: 'nombre',
    sortable: true
  },
  { name: 'precio', align: 'center', label: 'PRECIO', field: 'precio', sortable: true },
  { name: 'observacion', align: 'center', label: 'OBSERVACIÓN', field: 'observacion', sortable: true },
  { name: 'tipo', align: 'center', label: 'TIPO', field: 'tipo', sortable: true },
  { name: 'estado', align: 'center', label: 'ESTADO', field: 'estado' },
  { name: 'orden', align: 'center', label: 'ORDEN', field: 'orden' },
  { name: 'opcion', label: 'OPCIONES', field: 'action' }
],
  rows:[],

  }},
  created() {
      this.listado();
      this.misproveedores()
  },
  methods: {
      onReg(){
      this.$axios.post(process.env.API+'/provider',this.proveedor).then(res=>{
          this.misproveedores()
          this.provider={}
      })

      },
      misproveedores(){
          this.proveedores=[]
      this.$axios.get(process.env.API+'/provider').then(res=>{
          res.data.forEach( r=> {
              r.label=r.razon
              this.proveedores.push(r)
          });
          this.proveedor=this.proveedores[0]
      })

      },
    listado(){
      this.$q.loading.show();
      this.$axios.get(process.env.API+'/producto').then(res=>{
        console.log(res.data)
        this.rows=res.data;
        this.$q.loading.hide();
      })
    },
    registrar(){
      this.producto.nombre=  this.producto.nombre.toUpperCase()

      // console.log(this.producto.observacion)
      if (this.producto.observacion!=undefined){
        this.producto.observacion=  this.producto.observacion.toUpperCase()
      }

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
    logRow(props){
    this.dato=props.row;
    this.dialog_log=true;
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
    this.producto={};
  }

  },



}
</script>
