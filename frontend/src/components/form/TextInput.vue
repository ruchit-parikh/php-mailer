<script>
  export default {
    props: {value: {type: String}, name: {type: String, required: true}},
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
  <input v-bind:name="name" @blur="emitInput" @input="emitInput" type="text" :class="isEntered ? hasError ? 'is-invalid' : 'is-valid': ''" class="form-control" v-bind="$attrs" v-bind:value="value" />
</template>
