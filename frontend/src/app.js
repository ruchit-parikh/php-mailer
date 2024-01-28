export default {
  data() {
    return {
      loading: false
    }
  },
  mounted() {
    this.$router.beforeEach((to, from, next) => {
      this.loading = true;

      next();
    })

    this.$router.afterEach(() => {
      this.loading = false;
    })
  }
}
