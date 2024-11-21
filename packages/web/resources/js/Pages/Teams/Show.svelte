<script>
    import Layout from '@/Shared/Layout.svelte'

    let { team } = $props()
</script>

<Layout>
    <h1>{team.name}</h1>
</Layout>
