<template>
	<div class="icon">
		<vue-feather class="feather" :size="size" :type="type"></vue-feather>
	</div>
</template>

<script>
import VueFeather from 'vue-feather'

export default {
	props: {
		type: {
			type: String,
			required: true,
		},
		size: {
			type: Number,
			default: '16',
		},
	},
	components: {
		VueFeather,
	},
}
</script>

<style lang="scss">
.icon {
	display: inline-flex;
	align-items: center;
	justify-content: center;

	.feather {
		object-fit: contain;
		object-position: center center;
	}
}
</style>
