<script>
  import Validator from "@/services/Validator.js";

  export default {
    data() {
      return {error: false}
    },
    props: {validations: {type: Array, default: []}, for: {required: true, type: String}},
    computed: {
      hasError() {
        return this.error || (typeof this.$parent.$parent.$refs[this.$props.for] !== 'undefined' &&
            typeof this.$parent.$parent.$refs[this.$props.for].error !== 'undefined' &&
            this.$parent.$parent.$refs[this.$props.for].error !== false);
      }
    },
    mounted() {
      this.$nextTick(() => {
        //TODO: As we dont have state we need to maintain this hierarchy or we need to implement a store/state system
        if (this.$parent.$parent.$refs[this.$props.for]) {
          this.$eventBus.on('mailerInput', (e) => {
            if (typeof e.target.name !== 'undefined' && e.target.name === this.$props.for) {
              let errors = Object.values(Validator.validate(e.target.value, this.$props.validations));

              this.error = errors.length ? errors[0].replace('%s', this.$props.for.replace(/-|_/gi, ' ')) : false;

              this.$parent.$parent.$refs[this.$props.for].error = this.error;

              if (this.error) {
                e.target.classList.remove('is-valid')
                e.target.classList.add('is-invalid')
              } else {
                e.target.classList.remove('is-invalid')
                e.target.classList.add('is-valid')
              }
            }
          })
        }
      })
    }
  }
</script>

<template>
  <div class="form-group mb-3" v-bind="$attrs">
    <slot></slot>
    <span class="text-danger" v-if="hasError">{{this.error ? this.error : this.$parent.$parent.$refs[this.$props.for].error}}</span>
  </div>
</template>
