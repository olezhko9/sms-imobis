<template>
  <div class="container" id="app">
    <SmsImobis />
  </div>
</template>

<script>
import SmsImobis from './components/SmsImobis.vue'

export default {
  name: 'app',
  components: {
    SmsImobis
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
