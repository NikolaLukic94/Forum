<template>

	<button class="btn btn-default" @click="subscribe">Subscribe</button>

</template>

<script>

	export defalut {
		methods: {
		subscribe() {
			axios.post(location.pathname + '/subscriptions');

			flash('Subscribed!');
		}
		}

	}

</script>