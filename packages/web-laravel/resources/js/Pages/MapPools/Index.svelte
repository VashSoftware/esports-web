<script>
    import { router, Link } from '@inertiajs/svelte'
    import Layout from '../../Shared/Layout.svelte'

    let { mapPools } = $props()
</script>

<Layout>
    <Link href="/map_pools/create">
        <button>Create</button>
    </Link>

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
</Layout>
