<script lang="ts">
    import Layout from '../../Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'
    import { preventDefault } from 'svelte/legacy'
    import MapSearchInput from '@/Components/MapSearchInput.svelte'

    let { mapPool, mods } = $props()

    let form = useForm({
        map_pool_id: mapPool.id,
    })
</script>

<Layout>
    <h1>{mapPool.id}</h1>

    <div class="flex flex-col justify-center text-center">
        <form onsubmit={preventDefault(() => $form.post('/map_pool_maps'))}>
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
                {#each mapPool.map_pool_maps as map, index (map.id)}
                    <tr>
                        <td
                            ><select value={map}>
                                {#each mods as mod}
                                    <option value={mod.id}>{mod.name}</option>
                                {/each}
                            </select></td
                        >
                        <td>
                            <MapSearchInput mapPoolMap={map} />
                        </td>
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>
</Layout>
