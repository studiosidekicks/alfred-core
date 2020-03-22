<template>
  <div class="container-narrow">
    <h1 class="display-1">My Account</h1>

    <v-progress-circular
      v-if="isLoading"
      indeterminate
      color="primary"
    ></v-progress-circular>

    <div v-else>
      <validation-errors v-if="validationErrors" :errors="validationErrors"></validation-errors>

      <v-form 
        v-model="valid" 
        ref="myAccountForm"
        name="myAccountForm"
        @submit.prevent="save">

        <v-row>
          <v-col sm="12" md="6">
            <v-text-field
              v-model="myAccountForm.first_name"
              :rules="myAccountRules.first_name"
              label="First Name"
              outlined
              required
            ></v-text-field>
          </v-col>

          <v-col sm="12" md="6">
            <v-text-field
              v-model="myAccountForm.last_name"
              :rules="myAccountRules.last_name"
              label="Last Name"
              outlined
              required
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row no-gutters>
          <v-text-field
            v-model="myAccountForm.email"
            :rules="myAccountRules.email"
            label="Email"
            type="email"
            outlined
            required
          ></v-text-field>
        </v-row>

        <v-row no-gutters>
          <v-select
            v-model="myAccountForm.role_id"
            :rules="myAccountRules.role_id"
            :items="groups"
            item-text="name"
            item-value="id"
            label="Group"
            required
            outlined
          ></v-select>
        </v-row>

        <v-row no-gutters>
          <v-btn 
            type="submit"
            :disabled="!valid"
            depressed 
            large
            color="primary">
            Save
          </v-btn>
        </v-row>
      </v-form>
    </div>
  </div>
</template>

<script>
import { getInfo } from '@/api/myAccount';

export default {
  name: 'myAccount',
    data() {
    return {
      isLoading: true,
      myAccountForm: null,
      myAccountRules: {
        first_name: [
          v => !!v || 'First Name is required'
        ],
        last_name: [
          v => !!v || 'Last Name is required'
        ],
        email: [
          v => !!v || 'Last Name is required'
        ],
        role_id: [
          v => !!v || 'Group is required'
        ]
      },
      groups: [],
      validationErrors: null,
      valid: false
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      this.isLoading = true;

      getInfo()
        .then(response => {
          this.myAccountForm = response.data;
          this.groups = response.groups;
        })
        .finally(() => {
          this.isLoading = false;
        });
    },

    save() {
      console.log(123);
    }
  }
};
</script>