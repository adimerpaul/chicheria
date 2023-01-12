<template>
<q-page>
<div class="row">
  <div class="col-12">
    <div :class="`q-pa-xs bg-${type=='detalle'?'red':'green'} text-center text-bold text-white`">{{ type=='detalle'?'VENTA POR DETALLE':'VENTA POR LOCAL' }}</div>
  </div>
  <div class="col-7">
    <div class="row">
      <div class="col-2" v-for="p in products" :key="p.id" style="padding:5px">
        <q-card style="height: 80px;" @click="saleAdd(p)" class="no_selection">
          <q-card-section class="row items-center q-pb-none">
            <div class="text-bold text-grey">{{p.precio}}Bs.</div>
            <q-space />
            <div v-if="p.cantidad>0">
              <q-chip color="primary" class=" q-ma-none text-bold text-white" dense :label="p.cantidad"/>
            </div>
          </q-card-section>
          <q-card-section class="q-pa-none">
            <div class="text-subtitle2 flex-center flex text-center">{{p.nombre}}</div>
          </q-card-section>
        </q-card>
      </div>
    </div>
  </div>
  <div class="col-5">
    <q-card>
      <q-card-section class="row items-center q-pb-none">
          <div class="col-2">
             <q-btn color="green" icon="add_circle" v-if="type=='detalle'" @click="modalregistro=true; newcliente={}"/>
          </div>
          <div class="col-2">
             <q-btn color="yellow"  icon="edit" v-if="client && type=='detalle'" @click="modcliente=client; dialog_mod=true;"/>            
        </div>
        <div class="col-8">
          <q-input type="date" outlined v-model="fecha" dense label="Fecha" />        
        </div>
        <div class="col-2">
          <div class="text-bold text-grey">Total: <span class="text-red text-h5">{{total}}Bs.</span> </div>
        </div>
        <div class="col-9">
          <q-select
            outlined
            dense
            v-model="client"
            use-input
            input-debounce="0"
            label="Cliente"
            :options="clients"
            @filter="filterFn"
            behavior="menu"
          >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey">
                  No results
                </q-item-section>
              </q-item>
            </template>
          </q-select>
        </div>
        <div class="col-1">
          <q-btn icon="delete_outline" dense  color="negative" @click="saleClear" />
        </div>
      <div class="col-12"><q-input dense outlined v-model="obs" label="Observacion" /></div>
      </q-card-section>
      <q-card-section class="q-pa-none">
        <div class="text-subtitle2 flex-center flex text-center bg-primary text-white">PRODUCTOS</div>
      </q-card-section>
      <q-card-section class="q-pa-none">
        <div class="row items-center bg-primary text-white">
          <div class="col-2 text-center text-bold">Cantidad</div>
          <div class="col-6 text-center text-bold">Nombre</div>
          <div class="col-2 text-center text-bold">Precio</div>
          <div class="col-2 text-center text-bold">Subtotal</div>
        </div>
        <div class="row items-center" v-for="p in productSales" :key="p.id">
          <div class="col-2 text-center text-bold">
            <q-input v-model="p.cantidad" dense type="number" step="0.25" />
          </div>
          <div class="col-6 text-grey">{{p.nombre}}</div>
          <div class="col-2 text-right text-grey">
            <q-input v-model="p.precio" dense type="number" step="0.1">
              <template v-slot:append>
                <div class="text-subtitle1">Bs.</div>
              </template>
            </q-input>
          </div>
          <div class="col-2 text-right q-pr-xs text-bold">{{p.precio*p.cantidad}}Bs.</div>
        </div>
      </q-card-section>
    </q-card>
    <q-form>
      <div class="row">
        <div class="col-4">
          <q-input v-model="monto" dense outlined label="Monto" type="number" step="0.1">
            <template v-slot:append>
              <div class="text-subtitle1">Bs.</div>
            </template>
          </q-input>
        </div>
        <div class="col-4">
          <div :class="`bg-${porCobrar>0?'red':'green'}-3 text-${porCobrar>0?'red':'green'}-8 text-bold q-ma-xs q-pa-xs`" :style="`border: 1px solid ${porCobrar>0?'red':'green'};border-radius: 5px`">
            {{porCobrar>0?'POR COBRAR':'CANCELADO'}}
          </div>
        </div>
        <div class="col-4"><q-btn color="green" icon="check_circle" label="Guardar" @click="saleSave" /></div>
        <div class="col-12">
          {{porCobrar}}
        </div>
      </div>

    </q-form>
  </div>
  <q-dialog v-model="modalregistro">
    <q-card style="width: 700px;min-width: 80vw">
      <q-card-section ><div class="text-h6">Registro de cliente</div></q-card-section>
      <q-card-section class="q-pt-none">
        <q-form @submit.prevent="agregarcliente">
          <div class="row">
            <div class="col-12 col-md-6 q-pa-xs">
              <q-input outlined label="ci" v-model="newcliente.ci"/>
            </div>
            <div class="col-12 col-md-6 q-pa-xs">
              <q-input required outlined label="titular" style="text-transform: uppercase" v-model="newcliente.titular"/>
            </div>
            <div class="col-12 col-md-6 q-pa-xs">
              <q-input  outlined label="telefono" v-model="newcliente.telefono"/>
            </div>
            <div class="col-12 col-md-6 q-pa-xs">
              <q-input  outlined label="direccion" style="text-transform: uppercase" v-model="newcliente.direccion"/>
            </div>

            <div class="col-12  q-pa-xs flex flex-center">
              <q-btn type="submit" class="full-width" color="primary" icon="add_circle" label="Registrar"/>
            </div>
          </div>
        </q-form>
      </q-card-section>
      <q-card-section align="right" class="">
        <q-btn flat label="Cerrar" icon="delete" color="negative" v-close-popup/>
      </q-card-section>
    </q-card>
  </q-dialog>
  <q-dialog v-model="dialog_mod">
    <q-card>
      <q-card-section class="bg-green-14 text-white">
        <div class="text-h7">MODIFICAR REGISTRO CLIENTE</div>
      </q-card-section>
      <q-card-section class="q-pt-xs">
        <q-form
          @submit="onMod"
          class="q-gutter-md"  >
                <q-input
                  outlined
                  type="text"
                  v-model="modcliente.ci"
                  label="Cedula Identidad"
                  style="text-transform: uppercase"
                />
                <q-input
                  outlined
                  v-model="modcliente.titular"
                  type="text"
                  label="Nombre Completo"
                  style="text-transform: uppercase"
                  lazy-rules
                  :rules="[ val => val && val.length > 0 || 'Por favor ingresar dato']"
                />
                <q-input
                  outlined
                  type="text"
                  v-model="modcliente.telefono"
                  label="Telefono o Celular"
                  style="text-transform: uppercase"
                />
                <q-input
                  type="text"
                  outlined
                  v-model="modcliente.direccion"
                  label="Direccion*"
                  style="text-transform: uppercase"
                />
                <q-input
                  outlined
                  v-model="modcliente.observacion"
                  label="Observacion"
                  type="text"
                  style="text-transform: uppercase"
                />
          <div>
            <q-btn label="Modificar" type="submit" color="positive" icon="add_circle"/>
              <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
  <div class="col-12">
<!--    <pre>{{clients}}</pre>-->
<div class="row">
  <div class="col-3"><q-input  outlined v-model="fecha1" label="Fecha Inicial"  dense type="date"/></div>
  <div class="col-3"><q-input  outlined v-model="fecha2" label="Fecha Final"  dense type="date"/></div>
  <div class="col-3"> <q-btn color="green" label="Buscar" icon="search"  dense @click="consultaVenta"/></div>
  <div class="col-3"> <q-btn color="info" label="IMPRIMIR" icon="print"  dense @click="impresion"/></div>
  </div>
<div class="col-12">
  <q-table title="Ventas" :rows="ventas" :columns="columnas" row-key="name" :filter="filter">
    <template v-slot:top-right>
      <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
        <template v-slot:append>
          <q-icon name="search" />
        </template>
      </q-input>
    </template>

      <template v-slot:body-cell-cliente="props">
        <q-td key="cliente" :props="props">
          {{ props.row.cliente.local }}  {{ props.row.cliente.titular }}
        </q-td>
      </template>
      <template v-slot:body-cell-user="props">
        <q-td key="user" :props="props">
          {{ props.row.user.name}}
        </q-td>
      </template>
      <template v-slot:body-cell-opcion="props">
          <q-td key="opcion" :props="props">
            <q-btn-group v-if="props.row.estado!='ANULADO'" >
              <q-btn icon="cancel" color="red" @click="anular(props.row)" size="xs" v-if="$store.state.login.anularventa"/>
              <q-btn icon="local_shipping" color="accent"   @click="clickhojaruta(props.row)" size="xs" v-if="$store.state.login.ruta"/>
              <q-btn icon="shopping_cart" color="orange"   @click="clickcompra(props.row)" size="xs" />
              <template v-if="$store.state.login.reimpresion" >
                <q-btn dense icon="print" color="info" v-if="props.row.estado!='ANULADO'" @click="impboleta(props.row)" />
              </template>
            </q-btn-group>

        </q-td>
      </template>
    </q-table>
  </div>
  </div>
  <q-dialog v-model="modalgarantia">
    <q-card style="width: 700px;min-width: 80vw">
      <q-card-section ><div class="text-h6">Garantia</div></q-card-section>
      <q-card-section class="q-pt-none">
        <q-form @submit.prevent="agregargarantia">
          <div class="row">
            <div class="col-12 col-md-4 q-pa-xs">
              <q-input required type="text"  outlined label="Cliente" v-model="client.label" disable/>
            </div>
            <div class="col-12 col-md-4 q-pa-xs">
              <q-input required type="text"  outlined label="telefono" v-model="client.telefono" disable/>
            </div>
            <div class="col-12 col-md-4 q-pa-xs">
              <q-input required type="text"  outlined label="direccion" v-model="client.direccion" disable/>
            </div>
            <div class="col-12 col-md-4 q-pa-xs">
              <q-select required outlined label="inventario" v-model="inventario" :options="inventarios" option-label="nombre"/>
            </div>
            <div class="col-12 col-md-4 q-pa-xs">
              <q-input required type="number"  outlined label="cantidad" v-model="newgarantia.cantidad"/>
            </div>
            <div class="col-12 col-md-4 q-pa-xs">
              <q-input  outlined type="number" label="efectivo" v-model="newgarantia.efectivo"/>
            </div>
            <div class="col-12 col-md-4 q-pa-xs">
              <q-input  outlined label="fisico" v-model="newgarantia.fisico" style="text-transform: uppercase"/>
            </div>
            <div class="col-12 col-md-4 q-pa-xs">
              <q-input  outlined label="observacion" v-model="newgarantia.observacion" style="text-transform: uppercase"/>
            </div>
            <div class="col-12 col-md-4 q-pa-xs flex flex-center">
              <input type="radio" value="EN PRESTAMO" v-model="newgarantia.tipo"/><b> EN PRESTAMO </b>
              <input type="radio" value="VENTA" v-model="newgarantia.tipo"/><b> VENTA </b>
            </div>
            <div class="col-12  q-pa-xs flex flex-center">
              <q-btn type="submit" class="full-width" color="primary" icon="add_circle" label="Registrar"/>
            </div>
          </div>
        </q-form>
      </q-card-section>
      <q-card-section align="right" class="">
        <q-btn flat label="Cerrar" icon="delete" color="negative" v-close-popup/>
      </q-card-section>
    </q-card>
  </q-dialog>
  <q-dialog v-model="modalhojaruta">
    <q-card style="width: 700px;min-width: 80vw">
      <q-card-section ><div class="text-h6">Hoja ruta {{venta.titular }} {{venta.direccion }}</div></q-card-section>
      <q-card-section class="q-pt-none">
        <q-form @submit.prevent="actualizarventa">
          <div class="row">
            <div class="col-12  q-pa-xs">
              <q-input type="date" outlined label="fechaentrega" v-model="venta.fechaentrega"/>
            </div>
            <div class="col-12 col-md-6 q-pa-xs">
              <q-select required :options="['MAÑANA','TARDE']"  outlined label="turno" v-model="venta.turno"/>
            </div>
            <div class="col-12 col-md-6 q-pa-xs">
              <q-input required type="text"  style="text-transform: uppercase;" outlined label="hora" v-model="venta.hora"/>
            </div>
            <div class="col-12 col-md-6 q-pa-xs">
              <q-input  outlined type="text" style="text-transform: uppercase;" label="telefono1" v-model="venta.telefono1"/>
            </div>
            <div class="col-12 col-md-6 q-pa-xs">
              <q-input  outlined type="text" style="text-transform: uppercase;" label="telefono2" v-model="venta.telefono2"/>
            </div>
            <div class="col-12 col-md-6 q-pa-xs">
              <q-input  outlined label="direccion" style="text-transform: uppercase;" v-model="venta.direccion"/>
            </div>

            <div class="col-12 col-md-6 q-pa-xs">
              <q-input required outlined label="envase" style="text-transform: uppercase;" v-model="venta.envase"/>
            </div>

            <div class="col-12 col-md-6 q-pa-xs">
              <q-input required outlined label="acuenta" v-model="venta.acuenta" disable/>
            </div>
            <div class="col-12 col-md-6 q-pa-xs">
              <q-input required outlined label="saldo" v-model="venta.saldo" disable/>
            </div>
            <div class="col-12  q-pa-xs">
              <q-input required outlined label="observacion" style="text-transform: uppercase;" v-model="venta.observacion"/>
            </div>
            <div class="col-12  q-pa-xs flex flex-center">
              <q-btn type="submit" class="full-width" color="primary" icon="add_circle" label="Imprimir"/>
            </div>
          </div>
        </q-form>
      </q-card-section>
      <q-card-section align="right" class="">
        <q-btn flat label="Cerrar" icon="delete" color="negative" v-close-popup/>
      </q-card-section>
    </q-card>
  </q-dialog>

  <q-dialog v-model="modalDialog">
    <q-card style="width: 700px; max-width: 80vw;">
    <q-card-section>
      <div class="text-h6">DETALLE DE COMPRA</div>
    </q-card-section>
    <q-card-section>
    <div><b>Obs:</b>{{venta.observacion}}</div>
    <div>
      <table style="width:100%">
        <tr><th>PRODUCTO</th><th>CANTIDAD</th><th>PRECIO</th><th>SUBTOTAL</th></tr>
        <tr v-for=" d in venta.detalles " :key="d">
          <td>{{d.nombreproducto}}</td><td>{{d.cantidad}}</td><td>{{d.precio}}</td><td>{{d.subtotal}}</td>
        </tr>
      </table>
    </div>
    </q-card-section>
    <q-card-actions align="right">
    <q-btn flat label="OK" color="primary" v-close-popup />
    </q-card-actions>
    </q-card>
  </q-dialog>


</div>
</q-page>
</template>

<script>

import {date} from 'quasar'

export default {
  name: `Sale`,
  data() {
    return {
      monto: 0,
      fecha:date.formatDate(new Date(),'YYYY-MM-DD'),
      fecha1:date.formatDate(new Date(),'YYYY-MM-DD'),
      fecha2:date.formatDate(new Date(),'YYYY-MM-DD'),
      products: [],
      modalregistro:false,
      newcliente:{},
      filter:'',
      product: {},
      clients2: [],
      clients: [],
      client: '',
      productSales:[],
      sale:{},
      ventas:[],
      obs:'',
      inventarios:[],
      inventario:{},
      newgarantia:{},
      modalgarantia:false,
      modalhojaruta:false,
      modalDialog:false,
      dialog_mod:false,
      venta:{},
      type: this.$route.params.type,
      columnas:[
        {label:'opcion',name:'opcion',field:'opcion'},
        {label:'id',name:'id',field:'id'},
        {label:'fecha',name:'fecha',field:'fecha'},
        {label:'cliente',name:'cliente',field:'cliente'},
        {label:'total',name:'total',field:'total'},
        {label:'acuenta',name:'acuenta',field:'acuenta'},
        {label:'saldo',name:'saldo',field:'saldo'},
        {label:'estado',name:'estado',field:'estado'},
        {label:'user',name:'user',field:'user'},
      ]
    }
  },
  mounted() {
    this.$watch(
      () => this.$route.params.type,
      (toParams, previousParams) => {
        console.log('nuevo', toParams)
        console.log('antiguo', previousParams)
        if (toParams == undefined) {
          return false
        }
        this.datosGet(toParams)
        this.type = toParams
      }
    )
    this.datosGet(this.type)
    this.$axios.get(process.env.API+'/listainventario').then(res=>{
      this.inventarios=res.data
      this.inventario=res.data[0]
    })
    this.consultaVenta(this.type)

  },
  methods: {
    onMod(){
        this.$q.loading.show();
        this.$axios.put(process.env.API+'/cliente/'+this.modcliente.id,this.modcliente).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Modificado correctamente'
        });
        this.dialog_mod=false;
        this.modcliente={}
        this.datosGet(this.type)
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
    agregarcliente(){
      this.$q.loading.show()
      this.newcliente.tipocliente=2
      this.$axios.post(process.env.API+'/agregarcliente',this.newcliente).then(()=>{
        this.$q.loading.hide()
        this.datosGet(this.type)
        this.modalregistro=false
        this.newcliente={}
      }).catch(err=>{
        this.$q.loading.hide()
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          position:'center',

          icon:'error'
        })
      })
    },
    impresion(){
      if( this.ventas.length==0){
        return false
      }
      let sumtotal=0
      let sumcuenta=0
      let sumsaldo=0
      let cadena=`<style>
      *{
      }
      table{width:100%;border-collapse: collapse;}
      table, th, td {
        //border: 1px solid;
      }
      </style>
      <div style='padding:5px'>
      <div style='text-align:center'>HISTORIAL DE VENTAS DE `+this.fecha1 +` AL `+this.fecha2 +`</div>
      <hr>
      <table>
        <tr><th>TOTAL</th><th>A CUENTA</th><th>SALDO</th><th>TITULAR</th><th>USUARIO</th><tr>`
        this.ventas.forEach(v => {
           sumtotal+=v.total
           sumcuenta+=v.acuenta
           sumsaldo+=v.saldo
          cadena+='<tr><td>'+v.total+'</td><td>'+v.acuenta+'</td><td>'+v.saldo+'</td><td>'+v.cliente.titular+'</td><td>'+v.user.name+'</td></tr>'

        });

      cadena+='</table>\
      <div><b>Total Venta </b>'+ sumtotal +'</div>\
      <div><b>Total A Cuenta </b>'+ sumcuenta +'</div>\
      <div><b>Total Saldo </b>'+ sumsaldo+'</div>\
      </div>'
      let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(cadena);
        myWindow.document.close();
        myWindow.focus();
        setTimeout(function(){
          myWindow.print();
          myWindow.close();
          // this.comanda(sale_id);
          //    impAniv(response);
        },500);
    },
    impboleta(detalle)
    {
      //console.log(detalle);
      this.$axios.post(process.env.API+'/impresionVenta/'+detalle.id).then(res=>{
        let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.focus();
        setTimeout(function(){
          myWindow.print();
          myWindow.close();
          // this.comanda(sale_id);
          //    impAniv(response);
        },500);
      })

    },
    clickcompra(compra){
      console.log(compra)
      this.venta=compra
      this.modalDialog=true;
    },
    actualizarventa(){
      this.$q.loading.show()
      // console.log(this.venta)
      this.$axios.put(process.env.API+'/updateRuta/'+this.venta.id,{
        turno:this.venta.turno,
        hora:this.venta.hora,
        telefono1:this.venta.telefono1,
        telefono2:this.venta.telefono2,
        envase:this.venta.envase,
        direccion:this.venta.direccion,
        // total:this.venta.total,
        acuenta:this.venta.acuenta,
        saldo:this.venta.saldo,
        observacion:this.venta.observacion,
        fechaentrega:this.venta.fechaentrega,
      }).then(res=>{
        this.modalhojaruta=false
        // console.log(res.data)
        let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.print();
        myWindow.close();

        this.$q.loading.hide()
        // this.misclientes()
        this.misventas()
        // this.newcliente={}
      })
    },
    clickhojaruta(venta){
      this.venta=venta
      this.modalhojaruta=true
    },
    anular(venta){
      // console.log(venta)
      this.$q.dialog({
        title: 'Anular Venta?',
        message: 'Motivo?',
        cancel: true,
        prompt:{
          model:'',
          type:'text',
        }
      }).onOk((data) => {
      this.$axios.post(process.env.API+'/anular',{id:venta.id,observacion:data})
        .then(res=>{
        this.misventas();

          this.$q.notify({
            message:'Venta Anulado ',
            color:'green',
          position:'center',

            icon:'info'
          })})
      }).onOk(() => {
        // console.log('>>>> second OK catcher')
      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    },
    consultaVenta(tipo1){
      this.$api.post('listSale',{tipo:tipo1=='detalle'?'DETALLE':'LOCAL',ini:this.fecha1,fin:this.fecha2}).then(res => {
        res.data.forEach(r => {
          r.telefono1=r.cliente.telefono
        });
        this.ventas=res.data
      })

    },
    saleSave(){
      if(this.fecha=='' || this.fecha==undefined){
        this.$q.notify({
          message:'Ingrese la fecha',
          color:'red',
          position:'center',
          icon:'error'
        })
          return false
      }
      if(this.productSales.length==0)
        { console.log('sin prod')
        this.$q.notify({
          message:'Seleccione Productos',
          color:'red',
          position:'center',
          icon:'error'
        })
          return false

        }
      if(this.client.id==undefined || this.client.id=='')
        { console.log('sin cliente')
        this.$q.notify({
          message:'Debe Seleccionar Cliente',
          color:'red',
          position:'center',
          icon:'error'
        })
          return false

        }
      if(this.monto<0 ||  this.monto>this.total || this.monto==undefined)
        { console.log('sin monto')
          return false

        }
      console.log(this.client.id)
      this.productSales.forEach(r=>{
        r.subtotal=r.precio * r.cantidad
      })
      this.sale.tipo=this.type=='detalle'?'DETALLE':'LOCAL'
      this.sale.fecha=this.fecha
      this.sale.cliente_id=this.client.id
      this.sale.total=this.total
      this.sale.acuenta=this.monto
      this.sale.saldo=this.porCobrar
      this.sale.estado=this.porCobrar>0?'POR COBRAR':'CANCELADO'
      this.sale.detalles=this.productSales
      this.sale.observacion=this.obs
      console.log(this.sale)
      this.$api.post('sale',this.sale).then(res => {
        let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.focus();
        // setTimeout(function(){
          myWindow.print();
          myWindow.close();
        // },500);

        this.$q.notify({
          message:'Venta exitosa',
          color:'green',
          position:'center',

          icon:'info'
        })
        this.$q.dialog({
          message:'Deseas registrar garantia?',
          title:'Garantia?',
          cancel: true,
        }).onOk(()=>{
          this.newgarantia={}
          this.newgarantia.cantidad=1,
          this.newgarantia.efectivo=0,
          this.newgarantia.tipo='EN PRESTAMO'
          this.modalgarantia=true
        }).onCancel(()=>{
          this.monto=0
          this.obs=''
          this.sale={}
          this.productSales=[]
        })
      })
    },
    datosGet(type){
      this.products = []
      this.$api.get(`/listaproducto/${type}`).then(res => {
        res.data.forEach(p => {
          p.cantidad=0
          this.products.push(p)
        })
      })
      this.clients = []
      this.clients2 = []
      this.$api.get(`/listacliente/${type}`).then(res => {
        res.data.forEach(c => {
          c.label=c.ci+' '+c.local+' '+c.titular
          this.clients2.push(c)
          this.clients.push(c)
        })
      })
    },
    filterFn (val, update) {
      if (val === '') {
        update(() => {
          this.clients = this.clients2
        })
        return
      }
      update(() => {
        const needle = val.toLowerCase()
        this.clients = this.clients2.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    saleClear(){
      this.productSales=[]
      this.products.forEach(p => {
        p.cantidad=0
      })
    },
    saleAdd(p) {
      p.cantidad++
      let find = this.productSales.find(ps => ps.id == p.id)
      if (find) {
        find.cantidad++
      } else {
        this.productSales.push({
          id: p.id,
          nombre: p.nombre,
          precio: p.precio,
          cantidad: 1
        })
      }
    },
    agregargarantia(){
          this.monto=0
          this.obs=''
          this.sale={}
          this.productSales=[]
      this.$q.loading.show()
      this.$axios.post(process.env.API+'/prestamo',{
        inventario_id:this.inventario.id,
        cantidad:this.newgarantia.cantidad,
        efectivo:this.newgarantia.efectivo,
        fisico:this.newgarantia.fisico,
        observacion:this.newgarantia.observacion,
        cliente_id:this.client.id,
        tipo:this.newgarantia.tipo,
        fecha:date.formatDate(new Date(),'YYYY-MM-DD')
      }).then((res)=>{
        let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.print();
        myWindow.close();

        this.$q.loading.hide()
        this.producto=''
        this.cantidad=1
        //this.fecha=date.formatDate(new Date(),'YYYY-MM-DD');
        this.newgarantia={}
        this.modalgarantia=false
        this.$q.dialog({
          message:'Deseas registrar garantia?',
          title:'Garantia?',
          cancel: true,
        }).onOk(()=>{
          this.newgarantia={}
          this.newgarantia.cantidad=1,
          this.newgarantia.efectivo=0,
          this.newgarantia.tipo='EN PRESTAMO'
          this.modalgarantia=true
        }).onCancel(()=>{
          this.monto=0
          this.obs=''
          this.sale={}
          this.productSales=[]
        })
      }).catch(err=>{
        this.$q.loading.hide()
        console.log(err)
        this.$q.notify({
          message:err.message.error,
          color:'red',
          position:'center',
          icon:'error'
        })
      })
    },
  },
  computed: {
    total() {
      let total = 0
      this.productSales.forEach(p => {
        total += p.precio * p.cantidad
      })
      return total
    },
    porCobrar() {
      return this.total - this.monto
    }
  }
}
</script>

<style scoped>
.no_selection {
  -webkit-user-select: none;
  -moz-user-select: none;
  -khtml-user-select: none;
  -ms-user-select:none;
  cursor: pointer;
}
</style>
