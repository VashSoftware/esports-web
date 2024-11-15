<script>
    import { Link } from '@inertiajs/svelte'
    import Layout from '../../Shared/Layout.svelte'

    let { mapPool } = $props()
</script>

<Layout>
    <h1>{mapPool.name}</h1>

    <Link href="/map_pools/{mapPool.id}/edit">
        <button>Edit</button>
    </Link>
</Layout>
