<script>
  export default {
    props: {
      'class': {default: 'btn btn-primary'}, 'type': {default: 'button'}
    },
    inheritAttrs: false,
    data() {
      return {loading: false}
    },
    methods: {
      enableLoading() {
        this.loading = true;
      },
      disableLoading() {
        this.loading = false;
      }
    },
    computed: {
      mergedAttributes() {
        return {
          ...this.$props,
          ...this.$attrs,
        };
      },
    },
  }
</script>

<template>
  <button v-bind="mergedAttributes" :disabled="loading || mergedAttributes.disable">
    <div v-if="loading" class="d-flex align-items-center">
      <mailer-loader class="button-loader"></mailer-loader>&nbsp;&nbsp;Loading...
    </div>
    <slot v-else></slot>
  </button>
</template>

<style>
  .button-loader .spinner-border {
    --bs-spinner-width: 1.25rem;
    --bs-spinner-height: 1.25rem;
  }
</style>
