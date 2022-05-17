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
            dense
            :rows-per-page-options="[0]"
            title="LISTA DE MATERIALES "
            :rows="materiales"
            :columns="columns"
            :filter="filter"
            row-key="name">
            <template v-slot:top-right>
               <q-btn color="amber-8" icon="shopping_cart" label="COMPRAS" @click="dialog_add=true; compras=[]"/>
              
              <q-input dense outlined debounce="300" v-model="filter" placeholder="Buscar">
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>
            <template v-slot:body-cell-opcion="props" >
              <q-td key="opcion" :props="props" >
                <q-btn dense round flat color="accent" @click="retirarRow(props)" icon="download"></q-btn>
                <q-btn dense round flat color="cyan" @click="reporte(props)" icon="poll"></q-btn>
                <q-btn dense round flat color="yellow" @click="editRow(props)" icon="edit"></q-btn>
                <q-btn dense round flat color="red" @click="delRow(props)" icon="delete"></q-btn>
              </q-td>
            </template>
          </q-table>
        </div>

      </div>
      <q-dialog v-model="dialog_add">
        <q-card style="width: 800px; max-width: 80vw;">
          <q-card-section class="bg-green-14 text-white">
            <div class="text-h7">Compra MATERIAL </div>
            <div class="text-h7">Proveedor: {{proveedor.razon}}</div>
          </q-card-section>
          <q-card-section class="q-pt-xs">
              <div class="row">
              <div class="col-12"><q-select dense outlined v-model="material" :options="materiales" label="Material" /></div>
              <div class="col-2"><q-input dense outlined type="text" v-model="compra.cantidad" label="Cantidad"/></div>
              <div class="col-2"><q-input dense outlined type="number" step="0.01" v-model="compra.costo" label="Costo" /></div>
              <div class="col-3"><q-input dense outlined  type="date" v-model="compra.fechaven"  label="Fecha Vencimiento"  /></div>
              <div class="col-3"><q-input dense outlined  type="text"  v-model="compra.observacion" label="Observacion" /></div>
              <div class="col-1"> <q-btn  dense color="green" icon="add_circle" @click="agregarcompra"/>
              </div>
              <table style="width:100%;border-collapse: collapse;">
              <thead>
              <tr>
              <th>NRO</th>
              <th>MATERIAL</th>
              <th>CANTIDAD</th>
              <th>COSTO</th>
              <th>FEC VEN</th>
              <th>OBS</th>
              <th>OPCION</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="(d,index) in compras " :key="index">
                <td>{{index + 1}}</td>
                <td>{{d.material}}</td>
                <td>{{d.cantidad}}</td>
                <td>{{d.costo}}</td>
                <td>{{d.fechaven}}</td>
                <td>{{d.observacion}}</td>
                <td> <q-btn color="red" icon="delete" @click="eliminar(index)"/>
                </td>
              </tr>
              </tbody>
              </table>
              </div>              
              <div>
                <q-btn label="REGISTRAR" color="positive" icon="add_circle" @click="regcompra"/>
                <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
              </div>
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

            <q-dialog v-model="dialog_modmat">
        <q-card>
          <q-card-section class="bg-green-14 text-white">
            <div class="text-h7">MODIFICAR MATERIAL</div>
          </q-card-section>
          <q-card-section class="q-pt-xs">
            <q-form @submit="onModmat" class="q-gutter-md" >
              <q-input outlined type="text" v-model="material2.nombre" label="NOMBRE"/>
              <q-input outlined type="text" v-model="material2.unid" label="UNIDADES"/>
              <q-input outlined type="text" v-model="material2.min" label="MIN STOCK"/>
              <div>
                <q-btn label="MODIFICAR" type="submit" color="positive" icon="add_circle"/>
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
        materiales:[],
        material2:{},
        proveedores:[],
        compras:[],
        compra:{},
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
      this.misproveedores()
      this.mismateriales()
  },
  methods: {
    regcompra(){
      if(this.compras.length==0){
                this.$q.notify({
          color: 'red-4',
          textColor: 'white',
          icon: 'info',
          message: 'Debe registrar '
        });
        return false}
      this.$axios.post(process.env.API+'/compra',{provider_id:this.proveedor.id,user_id:this.$store.getters["login/user"].id,compras:this.compras}).then(res=>{
        console.log(res.data)
        this.dialog_add=false
        this.mismateriales();
      })

    },
    eliminar(index){
      this.compras.splice(this.compras.indexOf(index),1);
    },
    agregarcompra(){
      if(this.compra.cantidad=='' || this.compra.cantidad==0 || this.compra.cantidad==undefined)
        return false
      if(this.compra.costo==undefined || this.compra.costo=='') this.compra.costo=''
      if(this.compra.fechaven==undefined || this.compra.fechaven=='') this.compra.fechaven=''
      if(this.compra.observacion==undefined || this.compra.observacion=='') this.compra.observacion=''
      this.compra.material_id=this.material.id
      this.compra.material=this.material.nombre
      this.compras.push(this.compra)
      this.compra={}
    },
    onRegRecuento(){
      //console.log
      this.recuento.material_id=this.material2.id
      this.recuento.user_id=this.$store.getters["login/user"].id
      this.$axios.post(process.env.API+'/recuento',this.recuento).then(res=>{
        this.recuento={}
        this.dialog_add=false
        this.mismateriales()
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
      this.$axios.post(process.env.API+'/material',this.material).then(res=>{
          this.$q.loading.hide()
          this.dialog_mat=false
          this.mismateriales()
          this.material={}
        })
      },
      onModmat(){
      this.$q.loading.show()
      this.$axios.put(process.env.API+'/material/'+this.material2.id,this.material2).then(res=>{
          this.$q.loading.hide()
          this.dialog_modmat=false
          this.mismateriales()
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

       mismateriales(){
          this.materiales=[]
      this.$axios.get(process.env.API+'/material').then(res=>{
          res.data.forEach( r=> {
              r.label=r.nombre
              this.materiales.push(r)
          });
          this.material=this.materiales[0]
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
    this.material2=props.row;
    this.dialog_modmat=true;
  },
    logRow(props){
    this.dato=props.row;
    this.dialog_log=true;
  },
  delRow(props){
    this.material2=props.row;
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

    onDel(){
        this.$q.loading.show();
        this.$axios.delete(process.env.API+'/material/'+this.material2.id).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Eliminado correctamente'
        });
        this.dialog_del=false;
        this.mismateriales();
        })
        this.$q.loading.hide();
    },


  onReset(){
    this.producto={};
  }

  },



}
</script>
<style>
</style>
