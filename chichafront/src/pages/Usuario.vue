<template>
  <div class="q-pa-md">
    <q-btn
      label="Nuevo Usuario"
      color="positive"
      @click="alert = true"
      icon="add_circle"
      class="q-mb-xs"
    />
    <q-dialog v-model="alert">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6"><q-icon name="add_circle" /> Nuevo Usuario</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
            <div class="row">
              <div class="col-6">
                <q-input
                  filled
                  v-model="dato.name"
                  type="text"
                  label="Nombre "
                  hint="Ingresar Nombre"
                  lazy-rules
                  :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
                />

                <q-input
                  filled
                  v-model="dato.email"
                  type="email"
                  label="Email"
                  hint="Correo electronico"
                  lazy-rules
                  :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
                />

                <q-input
                  filled
                  v-model="dato.password"
                  type="password"
                  label="Contraseña"
                  hint="Contraseña"
                  lazy-rules
                  :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
                />
                <q-input
                  filled
                  label="Fecha limite"
                  type="date"
                  v-model="dato.fechalimite"
                />
              </div>
              <div class="col-6">
                <div class="text-5">Permisos</div>
                <q-checkbox style="width: 100%"  v-for="(permiso,index) in permisos" :key="index" :label="permiso.nombre" v-model="permiso.estado" />
              </div>
            </div>

            <div>
              <q-btn label="Crear" type="submit" color="positive" icon="add_circle" />
              <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <q-table :filter="filter" title="Usuarios"
      :rows="data"
      :columns="columns"
      row-key="name"
      :rows-per-page-options="[0,50,100]">
      <template v-slot:top-right>
        <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="name" :props="props">
            {{props.row.name}}
          </q-td>
          <q-td key="email" :props="props">
            {{props.row.email}}
          </q-td>
          <q-td key="fechalimite" :props="props">
            {{props.row.fechalimite}}
          </q-td>
          <q-td key="opcion" :props="props">
          <q-btn
              dense
              round
              flat
              color="yellow"
              @click="editRow(props)"
              icon="edit"
          />
            <q-btn
              dense
              round
              flat
            color="positive"
            @click="cambiopass(props)"
            icon="vpn_key"
            />
            <q-btn
              dense
              round
              flat
              color="green-10"
              @click="mispermisos(props)"
              icon="post_add"
            />
            <q-btn
              dense
              round
              flat
              color="red"
              @click="deleteRow(props)"
              icon="delete"
            ></q-btn>
          </q-td>

        </q-tr>
      </template>
    </q-table>
<!--    {{permisos2}}-->
    <q-dialog v-model="dialog_mod">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-warning text-white">
          <div class="text-h6"> <q-icon name="edit"/> Modificar</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onMod" class="q-gutter-md">
            <q-input
              filled
              v-model="dato2.name"
              type="text"
              label="Nombre "
              hint="Ingresar Nombre"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />

            <q-input
              filled
              v-model="dato2.email"
              type="email"
              label="Email"
              hint="Correo electronico"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />

            <q-input
              filled
              label="Fecha limite"
              type="date"
              v-model="dato2.fechalimite"
            />
            <div>
              <q-btn label="Modificar" type="submit" color="positive" icon="add_circle" />
              <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>


   <q-dialog v-model="dialog_del">
      <q-card>
        <q-card-section class="row items-center">
          <q-avatar icon="clear" color="red" text-color="white" />
          <span class="q-ml-sm">Seguro de eliminar Registro.</span>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="Eliminar" color="deep-orange" @click="onDel" />
          <q-btn flat label="Cancelar" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
    <q-dialog v-model="modelpermiso">
      <q-card style="width: 700px;max-width: 80vw">
        <q-card-section class="bg-info">
          <div class="text-h6 text-white"><q-icon name="folder"/> Permisos Usuario</div>
        </q-card-section>
        <q-card-section>
          <q-form @submit.prevent="updatepermisos">
<!--          v-on:click.native="updatepermiso(permiso)"-->
          <q-checkbox style="width: 100%"  v-for="(permiso,index) in permisos2" :key="index" :label="permiso.nombre" v-model="permiso.estado" />
          <!--          <q-form>-->
<!--&lt;!&ndash;            <q-checkbox v-model="permisos" />&ndash;&gt;-->
<!--          </q-form>-->
            <q-btn  type="submit" color="info" icon="send" label="Actualizar"></q-btn>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
import { date } from 'quasar'
const { addToDate } = date

export default {
  data() {
    return {
      alert: false,
      dialog_mod: false,
      dialog_del: false,
      filter:'',
      dato: {
        fechalimite:date.formatDate( addToDate(new Date(),{days:7}) , 'YYYY-MM-DD')
      },
      model:'',
      dato2: {},
      options: [],
      props: [],
      permisos:[],
      permisos2:[],
      modelpermiso:false,
      uni:{},
      columns: [
        {name: "name", align: "left", label: "Nombre ", field: "name", sortable: true,},
        {name: "email", align: "left", label: "Email", field: "email", sortable: true,},
        {name: "fechalimite", align: "left", label: "Fecha limite", field: row=>date.formatDate(row.fechalimite  , 'DD/MM/YYYY'), sortable: true,
        },

        { name: "opcion", label: "Opcion", field: "action", sortable: false },
      ],
      data: [],
    };
  },
  created() {

    if (!this.$store.state.boolusuario){
      // this.router.push('/')
    }
    this.misdatos();

    this.$axios.get(process.env.API+'/permiso').then(res=>{
      // console.log(res.data)
      // this.permisos=res.data
      res.data.forEach(r=>{
          this.permisos.push({id:r.id,nombre:r.nombre,estado:false});
          this.permisos2.push({id:r.id,nombre:r.nombre,estado:false});
      });
    })
  },
  methods: {
      // updatepermiso(permiso){
      //   console.log(permiso)
      // },
    updatepermisos(){
      $q.dialog({
        title: 'Esta Seguro de Cambiar Permisos',
        message: 'Se modificara los permisos',
        cancel: true,
        persistent: true
      }).onOk(() => {
        // console.log('>>>> OK')
        this.$axios.put(process.env.API+'/updatepermisos/'+this.dato2.id,{permisos:this.permisos2}).then(res=>{
        console.log(res.data)
        this.modelpermiso=false
        this.misdatos()
      }).catch(err=>{
        this.$q.notify({
          message:err.response.data.message,
          icon:'close',
          color:'red'
        })
      })
      }).onOk(() => {
        // console.log('>>>> second OK catcher')
      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })

    },
    mispermisos(i){
      // console.log(i.row)
      this.modelpermiso=true
      this.dato2=i.row
      // console.log(this.dato2.permisos)
      let p;
      // this.permisos2.forEach(r=>{
      //
      // })
      this.permisos2.forEach(pe=>{
        // console.log(pe);
        p=this.dato2.permisos.find(r=>r.pivot.permiso_id==pe.id)
        // console.log(p)
        if (p!=undefined)
          pe.estado=true
        else
          pe.estado=false
        // console.log(p)
      })



    },
    misdatos() {
      this.$q.loading.show();
      this.$axios.get(process.env.API + "/user").then((res) => {
        // console.log(res.data)
        this.data = res.data;
        this.$q.loading.hide();
      });
    },

    editRow(item) {
      this.dato2 = item.row
      // console.log(this.dato2)
      this.dialog_mod = true;
    },
    deleteRow(item) {
      this.dato2 = item.row;
      this.dialog_del = true;
    },

    onSubmit() {
      this.$q.loading.show();
      // this.dato.unid_id=this.dato.unid_id.id;
      this.$axios.post(process.env.API + "/user", {
        name:this.dato.name,
        password:this.dato.password,
        email:this.dato.email,
        fechalimite:this.dato.fechalimite,
        permisos:this.permisos
      }).then((res) => {
        this.$q.notify({
          color: "green-4",
          textColor: "white",
          icon: "cloud_done",
          message: "Creado correctamente",
        });
        this.dato={fechalimite:date.formatDate(Date.now(), 'YYYY-MM-DD')}
        this.alert = false;
        this.misdatos();
      }).catch(err=>{
        console.log(err.response.data);
        this.$q.notify({
          message:err.response.data.message,
          icon:'close',
          color:'red'
        })
        this.$q.loading.hide()
      })
    },
    onMod() {
      this.$q.loading.show();
      this.$axios.put(process.env.API + "/user/" + this.dato2.id, {name:this.dato2.name,
        password:this.dato2.password,
        email:this.dato2.email,
        fechalimite:this.dato2.fechalimite,
      }).then((res) => {
          this.$q.notify({
            color: "green-4",
            textColor: "white",
            icon: "cloud_done",
            message: "Modificado correctamente",
          });
          this.dialog_mod = false;
          this.misdatos();
        });
    },

    onDel() {
      this.$q.loading.show();
      this.$axios.delete(process.env.API + "/user/" + this.dato2.id)
        .then((res) => {
        this.$q.notify({
          color: "green-4",
          textColor: "white",
          icon: "cloud_done",
          message: "Eliminado correctamente",
        });
        this.dialog_del = false;
        this.misdatos();
      }).catch(err=>{
        this.$q.loading.hide()
        this.$q.notify({
          message:err.response.data.message,
          icon:'error',
          color:'red'
        })
      })
    },

    onReset() {
      this.dato.nombre = null;
      this.dato.inicio = 0;
      this.dato.fin = 0;
    },
    cambiopass (i) {
      // console.log(i.row);
      this.$q.dialog({
        title: 'Cambiar password',
        message: 'Ingresar nueva contraseña',
        prompt: {
          model: '',
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        this.$q.loading.show()
        this.$axios.put(process.env.API+'/pass/'+i.row.id,{password:data}).then(res=>{
          this.$q.loading.hide()
        })
      }).onCancel(() => {
      }).onDismiss(() => {
      })
    }
  },
};
</script>
