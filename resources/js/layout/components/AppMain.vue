<template>
  <div class="app-main">
    <transition name="fade-transform" mode="out-in">
      <router-view :key="key" />
    </transition>
  </div>
</template>

<script>
export default {
  name: 'AppMain',
  computed: {
    key() {
      return this.$route.fullPath;
    },
  },
};
</script>

<style lang="scss">
  .app-main {
    padding: 2em;
  }
</style>