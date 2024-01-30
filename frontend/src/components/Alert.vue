<script>
  export default {
    props: {
      message: {type: String, required: true},
      type: {default: 'info'}
    },
    methods: {
      removeSelf() {
        this.$notificationBus.emit('mailerAlertRemoved', {type: this.type, message: this.message})
      }
    }
  }
</script>

<template>
  <div v-bind="$attrs" :class="'alert-' + type" class="d-flex justify-content-between alert alert-dismissible fade show" role="alert">
    {{message}}
    <button @click="removeSelf" class="btn btn-transparent alert-close-btn text-decoration-none" data-dismiss="alert" aria-label="Close">X</button>
  </div>
</template>

<style>
  .alert .btn.alert-close-btn {
    font-size: 0.9rem;
    line-height: 1rem;
  }
</style>
