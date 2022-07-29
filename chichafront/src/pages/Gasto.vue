<template>
  <q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <div class="text-subtitle1 bg-red text-center text-white">CONTROL DE GASTOS</div>
    </div>
    <div class="col-6 col-sm-3 q-pa-xs"><q-input dense type="date" label="fecha" v-model="fecha1" outlined required/></div>
    <div class="col-6 col-sm-3 q-pa-xs"><q-input dense type="date" label="fecha" v-model="fecha2" outlined required/></div>
    <div class="col-6 col-sm-3 q-pa-xs" v-if="$store.state.login.gastoreporteuser"><q-select dense v-model="user" :options="users" label="Usuarios" outlined /></div>
    <div class="col-6 col-sm-3 q-pa-xs flex flex-center">
      <q-btn color="info"  label="Consultar" icon="search" type="submit" @click="misgastos" />
    </div>
    <div class="col-12">
      <q-form @submit.prevent="agregar">
        <div class="row">
          <div class="col-12 q-pa-xs col-sm-1">
          <q-input dense outlined type="number" step="0.1" label="Precio" v-model="empleado.precio" required/></div>
          <div class="col-12 q-pa-xs col-sm-3">
            <q-select outlined v-model="glosa" :options="glosas" label="Glosa" use-input @filter="filterFn"     dense  >
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    No results
                  </q-item-section>
                </q-item>
              </template>
            </q-select>
          </div>
          <div class="col-12 q-pa-xs col-sm-1">
             <q-btn color="green" icon="add_circle"  @click="dialogaddglosa=true" v-if="$store.state.login.editglosa"/>

          </div>
          <div class="col-12 q-pa-xs col-sm-3"><q-input dense outlined label="Observacion" v-model="empleado.observacion" style="text-transform: uppercase" required/></div>
          <div class="col-12 q-pa-xs col-sm-2"><q-input dense outlined label="Fecha " type="date" v-model="empleado.fecha" required/></div>
<!--          <div class="col-12 q-pa-xs col-sm-2"><q-input outlined label="Celular" v-model="empleado.celular"/></div>-->
<!--          <div class="col-12 q-pa-xs col-sm-2"><q-input outlined label="Salario" v-model="empleado.salario" type="number"/></div>-->
          <div class="col-12 q-pa-xs col-sm-2 flex flex-center">
            <q-btn icon="send" :label="boolcrear?'CREAR':'MODIFICAR'" type="submit" :color="boolcrear?'positive':'warning'"/>
          </div>
        </div>
      </q-form>
                <div class="col-12 q-pa-xs col-sm-2 flex flex-center">
            <q-btn icon="send" label="Adelanto" type="button" color="teal" @click="pagos=true"/>
            <q-btn icon="price_change" label="Caja Chica" type="button" color="accent" @click="cajachica=true"/>
          </div>
    </div>
    <div class="col-12">
<!--      <q-table-->
<!--      :columns="columns"-->
<!--      :rows="gastos"-->
<!--      :rows-per-page-options="[50,100,0]"-->
<!--      :filter="filter"-->
<!--      >-->
<!--        <template v-slot:top-right>-->
<!--          <q-input outlined dense debounce="300" v-model="filter" placeholder="Search">-->
<!--            <template v-slot:append>-->
<!--              <q-icon name="search" />-->
<!--            </template>-->
<!--          </q-input>-->
<!--        </template>-->

<!--        <template v-slot:body-cell-action="props">-->
<!--          <q-td :props="props">-->
<!--            <q-btn-->
<!--              color="warning"-->
<!--              icon-right="edit"-->
<!--              no-caps-->
<!--              label="Modificar"-->
<!--              flat-->
<!--              dense-->
<!--              @click="updateval(props.row)"-->
<!--            />-->
<!--            <q-btn-->
<!--            v-if="$store.state.login.eliminargasto"-->
<!--              color="negative"-->
<!--              icon-right="delete"-->
<!--              no-caps-->
<!--              label="Eliminar"-->
<!--              flat-->
<!--              dense-->
<!--              @click="deleteval(props.row)"-->
<!--            />-->
<!--&lt;!&ndash;            <q-btn&ndash;&gt;-->
<!--&lt;!&ndash;              color="info"&ndash;&gt;-->
<!--&lt;!&ndash;              icon-right="list"&ndash;&gt;-->
<!--&lt;!&ndash;              no-caps&ndash;&gt;-->
<!--&lt;!&ndash;              label="Sueldos"&ndash;&gt;-->
<!--&lt;!&ndash;              flat&ndash;&gt;-->
<!--&lt;!&ndash;              dense&ndash;&gt;-->
<!--&lt;!&ndash;              @click="pagosval(props.row)"&ndash;&gt;-->
<!--&lt;!&ndash;            />&ndash;&gt;-->

<!--            &lt;!&ndash;              @click="deleteval(detalles.indexOf(props.row))"&ndash;&gt;-->
<!--          </q-td>-->
<!--        </template>-->
<!--      </q-table>-->
      <table id="example" style="width:100%" class="cell-border">
        <thead>
        <tr>
          <th>id</th>
          <th>precio</th>
          <th>glosa</th>
          <th>observacion</th>
          <th>fecha</th>
          <th>hora</th>
          <th>user</th>
          <th>action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="g in gastos" :key="g.i">
          <td>{{g.id}}</td>
          <td>{{g.precio}}</td>
          <td>{{g.glosa}}</td>
          <td>{{g.observacion}}</td>
          <td>{{g.fecha}}</td>
          <td>{{g.hora}}</td>
          <td>{{g.user}}</td>
          <td>
              <q-td >
                <q-btn
                  color="warning"
                  icon-right="edit"
                  no-caps

                  flat
                  size="xs"
                  dense
                  @click="updateval(g)"
                />
                <q-btn
                v-if="$store.state.login.eliminargasto"
                  color="negative"
                  icon-right="delete"
                  no-caps
                   flat
                  size="xs"
                  dense
                  @click="deleteval(g)"
                />
                <q-btn
                v-if="$store.state.login.user.id==1"
                  color="info"
                  icon-right="print"
                  no-caps
                   flat
                  size="xs"
                  dense
                  @click="printgasto(g)"
                />
              </q-td>
          </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
          <th colspan="7" style="text-align:right">Total:</th>
          <th></th>
        </tr>
        </tfoot>
      </table>
      <q-table title="Gastos Caja Chica" :rows="chica" :columns="columns4" row-key="name" :filter="filtercaja">
            <template v-slot:top-right>
                          <q-input dense outlined debounce="300" v-model="filtercaja" placeholder="Buscar">
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
             <q-btn color="deep-purple-6" label="Exportar Excel"  @click="exportTable"/>

            </template>
                        <template v-slot:body-cell-opcion="props" >
                <q-td key="opcion" :props="props" >
                    <q-btn size="xs" @click="printcaja(props.row)" v-if="$store.state.login.user.id==1" color="primary" icon="print"/>
                </q-td>
            </template>
    </q-table>

<!--            <table id="example" style="width:100%" class="cell-border">
        <thead>
        <tr>
          <th>id</th>
          <th>Monto</th>
          <th>glosa</th>
          <th>Motivo</th>
          <th>fecha</th>
          <th>hora</th>
          <th>user</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="c in chica" :key="c.id">
          <td>{{c.id}}</td>
          <td>{{c.monto}}</td>
          <td>{{c.glosa==null?'GASTO':c.glosa.nombre}}</td>
          <td>{{c.motivo}}</td>
          <td>{{c.fecha}}</td>
          <td>{{c.hora}}</td>
          <td>{{c.user.name}}</td>
        </tr>
        </tbody>
      </table>-->
<!--      <div class="row">-->
<!--        <div class="col-12">-->
<!--&lt;!&ndash;          <div class="text-subtitle1 bg-accent text-center text-white">Historial de pagos</div>&ndash;&gt;-->
<!--        </div>-->

<!--        <div class="col-12">-->
<!--          <q-table-->
<!--            :columns="columns3"-->
<!--            :rows="gastos"-->
<!--            title="Historial de pagos"-->

<!--          >-->
<!--&lt;!&ndash;            :filter="filter"&ndash;&gt;-->

<!--            &lt;!&ndash;        <template v-slot:top-right>&ndash;&gt;-->
<!--            &lt;!&ndash;          <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">&ndash;&gt;-->
<!--            &lt;!&ndash;            <template v-slot:append>&ndash;&gt;-->
<!--            &lt;!&ndash;              <q-icon name="search" />&ndash;&gt;-->
<!--            &lt;!&ndash;            </template>&ndash;&gt;-->
<!--            &lt;!&ndash;          </q-input>&ndash;&gt;-->
<!--            &lt;!&ndash;        </template>&ndash;&gt;-->
<!--&lt;!&ndash;            <template v-slot:body="props">&ndash;&gt;-->
<!--&lt;!&ndash;              <q-tr :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                <q-td key="total" :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                  {{ props.row.total }}&ndash;&gt;-->
<!--&lt;!&ndash;                </q-td>&ndash;&gt;-->
<!--&lt;!&ndash;                <q-td key="acuenta" :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                  {{ props.row.acuenta }}&ndash;&gt;-->
<!--&lt;!&ndash;                </q-td>&ndash;&gt;-->
<!--&lt;!&ndash;                <q-td key="saldo" :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                  {{ props.row.saldo }}&ndash;&gt;-->
<!--&lt;!&ndash;                </q-td>&ndash;&gt;-->
<!--&lt;!&ndash;                <q-td key="estado" :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                  <q-badge :color="props.row.estado=='CANCELADO'?'positive':'negative'">{{ props.row.estado }}</q-badge>&ndash;&gt;-->
<!--&lt;!&ndash;                </q-td>&ndash;&gt;-->
<!--&lt;!&ndash;                <q-td key="local" :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                  {{ props.row.local }}&ndash;&gt;-->
<!--&lt;!&ndash;                </q-td>&ndash;&gt;-->
<!--&lt;!&ndash;                <q-td key="titular" :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                  {{ props.row.titular }}&ndash;&gt;-->
<!--&lt;!&ndash;                </q-td>&ndash;&gt;-->
<!--&lt;!&ndash;                <q-td key="user" :props="props">&ndash;&gt;-->
<!--&lt;!&ndash;                  {{ props.row.user }}&ndash;&gt;-->
<!--&lt;!&ndash;                </q-td>&ndash;&gt;-->
<!--&lt;!&ndash;              </q-tr>&ndash;&gt;-->
<!--&lt;!&ndash;            </template>&ndash;&gt;-->
<!--          </q-table>-->
<!--        </div>-->
<!--        <div class="col-12">-->
<!--          <q-btn label="Imprimir" icon="print" color="info" class="full-width" @click="imprimir"/>-->
<!--        </div>-->
<!--      </div>-->
      <div class="col-12">
        <q-btn label="Imprimir mis gastos" icon="print" color="info" class="full-width" @click="imprimir(user)"/>
      </div>
      <div class="row">
        <div class="col-6">
          <q-btn label="Imprimir mis ventas Detalle" icon="print" color="teal" style="width:100%"  @click="imprimirmisventasdetalle(user)"/>
        </div>
        <div class="col-6">
          <q-btn label="Imprimir mis ventas Local" icon="print" color="warning" style="width:100%"  @click="imprimirmisventaslocal(user)"/>
        </div>
      </div>
      <div class="col-12">
        <q-btn label="Imprimir mis ventas y gastos" icon="print" color="accent" class="full-width" @click="imprimirmisventasygastos(user)"/>
      </div>

      <q-dialog v-model="pagos" full-width>
        <q-card>
          <q-card-section>
            <div class="text-h6">Historial de {{pago.empleado.element.nombre}}</div>
          </q-card-section>
          <q-card-section class="q-pt-none">
            <q-form @submit.prevent="agregarpago">
              <div class="row">
                <div class="col-4">
                  <q-select outlined label="Empleado" v-model="pago.empleado" :options="empleados"/>
                </div>
                <div class="col-3">
                  <q-input outlined label="Monto" type="number" step="0.01" v-model="pago.monto" required/>
                </div>
                <div class="col-3">
                  <q-select outlined label="Tipo" v-model="pago.tipo" :options="['DESCUENTO','ADELANTO','EXTRA']"/>
                </div>
                <div class="col-3">
                  <q-input outlined label="Observacion" type="text" v-model="pago.observacion" />
                </div>
                <div class="col-3">
                  <q-input outlined label="Fecha" type="date" v-model="pago.fecha" />
                </div>
                <div class="col-3" v-if="$store.state.login.user.id==1">
                  <q-radio v-model="checkgasto" val="GASTO" label="GASTO" />
                  <q-radio v-model="checkgasto" val="CAJA" label="CAJA CHICA" />

                </div>
                <div class="col-3 flex flex-center">
                  <q-btn label="Agregar" type="submit" icon="send" color="info"/>
                </div>
              </div>
            </q-form>
            <q-table
            title="Hitorial de pagos"
            :rows-per-page-options="[50,100,0]"
            :columns="columns2"
            :rows="pago.empleado.element.sueldos"
            >
        <template v-slot:body-cell-opcion="props" >
                <q-td key="opcion" :props="props" >
                <q-btn dense round flat color="teal" @click="printRow(props)" icon="print"></q-btn>
                </q-td>
            </template>
            </q-table>
          </q-card-section>
          <q-card-actions align="right" class="bg-white text-teal">
            <q-btn flat label="OK" v-close-popup />
          </q-card-actions>
        </q-card>
      </q-dialog>

            <q-dialog v-model="cajachica">
        <q-card>
          <q-card-section>
            <div class="text-h6">Registro Gasto de Caja Chica {{montocajachica}} Bs</div>
          </q-card-section>
          <q-card-section class="q-pt-none">
            <q-form @submit.prevent="agregarcjchica">
              <div class="row">
            <div class="col-12">
            <q-select outlined v-model="glosa" :options="glosas" label="Glosa" use-input @filter="filterFn"     dense  >
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    No results
                  </q-item-section>
                </q-item>
              </template>
            </q-select>
          </div>
                <div class="col-12">
                  <q-input outlined label="Monto" type="number" step="0.1" v-model="cchica.precio"
                    :rules="[
                    val => val>0 && val<= montocajachica  || 'No debe exceder el monto',
                    ]"
                lazy-rules/>
                </div>
                 <div class="col-12">
                  <q-input outlined label="Observacion" type="text" v-model="cchica.observacion" />
                </div>
                <div class="col-3 flex flex-center">
                  <q-btn label="Registrar" type="submit" icon="send" color="info"/>
                </div>
              </div>
            </q-form>
          </q-card-section>
          <q-card-actions align="right" class="bg-white text-teal">
            <q-btn flat label="Cerrar" v-close-popup />
          </q-card-actions>
        </q-card>
      </q-dialog>


            <q-dialog v-model="dialogaddglosa">
        <q-card>
          <q-card-section>
            <div class="text-h6">Registro / Mod  Glosa</div>
          </q-card-section>
          <q-card-section class="q-pt-none">
            <q-form @submit.prevent="regglosa">
              <div class="row">
                <div class="col-6">
                  <q-input outlined label="Nombre" v-model="glosa.nombre"
                    :rules="[
                    val => val.length>0  || 'INGRESE NOMBRE',
                    ]"
                lazy-rules/>
                </div>
                <div class="col-3">
                  <q-input outlined label="N orden" v-model="glosa.orden" type="number"
                    :rules="[
                    val => val>=0  || 'INGRESE nummero',
                    ]"
                lazy-rules/>
                </div>
                <div class="col-3 ">
                  <q-btn label="Reg/Mod" type="submit" icon="send" color="info" dense/>
                </div>
              </div>
            </q-form>
          </q-card-section>
          <q-card-actions align="right" class="bg-white text-teal">
            <q-btn flat label="Cerrar" v-close-popup />
          </q-card-actions>
        </q-card>
      </q-dialog>
    </div>

  </div>
</q-page>
</template>

<script>
import {date} from 'quasar'
import {jsPDF} from "jspdf";
import $ from "jquery";
import xlsx from "json-as-xlsx"
export default {
  name: "Venta",
  data(){
    return{
      filter:'',
      filtercaja:'',
      cchica:{},
      glosa:{},
      glosas:[],
      chica:[],
      checkgasto:'CAJA',
      dialogaddglosa:false,
      pagos:false,
      cajachica:false,
      pago:{fecha:date.formatDate( Date.now(),'YYYY-MM-DD')},
      empleados:[],
      empleadohistorial:{},
      boolcrear:true,
      gastos:[],
      anulados:[],
      rpagos:[],
      reporteventa:[],
      prestamoventa:[],
      users:[],
      user:{},
      gl:[],
      filterglosa:[],
      pageTotal:'',
      tot:'',
      resumenplanilla:0,
      empleado:{fecha:date.formatDate( Date.now(),'YYYY-MM-DD')},
      fecha1:date.formatDate( Date.now(),'YYYY-MM-DD'),
      fecha2:date.formatDate( Date.now(),'YYYY-MM-DD'),
      montocajachica:0,
      montogeneral:0,
      columns:[
        {name:'id',label:'Id',field:'id'},
        {name:'precio',label:'Precio',field:'precio'},
        {name:'glosa',label:'Glosa',field:row=>row.glosa.nombre},
        {name:'observacion',label:'Observacion',field:'observacion'},
        {name:'fecha',label:'Fecha',field:'fecha'},
        {name:'hora',label:'Hora',field:'hora'},
        {name:'user',label:'Usuario',field:'user'},
        {name:'action',label:'Action',field:'action'},
      ],
      columns2:[
        {name:'fecha',label:'Fecha',field:'fecha',sortable: true },
        {name:'hora',label:'Hora',field:'hora'},
        {name:'tipo',label:'Tipo',field:'tipo',sortable: true },
        // {name:'detalle',label:'detalle',field:'detalle'},
        {name:'monto',label:'Monto',field:'monto'},
        {name:'opcion',label:'Opcion',field:'opcion'},
      ],
      columns3:[
        {name:'nombre',label:'Empleado',field:'nombre'},
        {name:'salario',label:'Sueldo',field:'salario'},
        {name:'pago',label:'Pago',field:'pago'},
        {name:'adelanto',label:'Adelanto',field:'adelanto'},
        // {name:'detalle',label:'detalle',field:'detalle'},
        {name:'descuento',label:'Descuento',field:'descuento'},
      ],
      columns4:[
        {name:'id',label:'Id',field:'id'},
        {name:'monto',label:'Monto',field:'monto'},
        {name:'glosa',label:'Glosa',field:'glosa'},
        {name:'motivo',label:'Motivo',field:'motivo'},
        {name:'fecha',label:'Fecha',field:'fecha'},
        {name:'hora',label:'Hora',field:'hora'},
        {name:'user',label:'Usuario',field:'user'},
        {name:'opcion',label:'Opcion'},
      ],
      encabezado:{"id":'id',"Monto":'monto',"Glosa":'glosa',"Motivo":'glosa',"Fecha":"fecha","Hora":"hora","Usuario":'user'}
    }
  },
  mounted() {
    if(!this.$store.state.login.gastoreporteuser) this.user={label:this.$store.state.login.user.name,id:this.$store.state.login.user.id}
    $('#example').DataTable( )
    this.misgastos()
    this.misuser()
    this.misglosa()
    // this.misempleados()
    // console.log(this.$store.state.login)
    // this.$axios.get(process.env.API+'/cliente').then(res=>{
    //   this.clientes=res.data
    //   this.cliente=res.data[0]
    // })
    // this.$axios.get(process.env.API+'/producto').then(res=>{
    //   this.productos=res.data
    //   this.producto=res.data[0]
    // })
    // this.$axios.post(process.env.API+'/misventas',{fecha:this.fecha2}).then(res=>{
    //   this.venta=res.data
    //   // console.log(this.venta)
    //   // this.producto=res.data[0]
    // })
    // this.$axios.post(process.env.API+'/me').then(res=>{
    //   // console.log(res.data)
    //   this.responsable=res.data.name
    // })
    // this.responsable=this.$store.getters["login/user"].name
    this.listadog();
    this.misempleados();
    this.totalcaja();
    this.totalgeneral();
  },

  methods:{
          exportTable () {
let datacaja = [
  {
    sheet: "Caja Chica",
    columns: [
      { label: "id", value: "id" }, // Top level data
      { label: "Monto", value: "monto" }, // Top level data
      { label: "Glosa", value: "glosa" }, // Top level data
      { label: "Motivo", value: "motivo" }, // Top level data
      { label: "fecha", value: "fecha" }, // Top level data
      { label: "Hora", value: "hora" }, // Top level data
      { label: "Usuario", value: "user" }, // Top level data
    ],
    content: this.chica
  },

]

let settings = {
  fileName: "CajaChica", // Name of the resulting spreadsheet
  extraLength: 7, // A bigger number means that columns will be wider
  writeOptions: {}, // Style options from https://github.com/SheetJS/sheetjs#writing-options
}

xlsx(datacaja, settings) // Will download the excel file
      },
                  totalgeneral(){
      this.$axios.post(process.env.API + "/totalgeneral").then((res) => {
          this.montogeneral=parseFloat( res.data.monto);
      })
      },
    regglosa(){
      if(this.glosa.id==undefined){
        this.$axios.post(process.env.API+'/glosa',{nombre:this.glosa.nombre,orden:this.glosa.orden==undefined?0:this.glosa.orden}).then(res=>{
          this.misglosa()
          this.dialogaddglosa=false;
                          this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Registrado correctamente'
        });
        })
      }
      else{
            this.glosa.orden==undefined?0:this.glosa.orden
                this.$axios.put(process.env.API+'/glosa/'+this.glosa.id,this.glosa).then(res=>{
          this.misglosa()
          this.dialogaddglosa=false;
                          this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Modificado correctamente'
        });
      })}

    },
          filterFn (val, update) {
        if (val === '') {
          update(() => {
            this.glosas = this.filterglosa
          })
          return
        }

        update(() => {
          const needle = val.toLowerCase()
          this.glosas = this.filterglosa.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
        })
      },

    printRow(props){
      this.$axios.get(process.env.API + "/impade/"+props.row.id).then((res) => {
                let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.print();
        myWindow.close();
      })

    },
    printcaja(caja){
        let cadena="<style>   .textcnt{   text-align:center;        }        table{width:100%;}        td{vertical-align:top;}        </style>"
        cadena+="<div class='textcnt'> DETALLE GASTO CAJA CHICA</div>"
        cadena+="<div class='textcnt'>Nro "+caja.id+"</div>        <hr>"
        cadena+="<div>Nombre: "+caja.user+"</div>"
        cadena+="<div>Fecha: "+caja.fecha+"</div>        <hr>"
        cadena+="<table>        <tr><td>Glosa: </td><td><b>"+caja.glosa+"</b></td></tr>"
        cadena+="<tr><td>Costo: </td><td><b>"+caja.monto+"</b></td></tr>"
        cadena+="<tr><td>Observacion: </td><td><b>"+caja.motivo+"</b></td></tr>        </table>"
        cadena+="    <br>"
        let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(cadena);
        myWindow.document.close();
        myWindow.print();
        myWindow.close();
    },
    agregarcjchica(){
      if(this.glosa.id==undefined)
      {
        return false
      }
      this.cchica.glosa_id=this.glosa.id
      //console.log(this.cchica)
      //  return false
      this.$axios.post(process.env.API + "/gastocaja",this.cchica).then((res) => {
                        let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.print();
        myWindow.close();
        this.cchica.precio=0;
        this.cchica.observacion='';
        this.cajachica=false;
        this.glosa={}
        this.misgastos()
        this.totalcaja()
                this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Registrado correctamente'
        });
      })

    },
      totalcaja(){
      this.$axios.post(process.env.API + "/totalcaja").then((res) => {
          this.montocajachica=res.data.monto;
      })
      },



    listadog(){
      this.$axios.post(process.env.API+'/listglosa').then(res=>{
        this.gl=res.data
      })

    },
    misuser(){
      this.$axios.post(process.env.API+'/listuser').then(res=>{
        this.users=[{label:'TODOS',id:0}]
        res.data.forEach(element => {
          this.users.push({label:element.name,id:element.id});

        });
        this.user=this.users[0];
      })
    },
        misglosa(){
          this.glosas=[{label:''}]
      this.$axios.get(process.env.API+'/glosa').then(res=>{
        //console.log(res.data)
        res.data.forEach(r => {
          r.label=r.nombre
          this.glosas.push(r);

        });
        this.filterglosa=this.glosas
        this.glosa=this.glosas[0];
      })
    },
    imprimirmisventasygastos(us){
      let mc=this
      if(this.$store.state.login.user.id!=1)
      us.label=this.$store.state.login.user.name;
      function header(){
        var img = new Image()
        img.src = 'logo.png'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'HISTORIAL DE INGRESOS Y GASTOS '+us.label)
        doc.text(5, 1.5,  'DE '+mc.fecha1+' AL '+mc.fecha2)
        // doc.text(1, 3, 'Total')
        doc.text(1, 3, 'Ruta/tip')
        doc.text(3, 3, 'Tipo')
        doc.text(4.5, 3, 'Estado')
        doc.text(6.5, 3, 'Monto')
        doc.text(8, 3, 'Cant')
        doc.text(10, 3, 'Producto')
        doc.text(13.5, 3, 'Titular')
        doc.text(18.5, 3, 'Local')
        doc.setFont(undefined,'normal')
      }
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
      doc.setFont("courier");
      doc.setFontSize(9);
      // var x=0,y=
      header()
      // let xx=x
      // let yy=y
      let y=0
      let ventas=0
      let ccpago=0

      this.ventas.forEach(r=>{
        y+=0.5
        // console.log(r)
       doc.setFontSize(6);
        doc.text(1, y+3, r.fechaentrega!=null&&r.fechaentrega!=''?'Ruta '+r.tipo:''+r.tipo)
        doc.setFontSize(9);
        doc.text(3, y+3, 'Cobro')
        doc.text(4.5, y+3, r.estado+'')
        doc.text(6.5, y+3, r.acuenta!=null?r.acuenta.toString():''+' Bs.')
        ventas+=parseFloat(r.acuenta!=null?r.acuenta:0)
        doc.text(8, y+3, r.cantidad!=null?r.cantidad.toString():'')
        doc.text(10, y+3, r.detalle!=null?r.detalle.toString():'')
        doc.text(13.5, y+3, r.titular!=null?r.titular.substring(0,25):'')
        doc.text(18.5, y+3, r.local!=null?r.local.toString():'')
        if (y+3>25){
          doc.addPage();
          header()
          y=0
        }
      })
      y+=0.5
        doc.text(1, y+3, 'T VENTA:')
        doc.text(3, y+3, ventas+' Bs.')
      let gastos=0
      let caja=0

            y+=0.5
        doc.setFont(undefined,'bold')
        doc.text(1, y+3, '-------------------------------------------------------')
      y+=0.5
        doc.text(1, y+3, 'DETALLE DE GASTO')
        doc.setFont(undefined,'normal')
      this.gastos.forEach(r=>{
        y+=0.5
        // console.log(r)
        doc.text(3, y+3, 'Gasto')
        doc.text(6.5, y+3, r.precio!=null?r.precio.toString():''+'Bs.')
        if(r.glosa=='CAJA CHICA')
        caja+=parseFloat(r.precio!=null?r.precio:0)
        else
        gastos+=parseFloat(r.precio!=null?r.precio:0)
        doc.text(8, y+3, r.glosa+': '+r.observacion)
        // doc.text(9, y+3, r.fecha!=null?r.fecha.toString():'')
        // doc.text(11.5, y+3, r.hora!=null?r.hora.toString():'')
        //doc.text(18.5, y+3, r.user!=null?r.user.toString():'')
        if (y+3>25){
          doc.addPage();
          header()
          y=0
        }
      })
            y+=0.5
        doc.text(1, y+3, 'T GASTO:')
        doc.text(3, y+3, gastos+'Bs.')
        doc.setFont(undefined,'bold')
                  y+=0.5
        doc.text(1, y+3, '-------------------------------------------------------')
      y+=0.5
        doc.text(1, y+3, 'DETALLE DE GASTO CAJA CHICA')
        y+=0.5
        doc.setFont(undefined,'normal')
            this.chica.forEach(r=>{
        y+=0.5
        // console.log(r)
        doc.text(3, y+3, 'Gasto')
        doc.text(6.5, y+3, r.monto!=null?r.monto.toString():''+'Bs.')
        caja+=parseFloat(r.monto!=null?r.monto:0)
        doc.text(8, y+3, r.glosa==null?'GASTO':r.glosa+' : '+r.motivo)
        // doc.text(9, y+3, r.fecha!=null?r.fecha.toString():'')
        // doc.text(11.5, y+3, r.hora!=null?r.hora.toString():'')
        //doc.text(18.5, y+3, r.user!=null?r.user.toString():'')
        if (y+3>25){
          doc.addPage();
          header()
          y=0
        }
      })

      y+=0.5
        doc.text(1, y+3, 'Gasto Caja Chica:')
        doc.text(6, y+3, caja+'Bs.')

      y+=0.5
        doc.text(1, y+3, '-------------------------------------------------------')
      y+=0.5
        doc.setFont(undefined,'bold')
        doc.text(1, y+3, 'INGRESOS DE ANULADOS PRESTAMOS')
        doc.setFont(undefined,'normal')
                if (y+3>25){
          doc.addPage();
          header()
          y=0
        }

      if(this.totalanulado>0){
        ventas=ventas+this.totalanulado;
              this.anulados.forEach(element => {
              y+=0.5
        doc.text(3, y+3, 'Prestamo')
        doc.text(6.5, y+3, element.efectivo+'')
        doc.text(8, y+3, element.cantidad+'')
        doc.text(10, y+3, element.inventario.nombre)
        doc.text(13.5, y+3, element.cliente.titular)
        doc.text(18.5, y+3, element.cliente.local)
                if (y+3>25){
          doc.addPage();
          header()
          y=0
        }

              });
      y+=0.5
        doc.text(1, y+3, 'T. Anulado')
        doc.text(3, y+3, this.totalanulado+' Bs')

      }
      //if(this.totalpresventa>0){
      doc.setFont(undefined,'bold')
      y+=0.5
        doc.text(1, y+3, '-------------------------------------------------------')
      y+=0.5
        doc.text(1, y+3, 'INGRESOS DE VENTA MATERIAL')
        doc.setFont(undefined,'normal')
                if (y+3>25){
          doc.addPage();
          header()
          y=0
        }

      this.prestamoventa.forEach(r=>{
        y+=0.5
        // console.log(r)
       doc.setFontSize(6);
        doc.text(1, y+3, '')
       doc.setFontSize(9);
        doc.text(6.5, y+3, r.efectivo+' Bs.')
        ventas+=parseFloat(r.efectivo)
        doc.text(3, y+3, 'Material')
        doc.text(8, y+3, r.cantidad+'')
       doc.setFontSize(6);
        doc.text(10, y+3, r.inventario.nombre)
       doc.setFontSize(9);
        doc.text(13.5, y+3, r.cliente.titular)
        doc.text(18.5, y+3, r.cliente.local)
        if (y+3>25){
          doc.addPage();
          header()
          y=0
        }
      })
             y+=0.5
        doc.text(1, y+3, 'T MATERIAL')
        doc.text(3, y+3, this.totalpresventa+' Bs.')

      if(this.totalpagos>0){
        y+=0.5
      doc.setFont(undefined,'bold')
        doc.text(1, y+3, '-------------------------------------------------------')
        y+=0.5

        doc.text(1, y+3, 'INGRESOS DE PENDIENTES DE PAGO')
        doc.setFont(undefined,'normal')
        if (y+3>25){
          doc.addPage();
          header()
          y=0
        }

      this.rpagos.forEach(r=>{
        y+=0.5
        doc.setFontSize(6);
        doc.text(1, y+3, r.fechaentrega!=null?'Ruta '+r.tipo:''+r.tipo)
        doc.setFontSize(9);
        doc.text(3, y+3, 'Pagos')
        doc.text(6.5, y+3, r.monto!=null?r.monto.toString():''+' Bs.')
        //ventas+=r.monto;
        ccpago+=r.monto
        doc.text(8, y+3, 'N-'+r.id)
        doc.text(10, y+3, r.nombreproducto!=null?r.nombreproducto.toString():'')
        doc.text(13.5, y+3, r.titular!=null?r.titular.substring(0,25):'')
        doc.text(18.5, y+3, r.local!=null?r.local.toString():'')
        if (y+3>25){
          doc.addPage();
          header()
          y=0
        }
      })

      y+=0.5
        if (y+4>25){
          doc.addPage();
          header()
          y=0
        }
             doc.text(1, y+3, 'T.V. Pago:')
        doc.text(3, y+3, this.totalpagos+' Bs.')
      }
        if (y+4>25){
          doc.addPage();
          header()
          y=0
        }

      doc.setFontSize(11);
        doc.setFont(undefined,'normal')

      doc.text(2, y+4, 'Total Ingreso: ')
        doc.setFont(undefined,'bold')
      doc.text(5.5, y+4, ventas+'Bs')

        doc.setFont(undefined,'normal')
      doc.text(8, y+4, 'Total gasto: ')
        doc.setFont(undefined,'bold')
      doc.text(11, y+4, gastos+'Bs')
        doc.setFont(undefined,'normal')
      doc.text(14, y+4, 'Total saldo: ')
        doc.setFont(undefined,'bold')
      doc.text(17, y+4, (ventas-gastos)+' Bs')
        doc.setFont(undefined,'normal')
      doc.text(2, y+4.5, 'T. CxC pagos: ')
        doc.setFont(undefined,'bold')
      doc.text(5.5, y+4.5, ccpago+'Bs')
      if(this.$store.state.login.user.id==1){
        doc.setFont(undefined,'normal')
        doc.text(8, y+4.5, 'Salarios:')
        doc.setFont(undefined,'bold')
        doc.text(11, y+4.5, this.resumenplanilla+'Bs.')}
      // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
      window.open(doc.output('bloburl'), '_blank');
    },
    imprimirmisventasdetalle(us){
      let mc=this
      if(this.$store.state.login.user.id!=1)
      us.label=this.$store.state.login.user.name;

      function header(){
        var img = new Image()
        img.src = 'logo.png'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'Historial de ventas DETALLE ' +us.label)
        doc.text(5, 1.5,  'DE '+mc.fecha1+' AL '+mc.fecha2)
        doc.text(1, 3, 'Usuario')
        doc.text(3, 3, 'Fecha')
        doc.text(5.5, 3, 'Total')
        doc.text(6.7, 3, 'Acuenta')
        doc.text(8.2, 3, 'Saldo')
        doc.text(9.5, 3, 'Producto')
        doc.text(12, 3, 'Estado')
        doc.text(14, 3, 'Hora')
        doc.text(16.5 , 3, 'Titular')
        doc.setFont(undefined,'normal')
      }
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
      doc.setFont("courier");
      doc.setFontSize(9);
      // var x=0,y=
      header()
      // let xx=x
      // let yy=y
      let y=0
      let tsaldo=0
      let tacuenta=0
      let total=0
      let caja=0
      this.ventas.forEach(r=>{
        console.log(r)
        if(r.tipo=='DETALLE'){
        tsaldo=tsaldo+r.saldo;
        tacuenta=tacuenta+r.acuenta;
        total=total+r.total;
        // xx+=0.5
        y+=0.5
        doc.text(1, y+3, r.user!=null?r.user.substring(0,8 ):'')
        doc.text(3, y+3, r.fecha+'')
        doc.text(5.5, y+3, r.total!=null?r.total.toString():'')
        doc.text(6.7, y+3, r.acuenta!=null?r.acuenta.toString():'')
        doc.text(8.2, y+3, r.saldo!=null?r.saldo.toString():'')
        doc.text(9.5, y+3, r.producto.substring(0,12)+'')
        doc.text(12, y+3, r.estado!=null?r.estado.toString():'')
        doc.text(14, y+3, r.hora)
        doc.text(16.5, y+3, r.titular!=null?r.titular.substring(0,25):'')
        if (y+3>25){
          doc.addPage();
          header()
          y=0
        }}
      })
      caja=total-tsaldo;
        doc.setFont(undefined,'bold')
      doc.text(2, y+4, 'Ventas totales: ')
        doc.setFont(undefined,'normal')
      doc.text(5, y+4, total+'Bs')

        doc.setFont(undefined,'bold')
      doc.text(7, y+4, 'Por Cobrar: ')
        doc.setFont(undefined,'normal')
      doc.text(10, y+4, tsaldo+' Bs')

        doc.setFont(undefined,'bold')
      doc.text(14, y+4, 'En Caja totales: ')
        doc.setFont(undefined,'normal')
      doc.text(18, y+4, caja+'Bs')


      // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
      window.open(doc.output('bloburl'), '_blank');
    },

    imprimirmisventaslocal(us){
      let mc=this
      if(this.$store.state.login.user.id!=1)
      us.label=this.$store.state.login.user.name;

      function header(){
        var img = new Image()
        img.src = 'logo.png'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'Historial de ventas LOCAL '+ us.label)
        doc.text(5, 1.5,  'DE '+mc.fecha1+' AL '+mc.fecha2)
        doc.text(1, 3, 'Usuario')
        doc.text(2.5, 3, 'Fecha Hora')
        doc.text(6, 3, 'Producto')
        doc.text(8.5, 3, 'Total')
        doc.text(10, 3, 'ACuenta')
        doc.text(11.5, 3, 'Saldo')
        doc.text(13, 3, 'Estado')
        doc.text(15, 3, 'Local')
        doc.text(18, 3, 'Titular')
        doc.setFont(undefined,'normal')
      }
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
      doc.setFont("courier");
      doc.setFontSize(9);
      // var x=0,y=
      header()
      // let xx=x
      // let yy=y
      let y=0
      let tsaldo=0
      let tacuenta=0
      let caja=0
      let total=0
      this.ventas.forEach(r=>{
        if(r.tipo=='LOCAL'){
        tsaldo=tsaldo+r.saldo;
        tacuenta=tacuenta+r.acuenta;
        total=total+r.total;
        // xx+=0.5
        y+=0.5
        doc.text(1, y+3, r.user!=null?r.user.substring(0,8):'')
        doc.text(2.5, y+3, r.fecha+' '+r.hora)
        doc.text(6, y+3, r.producto.substring(0,12 ))
        doc.text(8.5, y+3, r.total!=null?r.total.toString():'')
        doc.text(10, y+3, r.acuenta!=null?r.acuenta.toString():'')
        doc.text(11.5, y+3, r.saldo!=null?r.saldo.toString():'')
        doc.text(13, y+3, r.estado!=null?r.estado.toString():'')
        doc.text(15, y+3, r.local!=null?r.local.toString():'')
        doc.text(18, y+3, r.titular!=null?r.titular.substring(0,6 ):'')

        if (y+3>25){
          doc.addPage();
          header()
          y=0
        }}
      })
      caja=total-tsaldo
        doc.setFont(undefined,'bold')
      doc.text(2, y+4, 'Ventas totales: ')
        doc.setFont(undefined,'normal')
      doc.text(5, y+4, total+'Bs')

        doc.setFont(undefined,'bold')
      doc.text(7, y+4, 'Por Cobrar: ')
        doc.setFont(undefined,'normal')
      doc.text(10, y+4, tsaldo+' Bs')

        doc.setFont(undefined,'bold')
      doc.text(14, y+4, 'En Caja totales: ')
        doc.setFont(undefined,'normal')
      doc.text(18, y+4, caja+'Bs')


      // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
      window.open(doc.output('bloburl'), '_blank');
    },

    imprimir(us){
      let mc=this
      if(this.$store.state.login.user.id!=1)
      us.label=this.$store.state.login.user.name;

      function header(){
        var img = new Image()
        img.src = 'logo.png'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'Historial de gastos '+ us.label)
        doc.text(5, 1.5,  'DE '+mc.fecha1+' AL '+mc.fecha2)
        doc.text(1.5, 3, 'Usuario')
        doc.text(4, 3, 'Precio')
        doc.text(6.5, 3, 'Observacion')
        doc.text(11, 3, 'Glosa')
        doc.text(15.5, 3, 'Fecha')
        doc.text(17.5, 3, 'Hora')
        doc.setFont(undefined,'normal')
      }
      var doc = new jsPDF('p','cm','letter')
      doc.setFont("courier");
      doc.setFontSize(9);
      header()
      let y=0
      let cont=1
      let sumgasto=0
      let caja=0

      this.gastos.forEach(r=>{
        if(r.glosa=='CAJA CHICA')
        caja+=parseFloat(r.precio)
        else
        sumgasto+=parseFloat(r.precio)
        console.log(r)
        // xx+=0.5
        y+=0.5
        doc.text(1.5, y+3, r.user)
        doc.text(4, y+3, r.precio+'')
        doc.text(6.5, y+3, r.observacion)
        doc.text(11, y+3, r.glosa)
        doc.text(15.5, y+3, r.fecha)
        doc.text(17.5, y+3, r.hora)

        cont++
        if (y+3>25){
          doc.addPage();
          header()
          y=0
        }
      })
              doc.setFont(undefined,'bold')
                  y+=0.5
        doc.text(1, y+3, '-------------------------------------------------------')
      y+=0.5
        doc.text(1, y+3, 'DETALLE DE GASTO CAJA CHICA')
        y+=0.5
        doc.setFont(undefined,'normal')
            this.chica.forEach(r=>{
        caja+=parseFloat(r.monto)
        console.log(r)
        // xx+=0.5
        y+=0.5
        doc.text(1.5, y+3, r.user.name)
        doc.text(4, y+3, r.monto+'')
        doc.text(6.5, y+3, r.motivo)
        doc.text(11, y+3, r.glosa==null?'GASTO':r.glosa+' : '+r.motivo)
        doc.text(15.5, y+3, r.fecha)
        doc.text(17.5, y+3, r.hora)

        cont++
        if (y+3>25){
          doc.addPage();
          header()
          y=0
        }
      })
      y+=0.5
        doc.setFont(undefined,'bold')
              doc.text(1, y+3, 'TOTAL:')
        doc.setFont(undefined,'normal')
        doc.text(3, y+3, sumgasto+' Bs')
      y+=0.5
              if (y+3>25){
          doc.addPage();
          header()
          y=0
        }
      y+=0.5
          doc.setFont(undefined,'bold')
          doc.text(1, y+3, 'caja chica:')
        doc.setFont(undefined,'normal')
        doc.text(3.5, y+3, caja+' Bs')
                      if (y+3>25){
          doc.addPage();
          header()
          y=0
        }
      y+=0.5
                if(this.$store.state.login.user.id==1){
                doc.setFont(undefined,'bold')
          doc.text(1, y+3, 'SALARIOS:')
        doc.setFont(undefined,'normal')
        doc.text(3.5, y+3, this.resumenplanilla+' Bs')}
      // doc.text(2, y+4, 'Ventas totales: ')
      // doc.text(5, y+4, this.ventat+'Bs')
      // doc.text(7, y+4, 'Por cobrar totales: ')
      // doc.text(11, y+4, this.porc+'Bs')
      // doc.text(14, y+4, 'Saldo totales: ')
      // doc.text(17, y+4, this.saldoc+'Bs')
      // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
      window.open(doc.output('bloburl'), '_blank');
    },
    misgastos(){
      this.$q.loading.show()
      this.gastos=[]
      this.chica=[]
      if(!this.$store.state.login.gastoreporteuser) this.user={label:this.$store.state.login.user.name,id:this.$store.state.login.user.id}
      //console.log(this.user)
      $('#example').DataTable().destroy()
      this.$axios.post(process.env.API+'/misgastos',{fecha1:this.fecha1,fecha2:this.fecha2,user_id:this.user.id}).then(res=>{
        //console.log(res.data)
        // this.gastos=res.data
         $('#example').DataTable().destroy()
        console.log(res.data)
        res.data.forEach(r=>{
          //console.log(r.glosa.nombre)
          this.gastos.push({
            id:r.id,
            observacion:r.observacion,
            glosa:r.glosa.nombre,
            precio:r.precio,
            fecha:r.fecha,
            hora:r.hora,
            user:r.user.name
          })
        })
            this.$axios.post(process.env.API+'/listcaja',{fecha1:this.fecha1,fecha2:this.fecha2,user_id:this.user.id}).then(res=>{
        console.log(res.data)
        //return false
                 res.data.forEach(r => {
            if(r.tipo=='GASTO'){
                this.chica.push({
                  id:r.id,
                  motivo:r.motivo,
                  glosa:r.glosa==null?'GASTO':r.glosa.nombre,
                  monto:r.monto,
                  fecha:r.fecha,
                  hora:r.hora,
                  user:r.user.name
                  })
                        }
         })

        this.$nextTick(()=>{
          $('#example').DataTable( {
                       "language":{
              "processing": "Procesando...",
              "lengthMenu": "Mostrar _MENU_ registros",
              "zeroRecords": "No se encontraron resultados",
              "emptyTable": "Ningún dato disponible en esta tabla",
              "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
              "infoFiltered": "(filtrado de un total de _MAX_ registros)",
              "search": "Buscar:",
              "infoThousands": ",",
              "loadingRecords": "Cargando...",
              "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
              },
              "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
              },
              "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad",
                "collection": "Colección",
                "colvisRestore": "Restaurar visibilidad",
                "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                "copySuccess": {
                  "1": "Copiada 1 fila al portapapeles",
                  "_": "Copiadas %ds fila al portapapeles"
                },
                "copyTitle": "Copiar al portapapeles",
                "csv": "CSV",
                "excel": "Excel",
                "pageLength": {
                  "-1": "Mostrar todas las filas",
                  "_": "Mostrar %d filas"
                },
                "pdf": "PDF",
                "print": "Imprimir",
                "renameState": "Cambiar nombre",
                "updateState": "Actualizar",
                "createState": "Crear Estado",
                "removeAllStates": "Remover Estados",
                "removeState": "Remover",
                "savedStates": "Estados Guardados",
                "stateRestore": "Estado %d"
              },
              "autoFill": {
                "cancel": "Cancelar",
                "fill": "Rellene todas las celdas con <i>%d<\/i>",
                "fillHorizontal": "Rellenar celdas horizontalmente",
                "fillVertical": "Rellenar celdas verticalmentemente"
              },
              "decimal": ",",
              "searchBuilder": {
                "add": "Añadir condición",
                "button": {
                  "0": "Constructor de búsqueda",
                  "_": "Constructor de búsqueda (%d)"
                },
                "clearAll": "Borrar todo",
                "condition": "Condición",
                "conditions": {
                  "date": {
                    "after": "Despues",
                    "before": "Antes",
                    "between": "Entre",
                    "empty": "Vacío",
                    "equals": "Igual a",
                    "notBetween": "No entre",
                    "notEmpty": "No Vacio",
                    "not": "Diferente de"
                  },
                  "number": {
                    "between": "Entre",
                    "empty": "Vacio",
                    "equals": "Igual a",
                    "gt": "Mayor a",
                    "gte": "Mayor o igual a",
                    "lt": "Menor que",
                    "lte": "Menor o igual que",
                    "notBetween": "No entre",
                    "notEmpty": "No vacío",
                    "not": "Diferente de"
                  },
                  "string": {
                    "contains": "Contiene",
                    "empty": "Vacío",
                    "endsWith": "Termina en",
                    "equals": "Igual a",
                    "notEmpty": "No Vacio",
                    "startsWith": "Empieza con",
                    "not": "Diferente de",
                    "notContains": "No Contiene",
                    "notStarts": "No empieza con",
                    "notEnds": "No termina con"
                  },
                  "array": {
                    "not": "Diferente de",
                    "equals": "Igual",
                    "empty": "Vacío",
                    "contains": "Contiene",
                    "notEmpty": "No Vacío",
                    "without": "Sin"
                  }
                },
                "data": "Data",
                "deleteTitle": "Eliminar regla de filtrado",
                "leftTitle": "Criterios anulados",
                "logicAnd": "Y",
                "logicOr": "O",
                "rightTitle": "Criterios de sangría",
                "title": {
                  "0": "Constructor de búsqueda",
                  "_": "Constructor de búsqueda (%d)"
                },
                "value": "Valor"
              },
              "searchPanes": {
                "clearMessage": "Borrar todo",
                "collapse": {
                  "0": "Paneles de búsqueda",
                  "_": "Paneles de búsqueda (%d)"
                },
                "count": "{total}",
                "countFiltered": "{shown} ({total})",
                "emptyPanes": "Sin paneles de búsqueda",
                "loadMessage": "Cargando paneles de búsqueda",
                "title": "Filtros Activos - %d",
                "showMessage": "Mostrar Todo",
                "collapseMessage": "Colapsar Todo"
              },
              "select": {
                "cells": {
                  "1": "1 celda seleccionada",
                  "_": "%d celdas seleccionadas"
                },
                "columns": {
                  "1": "1 columna seleccionada",
                  "_": "%d columnas seleccionadas"
                },
                "rows": {
                  "1": "1 fila seleccionada",
                  "_": "%d filas seleccionadas"
                }
              },
              "thousands": ".",
              "datetime": {
                "previous": "Anterior",
                "next": "Proximo",
                "hours": "Horas",
                "minutes": "Minutos",
                "seconds": "Segundos",
                "unknown": "-",
                "amPm": [
                  "AM",
                  "PM"
                ],
                "months": {
                  "0": "Enero",
                  "1": "Febrero",
                  "10": "Noviembre",
                  "11": "Diciembre",
                  "2": "Marzo",
                  "3": "Abril",
                  "4": "Mayo",
                  "5": "Junio",
                  "6": "Julio",
                  "7": "Agosto",
                  "8": "Septiembre",
                  "9": "Octubre"
                },
                "weekdays": [
                  "Dom",
                  "Lun",
                  "Mar",
                  "Mie",
                  "Jue",
                  "Vie",
                  "Sab"
                ]
              },
              "editor": {
                "close": "Cerrar",
                "create": {
                  "button": "Nuevo",
                  "title": "Crear Nuevo Registro",
                  "submit": "Crear"
                },
                "edit": {
                  "button": "Editar",
                  "title": "Editar Registro",
                  "submit": "Actualizar"
                },
                "remove": {
                  "button": "Eliminar",
                  "title": "Eliminar Registro",
                  "submit": "Eliminar",
                  "confirm": {
                    "_": "¿Está seguro que desea eliminar %d filas?",
                    "1": "¿Está seguro que desea eliminar 1 fila?"
                  }
                },
                "error": {
                  "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                },
                "multi": {
                  "title": "Múltiples Valores",
                  "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                  "restore": "Deshacer Cambios",
                  "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
                }
              },
              "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
              "stateRestore": {
                "creationModal": {
                  "button": "Crear",
                  "name": "Nombre:",
                  "order": "Clasificación",
                  "paging": "Paginación",
                  "search": "Busqueda",
                  "select": "Seleccionar",
                  "columns": {
                    "search": "Búsqueda de Columna",
                    "visible": "Visibilidad de Columna"
                  },
                  "title": "Crear Nuevo Estado",
                  "toggleLabel": "Incluir:"
                },
                "emptyError": "El nombre no puede estar vacio",
                "removeConfirm": "¿Seguro que quiere eliminar este %s?",
                "removeError": "Error al eliminar el registro",
                "removeJoiner": "y",
                "removeSubmit": "Eliminar",
                "renameButton": "Cambiar Nombre",
                "renameLabel": "Nuevo nombre para %s",
                "duplicateError": "Ya existe un Estado con este nombre.",
                "emptyStates": "No hay Estados guardados",
                "removeTitle": "Remover Estado",
                "renameTitle": "Cambiar Nombre Estado"
              }
            },
                      dom: 'Blfrtip',
            // pageLength: 5,
             lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
            // buttons: [
            //   'copy', 'csv', 'excel', 'pdf', 'print'
            // ],
            "footerCallback": function ( row, data, start, end, display ) {
              var api = this.api(), data;

              // Remove the formatting to get integer data for summation
              var intVal = function ( i ) {
                return typeof i === 'string' ?
                  i.replace(/[\$,]/g, '')*1 :
                  typeof i === 'number' ?
                    i : 0;
              };

              // Total over all pages
              this.tot = api
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
                }, 0 );
              // console.log(this.tot)
              // Total over this page
              this.pageTotal = api
                .column( 1, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
                }, 0 );
              // this.ttotal= api
              //   .column( 3, { page: 'current'} )
              //   .data()
              //   .reduce( function (a, b) {
              //     return intVal(a) + intVal(b);
              //   }, 0 );
              // this.tcuenta= api
              //   .column(4 , { page: 'current'} )
              //   .data()
              //   .reduce( function (a, b) {
              //     return intVal(a) + intVal(b);
              //   }, 0 );
              // this.tsaldo= api
              //   .column(5 , { page: 'current'} )
              //   .data()
              //   .reduce( function (a, b) {
              //     return intVal(a) + intVal(b);
              //   }, 0 );

              // Update footer
              $( api.column( 4 ).footer() ).html(
                '$'+this.pageTotal +' ( $'+ this.tot +' total)'
                // 'total:'+this.ttotal +' a cuenta:'+this.tcuenta +' saldo:'+this.tsaldo +' '
              );
            }
          } );
        })

        })

        this.$axios.post(process.env.API+'/replanilla',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
          console.log(res.data)
            this.resumenplanilla=res.data[0].total==null?0:res.data[0].total
        })

        this.$axios.post(process.env.API+'/misventas',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
          this.$q.loading.hide()

          // this.ventas=res.data
           console.log(res.data)
           console.log(this.user.id)
          this.$q.loading.hide()
          this.ventas=[]
          res.data.forEach(r=>{
             if (r.estado!='ANULADO'){
              if(this.$store.state.login.gastoreporteuser){
              if(this.user.id==0){this.ventas.push({
                fecha:r.fecha,
                total:r.total,
                // tipo:r.tipo,
                acuenta:r.acuenta,
                saldo:r.saldo,
                producto:r.detalle.nombreproducto,
                estado:r.estado,
                local:r.cliente.local,
                titular:r.cliente.titular,
                user:r.user.name,
                detalle:r.detalle.nombreproducto,
                cantidad:r.detalle.cantidad,
                fechaentrega:r.fechaentrega,
                tipo:r.tipo,
                hora:r.hora
              })}
              else{
              if(this.user.id==r.user_id){this.ventas.push({
                fecha:r.fecha,
                total:r.total,
                tipo:r.tipo,
                acuenta:r.acuenta,
                saldo:r.saldo,
                producto:r.detalle.nombreproducto,
                estado:r.estado,
                local:r.cliente.local,
                titular:r.cliente.titular,
                user:r.user.name,
                detalle:r.detalle.nombreproducto,
                cantidad:r.detalle.cantidad,
                fechaentrega:r.fechaentrega,
                // tipo:r.tipo,
                hora:r.hora
              })}
              }
              }
              else{
                if(this.$store.state.login.user.id==r.user_id)
              this.ventas.push({
                fecha:r.fecha,
                total:r.total,
                tipo:r.tipo,
                acuenta:r.acuenta,
                saldo:r.saldo,
                producto:r.detalle.nombreproducto,
                estado:r.estado,
                local:r.cliente.local,
                titular:r.cliente.titular,
                user:r.user.name,
                detalle:r.detalle.nombreproducto,
                cantidad:r.detalle.cantidad,
                fechaentrega:r.fechaentrega,
                // tipo:r.tipo,
                hora:r.hora
              })
              }
              }
          })
          console.log(this.ventas)
          this.$axios.post(process.env.API+'/misanulados',{fecha1:this.fecha1,fecha2:this.fecha2,id:this.user.id}).then(res=>{
            console.log(res.data)
          this.anulados=res.data;

            this.$axios.post(process.env.API+'/reportepago',{fecha1:this.fecha1,fecha2:this.fecha2,id:this.user.id}).then(res=>{
              this.rpagos=[];
              this.rpagos=res.data;
            this.$axios.post(process.env.API+'/reporteventa',{fecha1:this.fecha1,fecha2:this.fecha2,id:this.user.id}).then(res=>{
              //console.log(res.data)
            this.prestamoventa=[];
            this.prestamoventa=res.data;
            })

            })
          })

        })

      }).catch(err=>{
        this.$q.loading.hide()
        this.$q.notify({
          color:'red',
          icon:'error',
          message:err.response.data.message
        })
      })
    },
    agregarpago(){
      if(this.empleadohistorial.tipo=='FIJO'){
            if((parseFloat(this.pago.empleado.element.salario)- this.totaldescuento) < parseFloat( this.pago.monto) && (this.pago.tipo=='ADELANTO' || this.pago.tipo=='DESCUENTO'))
          {
              this.$q.notify({
                message:'El monto excede al salario ',
                icon:'info',
                color:'red'
              })
            return false;
          }
      }

      // console.log('a');
      //this.pago.fecha=date.formatDate( Date.now(),'YYYY-MM-DD');
      this.pago.empleado_id=this.pago.empleado.element.id
      this.pago.empleado_nombre=this.pago.empleado.label;
      this.pago.checkbox=this.checkgasto
      if(this.checkgasto=='GASTO' && (this.pago.tipo=='ADELANTO' || this.pago.tipo=='EXTRA') && this.pago.monto > this.montogeneral){
                      this.$q.notify({
                message:'El monto excede en General ',
                icon:'info',
                color:'red'
              })
        return false
      }

     if(this.checkgasto=='CAJA' && (this.pago.tipo=='ADELANTO' || this.pago.tipo=='EXTRA') && this.pago.monto > this.montocajachica){
                      this.$q.notify({
                message:'El monto excede en Caja Chica ',
                icon:'info',
                color:'red'
              })
        return false
      }
       //console.log(this.pago)
      // return false

      this.$axios.post(process.env.API+'/sueldo',this.pago).then(res=>{
        //console.log(res.data)
        //return false
        //this.empleadohistorial=res.data
        this.misempleados()
        this.misgastos()
          this.totalcaja()
          this.totalgeneral()

        this.pagos=false
        this.checkgasto='CAJA'
        this.pago.monto=0
        this.pago.tipo=''
        this.pago.observacion=''
        this.pago.fecha=date.formatDate( Date.now(),'YYYY-MM-DD');
      })
    },
    misempleados(){
      this.$q.loading.show()
      this.$axios.get(process.env.API+'/empleado').then(res=>{
        // this.ventas=res.data
        // console.log(res.data)
        this.$q.loading.hide()
        this.empleados=[]
        res.data.forEach(element => {
          this.empleados.push({element,label:element.nombre})
        });
        console.log (this.empleados)
        this.pago.empleado=this.empleados[0]
        // res.data.forEach(r=>{
        //   this.ventas.push({
        //     total:r.total,
        //     acuenta:r.acuenta,
        //     saldo:r.saldo,
        //     estado:r.estado,
        //     cliente:r.cliente.local,
        //     user:r.user.name,
        //   })
        // })
      })
    },
    agregar(){
     // console.log(this.glosa)
      if(this.glosa.id==undefined){
        return false
      }

      this.totalgeneral()
      console.log(this.montogeneral)
      //return false
      if(parseFloat(this.montogeneral) < parseFloat(this.empleado.precio)){
          this.$q.notify({
            message:'No se Tiene Fondos',
            icon:'info',
            color:'red'
          })
        return false
      }
      this.$q.loading.show()
      this.empleado.observacion=this.empleado.observacion.toUpperCase()
      this.empleado.glosa=this.glosa.nombre
      this.empleado.glosa_id=this.glosa.id
      if (this.boolcrear){
        this.$axios.post(process.env.API+'/gasto',this.empleado).then(res=>{
          // this.ventas=res.data
          // console.log(res.data)
                  let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.focus();
        // setTimeout(function(){
          myWindow.print();
          myWindow.close();
          this.$q.loading.hide()
          // this.empleados=res.data
          this.misgastos()
          this.listadog()
          this.totalgeneral()

          this.empleado.precio=0
          this.empleado.observacion=''
          this.empleado.glosa=''
          this.glosa={label:''}
          this.$q.notify({
            message:'Creado correctamente',
            icon:'info',
            color:'positive'
          })
        })
      }else{
        this.$axios.put(process.env.API+'/gasto/'+this.empleado.id,this.empleado).then(res=>{
          // this.ventas=res.data
          // console.log(res.data)
          this.$q.loading.hide()
          // this.empleados=res.data
          this.misgastos()
          this.listadog()
          this.boolcrear=true
          // this.empleado={fechanac: '2000-01-01'}
          this.empleado={fecha:date.formatDate( Date.now(),'YYYY-MM-DD')}
          this.$q.notify({
            message:'Creado correctamente',
            icon:'info',
            color:'positive'
          })
        })
      }


    },
    guardar(){
      // console.log(this.detalles)
      // return  false
      if (this.detalles.length==0){
        this.$q.notify({
         message:'Tienes que tener un detalle de ventas',
         color:'red',
         icon:'error'
        })
        return false;
      }
      // return false
      this.$q.loading.show()
      this.$axios.post(process.env.API+'/venta',{
        total:this.total,
        acuenta:this.acuenta,
        saldo:this.saldo,
        estado:this.estado,
        cliente_id:this.cliente.id,
        detalles:this.detalles
      }).then(res=>{
        // console.log(res.data)
        this.$q.notify({
          message:'Venta exitosa',
          color:'green',
          icon:'info'
        })
        this.misventas()
      })
    },
    printgasto(gasto){
      let cadena="<style>   .textcnt{   text-align:center;        }        table{width:100%;}        td{vertical-align:top;}        </style>"
        cadena+="<div class='textcnt'> DETALLE GASTO</div>"
        cadena+="<div class='textcnt'>Nro "+gasto.id+"</div>        <hr>"
        cadena+="<div>Nombre: "+gasto.user+"</div>"
        cadena+="<div>Fecha: "+gasto.fecha+"</div>        <hr>"
        cadena+="<table>        <tr><td>Glosa: </td><td><b>"+gasto.glosa+"</b></td></tr>"
        cadena+="<tr><td>Costo: </td><td><b>"+gasto.precio+"</b></td></tr>"
        cadena+="<tr><td>Observacion: </td><td><b>"+gasto.observacion+"</b></td></tr>        </table>"
        cadena+="    <br>"

      let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(cadena);
        myWindow.document.close();
        myWindow.focus();
        // setTimeout(function(){
          myWindow.print();
          myWindow.close();
    },
    deleteval(index){
      // this.detalles.splice(index, 1);
      // console.log(index)
      this.$q.dialog({
        title:'Seguro de eliminar?',
        cancel:true,
      }).onOk(()=>{
        this.$q.loading.show()
        this.$axios.delete(process.env.API+'/gasto/'+index.id).then(res=>{
          this.$q.loading.hide()
          this.misgastos()
          this.$q.notify({
            message:'Borrado correctamente',
            icon:'info',
            color:'positive'
          })
        }).catch(err=>{
          // console.log(err.response)
          this.$q.loading.hide()
          this.$q.notify({
            message:err.response.data.message,
            icon:'error',
            color:'red'
          })
        })
      })

    },
    updateval(index){
      console.log(index)
      index.glosa.label=index.glosa.nombre
      this.glosa=index.glosa
      this.empleado=index
      this.boolcrear=false
      // this.detalles.splice(index, 1);
      // console.log(index)
      // this.$q.loading.show()
      // this.$axios.delete(process.env.API+'/empleado/'+index.id).then(res=>{
      //   this.$q.loading.hide()
      //   this.misempleados()
      // }).catch(err=>{
      //   // console.log(err.response)
      //   this.$q.loading.hide()
      //   this.$q.notify({
      //     message:err.response.data.message,
      //     icon:'error',
      //     color:'red'
      //   })
      // })
    },
    pagosval(index){
      // console.log('a')
      this.pagos=true
      this.$q.loading.show()
      this.$axios.get(process.env.API+'/empleado/'+index.id).then(res=>{
        // console.log(res.data);
        this.empleadohistorial=res.data
        this.$q.loading.hide()
      })
    }
  },
  computed:{
          totaldescuento(){
        let total=0;
      this.pago.empleado.element.sueldos.forEach(element => {
        if(date.formatDate( element.fecha,'YYYY-MM') == date.formatDate( this.pago.fecha,'YYYY-MM'))
        if(element.tipo=='ADELANTO' || element.tipo=='DESCUENTO')
          total+=parseFloat(element.monto)
      });
      return total;
      },

    ventat(){
      let total=0;
      this.ventas.forEach(r=>{
        total+= parseFloat(r.total)
      })
      return total
    },
    porc(){
      let total=0;
      this.ventas.forEach(r=>{
        total+= parseFloat(r.acuenta)
      })
      return total
    },
    saldoc(){
      let total=0;
      this.ventas.forEach(r=>{
        total+= parseFloat(r.saldo)
      })
      return total
    },
    totalanulado(){
      let total=0;
      this.anulados.forEach(r=>{
        total+=parseFloat(r.efectivo)
      })
      return total;
    },

        totalpagos(){
      let total=0;
      this.rpagos.forEach(r=>{
        total+=parseFloat(r.monto)
      })
      return total;
    },
            totalpresventa(){
      let total=0;
      this.prestamoventa.forEach(r=>{
        total+=parseFloat(r.efectivo)
      })
      return total;
    }
  }
}
</script>

<style scoped>

</style>
