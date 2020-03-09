<template>
  <v-alert type="error" v-if="validationErrors">
    <ul v-if="multiple">
      <li v-for="(value, key, index) in validationErrors">
        {{ value }}
      </li>
    </ul>
    <span v-if="!multiple">{{validationErrors}}</span>
  </v-alert>
</template>

<script>
export default {
  name: 'ValidationErrors',
  data: {
    multiple: true
  },
  props: {
    errors: null
  },
  computed: {
    validationErrors() {
      if (typeof this.errors === 'object') {
        this.multiple = true;
        let errors = Object.values(this.errors);
        return errors.flat();

      } else {
        this.multiple = false;
        return this.errors;
      }
    }
  }
};
</script>