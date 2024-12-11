<script lang="ts">
    import Layout from '@/Shared/Layout.svelte'
    import { router } from '@inertiajs/svelte'
    import { onMount } from 'svelte'

    let { match } = $props()

    function getPickableMods() {
        return match.map_pool.maps
    }

    function getPickableMaps(id: number) {
        return match.map_pool.maps
    }

    let canPickMaps = $state(false)
    let shareModalShown = $state(false)

    onMount(() => {
        const channel = window.Echo.channel('match.1')
        channel.listen('ScoreUpdated', (e) => console.log('Event: ' + e))
    })
</script>

<Layout>
    <div class="flex justify-around">
        <div></div>
        <h1 class="my-4 text-center text-2xl font-bold">Match Play</h1>
        <button onclick={() => (shareModalShown = true)} class="bg-gray-500 p-2">Share</button>
    </div>

    <h2 class="text-center text-xl font-bold">Maps</h2>
    {#each match.match_maps as map}
        <div class="flex">
            <div>
                Scores Team 1
                {#each map.scores as score}{/each}
            </div>
            <div>
                <img src="" alt="" />
                <div>
                    {map.map_pool_map.map.map_set.artist} - {map.map_pool_map.map.map_set.title} [{map.map_pool_map.map
                        .difficulty_name}]
                </div>
            </div>
            <div>
                Scores Team 2
                {#each map.scores as score}{/each}
            </div>
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

{#if shareModalShown}
    <div class="fixed inset-0 z-10 bg-black opacity-50"></div>
    <div class="fixed inset-0 z-20 flex items-center justify-center" onclick={() => (shareModalShown = false)}>
        <div class="relative w-1/3 rounded-xl bg-white p-8 text-center shadow-xl" onclick={(e) => e.stopPropagation()}>
            <h3 class="text-xl font-bold">Share Match</h3>
            <p>Your share URL is:</p>
            <input
                type="text"
                class="my-8 w-full text-center"
                value="https://esports.vash.software/matches/{match.id}"
                readonly
            />
        </div>
    </div>
{/if}

{#if match.is_banning}
    <div class="fixed inset-0 z-10 bg-black opacity-50"></div>
    <div class="fixed inset-0 z-20 flex items-center justify-center">
        <div class="relative w-1/3 rounded-xl bg-white p-8 text-center shadow-xl" onclick={(e) => e.stopPropagation()}>
            <h3 class="text-xl font-bold">Ban Map</h3>
            <p>You can ban {match.bans_per_team} maps.</p>

            {#each Object.entries(match.map_pool.map_pool_maps.reduce((acc, map) => {
                    const modsKey = map.mods.sort().join(',') || 'No Mod'

                    if (!acc[modsKey]) {
                        acc[modsKey] = []
                    }

                    acc[modsKey].push(map)

                    return acc
                }, {})) as [modsKey, maps]}
                <p><strong>Mod Combination:</strong> {modsKey}</p>
                <ul>
                    {#each maps as map}
                        <li
                            onclick={() => {
                                router.post('/match_bans', {
                                    match_id: match.id,
                                    map_pool_map_id: map.id,
                                })
                            }}
                        >
                            Map ID: {map.id}
                        </li>
                        <!-- Adjust property as needed -->
                    {/each}
                </ul>
            {/each}
        </div>
    </div>
{/if}
