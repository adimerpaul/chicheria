<template>
    <div class="row">
      <div class="col-12"><q-badge label="Control de clientes" color="teal" class="full-width text-h6"/></div>
      <div class="col-12">
        <q-card>
          <q-tabs
            v-model="tab"
            dense
            class="text-grey"
            active-color="primary"
            indicator-color="primary"
            align="justify"
            narrow-indicator
            @update:model-value="filtrarlista"
          >
            <q-tab name="local" label="Local" />
            <q-tab name="cliente" label="Cliente" />
<!--            <q-tab name="movies" label="Movies" />-->
          </q-tabs>

          <q-separator />

          <q-tab-panels v-model="tab" animated>
            <q-tab-panel name="local">
<!--              <div class="text-h6">Mails</div>-->
<!--              Lorem ipsum dolor sit amet consectetur adipisicing elit.-->
                          <q-form @submit="registrar(1)" class="q-gutter-md">
                          <div class="row">
                          <div class="col-12 col-sm-2">
                            <q-input
                              outlined
                              type="text"
                              v-model="cliente.local"
                              label="Local"
                              style="text-transform: uppercase"
                            />
                            </div>
                            <div class="col-12 col-sm-2">
                            <q-input
                              outlined
                              type="text"
                              v-model="cliente.ci"
                              label="Cedula Identidad"
                              style="text-transform: uppercase"
                            />
                            </div>
                            <div class="col-12 col-sm-2">
                            <q-input
                              outlined
                              v-model="cliente.titular"
                              type="text"
                              label="Nombre Completo"
                              style="text-transform: uppercase"
                              lazy-rules
                              :rules="[ val => val && val.length > 0 || 'Por favor ingresar dato']"
                            />
                                              </div>

                            <div class="col-12 col-sm-2">
                            <q-input
                              outlined
                              type="text"
                              v-model="cliente.telefono"
                              label="Telefono o Celular"
                              style="text-transform: uppercase"
                            />
                                              </div>
                            <div class="col-12 col-sm-2">
                            <q-input
                              type="date"
                              outlined
                              v-model="cliente.fechanac"
                              label="Fecha Nac"
                            />
                                              </div>
                            <div class="col-12 col-sm-2">
                            <q-input
                              type="text"
                              outlined
                              v-model="cliente.direccion"
                              label="Direccion*"
                              style="text-transform: uppercase"
                            />
                            </div>
                            <div class="col-12 col-sm-2">
                            <q-input
                              outlined
                              v-model="cliente.observacion"
                              label="Observacion"
                              type="text"
                              style="text-transform: uppercase"
                            />
                            </div>
                            <div class="col-12 col-sm-2">
                              <q-select outlined v-model="cliente.tipo" :options="['PROPIETARIO','INQUILINO']" label="Tipo" />
                            </div>
                            <div class="col-12 col-sm-2">
                              <q-select outlined v-model="cliente.legalidad" :options="['CON LICENCIA','SIN LICENCIA']" label="Legalidad" />
                            </div>
                            <div class="col-12 col-sm-2">
                              <q-select outlined v-model="cliente.categoria" :options="['GENERAL','SIMPLIFICADO','SIN NIT']" label="Categoria" />
                            </div>
                            <div class="col-12 col-sm-2">
                              <q-input
                                type="text"
                                outlined
                                v-model="cliente.razon"
                                label="Razon Social"
                                style="text-transform: uppercase"
                              />
                            </div>
                            <div class="col-12 col-sm-2">
                              <q-input
                                outlined
                                v-model="cliente.nit"
                                label="NIT"
                                type="text"
                                style="text-transform: uppercase"
                              />
                            </div>
                            <div class="col-12 flex flex-center">
                              <q-btn label="Registrar" icon="send" type="submit" color="primary" class="full-width" />
                            </div>

<!--                            <div v-if="tipocliente==0" class="col-1 flex flex-center">-->
<!--                              <q-btn label="Registrar" icon="send" type="submit" color="primary" />-->
<!--                            </div>-->
                          </div>
<!--                            <div v-if="tipocliente==1" class="row">-->




                            <div>
                            </div>

<!--                            </div>-->

                              </q-form>
            </q-tab-panel>

            <q-tab-panel name="cliente">
<!--              <div class="text-h6">Alarms</div>-->
<!--              Lorem ipsum dolor sit amet consectetur adipisicing elit.-->
              <q-form @submit="registrar(2)" class="q-gutter-md">
                <div class="row">
<!--                  <div class="col-12 col-sm-2">-->
<!--                    <q-input-->
<!--                      outlined-->
<!--                      type="text"-->
<!--                      v-model="cliente.local"-->
<!--                      label="Local"-->
<!--                      style="text-transform: uppercase"-->
<!--                    />-->
<!--                  </div>-->
                  <div class="col-12 col-sm-2">
                    <q-input
                      outlined
                      type="text"
                      v-model="cliente.ci"
                      label="Cedula Identidad"
                      style="text-transform: uppercase"
                    />
                  </div>
                  <div class="col-12 col-sm-2">
                    <q-input
                      outlined
                      v-model="cliente.titular"
                      type="text"
                      label="Nombre Completo"
                      style="text-transform: uppercase"
                      lazy-rules
                      :rules="[ val => val && val.length > 0 || 'Por favor ingresar dato']"
                    />
                  </div>

                  <div class="col-12 col-sm-2">
                    <q-input
                      outlined
                      type="text"
                      v-model="cliente.telefono"
                      label="Telefono o Celular"
                      style="text-transform: uppercase"
                    />
                  </div>
                  <div class="col-12 col-sm-2">
                    <q-input
                      type="date"
                      outlined
                      v-model="cliente.fechanac"
                      label="Fecha Nac"
                    />
                  </div>
                  <div class="col-12 col-sm-2">
                    <q-input
                      type="text"
                      outlined
                      v-model="cliente.direccion"
                      label="Direccion*"
                      style="text-transform: uppercase"
                    />
                  </div>
                  <div class="col-12 col-sm-2">
                    <q-input
                      outlined
                      v-model="cliente.observacion"
                      label="Observacion"
                      type="text"
                      style="text-transform: uppercase"
                    />
                  </div>
<!--                  <div class="col-12 col-sm-2">-->
<!--                    <q-select outlined v-model="cliente.tipo" :options="['PROPIETARIO','INQUILINO']" label="Tipo" />-->
<!--                  </div>-->
<!--                  <div class="col-12 col-sm-2">-->
<!--                    <q-select outlined v-model="cliente.legalidad" :options="['CON LICENCIA','SIN LICENCIA']" label="Legalidad" />-->
<!--                  </div>-->
<!--                  <div class="col-12 col-sm-2">-->
<!--                    <q-select outlined v-model="cliente.categoria" :options="['GENERAL','SIMPLIFICADO','SIN NIT']" label="Categoria" />-->
<!--                  </div>-->
<!--                  <div class="col-12 col-sm-2">-->
<!--                    <q-input-->
<!--                      type="text"-->
<!--                      outlined-->
<!--                      v-model="cliente.razon"-->
<!--                      label="Razon Social"-->
<!--                      style="text-transform: uppercase"-->
<!--                    />-->
<!--                  </div>-->
<!--                  <div class="col-12 col-sm-2">-->
<!--                    <q-input-->
<!--                      outlined-->
<!--                      v-model="cliente.nit"-->
<!--                      label="NIT"-->
<!--                      type="text"-->
<!--                      style="text-transform: uppercase"-->
<!--                    />-->
<!--                  </div>-->
                  <div class="col-12 flex flex-center">
                    <q-btn label="Registrar" icon="send" type="submit" color="primary" class="full-width" />
                  </div>

                  <!--                            <div v-if="tipocliente==0" class="col-1 flex flex-center">-->
                  <!--                              <q-btn label="Registrar" icon="send" type="submit" color="primary" />-->
                  <!--                            </div>-->
                </div>
                <!--                            <div v-if="tipocliente==1" class="row">-->
                <div>
                </div>

                <!--                            </div>-->
              </q-form>
            </q-tab-panel>

<!--            <q-tab-panel name="movies">-->
<!--              <div class="text-h6">Movies</div>-->
<!--              Lorem ipsum dolor sit amet consectetur adipisicing elit.-->
<!--            </q-tab-panel>-->
          </q-tab-panels>
        </q-card>
      </div>
      <div class="col-12">
<!--            <div class="text-h6">-->
<!--              <h5 style="text-align:center">INFORMACION DE CLIENTES</h5>-->
<!--            </div>-->
            <!--            <div class="text-subtitle2">by John Doe</div>-->
<!--            <q-card style="width:100% ;">-->
<!--              <q-card-section>-->
<!--                <div class="text-h6">Registro nuevo cliente</div>-->
<!--              </q-card-section>-->
<!--              <q-card-section class="q-pt-none">-->
<!--                  <div>-->
<!--      <q-btn-toggle-->
<!--        v-model="tipocliente"-->
<!--        @click="onReset"-->
<!--        class="my-custom-toggle"-->
<!--        no-caps-->
<!--        rounded-->
<!--        unelevated-->
<!--        toggle-color="primary"-->
<!--        color="white"-->
<!--        text-color="primary"-->
<!--        :options="[-->
<!--          {label: 'Local', value: 1},-->
<!--          {label: 'Persona', value: 0}-->
<!--        ]"-->
<!--      />-->
<!--    </div>-->
<!--                <q-form-->
<!--                  @submit="registrar"-->
<!--                  class="q-gutter-md"-->
<!--                >-->
<!--                <div class="row">-->
<!--                <div class="col-2">-->
<!--                  <q-input-->
<!--                    outlined-->
<!--                    type="text"-->
<!--                    v-model="cliente.local"-->
<!--                    label="Local"-->
<!--                    style="text-transform: uppercase"-->
<!--                  />-->
<!--                  </div>-->
<!--                  <div class="col-2">-->
<!--                  <q-input-->
<!--                    outlined-->
<!--                    type="text"-->
<!--                    v-model="cliente.ci"-->
<!--                    label="Cedula Identidad"-->
<!--                    style="text-transform: uppercase"-->
<!--                  />-->
<!--                  </div>-->
<!--                  <div class="col-2">-->
<!--                  <q-input-->
<!--                    outlined-->
<!--                    v-model="cliente.titular"-->
<!--                    type="text"-->
<!--                    label="Nombre Completo"-->
<!--                    style="text-transform: uppercase"-->
<!--                    lazy-rules-->
<!--                    :rules="[ val => val && val.length > 0 || 'Por favor ingresar dato']"-->
<!--                  />-->
<!--                                    </div>-->

<!--                  <div class="col-1">-->
<!--                  <q-input-->
<!--                    outlined-->
<!--                    type="text"-->
<!--                    v-model="cliente.telefono"-->
<!--                    label="Telefono o Celular"-->
<!--                    style="text-transform: uppercase"-->
<!--                  />-->
<!--                                    </div>-->
<!--                  <div class="col-2">-->
<!--                  <q-input-->
<!--                    type="date"-->
<!--                    outlined-->
<!--                    v-model="cliente.fechanac"-->
<!--                    label="Fecha Nac"-->
<!--                  />-->
<!--                                    </div>-->
<!--                  <div class="col-2">-->
<!--                  <q-input-->
<!--                    type="text"-->
<!--                    outlined-->
<!--                    v-model="cliente.direccion"-->
<!--                    label="Direccion*"-->
<!--                    style="text-transform: uppercase"-->
<!--                  />-->
<!--                                    </div>-->
<!--                                    <div class="col-2">-->
<!--                  <q-input-->
<!--                    outlined-->
<!--                    v-model="cliente.observacion"-->
<!--                    label="Observacion"-->
<!--                    type="text"-->
<!--                    style="text-transform: uppercase"-->
<!--                  />-->

<!--                  </div>-->
<!--                  <div v-if="tipocliente==0" class="col-1 flex flex-center">-->
<!--                    <q-btn label="Registrar" icon="send" type="submit" color="primary" />-->
<!--                  </div>-->
<!--                </div>-->
<!--                  <div v-if="tipocliente==1" class="row">-->

<!--                  <div class="col-2">-->
<!--                    <q-select outlined v-model="cliente.tipo" :options="['PROPIETARIO','INQUILINO']" label="Tipo" />-->
<!--                  </div>-->
<!--                  <div class="col-3">-->
<!--                    <q-select outlined v-model="cliente.legalidad" :options="['CON LICENCIA','SIN LICENCIA']" label="Legalidad" />-->
<!--                  </div>-->
<!--                  <div class="col-3">-->
<!--                    <q-select outlined v-model="cliente.categoria" :options="['GENERAL','SIMPLIFICADO','SIN NIT']" label="Categoria" />-->
<!--                  </div>-->
<!--                  <div class="col-3">-->
<!--                  <q-input-->
<!--                    type="text"-->
<!--                    outlined-->
<!--                    v-model="cliente.razon"-->
<!--                    label="Razon Social"-->
<!--                    style="text-transform: uppercase"-->
<!--                  />-->
<!--                  </div>-->
<!--                  <div class="col-2">-->
<!--                  <q-input-->
<!--                    outlined-->
<!--                    v-model="cliente.nit"-->
<!--                    label="NIT"-->
<!--                    type="text"-->
<!--                    style="text-transform: uppercase"-->
<!--                  />-->
<!--                  </div>-->


<!--                  <div>-->
<!--                  </div>-->
<!--                    <div class="col-1 flex flex-center">-->
<!--                      <q-btn label="Registrar" icon="send" type="submit" color="primary" />-->
<!--                    </div>-->
<!--                  </div>-->

<!--                </q-form>-->
<!--              </q-card-section>-->

<!--            </q-card>-->

        <div class="q-pa-md">
          <q-table
            title="CLIENTES"
            :rows="rows"
            :columns="columns"
            row-key="name"
            :filter="filter"
          >

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

            <template v-slot:body-cell-tipocliente="props" >
<!--              <q-tr :props="props" >-->
                <q-td key="tipocliente" :props="props" >
                  <q-badge color="accent" v-if="props.row.tipocliente=='1'">
                    LOCAL
                  </q-badge>
                  <q-badge color="info" v-else>
                    CLIENTE
                  </q-badge>
                </q-td>
<!--              </q-tr>-->
            </template>

            <template v-slot:body-cell-opcion="props" >
                <q-td key="opcion" :props="props" >
                <q-btn dense round flat color="yellow" @click="editRow(props)" icon="edit"></q-btn>
                <q-btn dense round flat color="red" @click="delRow(props)" icon="delete"></q-btn>
                </q-td>
            </template>
            <template v-slot:top-right>
              <q-input borderless dense debounce="300" v-model="filter" placeholder="Buscar">
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
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
                    outlined
                    type="text"
                    v-model="dato.local"
                    label="Local"
                    style="text-transform: uppercase"
                  />
                  <q-input
                    outlined
                    type="text"
                    v-model="dato.ci"
                    label="Cedula Identidad"
                    style="text-transform: uppercase"
                  />
                  <q-input
                    outlined
                    v-model="dato.titular"
                    type="text"
                    label="Nombre Completo"
                    style="text-transform: uppercase"
                    lazy-rules
                    :rules="[ val => val && val.length > 0 || 'Por favor ingresar dato']"
                  />


                  <q-input
                    outlined
                    type="text"
                    v-model="dato.telefono"
                    label="Telefono o Celular"
                    style="text-transform: uppercase"
                  />
                  <q-input
                    type="date"
                    outlined
                    v-model="dato.fechanac"
                    label="Fecha Nac"
                    lazy-rules
                    :rules="[ val => val && val.length > 0 || 'Por favor ingresar fechas']"
                  />
                  <q-input
                    type="text"
                    outlined
                    v-model="dato.direccion"
                    label="Direccion*"
                    style="text-transform: uppercase"
                  />
                  <q-input
                    outlined
                    v-model="dato.observacion"
                    label="Observacion"
                    type="text"
                    style="text-transform: uppercase"
                  />
                  <div v-if="dato.tipocliente=='1'">
                  <q-select v-model="dato.tipo" :options="['PROPIETARIO','INQUILINO']" label="Tipo" />
                  <q-select outlined v-model="dato.legalidad" :options="['CON LICENCIA','SIN LICENCIA']" label="Legalidad Tributaria" />
                  <q-select outlined v-model="dato.categoria" :options="['GENERAL','SIMPLIFICADO','SIN NIT']" label="Categoria" />
                  <q-input
                    type="text"
                    outlined
                    v-model="dato.razon"
                    label="Razon Social"
                    style="text-transform: uppercase"
                  />

                  <q-input
                    outlined
                    v-model="dato.nit"
                    label="NIT"
                    type="text"
                    style="text-transform: uppercase"
                  />
                </div>


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
      <div class="col-12">
<!--        <div class="q-pb-sm">-->
<!--          Model: {{ days }}-->
<!--        </div>-->

        <q-date v-model="days" multiple />
      </div>
    </div>
</template>
<script>

import { date } from 'quasar'
export default {
  data(){
    return{
      tab:'local',
      // days:[{id :'2019/02/01'}, {id:'2019/02/10'} ],
      days:[],filter:'',
      crear:false,
      dialog_mod:false,
      dialog_del:false,
      tipocliente:1,
      cliente:{
        fechanac:'2000-01-01'
      },
      clientes:{},
      color:'',
      dato:{},
      columns : [
  {
    name: 'local',
    label: 'Codigo',
    align: 'center',
    field: 'local',
    sortable: true
  },
  { name: 'ci', align: 'center', label: 'CI', field: 'ci', sortable: true },
  { name: 'titular', align: 'center', label: 'Titular', field: 'titular', sortable: true },
  { name: 'tipo', label: 'Tipo', field: 'tipo' },
  { name: 'telefono', label: 'telefono', field: 'telefono' },
  { name: 'fecha nac', label: 'Fecha Nac', field: 'fechanac' },
  { name: 'direccion', label: 'Direccion', field: 'direccion' },
  { name: 'legalidad', label: 'Legalidad', field: 'legalidad' },
  { name: 'categoria', label: 'Categoria NIT', field: 'categoria' },
  { name: 'razon', label: 'Razon Social', field: 'razon' },
  { name: 'nit', label: 'Numero NIT', field: 'nit' },
  { name: 'observacion', label: 'Observacion', field: 'observacion' },
  { name: 'tipocliente', label: 'Tipo cliente', field: 'tipocliente' },
  { name: 'estado', align: 'center', label: 'Estado', field: 'estado' },
  { name: 'opcion', label: 'Opciones', field: 'action' }
],
  rows:[]

    }
  },
  created() {
      this.filtrarlista();
  },
  methods: {
    listado(valor){
      this.$q.loading.show();
      this.rows=[];
      this.$axios.get(process.env.API+'/cumple').then(res=>{
        // console.log(res.data)
        res.data.forEach(el => {
           //console.log(valor);
          this.days.push( el.fechanac.replaceAll('-','/'));
          //console.log(el.tipocliente);
          if(valor == el.tipocliente){
        this.clientes={};
        this.clientes.id=el.id;
        this.clientes.local=el.local;
        this.clientes.ci=el.ci;
        this.clientes.titular=el.titular;
        this.clientes.tipo=el.tipo;
        this.clientes.telefono=el.telefono;
        this.clientes.fechanac=el.fechanac;
        this.clientes.direccion=el.direccion;
        this.clientes.legalidad=el.legalidad;
        this.clientes.categoria=el.categoria;
        this.clientes.razon=el.razon;
        this.clientes.nit=el.nit;
        this.clientes.observacion=el.observacion;
        this.clientes.tipocliente=el.tipocliente;
        this.clientes.estado=el.estado;
        this.rows.push(this.clientes);}
        });
      this.$axios.get(process.env.API+'/cumple2').then(res=>{
        // console.log(res.data)
        res.data.forEach(el => {
          this.days.push( el.fechanac.replaceAll('-','/'))
          //console.log(el.tipocliente)
            if(valor==el.tipocliente){
          this.clientes={};
          this.clientes.id=el.id;
        this.clientes.local=el.local;
        this.clientes.ci=el.ci;
        this.clientes.titular=el.titular;
        this.clientes.tipo=el.tipo;
        this.clientes.telefono=el.telefono;
        this.clientes.fechanac=el.fechanac;
        this.clientes.direccion=el.direccion;
        this.clientes.legalidad=el.legalidad;
        this.clientes.categoria=el.categoria;
        this.clientes.razon=el.razon;
        this.clientes.nit=el.nit;
        this.clientes.observacion=el.observacion;
        this.clientes.tipocliente=el.tipocliente;
        this.clientes.estado=el.estado;
        this.rows.push(this.clientes);}
        
        });
        this.$q.loading.hide();
      })
      });

    },
    filtrarlista(){
      if(this.tab=='local') this.listado(1)
      else this.listado(2)
    },
    registrar(tipo){
        this.cliente.tipocliente=tipo;
        this.$axios.post(process.env.API+'/cliente', this.cliente).then(res=>{
        this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Creado correctamente'
        });
        this.crear=false;
        this.onReset();
        this.filtrarlista();
      }).catch(err=>{

          this.$q.notify({
            color: 'red-4',
            textColor: 'white',
            icon: 'error',
            message: err.response.data.message
          });
        })
      },


      activar(props){
        this.dato=props.row;
        this.$axios.post(process.env.API+'/activar', this.dato).then(res=>{
          this.filtrarlista();
        });

      },
  editRow(props){
    this.dato=props.row;
    console.log(this.dato);
    this.dialog_mod=true;
  },
  delRow(props){
    this.dato=props.row;
    this.dialog_del=true;
  },
     onMod(){
        this.$q.loading.show();
        this.$axios.put(process.env.API+'/cliente/'+this.dato.id,this.dato).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Modificado correctamente'
        });
        this.dialog_mod=false;
        this.filtrarlista();
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
        this.$axios.delete(process.env.API+'/cliente/'+this.dato.id).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Eliminado correctamente'
        });
        this.dialog_del=false;
        this.filtrarlista();
        })
        this.$q.loading.hide();
    },
  onReset(){
    this.cliente={
      fechanac: '2000-01-01'
    };
    console.log(this.tipocliente);
  }

  },



}
</script>
