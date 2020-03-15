<template>
  <div>
    <h1 class="display-1">Log in</h1>

    <v-alert type="success" v-if="message">{{message}}</v-alert>
    
    <validation-errors v-if="validationErrors" :errors="validationErrors"></validation-errors>

    <v-form 
      v-model="valid" 
      ref="loginForm"
      name="loginForm"
      @submit.prevent="handleLogin">

      <v-row no-gutters>
        <v-text-field
          v-model="loginForm.email"
          :rules="loginRules.email"
          label="Login"
          outlined
          required
        ></v-text-field>
      </v-row>
      
      <v-row no-gutters>
        <v-text-field
          v-model="loginForm.password"
          :rules="loginRules.password"
          type="password"
          label="Password"
          outlined
          required
        ></v-text-field>
      </v-row>

      <v-row class="login-footer" no-gutters align="center">
        <v-col
          sm="12"
          md="6">
          <router-link
            class="layout-auth-footer-link" 
            :to="{name: 'auth.forgot-password'}">
            Forgot password?
          </router-link>
        </v-col>
        <v-col
          class="text-right"
          sm="12"
          md="6">
          <v-btn 
            type="submit"
            :disabled="!valid"
            depressed 
            large
            :loading="loading"
            color="primary">
            Log in
          </v-btn>
        </v-col>
      </v-row>
    </v-form>
  </div>
</template>

<script>
import ValidationErrors from '@/components/ValidationErrors';

export default {
  components: {
    ValidationErrors
  },
  name: 'Login',
  props: {
    message: null
  },
  data() {
    return {
      loginForm: {
        email: '',
        password: ''
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
      valid: false,
      validationErrors: null
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
        this.validationErrors = null;
        this.loading = true;

        this.$store.dispatch('user/login', this.loginForm)
          .then(() => {
            this.$router.push({ path: this.redirect || '/dashboard' }).catch(e => {});
          })
          .catch(response => {
            this.validationErrors = response;
          })
          .finally(() => this.loading = false);

        } else {
          return false;
        }
    }
  }
};
</script>