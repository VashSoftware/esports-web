<script>
    import { router, Link } from '@inertiajs/svelte'
    import Layout from '../../Shared/Layout.svelte'

    let { mapPools } = $props()
</script>

<Layout>
    <div class="my-5 flex items-center justify-between">
        <div></div>
        <h1 class="text-center text-2xl">Map Pools</h1>

        <Link href="/map_pools/create">
            <button class="mx-16 rounded bg-blue-500 px-4 py-2">Create</button>
        </Link>
    </div>

    <div class="my-16 flex flex-col content-center">
        <table class="table-auto">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Mods</th>
                </tr>
            </thead>
            <tbody>
                {#each mapPools as pool}
                    <tr onclick={router.visit(`/map_pools/${pool.id}`)}>
                        <td>{pool.name}</td>
                        <td>{pool.description}</td>
                        <td>{pool.created_at}</td>
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>
</Layout>
