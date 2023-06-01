<template>
  <q-page class="q-pa-xs">
    <div class="row">
      <div class="col-4 flex flex-center">
        <q-btn @click="providerAdd" v-if="$store.state.login.editalmacen" :loading="loading" label="Registro de Provedor" color="blue-7" no-caps icon="o_assignment_ind"/>
      </div>
      <div class="col-4 flex flex-center">
        <q-btn @click="materialAdd" :loading="loading" label="Registro de Materia Prima" color="green-7" no-caps icon="o_shopping_bag"/>
      </div>
      <div class="col-4 flex flex-center">
        <q-btn @click="compraAdd" v-if="$store.state.login.editalmacen" :loading="loading" label="Ingreso de Material Prima" color="cyan-7" no-caps icon="add_circle_outline"/>
      </div>
    </div>
    <div class="col-12">
      <q-table
        dense
        title="Lista de Materiales"
        :rows="materials"
        :columns="materialColumns"
        :loading="loading"
        :rows-per-page-options="[10, 25, 50]"
        :filter="almacenFilter"
        row-class="cursor-pointer"
      >
        <template v-slot:top-right>
          <q-input outlined dense v-model="almacenFilter" debounce="300" placeholder="Buscar...">
            <template v-slot:append>
              <q-icon name="search" class="cursor-pointer"/>
            </template>
          </q-input>
        </template>
        <template v-slot:body-cell-actions="props">
          <q-td :props="props" auto-width>
            <q-btn-dropdown icon="more_vert" no-caps dense color="primary" label="Opciones">
              <q-list>
                <q-item clickable v-close-popup @click="materialEdit(props.row)">
                  <q-item-section>Editar</q-item-section>
                </q-item>
                <q-item clickable v-close-popup @click="materialDelete(props.row)">
                  <q-item-section>Eliminar</q-item-section>
                </q-item>
              </q-list>
            </q-btn-dropdown>
          </q-td>
        </template>
        <template v-slot:body-cell-stock="props" >
          <q-td :props="props">
            <q-linear-progress size="18px" rounded :value="calcular(props.row.stock,props.row.min)" :color="calcular(props.row.stock,props.row.min)<1?'red-7':'green-7'" class="full-width">
              <div class="absolute-full flex flex-center">
                <q-badge color="white" :text-color="calcular(props.row.stock,props.row.min)<1?'red-7':'green-7'" :label="props.row.stock" />
              </div>
            </q-linear-progress>
          </q-td>
        </template>
      </q-table>
    </div>
    <div class="col-12">
      <div class="col-4"><q-input dense outlined v-model="fecha3" label="Fecha Ini" type="date"/></div>
      <div class="col-4"><q-input dense outlined v-model="fecha4" label="Fecha fin" type="date"/></div>
<!--      <div class="col-4"><q-select dense outlined v-model="material3" :options="materiales" label="Material" /></div>-->
      <div class="col-4"> <q-btn color="info" label="Consultar"  @click="consultmaterial"/>
      </div>
    </div>
    <q-dialog v-model="providerDialog">
      <q-card style="width: 700px; max-width: 90vw;">
        <q-card-section class="q-pb-none row items-center">
          <div class="text-h6">{{providerOptions === 'create' ? 'Registro de Provedor' : 'Editar Provedor'}}</div>
          <q-space/>
          <q-btn flat round dense icon="close" v-close-popup/>
        </q-card-section>
        <q-card-section>
          <q-form @submit="providerOptions === 'create' ? providerCreate() : providerUpdate()">
            <div class="row">
              <div class="col-8">
                <q-input outlined dense v-model="provider.razon" label="Nombre o Razón Social" lazy-rules :rules="[val => !!val || 'Campo requerido']"/>
              </div>
              <div class="col-4">
                <q-input outlined dense v-model="provider.nit" label="CI/NIT" hint="" />
              </div>
              <div class="col-12">
                <q-input outlined dense v-model="provider.direccion" label="Dirección" hint="" />
              </div>
              <div class="col-6">
                <q-input outlined dense v-model="provider.email" label="Email" hint="" />
              </div>
              <div class="col-6">
                <q-input outlined dense v-model="provider.telefono" label="Teléfono" hint="" />
              </div>
            </div>
            <q-card-section class="row justify-end">
              <q-btn :loading="loading" color="red" no-caps icon="o_delete" label="Cancelar" dense v-close-popup/>
              <q-btn :loading="loading" color="green" no-caps icon="o_save" label="Guardar" dense type="submit"/>
            </q-card-section>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
    <q-dialog v-model="materialDialog">
      <q-card style="width: 500px; max-width: 90vw;">
        <q-card-section class="q-pb-none row items-center">
          <div class="text-h6">{{materialOptions === 'create' ? 'Registro de ' : 'Editar '}} Material</div>
          <q-space/>
          <q-btn flat round dense icon="close" v-close-popup/>
        </q-card-section>
        <q-card-section>
          <q-form @submit="materialOptions === 'create' ? materialCreate() : materialUpdate()">
            <div class="row">
              <div class="col-12">
                <q-input outlined dense v-model="material.nombre" label="Nombre" lazy-rules :rules="[val => !!val || 'Campo requerido']"/>
              </div>
              <div class="col-6">
                <q-select outlined dense v-model="material.unid" label="Unidad" :options="unidades" lazy-rules :rules="[val => !!val || 'Campo requerido']"/>
              </div>
              <div class="col-6">
                <q-input outlined type="number" dense v-model="material.min" label="Minimo" hint="" :rules="[val => !!val || 'Campo requerido']">
                  <q-tooltip>
                      Cantidad minima de material en almacen
                  </q-tooltip>
                </q-input>
              </div>
            </div>
            <q-card-section class="row justify-end">
              <q-btn :loading="loading" color="red" no-caps icon="o_delete" label="Cancelar" dense v-close-popup/>
              <q-btn :loading="loading" color="green" no-caps icon="o_save" label="Guardar" dense type="submit"/>
            </q-card-section>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
    <q-dialog v-model="dialog_add">
      <q-card style="width: 800px; max-width: 80vw;">
        <q-card-section class="bg-green-14 text-white q-pb-none">
          <div class="text-bold text-center">INGRESO DE MATERIA PRIMA</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <div class="row">
            <div class="col-6">
              <q-select dense outlined v-model="material" :options="materials" label="Material" option-label="nombre" option-value="id" />
            </div>
            <div class="col-6">
              <q-select dense outlined v-model="provider" :options="providers" label="Proveedor" option-label="razon" option-value="id" />
            </div>
            <div class="col-3"><q-input dense outlined type="text" v-model="compra.cantidad" label="Cantidad"/></div>
<!--            <div class="col-2"><q-input dense outlined type="number" step="0.01" v-model="compra.costo" label="Costo U" /></div>-->
<!--            <div class="col-2 flex-center flex text-bold">Subtotal: {{subTotalNumber(compra.costo,compra.cantidad)}}</div>-->
            <div class="col-3"><q-input dense outlined  type="text" v-model="compra.lote"  label="Lote"  /></div>
            <div class="col-3"><q-input dense outlined  type="date" v-model="compra.fechaven"  label="Fecha Vencimiento"  /></div>
            <div class="col-3"><q-input dense outlined  type="text"  v-model="compra.observacion" label="Observacion" /></div>
            <div class="col-12 text-right">
              <q-btn label="Añadir" no-caps  color="green" icon="add_circle" @click="agregarcompra"/>
            </div>
            <div class="col-12">
                            <q-markup-table>
                            <thead>
                            <tr>
                              <th class="text-left" >NRO</th>
                              <th class="text-left">MATERIAL</th>
                              <th class="text-center">CANTIDAD</th>
<!--                              <th>COSTO</th>-->
<!--                              <th>SUBTOTAL</th>-->
                              <th class="text-center">LOTE</th>
                              <th class="text-left">FEC VEN</th>
                              <th class="text-left">OBS</th>
                              <th class="text-right">OPCION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(d,index) in compras " :key="index">
                              <td class="text-left">{{index + 1}}</td>
                              <td class="text-left">{{d.material}}</td>
                              <td class="text-center">{{d.cantidad}}</td>
<!--                              <td>{{d.costo}}</td>-->
<!--                              <td>{{d.subtotal}}</td>-->
                              <td class="text-center">{{d.lote}}</td>
                              <td class="text-left">{{d.fechaven}}</td>
                              <td class="text-left">{{d.observacion}}</td>
                              <td class="text-right"> <q-btn flat dense color="red" icon="o_delete" @click="eliminar(index)"/>
                              </td>
                            </tr>
                            </tbody>
                          </q-markup-table>
<!--              <pre>{{compras}}</pre>-->
            </div>
            <div>
            </div>
          </div>
          <div>
            <q-btn :loading="loading" label="REGISTRAR" color="positive" icon="add_circle" @click="regcompra"/>
            <q-btn  :loading="loading" label="Cancelar" icon="delete" color="negative" v-close-popup />
          </div>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-page>
</template>
<script>
import {date} from "quasar";

export default {
  data () {
    return {
      providers: [],
      provider: {},
      providerOptions: 'create',
      providerDialog: false,
      loading: false,
      almacenFilter: '',
      materials: [],
      material: '',
      dialog_add: false,
      fecha3:date.formatDate( Date.now(),'YYYY-MM-DD'),
      fecha4:date.formatDate( Date.now(),'YYYY-MM-DD'),
      unidades: ['Kilogramos', 'Litros', 'Unidad', 'Metros', 'Metros Cuadrados', 'Metros Cubicos', 'Caja', 'Bolsa', 'Paquete', 'Otro'],
      materialDialog: false,
      compra: {
        cantidad: 0,
        costo: 0,
        lote: '',
        fechaven: '',
        observacion: ''
      },
      compras: [],
      materialOptions: 'create',
      materialColumns: [
        { name: 'nombre', label: 'Material', align: 'left', field: 'nombre' },
        { name: 'unid', label: 'Unidad', align: 'left', field: 'unid' },
        { name: 'min', label: 'Minimo', align: 'center', field: 'min' },
        { name: 'stock', label: 'Stock', align: 'center', field: 'stock' },
        { name: 'actions', label: 'Acciones', align: 'center', field: 'actions' }
      ]
    }
  },
  created() {
    this.providersGet()
    this.materialsGet()
  },
  methods: {
    subTotalNumber(costo,cantidad){
      if(costo==undefined || costo=='' || costo==0) return 0
      if(cantidad==undefined || cantidad=='' || cantidad==0) return 0
      return parseFloat(costo) * parseFloat(cantidad)
    },
    eliminar(index){
      this.compras.splice(this.compras.indexOf(index),1);
    },
    agregarcompra(){
      if(this.compra.cantidad=='' || this.compra.cantidad==0 || this.compra.cantidad==undefined){
        this.$q.notify({
          color: 'red-4',
          textColor: 'white',
          icon: 'warning',
          message: 'Ingrese la cantidad',
          position: 'top'
        })
        return false
      }
      // if(this.compra.costo==undefined || this.compra.costo=='' || this.compra.costo==0) return false
      if(this.compra.fechaven==undefined || this.compra.fechaven=='') this.compra.fechaven=''
      if(this.compra.observacion==undefined || this.compra.observacion=='') this.compra.observacion=''
      if(this.compra.lote==undefined || this.compra.lote=='') this.compra.lote=''
      this.compra.material_id=this.material.id
      this.compra.subtotal=parseFloat(this.compra.cantidad)
      this.compra.material=this.material.nombre
      this.compra.provider_id=this.provider.id
      this.compras.push(this.compra)
      this.compra={
        cantidad: '',
        costo: '',
        lote: '',
        fechaven: '2023-01-01',
        observacion: ''
      }
    },
    regcompra(){
      if(this.compras.length==0){
        this.$q.notify({
          color: 'red-4',
          textColor: 'white',
          icon: 'info',
          message: 'Debe registrar '
        });
        return false
      }
      this.totalgeneral();
      this.totalcompra=0
      this.compras.forEach(r => {
        this.totalcompra+=r.subtotal
      });
      if(parseFloat(this.montogeneral) < parseFloat(this.totalcompra)){
        this.$q.notify({
          color: 'red-4',
          textColor: 'white',
          icon: 'info',
          message: 'No puede exeder monto'
        });
        return false
      }
      this.loading=true
      this.$axios.post(process.env.API+'/compra2',{
        // provider_id:this.proveedor.id,
        user_id:this.$store.getters["login/user"].id,
        compras:this.compras}).then(res=>{
        //console.log(res.data)
        this.dialog_add=false
        this.materialsGet();
        this.loading=false
      })

    },
    totalgeneral(){
      this.$axios.post(process.env.API + "/totalgeneral").then((res) => {
        this.montogeneral=parseFloat( res.data.monto);
      })
    },
    calcular(stock,min){
      let porcentaje=((stock/min*100)/100)
      if (porcentaje>1){
        return 1
      }else{
        return porcentaje
      }
    },
    compraAdd() {
      this.dialog_add = true
      this.compras=[]
      this.compra={
        cantidad: '',
        costo: '',
        lote: '',
        fechaven: '2023-01-01',
        observacion: ''
      }
      this.material=''
      this.provider=''
    },
    materialAdd() {
      this.material = {}
      this.materialDialog = true
      this.materialOptions = 'create'
    },
    providerAdd() {
      this.provider = {}
      this.providerDialog = true
      this.providerOptions = 'create'
    },
    providersGet() {
      this.$axios.get('provider').then(res => {
          this.providers = res.data
      }).catch(e => {
        console.log(e)
      })
    },
    providerCreate() {
      this.loading = true
      this.$axios.post('provider', this.provider).then(res => {
        this.providerDialog = false
        this.providersGet()
      }).catch(e => {
        console.log(e)
      }).finally(() => {
        this.loading = false
      })
    },
    materialUpdate() {
      this.loading = true
      this.$axios.put('material/' + this.material.id, this.material).then(res => {
        this.materialDialog = false
        this.materialsGet()
      }).catch(e => {
        console.log(e)
      }).finally(() => {
        this.loading = false
      })
    },
    materialCreate() {
      this.loading = true
      this.$axios.post('material', this.material).then(res => {
        this.materialDialog = false
        this.materialsGet()
      }).catch(e => {
        console.log(e)
      }).finally(() => {
        this.loading = false
      })
    },
    materialEdit(material) {
      this.material = material
      this.materialDialog = true
      this.materialOptions = 'update'
    },
    materialDelete(material) {
      this.$q.dialog({
        title: 'Confirmar',
        message: '¿Desea eliminar el material?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        this.loading = true
        this.$axios.delete('material/' + material.id).then(res => {
          this.materialsGet()
        }).catch(e => {
          console.log(e)
        }).finally(() => {
          this.loading = false
        })
      })
    },
    materialsGet() {
      this.loading = true
      this.$axios.get('material').then(res => {
          this.materials = res.data
        console.log(this.materials)
      }).catch(e => {
        console.log(e)
      }).finally(() => {
        this.loading = false
      })
    },
  }
}
</script>
<style scoped>

</style>
