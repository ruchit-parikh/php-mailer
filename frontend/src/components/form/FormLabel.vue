<script>
  export default {
    props: {
      label: {
        type: String,
        required: true
      },
      required: {
        type: Boolean,
        default: false
      }
    }
  }
</script>

<template>
  <label class="form-label" v-bind="$attrs">
    {{label}}<span class="text-danger" v-if="required">&nbsp;*</span>
    <slot></slot>
  </label>
</template>
