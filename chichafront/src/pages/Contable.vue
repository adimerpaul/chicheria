<template>
    <div class="row">
      <div class="col-12">
        <div class="text-center text-bold">RESUMEN DE INGRESOS Y EGRESOS</div>
      </div>
      <div class="col-12">
                <q-form @submit="listado" >
                <div class="row">
                <div class="col-4">
                  <q-input
                    outlined
                    dense
                    type="date"
                    v-model="fecha1"
                    label="Fecha ini"
                    required
                    hint="Porfavor ingresar fecha inicio"

                    counter
                  />
                  </div>
                  <div class="col-4">
                  <q-input
                    outlined
                    dense
                    type="date"
                    v-model="fecha2"
                    label="Fecha fin"
                    required
                    :rules="[ val => val>=fecha1 || 'Fecha debe ser mayor o igual']"
                    hint="Porfavor ingresar fecha fin"
                    counter
                  />
                  </div>
                  <div class="col-4 flex ">
                    <q-btn  label="Generar" class="full-width "  type="submit" color="primary" icon="send" />
                  </div>
                  </div>

                </q-form>


        <div class="col-12">
          <div class=" responsive">
           <!-- <table id="example1" class="display">
              <thead>
                <tr>
                <th>DETALLE</th>
                <th>TOTAL</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="r in ingreso " :key="r">
                  <td>{{r.detalle}}</td>
                  <td>{{r.total}}</td>
                </tr>
              </tbody>
             </table>
             <table id="example2" class="display">
              <thead>
                <tr>
                <th>DETALLE</th>
                <th>TOTAL</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="r in ingreso " :key="r">
                  <td>{{r.detalle}}</td>
                  <td>{{r.total}}</td>
                </tr>
              </tbody>
             </table>
             <table id="example3" class="display">
              <thead>
                <tr>
                <th>DETALLE</th>
                <th>TOTAL</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="r in ingreso " :key="r">
                  <td>{{r.detalle}}</td>
                  <td>{{r.total}}</td>
                </tr>
              </tbody>
             </table>-->
              <q-table dense title="Ingresos" :rows="ingreso" :columns="columns" row-key="name"    :rows-per-page-options="[0,50,100]"/>
                <q-table dense title="Egresos" :rows="egreso" :columns="columns2" row-key="name"       :rows-per-page-options="[0,50,100]"/>
                <q-table dense title="Caja Chica" :rows="cchica" :columns="columns3" row-key="name"       :rows-per-page-options="[0,50,100]"/>
          </div>
        </div>

            <div class="col-12">
              <q-form>
                <div class="row">
                  <div class="col-3 q-pa-md">
                    <q-input type="text" label="Ingreso total" label-color="positive"  v-model="totalingreso"  outlined/>
                  </div>
                  <div class="col-3 q-pa-md">
                    <q-input type="text" label="Egreso Total" label-color="info"  v-model="totalegreso"  outlined/>
                  </div>
                  <div class="col-3 q-pa-md">
                    <q-input type="text" label="Caja Chica Total" label-color="info"  v-model="totalchica"  outlined/>
                  </div>
                  <div class="col-3 q-pa-md">
                    <q-input type="text" label="Balance" label-color="teal"  outlined v-model="balance"/>
                  </div>
                </div>
              </q-form>
            </div>
      <div class="col-12">
        <q-btn label="Imprimir" icon="print" color="accent" class="full-width" @click="impresion2()"/>
      </div>
      </div>
    </div>

</template>
<script>
import {date} from 'quasar'
import { jsPDF } from "jspdf";
import $ from "jquery";
import moment from 'moment'

export default {
  data(){
    return{
      fecha1:date.formatDate(new Date(),'YYYY-MM-DD'),
      fecha2:date.formatDate(new Date(),'YYYY-MM-DD'),
      resumen:[],
      usuarios:[],
      filter:'',
      usuario:'',
      ventas:[],
      deudas:[],
      ingreso:[],
      egreso:[],
      cchica:[],
      regpago:{},
      pagos:{},
      final:0,
      dato:{},
      alert:false,
      dialog_pago:false,

      columns : [

  { name: 'detalle', align: 'center', label: 'DETALLE', field: 'detalle', sortable: true },
  { name: 'total', align: 'center', label: 'total', field: 'total'},
],


      columns2 : [

  { name: 'detalle', align: 'center', label: 'DETALLE', field: 'detalle', sortable: true },
  { name: 'total', align: 'center', label: 'total', field: 'total'},
],
      columns3 : [

  { name: 'detalle', align: 'center', label: 'DETALLE', field: 'detalle', sortable: true },
  { name: 'total', align: 'center', label: 'total', field: 'total'},
],

    }
  },
  mounted() {
  },
  created() {
    $('#example1').DataTable( )
    $('#example2').DataTable( )
    $('#example3').DataTable( )

      this.listado();
  },
  methods: {
          onPago(){
      this.$axios.post(process.env.API+'/pago',this.regpago).then(res=>{
          this.regpago={};
          this.dialog_pago=false;
          this.deudores();
                  this.$q.notify({
          message:'Registro correcto',
          color:'green',
          icon:'send'
        })
      })

      },
    listado(){
      this.ingreso=[]
      this.egreso=[]
      this.cchica=[]
    //      $('#example1').DataTable().destroy();
    //      $('#example2').DataTable().destroy();
    //      $('#example3').DataTable().destroy();
      this.$axios.post(process.env.API+'/repventa',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
        //console.log(res.data)
        //return false
        res.data.forEach(r=>{
        if(r.total!=null && r.total!=undefined)
          this.ingreso.push({detalle:'Venta '+r.tipo,total:r.total,ingreso:r.total,egreso:0})
        })

      })

     this.$axios.post(process.env.API+'/repventpago',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
      //  console.log(res.data)
        if(res.data.total!=null && res.data.total!=undefined)
          this.ingreso.push({detalle:'CxC pagos',total:res.data.total,ingreso:res.data.total,egreso:0})
      })

      this.$axios.post(process.env.API+'/repingprestamo',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
        //console.log(res.data)
        res.data.forEach(r=>{
        if(r.total!=null && r.total!=undefined)
          this.ingreso.push({detalle:'Prest/mat '+r.estado,total:r.total,ingreso:r.total,egreso:0})
        })
        /*this.$nextTick(()=>{
          $('#example1').DataTable( {
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
             lengthMenu: [[-1,20, 50, 100], [ "All",20, 50, 100]],
          } )})*/
      })

    this.$axios.post(process.env.API+'/repgastos',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
    //    console.log(res.data)
        res.data.forEach(r=>{
        if(r.total!=null && r.total!=undefined)
          this.egreso.push({detalle:r.glosa,total:r.total,egreso:r.total,ingreso:0})
        })

      })
      this.$axios.post(process.env.API+'/replanilla',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
       //   console.log(res.data)
          let t=res.data[0]
          if(t.total!=null && t.total!=undefined){
            this.egreso.push({detalle:'SALARIOS',total:t.total,egreso:t.total,ingreso:0})}
         // console.log(this.egreso)

        })
      this.$axios.post(process.env.API+'/repcompra',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
          console.log(res.data)
          let t=res.data[0]
          if(t.total!=null && t.total!=undefined){
            this.egreso.push({detalle:'COMPRA ALMACEN',total:t.total,egreso:t.total,ingreso:0})}
         // console.log(this.egreso)


        })
      this.$axios.post(process.env.API+'/repcaja',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
          console.log(res.data)
          //let t=res.data[0]
          res.data.forEach(r => {
            this.cchica.push({detalle:r.glosa,total:r.total,egreso:r.total,ingreso:0})})


         // console.log(this.egreso)

        })
      /* this.$nextTick(()=>{
          $('#example1').DataTable( {
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
             lengthMenu: [[-1,20, 50, 100], [ "All",20, 50, 100]],
          } )})
          this.$nextTick(()=>{
          $('#example2').DataTable( {
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
             lengthMenu: [[-1,20, 50, 100], [ "All",20, 50, 100]],
          } )})
          this.$nextTick(()=>{
          $('#example3').DataTable( {
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
             lengthMenu: [[-1,20, 50, 100], [ "All",20, 50, 100]],
          } )})*/
    },
    impresion2(){
      this.resumen=[]
      this.ingreso.forEach(r => {
        this.resumen.push({detalle:r.detalle,ingreso:r.total,egreso:0});
      })

      this.egreso.forEach(r => {
        this.resumen.push({detalle:r.detalle,ingreso:0,egreso:r.total});
      })
      let mc=this
      let totalingreso=0
      let totalegreso=0
      let totalcaja=0
        let cadena="<style>\
        *{font-size:14px}\
        table{width:100%;border-collapse: collapse;}\
        table, th, td {  border: 1px solid;}\
        .titulo1{text-align:center; font-weight: bold;}\
        </style>\
        <div><img src='logo.png' style='width:150px; height:75px;'></div>\
        <div class='titulo1'>RESUMEN DE BALANCE DE <br>"+moment(mc.fecha1).format('DD/MM/YYYY')+' AL '+moment(mc.fecha2).format('DD/MM/YYYY') +"</div><br>\
        <div>INGRESOS</div><table><tr><th>DETALLE</th> <th>INGRESO</th> </tr>"

        this.ingreso.forEach(r=>{
        totalingreso=totalingreso+r.ingreso;
        cadena+="<tr><td>"+r.detalle+"</td><td>"+r.ingreso+"</td></tr>"
        })
        cadena+="</table><br><div>EGRESOS</div><table><tr><th>DETALLE</th>  <th>EGRESO</th></tr>"


              this.egreso.forEach(r=>{
        totalegreso=totalegreso+r.egreso;
        cadena+="<tr><td>"+r.detalle+"</td><td>"+r.egreso+"</td></tr>"
        })
        cadena+="</table><br><div>CAJA CHICA</div><table><tr><th>DETALLE</th> <th>EGRESO</th></tr>"
              this.cchica.forEach(r=>{
        totalcaja=totalcaja+r.egreso;
        cadena+="<tr><td>"+r.detalle+"</td><td>"+r.egreso+"</td></tr>"
        })
        var ttotal=totalingreso - totalegreso - totalcaja
        cadena+="</table><div><b>TOTAL INGRESO: </b> "+ totalingreso+" Bs</div>\
        <div><b>TOTAL EGRESO: </b> "+ totalegreso+" Bs</div>\
        <div><b>T. CJA CHICA: </b> "+ totalcaja+" Bs</div>\
        <div><b>BALANCE: </b> "+ ttotal+" Bs</div>"

        let myWindow = window.open("_blank");
        myWindow.document.write(cadena);
        myWindow.document.close();
    },
    impresion(){
      this.resumen=[]
      this.ingreso.forEach(r => {
        this.resumen.push({detalle:r.detalle,ingreso:r.total,egreso:0});
      });

      this.egreso.forEach(r => {
        this.resumen.push({detalle:r.detalle,ingreso:0,egreso:r.total});
      });

           let mc=this

      function header(){
        var img = new Image()
        img.src = 'logo.png'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'RESUMEN DE BALANCE ')
        doc.text(5, 1.5,  'DE '+moment(mc.fecha1).format('DD/MM/YYYY')+' AL '+moment(mc.fecha2).format('DD/MM/YYYY'))
        doc.text(1, 3, 'DETALLE')
        doc.text(10, 3, 'INGRESO')
        doc.text(14, 3, 'EGRESO')
        doc.setFont(undefined,'normal')
      }
      var doc = new jsPDF('p','cm','letter')
      // console.log(dat);
      doc.setFont("courier");
      doc.setFontSize(12);
      // var x=0,y=
      header()
      // let xx=x
      // let yy=y
      let y=0
      let totalingreso=0
      let totalegreso=0
      let totalcaja=0
      this.ingreso.forEach(r=>{
        totalingreso=totalingreso+r.ingreso;
        // xx+=0.5
        y+=0.5
        doc.text(1, y+3, r.detalle)
        doc.text(10, y+3, r.ingreso+'')
        doc.text(14, y+3, r.egreso+'')

        if (y+3>25){
          doc.addPage();
          header()
          y=0
        }
        })
        y+=0.5

              this.egreso.forEach(r=>{
        totalegreso=totalegreso+r.egreso;
        // xx+=0.5
        y+=0.5
        doc.text(1, y+3, r.detalle)
        doc.text(10, y+3, r.ingreso+'')
        doc.text(14, y+3, r.egreso+'')

        if (y+3>25){
          doc.addPage();
          header()
          y=0
        }
        })
        y+=0.5
              this.cchica.forEach(r=>{
        totalcaja=totalcaja+r.egreso;
        // xx+=0.5
        y+=0.5
        doc.text(1, y+3, r.detalle)
        doc.text(10, y+3, r.ingreso+'')
        doc.text(14, y+3, r.egreso+'')

        if (y+3>25){
          doc.addPage();
          header()
          y=0
        }
        })

      doc.setFontSize(9);

        doc.setFont(undefined,'bold')
        doc.text(1, y+4, 'TOTAL INGRESO: ')
        doc.setFont(undefined,'normal')
        doc.text(4, y+4, totalingreso+' Bs')

        doc.setFont(undefined,'bold')
        doc.text(7, y+4, 'TOTAL EGRESO: ')
        doc.setFont(undefined,'normal')
        doc.text(10, y+4, totalegreso+' Bs')

        doc.setFont(undefined,'bold')
        doc.text(7, y+4.5, 'T. CJA CHICA: ')
        doc.setFont(undefined,'normal')
        doc.text(10, y+4.5, totalcaja+' Bs')

        var ttotal=totalingreso - totalegreso - totalcaja
        doc.setFont(undefined,'bold')
        doc.text(14, y+4, 'BALANCE: ')
        doc.setFont(undefined,'normal')
        doc.text(18, y+4, ttotal+'Bs')


      // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
      window.open(doc.output('bloburl'), '_blank');
    },
  },
computed:{

    totalingreso(){
      let total=0;
      this.ingreso.forEach(r=>{
        total+= parseFloat(r.ingreso)
      })
      return total
    },
    totalegreso(){
      let total=0;
      this.egreso.forEach(r=>{
        total+= parseFloat(r.egreso)
      })
      return total
    },
    totalchica(){
      let total=0;
      this.cchica.forEach(r=>{
        total+= parseFloat(r.total)
      })
      return total
    },

    balance(){
      var total=this.totalingreso - this.totalegreso - this.totalchica
      return total;
      //return this.totalingreso() - this.totalegreso()
    }

}

}
</script>
