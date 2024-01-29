<script>
  import SubscriberRepository from "@/repositories/SubscribersRepository.js";

  export default {
    data() {
      return {
        /**
         * @var {Subscriber[]}
         */
        subscribers: []
      }
    },
    methods: {
      /**
       * @param {int} page
       * @param {int} limit
       *
       * @returns {Promise}
       */
      loadSubscribers(page, limit) {
        return SubscriberRepository.getPaginated(page, limit)
          .then(r => {
            this.subscribers = r.data

            return r;
          })
      }
    }
  }
</script>

<template>
  <h3>List of subscribers</h3>
  <mailer-table :loader="loadSubscribers" colspan="4">
    <template v-slot:head>
      <mailer-thead>
        <mailer-tr>
          <mailer-th>Name</mailer-th>
          <mailer-th>Email</mailer-th>
          <mailer-th>Status</mailer-th>
          <mailer-th>Subscribed At</mailer-th>
        </mailer-tr>
      </mailer-thead>
    </template>

    <template v-slot:body>
      <mailer-tbody>
        <mailer-tr v-if="subscribers.length > 0" v-for="subscriber in subscribers">
          <mailer-td>{{subscriber.getName()}}</mailer-td>
          <mailer-td>{{subscriber.getEmail()}}</mailer-td>
          <mailer-td>
            <mailer-badge :color="subscriber.getStatsColor()">{{subscriber.getStatusLabel()}}</mailer-badge>
          </mailer-td>
          <mailer-td>{{subscriber.getSubscribedAt()}}</mailer-td>
        </mailer-tr>
        <mailer-tr v-else class="text-center">
          <mailer-td colspan="4" aria-colspan="4">No subscribers are created yet.</mailer-td>
        </mailer-tr>
      </mailer-tbody>
    </template>
  </mailer-table>
</template>
