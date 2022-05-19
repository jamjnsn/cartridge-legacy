<template>
	<transition name="fade">
		<div class="search">
			<div v-if="isLoading" class="loading-overlay">
				<loading-animation></loading-animation>
			</div>

			<h2 v-if="!isLoading" class="results-title">
				Search results for "{{ searchQuery }}"
			</h2>

			<game-list v-if="!isLoading" :games="games" />
		</div>
	</transition>
</template>

<script>
export default {
	data() {
		return {
			games: [],
			isLoading: true,
		}
	},
	computed: {
		searchQuery() {
			return this.$route.params.query ?? ''
		},
	},
	beforeMount() {},
	mounted() {
		if (this.searchQuery == '') {
			router.go('/')
		} else {
		}
	},
}
</script>

<style lang="scss">
.search {
	height: 100%;
	display: flex;
	flex-direction: column;
	padding: 0.75rem;
}

.results-title {
	padding: 0.75em;
}
</style>
