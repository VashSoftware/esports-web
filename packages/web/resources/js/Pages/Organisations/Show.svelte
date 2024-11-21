<script>
    import Layout from '@/Shared/Layout.svelte'

    let { organisation } = $props()
</script>

<Layout>
    <h1>{organisation.name}</h1>
</Layout>
