<template>
  <div>
    <v-progress-circular
      v-if="isLoading"
      indeterminate
      color="primary"
    ></v-progress-circular>

    <div v-else>
      List here.
    </div>
  </div>
</template>

<script>
import { getGroupsList } from '@/api/groups';

export default {
  name: 'cmsGroupsList',
  data() {
    return {
      isLoading: false,
      list: null
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      this.isLoading = true;
      getGroupsList()
        .then(response => {
          console.log(response);
        })
        .finally(() => {
          this.isLoading = false;
        });
    }
  }
};
</script>