<template>
  <v-list-item 
    class="sidebar-item"
    v-if="hasOneShowingChild(item.children,item) && (!onlyOneChild.children||onlyOneChild.noShowingChildren)&&!item.alwaysShow"
    link
    :to="item.path"
    @click="menuItemClick(onlyOneChild)"
    >
    <v-list-item-icon>
      <v-icon>{{ onlyOneChild.meta.icon || item.meta.icon }}</v-icon>
    </v-list-item-icon>

    <v-list-item-title>{{onlyOneChild.meta.title}}</v-list-item-title>
  </v-list-item>

  <div v-else>
    <v-list-group
      v-for="item in item.children"
      :key="item.path"
      :prepend-icon="item.meta.icon"
      link
      :value="isMenuItemActive(item)">
      <template v-slot:activator>
        <v-list-item-title>{{ item.meta.title }}</v-list-item-title>
      </template>

      <v-list-item
        class="sidebar-item-child"
        v-for="(child, i) in item.children"
        :key="i"
        link
        :to="child.path"
        @click="menuItemClick(child)"
        >
        <v-list-item-icon>
          <v-icon>{{ child.meta.icon }}</v-icon>
        </v-list-item-icon>

        <v-list-item-title>{{ child.meta.title }}</v-list-item-title>
      </v-list-item>
    </v-list-group>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'SidebarItem',
  props: {
    // route object
    item: {
      type: Object,
      required: true,
    }
  },
  data() {
    return {
      onlyOneChild: null,
    };
  },
  computed: {
    ...mapState({
      sidebar: state => state.app.sidebar
    })
  },
  methods: {
    menuItemClick(menuItem) {
      if (this.$route.matched[0]) {
        this.$store.dispatch('app/setActiveMenuItemPath', {path: this.$route.matched[0].path});
      }
    },
    hasOneShowingChild(children, parent) {
      const showingChildren = children.filter(item => {
        if (item.hidden) {
          return false;
        } else {
          // Temp set(will be used if only has one showing child)
          this.onlyOneChild = item;
          return true;
        }
      });

      // When there is only one child router, the child router is displayed by default
      if (showingChildren.length === 1) {
        return true;
      }

      // Show parent if there are no child router to display
      if (showingChildren.length === 0) {
        this.onlyOneChild = { ... parent, path: '', noShowingChildren: true };
        return true;
      }

      return false;
    },
    isMenuItemActive(item) {
      return this.sidebar.activeMenuItemPath === item.path ? true : undefined;
    }
  },
};
</script>

<style lang="scss">
  .sidebar-item {
    display: flex;
    width: 100%;

    &-child {
      margin-left: 10px;
    }
  }

  .v-list-group__items > *:last-child {
    margin-bottom: 1em;
  }
</style>
