window.Vue = require('vue').default

// Import axios
window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

// Import all Vue components
const files = require.context('./', true, /\.vue$/i)
files
	.keys()
	.map((key) =>
		Vue.component(key.split('/').pop().split('.')[0], files(key).default)
	)

// Create Vue app
const app = new Vue({
	el: '#app',
})
