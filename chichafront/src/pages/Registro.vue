<template>
  <q-page class="q-pa-xs">
    <div class="row">
      <div class="col-12">
        <q-card  bordered class="">
          <q-card-section>
            <div class="text-h6">
              Registro
              <q-btn label="Registrar" icon="add" color="positive" @click="crear = true" />
            </div>
            <!--            <div class="text-subtitle2">by John Doe</div>-->
          </q-card-section>
          <q-dialog v-model="crear"  style="max-width: 600px">
            <q-card>
              <q-card-section>
                <div class="text-h6">Registro nuevo inmueble</div>
              </q-card-section>
              <q-card-section class="q-pt-none">
                <q-form
                  @submit="onSubmit"
                  @reset="onReset"
                  class="q-gutter-md"
                >
                  <q-input
                    filled
                    v-model="registro.ci"
                    label="Carnet *"
                    hint="Nombre del carnet"
                    lazy-rules
                    :rules="[ val => val && val.length > 0 || 'Porfavor ingresar dato']"
                  />
                  <q-input
                    filled
                    v-model="registro.contributente"
                    label="Contribuyente *"
                    hint="Nombre del contribuyente"
                    lazy-rules
                    :rules="[ val => val && val.length > 0 || 'Porfavor ingresar dato']"
                  />
                  <q-input
                    filled
                    v-model="registro.numero"
                    label="Formulario 27 *"
                    hint="Formulario numero 27"
                    lazy-rules
                    :rules="[ val => val && val.length > 0 || 'Porfavor ingresar dato']"
                  />
                  <q-input
                    filled
                    v-model="registro.numtramite"
                    label="Numero tramite *"
                    hint="Formualario numero tramite"
                    lazy-rules
                    :rules="[ val => val && val.length > 0 || 'Porfavor ingresar dato']"
                  />
                  <q-input
                    filled
                    v-model="registro.numhoja"
                    label="Numero hoja *"
                    hint="Formulario numero hoja"
                    lazy-rules
                    :rules="[ val => val && val.length > 0 || 'Porfavor ingresar dato']"
                  />
                  <q-input
                    filled
                    v-model="registro.lugar"
                    label="Lugar *"
                    hint="Lugar"
                    lazy-rules
                    :rules="[ val => val && val.length > 0 || 'Porfavor ingresar dato']"
                  />

                  <q-input
                    filled
                    v-model="registro.tipo"
                    label="Tipo *"
                    hint="Tipo de tramite"
                    lazy-rules
                    :rules="[ val => val && val.length > 0 || 'Porfavor ingresar dato']"
                  />
                  <q-toggle v-model="accept" label="I accept the license and terms" />
                  <div>
                    <q-btn label="Submit" type="submit" color="primary"/>
                    <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
                  </div>
                </q-form>
              </q-card-section>

<!--              <q-card-actions align="right">-->
<!--                <q-btn flat label="OK" color="primary" v-close-popup />-->
<!--              </q-card-actions>-->
            </q-card>
          </q-dialog>


          <q-separator  inset />
          <q-card-section>
            <table id="example" class="display" style="width:100%">
              <thead>
              <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
              </tr>
              </tbody>
            </table>
          </q-card-section>
        </q-card>
      </div>
    </div>

  </q-page>
</template>
<script>
var $  = require( 'jquery' );
// // var dt = require( 'datatables.net' )( window, $ );
// require( 'jszip' );
// require( 'pdfmake' );
// require( 'datatables.net-dt' )();
// require( 'datatables.net-buttons-dt' )();
// require( 'datatables.net-buttons/js/buttons.colVis.js' )();
// import datatable from 'datatables.net-buttons-bs4'
require( 'datatables.net-buttons/js/buttons.html5.js' )();
require( 'datatables.net-buttons/js/buttons.print.js' )();
require('datatables.net-buttons/js/dataTables.buttons');
require('datatables.net-dt/css/jquery.dataTables.min.css');
import print from 'datatables.net-buttons/js/buttons.print';
import jszip from 'jszip/dist/jszip';
import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
pdfMake.vfs=pdfFonts.pdfMake.vfs;
window.JSZip=jszip;
import { date } from 'quasar';
export default {
  data(){
    return{
      fecha:date.formatDate(Date(),'YYYY-MM-DD'),
      crear:false,
      registro:{}
    }
  },
  mounted() {
    $('#example').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    } );
  }

}
</script>
