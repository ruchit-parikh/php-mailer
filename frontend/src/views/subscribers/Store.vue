<script>
import Subscriber from "@/entities/Subscriber.js";
import SubscriberRepository from "@/repositories/SubscribersRepository.js";

export default {
  data() {
    return {
      firstName: '',
      lastName: '',
      email:'',
      status: '',
      possibleStatus: Object.values(Subscriber.getPossibleStatus()),
    }
  },
  methods: {
    saveSubscriber() {
      return SubscriberRepository.store({
        first_name: this.firstName,
        last_name: this.lastName,
        email: this.email,
        status: this.status
      })
      .then(r => {
        this.$router.push({path: '/'})

        this.$notificationBus.emit('mailerAlert', {message: r.message, type: 'success'})

        return r;
      })
    },
  }
}
</script>

<template>
  <div class="col-md-12">
    <mailer-form :mailerAction="saveSubscriber" target="submitBtn">
      <h4 class="mb-3">Create New Subscriber</h4>
      <div class="row">
        <div class="col-md-6">
          <mailer-form-group for="first_name" :validations="['required']">
            <mailer-label :required="true" for="firstName" label="First Name"></mailer-label>
            <mailer-text v-model="firstName" name="first_name" id="firstName" placeholder="Enter first name" />
          </mailer-form-group>
        </div>
        <div class="col-md-6">
          <mailer-form-group for="last_name" :validations="['required']">
            <mailer-label :required="true" for="lastName" label="Last Name"></mailer-label>
            <mailer-text v-model="lastName" name="last_name" id="lastName" placeholder="Enter last name" />
          </mailer-form-group>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <mailer-form-group for="email" :validations="['required', 'email']">
            <mailer-label :required="true" for="email" label="Email"></mailer-label>
            <mailer-email v-model="email" name="email" id="email" placeholder="Enter your email" />
          </mailer-form-group>
        </div>
        <div class="col-md-6">
          <mailer-form-group for="status" :validations="['required', 'inArray:' + Object.keys(possibleStatus).join(',')]">
            <mailer-label :required="true" for="status" label="Status"></mailer-label>
            <mailer-select v-model="status" :options="possibleStatus" name="status" id="status" />
          </mailer-form-group>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <mailer-button type="submit" class="btn-success" ref="submitBtn">Submit</mailer-button>
        </div>
      </div>
    </mailer-form>
  </div>
</template>
