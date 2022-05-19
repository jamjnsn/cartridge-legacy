<template>
	<div class="games">
		<div v-for="game in games" :key="game.id" class="game">
			<router-link :to="'/games/' + game.slug">
				<img :src="game.cover" :alt="game.name" />
			</router-link>
		</div>

		<!-- Add a bunch of spacers to properly wrap flexbox -->
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
	</div>
</template>

<script>
export default {
	props: ['games'],
}
</script>

<style lang="scss">
$glow-primary: transparentize($primary, 0.2);
$glow-secondary: transparentize($secondary, 0.2);

@keyframes glow {
	0% {
		box-shadow: 0 0.02em 1em $black, 0 0 0 $glow-primary,
			0 0 0 $glow-secondary;
	}

	20% {
		box-shadow: 0 0.02em 1em $black, 1em 0 3em $glow-primary,
			0 0 1em $glow-secondary;
	}

	100% {
		box-shadow: 0 0.02em 1em $black, 0 0 1em $glow-primary,
			1em 0 3em $glow-secondary;
	}
}

.games {
	padding: 2rem;
	display: flex;
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
}

.game,
.spacer {
	flex: 1 1 200px;
}

.game {
	position: relative;
	z-index: 10;
	padding: 0.75rem;
	transition: transform 0.1s ease, box-shadow 0.1s ease;
	cursor: pointer;

	&:hover {
		transform: scale(1.1);
		z-index: 11;

		img {
			animation-name: glow;
			animation-duration: 3s;
			animation-iteration-count: infinite;
			animation-direction: alternate;
			animation-timing-function: linear;
		}
	}

	img {
		position: relative;
		object-fit: cover;
		width: 100%;
		height: 100%;
		display: block;
		border-radius: 0.25em;
		transition: filter 0.2s ease-in-out;
	}
}
</style>
