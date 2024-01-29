export default {
  data() {
    return {
      loading: false,
      notifications: []
    }
  },
  computed: {
    temporaryNotifications() {
      return this.notifications.filter(n => n.temporary)
    },
    persistentNotifications() {
      return this.notifications.filter(n => !n.temporary)
    }
  },
  mounted() {
    this.$router.beforeEach((to, from, next) => {
      this.loading = true;
      this.notifications = this.persistentNotifications

      next();
    })

    this.$router.afterEach(() => {
      this.loading = false;
    })

    this.$nextTick(() => {
      this.$notificationBus.on('mailerAlert', (e) => {
        if (!this.notifications.filter(n => n.type === e.type && n.message === e.message).length) {
          this.notifications = this.persistentNotifications;
          this.notifications.push(e)
        }
      })
    })

    this.$nextTick(() => {
      this.$notificationBus.on('mailerAlertRemoved', (e) => {
        this.notifications = this.notifications.filter(n => n.type !== e.type || n.message !== e.message)
      })
    })
  }
}
