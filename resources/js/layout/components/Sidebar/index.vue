<template>
  <div class="sidebar">
    <div class="sidebar__logo">
      <img
        src="@/assets/logo.svg" 
        width="100" 
        alt="Alfred">
    </div>

    <v-list
      class="sidebar__list"
      dense
      nav
    >
      <div
        v-for="route in routes"
        :key="route.path"
      >
        <sidebar-item
          :key="route.path" 
          :item="route">
        </sidebar-item>
      </div>
    </v-list>

  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import SidebarItem from './SidebarItem';

export default {
  components: { SidebarItem },
  computed: {
    ...mapGetters([
      'sidebar'
    ]),
    routes() {
      return this.$store.state.permission.routes.filter(route => !route.hidden && route.children);
    }
  },
  created() {
    if (this.$route.matched[0]) {
      this.$store.dispatch('app/setActiveMenuItemPath', { path: this.$route.matched[0].path });
    }
  }
};
</script>

<style lang="scss" scoped>
  .sidebar {
    padding: 1.5em;

    &__logo {
      text-align: center;
      margin-bottom: 1em;
    }

    &__list {
      padding: 0;
    }
  }
</style>