<template>

  <q-page>
  <br>
  <div class="">
    <q-badge class="full-width text-h5 flex flex-center" color="orange" text-color="black" v-for="(r,index) in cliente" :key="index"><b>FECHA: &nbsp;</b>{{r.mes}}/{{r.dia}}  &nbsp;&nbsp;<b>LOCAL: &nbsp;</b>{{r.local}}  &nbsp;&nbsp;<b>TITULAR: &nbsp;</b>{{r.titular}} </q-badge>

  </div>
  <br>
  <div class="flex flex-center">
    <img 
      alt="Quasar logo"
      src="logo.png"
      style="width: 400px; height: 200px"
    >
  </div>
  </q-page>
</template>

<script>
import { defineComponent } from 'vue';

export default {
  data() {
    return {
    name: 'PageIndex',
    cliente:[]
      };
  },
  created()  {
      this.$axios.get(process.env.API + "/aniver").then(res => {
        console.log(res.data)
        this.cliente=res.data;
      })
    
  },
};
</script>
