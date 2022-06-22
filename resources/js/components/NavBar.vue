<template>
	<nav>
		<div class="menu-container">
			<a href="/" class="logo"><app-logo></app-logo></a>
			<div id="menu">
				<form ref="logout" action="/logout" method="POST">
					<csrf-token />
				</form>
				<div class="menu-item"><a href="/admin">Admin</a></div>
				<div class="menu-item">
					<a @click="submitLogout">Logout</a>
				</div>
			</div>
		</div>

		<div class="search-container">
			<div class="search" @click="$refs.query.focus()">
				<inline-svg
					src="icons/slash.svg"
					class="search-shortcut-icon"
				></inline-svg>
				<input
					v-model="query"
					type="text"
					ref="query"
					name="query"
					placeholder="Search..."
				/>
			</div>
		</div>
	</nav>
</template>

<script>
import CsrfToken from './CsrfToken.vue'
export default {
	components: { CsrfToken },
	methods: {},
	data() {
		return {
			query: '',
		}
	},
	created() {
		window.addEventListener('keypress', this.onKeyPress)
	},
	beforeDestroy() {
		window.removeEventListener('keypress', this.onKeyPress)
	},
	methods: {
		submitLogout() {
			console.log(this.$refs.logout)
			this.$refs.logout.submit()
		},
		onKeyPress(e) {
			if (e.key === '/') {
				e.preventDefault()
				this.$refs.query.focus()
			}
		},
	},
}
</script>

<style scoped lang="scss">
$menu-height: 85px;

nav {
	z-index: 50;
	background: $black-light;
	display: flex;
	flex: 0 0 auto;
	align-items: center;
	height: $menu-height;

	& > * {
		height: 100%;
	}
}

.menu-container {
	display: flex;
	align-items: center;
	z-index: initial;

	&:hover {
		#menu {
			display: block;
		}

		.logo {
			transform: scale(1.1);
			filter: drop-shadow(0 0.01em 0.2em $black)
				drop-shadow(0 0.01em 0.4em $primary);
		}
	}
}

#menu {
	z-index: -1;
	position: absolute;
	display: none;
	width: 16em;
	top: 100%;
	padding: 1rem 1rem 1rem 0;
	border-radius: 0 0 0.5em 0;
	box-shadow: 0 0.9em 1em #111;
	background: $black-light
		linear-gradient(
			179deg,
			rgba(255, 255, 255, 0) 0%,
			lighten($black-light, 2%) 100%
		);

	& > .menu-item {
		display: block;
		border-radius: 0 0.25em 0.25em 0;
		background-color: $black-lighter;
		transition: background 0.1s ease;

		a {
			cursor: pointer;
			display: block;
			width: 100%;
			height: 100%;
			color: $white;
			padding: 1rem;
		}

		&:not(:last-child) {
			margin-bottom: 0.5em;
		}

		&:hover {
			background: $primary;
		}
	}
}

.logo {
	flex: 0 0 auto;
	display: block;
	width: 3.5em;
	height: auto;
	margin-left: 1rem;
	padding: 1rem;
	transform: scale(1);
	transition: transform 0.1s ease, filter 0.2s ease;
	filter: drop-shadow(0 0.01em 0.4em $black-light);
}

.search-container {
	padding: 1rem;
	display: flex;
	align-items: center;
	flex: 1 1 auto;

	.search {
		display: flex;
		flex-direction: row;
		align-items: center;
		width: 100%;
		background-color: $grey-darker;
		border-radius: 0.4em;
		padding: 0.75em 1em;
		border: 0.2em solid transparent;
		transform: scale(1);
		transition: transform 0.1s ease;

		&:focus-within {
			transform: scale(1.01);
			border-color: $primary;
			box-shadow: 0 0.1em 0.8em transparentize($primary, 0.65);

			input {
				color: $grey-lighter;
			}
		}
	}

	.search-shortcut-icon {
		fill: currentColor;
		opacity: 0.3;
		margin-right: 0.5em;
		height: 1em;
		width: auto;
	}

	input {
		display: block;
		width: 100%;
		height: 100%;
		border: none;
		outline: none;
		color: $grey;
		background: transparent;

		transition: border-color 0.1s ease;
	}
}
</style>
