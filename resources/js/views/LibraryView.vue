<template>
	<transition name="fade">
		<div class="library">
			<div v-if="isLoading" class="loading-overlay">
				<loading-animation></loading-animation>
			</div>

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
	mounted() {
		this.$axios
			.get('/api/games')
			.then((res) => {
				return res.data
			})
			.then((games) => {
				this.games = games
				this.isLoading = false
			})
	},
}
</script>

<style lang="scss">
.library {
	height: 100%;
	display: flex;
	flex-direction: column;
	padding: 0.75rem;
}

.results-title {
	padding: 0.75em;
}
</style>
