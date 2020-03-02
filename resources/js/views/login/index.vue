<template>
  <div class="login-container">
    <h1>Log in</h1>
    <v-form 
      v-model="valid" 
      ref="loginForm"
      name="loginForm"
      @submit.prevent="handleLogin">
      <v-container>
        <v-row>
          <v-text-field
            v-model="loginForm.email"
            :rules="loginRules.email"
            label="Login"
            outlined
            required
          ></v-text-field>
        </v-row>
        <v-row>
          <v-text-field
            v-model="loginForm.password"
            :rules="loginRules.password"
            type="password"
            label="Password"
            outlined
            required
          ></v-text-field>
        </v-row>
        <v-row>
          <v-btn 
            type="submit"
            :disabled="!valid"
            depressed 
            block
            large
            :loading="loading"
            color="primary">
            Log in
          </v-btn>
        </v-row>
      </v-container>
    </v-form>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data() {
    return {
      loginForm: {
        email: '',
        password: '',
      },
      loginRules: {
        email: [
          v => !!v || 'Login is required'
        ],
        password: [
          v => !!v || 'Password is required'
        ],
      },
      loading: false,
      redirect: undefined,
      valid: false
    };
  },
  watch: {
    $route: {
      handler: function(route) {
        this.redirect = route.query && route.query.redirect;
      },
      immediate: true,
    },
  },
  methods: {
    handleLogin() {
      if (this.$refs.loginForm.validate()) {
        this.loading = true;
        this.$store.dispatch('user/login', this.loginForm)
          .then(() => {
            this.$router.push({ path: this.redirect || '/' });
            this.loading = false;
          })
          .catch(() => {
            this.loading = false;
          });
        } else {
          console.log('error submit!!');
          return false;
        }
    },
  },
};
</script>

<style lang="scss" scoped>
.login-container {
  width: 80%;
  max-width: 400px;
  margin: 50px auto;
}
</style>
