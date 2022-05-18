<template>
	<nav>
		<a href="/" class="logo"><app-logo></app-logo></a>
		<div class="search-container">
			<input type="text" />
		</div>
	</nav>
</template>

<style scoped lang="scss">
nav {
	background: $black-light;
	padding: 1rem;
	display: flex;
	flex: 0 0 auto;
	align-items: center;
}

.logo {
	flex: 0 0 auto;
	display: block;
	width: 35px;
	height: 35px;
	transform: scale(1);
	transition: transform 0.1s ease;
	margin-right: 1.5rem;
	margin-left: 0.5rem;

	&:hover {
		transform: scale(1.1);
		filter: drop-shadow(0 0.01em 0.4em $primary);
	}
}

.search-container {
	flex: 1 1 auto;

	input {
		display: block;
		width: 100%;
		height: 100%;
		border: none;
		outline: none;
		background-color: $grey-darker;
		border-radius: 0.4em;
		padding: 0.5em 0.75em;
		font-size: 1.1em;
		color: $grey-lighter;
		border: 0.2em solid transparent;

		&:focus {
			border-color: $primary;
			box-shadow: 0 0.1em 0.8em transparentize($primary, 0.65);
		}
	}
}
</style>
