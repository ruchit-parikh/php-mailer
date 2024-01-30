<script>
  export default {
    data() {
      return {value: '', error: null}
    },
    props: {options: {required: true, type: Array}, name: {type: String, required: true}},
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
  <select v-bind:name="name" v-model="value" class="form-control" v-bind="$attrs" @change="emitInput" :class="this.error !== null ? this.error ? 'is-invalid' : 'is-valid': ''">
    <option value="">Choose an option</option>
    <option v-for="option in options" v-bind:value="option.value">{{option.label}}</option>
  </select>
</template>
