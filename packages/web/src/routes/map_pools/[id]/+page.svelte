<script lang="ts">
	let { data } = $props();
</script>

<div class="my-8 flex justify-around">
	<div></div>
	<h1 class="text-2xl font-bold">{data.mapPool.name}</h1>

	<a href="/map_pools/{data.mapPool.id}/edit">
		<button class="rounded bg-red-500 px-4 py-2">Edit</button>
	</a>
</div>

<h1 class="text-center text-2xl font-bold">Maps</h1>
