<template>
  <div class="navbar">
    <v-spacer></v-spacer>

    <v-btn icon :to="{name: 'my-account'}">
      <v-icon>face</v-icon>
    </v-btn>

    <v-btn icon :to="{name: 'auth.logout'}">
      <v-icon>power_settings_new</v-icon>
    </v-btn>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters([
      'sidebar'
    ]),
  },
  methods: {
    toggleSideBar() {
      this.$store.dispatch('app/toggleSideBar');
    },
    async logout() {
      await this.$store.dispatch('user/logout');
      this.$router.push(`/login?redirect=${this.$route.fullPath}`);
    },
  },
};
</script>

<style lang="scss" scoped>
  .navbar {
    display: flex;
    align-items: center;
    width: 100%;
  }
</style>