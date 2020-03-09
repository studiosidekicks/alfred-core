<template>
  <div>
    <h1 class="display-1">Forgot password?</h1>

    <validation-errors v-if="validationErrors" :errors="validationErrors"></validation-errors>

    <v-form 
      v-model="valid" 
      ref="forgotPasswordForm"
      name="forgotPasswordForm"
      @submit.prevent="handleForm">

      <v-row no-gutters>
        <v-text-field
          v-model="forgotPasswordForm.email"
          :rules="forgotPasswordRules.email"
          label="Login"
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
            :to="{name: 'auth.login'}">
            Log in
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
            Submit
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
  name: 'ForgotPassword',
  props: {
    message: null
  },
  data() {
    return {
      forgotPasswordForm: {
        email: ''
      },
      forgotPasswordRules: {
        email: [
          v => !!v || 'Login is required'
        ]
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
    handleForm() {
      if (this.$refs.forgotPasswordForm.validate()) {
        this.validationErrors = null;
        this.loading = true;

        /*
        this.$store.dispatch('user/login', this.loginForm)
          .then(() => {
            this.$router.push({ path: this.redirect || '/' });
          })
          .catch(response => {
            this.validationErrors = response;
          })
          .finally(() => this.loading = false);
        } else {
          console.log('error submit!!');
          return false;
        }*/
      }
    }
  }
};
</script>