<template>
	<transition name="fade">
		<div class="is-full-size">
			<div v-if="isLoading" class="loading-overlay">
				<loading-animation></loading-animation>
			</div>

			<not-found v-if="game == null && !isLoading" />

			<div class="game-details" v-if="game != null && !isLoading">
				<div class="backdrop" :style="screenshotOverlayStyle"></div>
				<div class="backdrop gradient-overlay"></div>

				<div class="columns">
					<div class="column cover-column">
						<img :src="game.cover" class="game-cover" />
						<div
							v-for="file in game.files"
							:key="file.id"
							class="download-button"
						>
							<a
								:href="file.download_url"
								class="button is-primary is-full-width"
								>Download ({{
									file.platform.data.abbreviation
								}})</a
							>
						</div>
					</div>
					<div class="column">
						<h2>{{ game.name }}</h2>
						<div
							class="game-description"
							v-html="game.description"
						></div>
					</div>
				</div>
			</div>
		</div>
	</transition>
</template>

<script>
import sanitizeHtml from 'sanitize-html'

export default {
	data() {
		return {
			game: null,
			isLoading: true,
		}
	},
	computed: {
		screenshotOverlayStyle() {
			return {
				backgroundImage: 'url(' + this.game.screenshot + ')',
				filter: 'blur(1px) grayscale(1)',
				opacity: '0.8',
				backgroundSize: 'cover',
				backgroundRepeat: 'no-repeat',
			}
		},
		description() {
			return sanitizeHtml(this.game.description)
		},
	},
	mounted() {
		this.$axios
			.get('/api/games/' + this.$route.params.slug)
			.then((res) => {
				return res.data
			})
			.then((game) => {
				this.isLoading = false
				this.game = game
			})
			.catch((error) => {
				// Game not found with slug
				this.isLoading = false
			})
	},
}
</script>

<style lang="scss"></style>
