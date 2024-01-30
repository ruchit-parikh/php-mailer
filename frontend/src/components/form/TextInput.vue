<script>
  export default {
    data() {
      return {value: '', error: null}
    },
    props: {name: {type: String, required: true}},
    methods: {
      emitInput(e) {
        this.$validatorBus.emit('mailerInput', e)
      }
    },
    mounted() {
      this.$nextTick(() => {
        this.$validatorBus.on('mailerValidated', (errors) => {
          for (let i in errors) {
            if (errors.hasOwnProperty(i) && errors[i].name == this.$props.name) {
              this.error = errors[i].error;
              break;
            }
          }
        })
      })
    }
  }
</script>

<template>
  <input v-bind:name="name" @blur="emitInput" @input="emitInput" type="text" :class="this.error !== null ? this.error ? 'is-invalid' : 'is-valid': ''" class="form-control" v-bind="$attrs" v-model="value" />
</template>
