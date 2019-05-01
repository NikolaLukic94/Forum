<template>
    <div class="alert alert-warning fade show alert-flash" role="alert">
      <strong>Success!</strong> {{ body}}
    </div>
</template>

<script>
    export default {
    	props: ['message'],
        mounted() {
            console.log('Temp for now.')
        }
    }
</script>

<style>
	.alert-flash {
		position:fixed;
		right:25px;
		bottom:25px;
	}
</style>