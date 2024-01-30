<script>
  export default {
    props: {
      mailerAction: {required: true, type: Function},
      target: {required: true}
    },
    data() {
      return {loading: false}
    },
    methods: {
      enableLoading() {
        this.loading = true;
      },
      disableLoading() {
        this.loading = false;
      },
      submitForm(e)  {
        let target = this.$parent.$refs[this.$props.target];

        if (target && target.enableLoading) {
          target.enableLoading()
        } else {
          this.enableLoading()
        }

        return this.mailerAction(e)
          .catch(err => {
            let errors = [];

            if (err.response.data && err.response.data.errors) {
              for (let i in err.response.data.errors) {
                if (err.response.data.errors.hasOwnProperty(i)) {
                  errors.push({name: i, error: err.response.data.errors[i][0]})
                }
              }
            }

            this.$validatorBus.emit('mailerValidated', errors);
            this.$notificationBus.emit('mailerAlert', {message: err.response.data.message, type: 'danger', temporary: true})

            return err;
          })
          .finally(r => {
          if (target && target.disableLoading) {
            target.disableLoading()
          } else {
            this.disableLoading()
          }
        })
      }
    }
  }
</script>

<template>
  <div class="p-3 border rounded">
    <mailer-loader v-if="loading"></mailer-loader>
    <form @submit.prevent="submitForm" v-else>
      <slot></slot>
    </form>
  </div>
</template>
