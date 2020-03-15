<template>
  <div>
    <h1 class="display-1">Website Tools</h1>

    <v-tabs 
      v-model="activeTab" 
      grow>
      <v-tabs-slider></v-tabs-slider>

      <v-tab 
        v-for="(tab, i) of tabs" 
        :key="i" 
        :to="tab.path"
        :value="i"
        v-permission="tab.meta.permissions">
        {{ tab.meta.title }}
      </v-tab>
    </v-tabs>

    <div class="tabs-inner">
      <router-view :key="key" />
    </div>
  </div>
</template>

<script>
import websiteToolsRoutes from '@/router/modules/websiteTools';
import permission from '@/directive/permission';

export default {
  name: 'website-tools',
  directives: {
    permission
  },
  computed: {
    key() {
      return this.$route.fullPath;
    },
  },
  data() {
    const tabs = websiteToolsRoutes[0].children[0].children.filter(route => !route.hidden);
    return {
      activeTab: 0,
      tabs
    };
  }
};
</script>