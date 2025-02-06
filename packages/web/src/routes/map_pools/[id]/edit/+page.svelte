<script lang="ts">
	import Layout from '../../Shared/Layout.svelte';
	import { router, useForm } from '@inertiajs/svelte';
	import MapSearchInput from '@/Components/MapSearchInput.svelte';
	import type { MapPool, Mod } from '@/Types/app';

	let { mapPool, mods }: { mapPool: MapPool; mods: Mod[] } = $props();

	let openDropdownMapId: number | null = $state(null);

	let form = useForm({
		map_pool_id: mapPool.id
	});
</script>

<Layout>
	<h1 class="my-4 text-center text-2xl font-bold">{mapPool.name}</h1>

	<div class="flex flex-col justify-center text-center">
		<form
			onsubmit={(e) => {
				e.preventDefault();
				$form.post('/map_pool_maps');
			}}
		>
			<button class="my-3 rounded bg-white px-4 py-2 text-black">Add Map</button>
		</form>
		<table class="table-auto">
			<thead>
				<tr>
					<th>Mods</th>
					<th>Map</th>
				</tr>
			</thead>
			<tbody>
				{#each mapPool.map_pool_maps as map}
					<tr>
						<td class="flex items-center justify-center gap-2">
							{#each map.map_pool_map_mods as mod}
								<div class="bg-secondary group relative flex items-center rounded px-2 py-1">
									<span>{mod.mod.name}</span>
									<button
										class="ml-2 text-red-500 opacity-0 transition-opacity duration-200 hover:text-red-700 group-hover:opacity-100"
										onclick={(e) => {
											e.preventDefault();
											router.delete('/map_pool_map_mods/' + mod.id);
										}}
									>
										&times;
									</button>
								</div>
							{/each}
							<button
								class="bg-secondary rounded px-2 py-1"
								onclick={() => (openDropdownMapId = map.id)}
							>
								+
							</button>

							{#if openDropdownMapId == map.id}
								<div class="absolute z-10 mt-2 w-48 rounded-md bg-white shadow-lg">
									<ul class="py-1">
										{#each mods.filter((mod) => !map.map_pool_map_mods.some((m) => m.id === mod.id)) as availableMod}
											<li>
												<button
													class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100"
													onclick={() => {
														router.post('/map_pool_map_mods', {
															map_pool_map_id: map.id,
															mod_id: availableMod.id
														});

														openDropdownMapId = null;
													}}
												>
													{availableMod.name}
												</button>
											</li>
										{/each}
										{#if mods.filter((mod) => !map.map_pool_map_mods.some((m) => m.id === mod.id)).length === 0}
											<li>
												<span class="block px-4 py-2 text-sm text-gray-500">No mods available</span>
											</li>
										{/if}
									</ul>
								</div>
							{/if}
						</td><td>
							<MapSearchInput mapPoolMap={map} />
						</td>
					</tr>
				{/each}
			</tbody>
		</table>
	</div>
</Layout>
