<script>
  export default {
    props: {options: {required: true, type: Array}, value: {type: Object}, name: {type: String, required: true}},
    computed: {
      isEntered() {
        return typeof this.$parent.$refs[this.$props.name] !== 'undefined' && typeof this.$parent.$refs[this.$props.name].error !== 'undefined';
      },
      hasError() {
        return typeof this.$parent.$refs[this.$props.name] !== 'undefined' && typeof this.$parent.$refs[this.$props.name].error !== 'undefined' && this.$parent.$refs[this.$props.name].error !== false;
      },
    },
    methods: {
      emitInput(e) {
        this.$eventBus.emit('mailerInput', e)
      }
    }
  }
</script>

<template>
  <select v-bind:name="name" class="form-control" v-bind="$attrs" @change="emitInput" :class="isEntered ? hasError ? 'is-invalid' : 'is-valid': ''">
    <option value="">Choose an option</option>
    <option v-for="option in options" v-bind:value="option.value">{{option.label}}</option>
  </select>
</template>
