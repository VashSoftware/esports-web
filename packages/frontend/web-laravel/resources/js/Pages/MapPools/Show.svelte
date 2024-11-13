<script>
    import Layout from '../../Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'
    import { preventDefault } from 'svelte/legacy'

    let { mapPool, mods } = $props()

    let form = useForm({
        map_pool_id: mapPool.id,
        mod_id: null,
    })

    const addMod = () => {
        $form.post(`/map_pool_maps`)
    }
</script>

<Layout>
    <h1>{mapPool.id}</h1>

    <div class="flex flex-col justify-center text-center">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                {#each mapPool.maps as map, index (map.id)}
                    <tr>
                        <td>{index + 1}</td>
                        <td>{map.name}</td>
                        <td>{map.description}</td>
                    </tr>
                {/each}
            </tbody>
        </table>
        <form onsubmit={preventDefault(addMod)}>
            <select name="new-mod">
                {#each mods as mod}
                    <option value={mod.id}>{mod.name}</option>
                {/each}
            </select>
            <button>Add Mod</button>
        </form>
    </div>
</Layout>
