<script>
    import Layout from '../../Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'
    import { preventDefault } from 'svelte/legacy'

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
                    <th>#</th>
                    <th>Mod</th>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                {#each mapPool.map_pool_maps as map, index (map.id)}
                    <tr>
                        <td>{index + 1}</td>
                        <td
                            ><select name="" id="">
                                {#each mods as mod}
                                    <option value={mod.id}>{mod.name}</option>
                                {/each}
                            </select></td
                        >
                        <td>{map.name}</td>
                        <td>{map.description}</td>
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>
</Layout>
