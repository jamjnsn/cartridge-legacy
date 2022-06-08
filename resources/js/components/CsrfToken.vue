<template>
	<input type="hidden" name="_token" :value="csrfToken" />
</template>

<script>
export default {
	computed: {
		csrfToken() {
			return window.csrfToken
		}
	}
}
</script>
