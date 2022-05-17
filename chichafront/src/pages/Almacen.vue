<template>
  <q-page class="q-pa-xs">
    <div class="row">
      <div class="col-12">
        <div class="text-h5 text-center text-bold"  >INVENTARIO DE  MATERIAL</div>
      </div>
      <div class="col-3 flex flex-center">
        <q-btn-dropdown icon="list" class="full-width" color="accent" label="PROVEEDOR">
          <q-list>
            <q-item clickable v-close-popup @click="dialog_prov=true; proveedor={}">
              <q-item-section>
                <q-item-label>REGISTRO</q-item-label>
              </q-item-section>
            </q-item>

            <q-item clickable v-close-popup @click="modif_prov">
              <q-item-section>
                <q-item-label>MODIFICAR</q-item-label>
              </q-item-section>
            </q-item>

          </q-list>
        </q-btn-dropdown>
      </div>
      <div class="col-6">
        <q-select dense outlined v-model="proveedor" :options="proveedores" label="Provedores" />
      </div>
      <div class="col-3 flex flex-center">
        <q-btn icon="engineering" color="teal" class="full-width" label="Registrar Material" @click="dialog_mat=true; material={}"/>
      </div>
        <div class="col-12">
        <div class="q-pa-none">
          <q-table
            title="LISTA DE MATERIALES "
            :rows="proveedor.materiales"
            :columns="columns"
            :filter="filter"
            row-key="name">
            <template v-slot:top-right>
              <q-input dense outlined debounce="300" v-model="filter" placeholder="Buscar">
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>
            <template v-slot:body-cell-opcion="props" >
              <q-td key="opcion" :props="props" >
                <q-btn dense round flat color="green" @click="agregarRow(props)" icon="add"></q-btn>
                <q-btn dense round flat color="accent" @click="retirarRow(props)" icon="remove"></q-btn>
                <q-btn dense round flat color="yellow" @click="editRow(props)" icon="edit"></q-btn>
                <q-btn dense round flat color="red" @click="delRow(props)" icon="delete"></q-btn>
              </q-td>
            </template>
          </q-table>
        </div>

      </div>
      <q-dialog v-model="dialog_add">
        <q-card>
          <q-card-section class="bg-green-14 text-white">
            <div class="text-h7">INGRESAR MATERIAL </div>
            <div class="text-h7">Material: {{material2.nombre}}</div>
          </q-card-section>
          <q-card-section class="q-pt-xs">
            <q-form             @submit="onRegRecuento"             class="q-gutter-md"          >
              <q-input outlined type="text" v-model="recuento.cantidad" label="Cantidad"/>

              <q-input outlined type="number" step="0.01" v-model="recuento.costo" label="Costo" />
              <q-input outlined  type="date" v-model="recuento.fechaven"  label="Fecha Vencimiento"  />

              <q-input outlined  type="text"  v-model="recuento.observacion" label="Observacion" />
              <div>
                <q-btn label="Modificar" type="submit" color="positive" icon="add_circle"/>
                <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
              </div>
            </q-form>
          </q-card-section>
        </q-card>
      </q-dialog>

      <q-dialog v-model="dialog_remove">
        <q-card>
          <q-card-section class="bg-green-14 text-white">
            <div class="text-h7">RETIRAR MATERIAL </div>
            <div class="text-h7">Material: {{material2.nombre}}</div>
          </q-card-section>
          <q-card-section class="q-pt-xs">
            <q-form             @submit="onRegRecuento2"             class="q-gutter-md"          >
              <q-input outlined type="text" v-model="recuento.cantidad" label="Cantidad"/>
              <q-input outlined  type="text"  v-model="recuento.observacion" label="Observacion" />
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

      <q-dialog v-model="dialog_mat">
        <q-card>
          <q-card-section class="bg-green-14 text-white">
            <div class="text-h7">REGISTRO MATERIAL</div>
            <div class="text-h7">Proveedor: {{proveedor.razon}}</div>
          </q-card-section>
          <q-card-section class="q-pt-xs">
            <q-form @submit="onRegmat" class="q-gutter-md" >
              <q-input outlined type="text" v-model="material.nombre" label="NOMBRE"/>
              <q-input outlined type="text" v-model="material.unid" label="UNIDADES"/>
              <q-input outlined type="text" v-model="material.min" label="MIN STOCK"/>
              <div>
                <q-btn label="REGISTRAR" type="submit" color="positive" icon="add_circle"/>
                <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
              </div>
            </q-form>
          </q-card-section>
        </q-card>
      </q-dialog>

      <q-dialog v-model="dialog_modprov">
        <q-card>
          <q-card-section class="bg-yellow-14 text-white">
            <div class="text-h7">MODIFICAR PROVEEDOR</div>
          </q-card-section>
          <q-card-section class="q-pt-xs">
            <q-form @submit="onReg" class="q-gutter-md" >
              <q-input outlined type="text" v-model="proveedor2.razon" label="Razon Social"/>
              <q-input outlined type="text" v-model="proveedor2.nit" label="NIT / CI"/>
              <q-input outlined type="text" v-model="proveedor2.direccion" label="DIRECCION"/>
              <q-input outlined type="text" v-model="proveedor2.email" label="Email"/>
              <q-input outlined type="text" v-model="proveedor2.telefono" label="telefono"/>
              <div>
                <q-btn label="MODIFICAR" type="submit" color="positive" icon="add_circle"/>
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
  </q-page>
</template>
<script>

export default {
  data(){
    return{
        proveedor:{},
        proveedor2:{},
        dialog_prov:false,
        dialog_modprov:false,
        dialog_mat:false,
        dialog_modmat:false,
        material:{},
        material2:{},
        proveedores:[],
      crear:false,
      recuento:{},
      filter:'',
      dialog_mod:false,
      dialog_del:false,
      dialog_add:false,
      dialog_remove:false,
      dialog_log:false,
      agregar:0,
      disminuir:0,
      producto:{},
      color:'',
      dato:{},
      columns : [

  { name: 'nombre', align: 'center', label: 'Nombre', field: 'nombre', sortable: true },
  { name: 'unid', align: 'center', label: 'unidad', field: 'unid', sortable: true },
  { name: 'min', align: 'center', label: 'Minimo', field: 'min', sortable: true },
  { name: 'stock', align: 'center', label: 'stock', field: 'stock', sortable: true },
  { name: 'opcion', label: 'OPCIONES', field: 'opcion' }
],
  rows:[],

  }},
  created() {
      this.listado();
      this.misproveedores()
  },
  methods: {
    onRegRecuento(){
      //console.log
      this.recuento.material_id=this.material2.id
      this.recuento.tipo='AGREGAR'
      this.recuento.user_id=this.$store.getters["login/user"].id
      this.$axios.post(process.env.API+'/recuento',this.recuento).then(res=>{
        this.recuento={}
        this.dialog_add=false
        this.misproveedores()
      })
    },
    onRegRecuento2(){
      //console.log
      if(this.material2.stock<this.recuento.cantidad)
        return false
      this.recuento.material_id=this.material2.id
      this.recuento.tipo='RETIRAR'
      this.recuento.user_id=this.$store.getters["login/user"].id
      this.$axios.post(process.env.API+'/recuento',this.recuento).then(res=>{
        this.recuento={}
        this.dialog_remove=false
        this.misproveedores()
      })
    },
    agregarRow(props){
      this.material2=props.row
      this.dialog_add=true
    },
        retirarRow(props){
      this.material2=props.row
      this.dialog_remove=true
    },
      modif_prov(){
        this.proveedor2=this.proveedor
        this.dialog_modprov=true
      },
      onReg(){
      this.$axios.post(process.env.API+'/provider',this.proveedor).then(res=>{
        this.dialog_prov=false
          this.misproveedores()
          this.provider={}
      })

      },

      onRegmat(){
      this.$q.loading.show()
      this.material.provider_id=this.proveedor.id
      this.$axios.post(process.env.API+'/material',this.material).then(res=>{
          this.$q.loading.hide()
          this.dialog_mat=false
          this.misproveedores()
          this.material={}
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
