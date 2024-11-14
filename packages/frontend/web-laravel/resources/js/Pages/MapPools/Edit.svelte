<script lang="ts">
    import Layout from '../../Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'
    import { preventDefault } from 'svelte/legacy'

    let { mapPool, mods } = $props()

    let form = useForm({
        map_pool_id: mapPool.id,
    })

    let mapForm = useForm({
        query: '',
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
                            <input
                                class="text-black"
                                oninput={() => $mapForm.get('/maps/search')}
                                bind:value={$mapForm.query}
                            />
                            <li>
                                {#each $mapForm.data as map}
                                    <a href="/maps/{map.id}">{map.name}</a>
                                {/each}
                            </li>
                        </td>
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>
</Layout>
