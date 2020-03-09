<template>
  <div class="layout-auth">
    <div class="layout-auth__header">
      <img
        class="layout-auth__logo"
        src="@/assets/logo.svg" 
        width="100" 
        alt="Alfred">
    </div>

    <transition name="fade-transform" mode="out-in">
      <router-view />
    </transition>
  </div>
</template>

<script>
export default {
  name: 'AuthLayout'
};
</script>

<style lang="scss">
.layout-auth {
  width: 80%;
  max-width: 400px;
  padding: 2em;
  margin: 50px auto;
  border: 1px solid #ededed;
  border-radius: 4px;

  &__header {
    text-align: center;
  }

  &__headline {
    font-weight: 600;
    margin-bottom: 0.5em;
  }

  &__logo {
    margin-bottom: 1.5em;
  }

  &-footer-link {
    font-size: 14px;
    text-decoration: none;

    &:hover {
      color: #222;
    }
  }
}
</style>