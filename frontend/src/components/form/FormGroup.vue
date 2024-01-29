<script>
  import Validator from "@/services/Validator.js";

  export default {
    data() {
      return {error: false}
    },
    props: {validations: {type: Array, default: []}, for: {required: true, type: String}},
    mounted() {
      this.$validatorBus.on('mailerValidated', (errors) => {
        for (let i in errors) {
          if (errors.hasOwnProperty(i) && errors[i].name == this.$props.for) {
            this.error = errors[i].error;
            break;
          }
        }
      })
      this.$nextTick(() => {
        this.$validatorBus.on('mailerInput', (e) => {
          if (typeof e.target.name !== 'undefined' && e.target.name === this.$props.for) {
            let errors = Object.values(Validator.validate(e.target.value, this.$props.validations));

            this.error = errors.length ? errors[0].replace('%s', this.$props.for.replace(/-|_/gi, ' ')) : false;

            this.$validatorBus.emit('mailerValidated', [{name: this.$props.for, error: this.error}])
          }
        })
      })
    }
  }
</script>

<template>
  <div class="form-group mb-3" v-bind="$attrs">
    <slot></slot>
    <span class="text-danger" v-if="this.error !== false">{{this.error}}</span>
  </div>
</template>
