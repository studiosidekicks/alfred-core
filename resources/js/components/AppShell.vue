<template>
  <div>
    <navbar></navbar>
    <main>
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
import Navbar from './Navbar';

export default {
  name: 'AppShell',
  components: {
    Navbar
  }
}
</script>