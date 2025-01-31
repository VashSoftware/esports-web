<script>
    import Layout from '@/Shared/Layout.svelte'
    import { Link } from '@inertiajs/svelte'

    let { organisation } = $props()
</script>

<Layout>
    <h1>{organisation.name}</h1>

    <Link href="/organisations/{organisation.id}/edit">
        <button>Edit</button>
    </Link>
</Layout>
