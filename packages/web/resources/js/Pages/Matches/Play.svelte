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

    let canPickMaps = $state(false)
</script>

<Layout>
    <h1 class="my-4 text-center text-2xl font-bold">Match Play</h1>

    <h2>Maps</h2>
    {#each match.match_maps as map}
        <div class="flex">
            <div>Scores Team 1</div>
            <div>
                <img src="" alt="" />
                <div>
                    {map.map_pool_map.map.map_set.artist} - {map.map_pool_map.map.map_set.title} [{map.map_pool_map.map
                        .difficulty_name}]
                </div>
            </div>
            <div>Scores Team 2</div>
        </div>
    {/each}
</Layout>

{#if canPickMaps}
    <div class="fixed inset-0 bg-black opacity-50">
        <form>
            {#each getPickableMods() as mod}
                {#each getPickableMaps(mod.id) as map}
                    {map.id}
                {/each}
            {/each}
        </form>
    </div>
{/if}
