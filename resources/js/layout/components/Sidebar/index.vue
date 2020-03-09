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
      <v-list-item
        v-for="route in routes"
        :key="route.path"
        link
        :to="route.path"
      >
      <sidebar-item
        :key="route.path" 
        :item="route" 
        :base-path="route.path" />

      </v-list-item>
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
      'sidebar',
      'permission_routers',
    ]),
    routes() {
      return this.$store.state.permission.routes.filter(route => !route.hidden && route.children);
    }
  },
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