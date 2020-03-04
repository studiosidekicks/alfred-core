<template>
  <div class="login">
    <div class="login__header">
      <img
        class="login__logo"
        src="@/assets/logo.svg" 
        width="100" 
        alt="Alfred">

      <h1 class="login__headline display-1">Log in</h1>
    </div>

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

      <v-row class="login__footer" no-gutters align="center">
        <v-col
          sm="12"
          md="6">
          <a href="">Forgot password?</a>
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
            this.$router.push({ path: this.redirect || '/' });
          })
          .catch(response => {
            this.validationErrors = response;
          })
          .finally(() => this.loading = false);
        } else {
          console.log('error submit!!');
          return false;
        }
    },
  },
};
</script>

<style lang="scss" scoped>
.login {
  width: 80%;
  max-width: 400px;
  padding: 2em;
  margin: 50px auto;
  border: 1px solid #ededed;
  border-radius: 4px;

  &__header {
    text-align: center;
  }

  &__headline {
    font-weight: 600;
    margin-bottom: 0.5em;
  }

  &__logo {
    margin-bottom: 1.5em;
  }

  &__footer {
    a {
      font-size: 14px;
      text-decoration: none;
    }
  }
}
</style>
