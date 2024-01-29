import { createApp } from 'vue'
import mitt from 'mitt';
import App from './App.vue'
import router from './router/index.js'
import './assets/main.css'
import Loader from '@/components/Loader.vue'
import Badge from '@/components/Badge.vue'
import Alert from '@/components/Alert.vue'
import FormGroup from '@/components/form/FormGroup.vue'
import FormLabel from '@/components/form/FormLabel.vue'
import Button from '@/components/Button.vue'
import TextInput from '@/components/form/TextInput.vue'
import EmailInput from '@/components/form/EmailInput.vue'
import SelectInput from '@/components/form/SelectInput.vue'
import Form from '@/components/Form.vue'
import Paginator from '@/components/Paginator.vue'
import Table from '@/components/table/Table.vue'
import Thead from '@/components/table/Thead.vue'
import Tbody from '@/components/table/Tbody.vue'
import Tfoot from '@/components/table/Tfoot.vue'
import Th from '@/components/table/Th.vue'
import Tr from '@/components/table/Tr.vue'
import Td from '@/components/table/Td.vue'

const app = createApp(App)

app.component('mailer-loader', Loader)
app.component('alert', Alert)
app.component('mailer-badge', Badge)
app.component('mailer-paginator', Paginator)
app.component('mailer-form-group', FormGroup)
app.component('mailer-label', FormLabel);
app.component('mailer-button', Button)
app.component('mailer-text', TextInput)
app.component('mailer-email', EmailInput)
app.component('mailer-select', SelectInput)
app.component('mailer-form', Form)
app.component('mailer-table', Table)
app.component('mailer-thead', Thead)
app.component('mailer-tbody', Tbody)
app.component('mailer-tfoot', Tfoot)
app.component('mailer-th', Th)
app.component('mailer-tr', Tr)
app.component('mailer-td', Td)

app.use(router)
app.use({
  install: (app, options) => {
    app.config.globalProperties.$notificationBus = mitt()
    app.config.globalProperties.$validatorBus = mitt()
  }
});

app.mount('#app')
