<template>
  <div>
    <v-navigation-drawer app>
      <sidebar />
    </v-navigation-drawer>

    <v-app-bar app>
      <navbar />
    </v-app-bar>
    
    <v-content>
      <app-main />
    </v-content>
  </div>
</template>

<script>
import { Navbar, Sidebar, AppMain } from './components';

export default {
  name: 'Layout',
  components: {
    AppMain,
    Navbar,
    Sidebar,
  }
};
</script>