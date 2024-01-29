<script>
  export default {
    data() {
      return {
        limit: 10,
        isLoading: false
      }
    },
    props: {
      loader: {
        type: Function,
        required: true,
      }
    },
    methods: {
      paginator(page) {
        this.isLoading = true;

        return this.loader(page, this.limit)
            .catch(err => this.$notificationBus.emit('mailerAlert', {type: 'danger', message: err.message, temporary: true}))
            .finally(() => this.isLoading = false)
      }
    }
  }
</script>
<template>
  <table class="table" v-bind="$attrs">
    <slot name="head"></slot>

    <mailer-tr class="text-center border-bottom" v-if="isLoading">
      <mailer-td :colspan="$attrs.colspan || 1">
        <mailer-loader class="table-loader"></mailer-loader>
      </mailer-td>
    </mailer-tr>
    <slot name="body" v-else></slot>

    <slot name="foot"></slot>
  </table>

  <mailer-paginator :paginator="paginator"></mailer-paginator>
</template>

<style>
.table-loader .spinner-border {
  --bs-spinner-width: 1.25rem;
  --bs-spinner-height: 1.25rem;
}
</style>
