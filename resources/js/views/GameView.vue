<template>
	<transition name="fade">
		<div class="is-full-size">
			<div v-if="isLoading" class="loading-overlay">
				<loading-animation></loading-animation>
			</div>

			<not-found v-if="game == null && !isLoading" />

			<div class="game-details" v-if="game != null && !isLoading">
				<div
					class="screenshot-background"
					:style="screenshotOverlayStyle"
				></div>
				<div class="gradient-overlay"></div>

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
							class="content game-description"
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
				filter: 'blur(5px) grayscale(1)',
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

<style lang="scss">
.download-button:not(:first-child) {
	margin-top: 0.5rem;
}

.game-details {
	padding: 4rem;
	margin: 0 auto;
	max-width: 1024px;
	position: static;

	h2 {
		display: inline-block;
		line-height: 1;
		padding-bottom: 0.5rem;
		margin-bottom: 2rem;
		text-transform: uppercase;
		font-size: 2.5rem;
		border-bottom: 0.2em solid $primary;
		border-image: $fancy-gradient 30;
		background: $fancy-gradient;
		color: $primary;
		background-clip: text;
		-webkit-text-fill-color: transparent;
	}

	.game-description {
		font-size: 1.1rem;
	}

	.game-cover {
		box-shadow: rgba(0, 0, 0, 0.7) 0px 10px 30px;
		margin-bottom: 1rem;
		border-radius: 0.4em;
	}
}

.cover-column {
	padding-right: 3rem;
}

.screenshot-background,
.gradient-overlay {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 400px;
	z-index: -1;
}

.gradient-overlay {
	background: linear-gradient(
		177deg,
		transparentize($main-background, 1) 0%,
		transparentize($main-background, 0.5) 10%,
		transparentize($main-background, 0.25) 30%,
		transparentize($main-background, 0.1) 40%,
		transparentize($main-background, 0) 55%
	);
	height: 455px;
}

.screenshot-background {
	height: 400px;
	top: -10px;
	width: 140vw;
	left: 50%;
	transform: translateX(-50%);
}
</style>
