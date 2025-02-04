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
{#each Object.entries(data.mapPool.map_pool_maps.reduce((acc, map) => {
		const modsKey = map.map_pool_map_mods
				.map((mod) => mod.mod.code)
				.sort()
				.join(', ') || 'NM';

		if (!acc[modsKey]) {
			acc[modsKey] = [];
		}

		acc[modsKey].push(map);

		return acc;
	}, {})) as [modsKey, maps]}
	<div class="bg-secondary mx-8 my-2 flex items-center rounded-xl p-2">
		<h3 class="mx-4 text-xl font-bold">{modsKey}</h3>

		<div class="flex flex-wrap">
			{#each data.maps as map}
				<div class="bg-secondary p-2">
					<p>{map.map?.map_set.artist} - {map.map?.map_set.title}</p>
					<p>[{map.map?.difficulty_name}]</p>
				</div>
			{/each}
		</div>
	</div>
{/each}
