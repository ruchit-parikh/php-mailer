<script>
  export default {
    props: {
      color: {type: String, default: 'info'}
    }
  }
</script>

<template>
  <span class="badge" :style="'background-color: ' + color" v-bind="$attrs">
    <slot></slot>
  </span>
</template>
