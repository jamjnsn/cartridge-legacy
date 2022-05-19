import Vue from 'vue'
import VueRouter from 'vue-router'

// Inline SVG component
import InlineSvg from 'vue-inline-svg'
Vue.component('inline-svg', InlineSvg)

// Import axios
Vue.prototype.$axios = require('axios')
Vue.prototype.$axios.defaults.headers.common['X-Requested-With'] =
	'XMLHttpRequest'

// Routes
Vue.use(VueRouter)
import routes from './routes'
const router = new VueRouter({
	routes,
})

// Import all Vue components
const files = require.context('./', true, /\.vue$/i)
files
	.keys()
	.map((key) =>
		Vue.component(key.split('/').pop().split('.')[0], files(key).default)
	)

// Create Vue app
const app = new Vue({
	router,
}).$mount('#app')
