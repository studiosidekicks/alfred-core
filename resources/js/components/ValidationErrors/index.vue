<template>
  <v-alert type="error" v-if="validationErrors">
    <ul>
      <li v-for="(value, key, index) in validationErrors">
        {{ value }}
      </li>
    </ul>
  </v-alert>
</template>

<script>
export default {
  name: 'ValidationErrors',
  props: {
    errors: null
  },
  computed: {
    validationErrors() {
      let errors = Object.values(this.errors);
      return errors.flat();
    }
  }
};
</script>