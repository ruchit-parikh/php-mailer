import { createApp } from 'vue'
import mitt from 'mitt';
import App from './App.vue'
import router from './router/index.js'
import './assets/main.css'
import Loader from '@/components/Loader.vue'
import FormGroup from '@/components/form/FormGroup.vue'
import FormLabel from '@/components/form/FormLabel.vue'
import Button from '@/components/Button.vue'
import TextInput from '@/components/form/TextInput.vue'
import EmailInput from '@/components/form/EmailInput.vue'
import SelectInput from '@/components/form/SelectInput.vue'
import Form from '@/components/Form.vue'

const app = createApp(App)

app.component('mailer-loader', Loader)
app.component('mailer-form-group', FormGroup);
app.component('mailer-label', FormLabel);
app.component('mailer-button', Button)
app.component('mailer-text', TextInput)
app.component('mailer-email', EmailInput)
app.component('mailer-select', SelectInput)
app.component('mailer-form', Form)

app.use(router)
app.use({
  install: (app, options) => {
    app.config.globalProperties.$eventBus = mitt();
  }
});

app.mount('#app')
