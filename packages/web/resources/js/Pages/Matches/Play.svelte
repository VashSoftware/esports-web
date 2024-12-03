<script lang="ts">
    import Layout from '@/Shared/Layout.svelte'

    let { match } = $props()
    console.log(match)

    function getPickableMods() {
        return match.map_pool.maps
    }

    function getPickableMaps(id: number) {
        return match.map_pool.maps
    }
</script>

<Layout>
    <h1>Match Play</h1>

    <h2>Maps</h2>
    {#each match.match_maps as map}
        <div>{map.id}</div>
    {/each}
</Layout>

<div class="fixed inset-0 bg-black opacity-50">
    <form>
        {#each getPickableMods() as mod}
            {#each getPickableMaps(mod.id) as map}
                {map.id}
            {/each}
        {/each}
    </form>
</div>
