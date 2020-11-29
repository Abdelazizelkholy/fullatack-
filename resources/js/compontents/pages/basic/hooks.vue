<template>
  <div>
    <h1 ref="myref"> Hooks tutorial </h1>
    <p> My Name Is : {{ name }} </p>
  </div>
</template>
<script>
export default {
  data() {
    return {
      name: 'abdelaziz',
    }
  },
  beforeCreate() {
    console.log(this.name)
  },
  created() {
    console.log('data and other function is available but isn\'t html', this.name)
  },
  mounted() {
    console.log(this.$refs.myref)
  }
}
</script>