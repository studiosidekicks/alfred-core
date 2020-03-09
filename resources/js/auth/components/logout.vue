<template>
  <div>
    
  </div>
</template>

<script>
export default {
  name: 'Logout',
  mounted() {
    this.handleLogout();
  },
  methods: {
    handleLogout() {
      this.$store.dispatch('user/logout')
        .then(response => {
          this.$router.push({ name: 'auth.login', params: {message: response.message }})
        });
    },
  }
};
</script>