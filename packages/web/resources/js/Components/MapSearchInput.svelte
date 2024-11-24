<script>
    import { debounce } from 'lodash'
    import axios from 'axios'
    import { router } from '@inertiajs/svelte'

    let { mapPoolMap } = $props()

    let cursor_string = $state('')
    let foundMaps = $state([])

    const fetchMaps = debounce(async () => {
        if (cursor_string.trim() === '') {
            foundMaps = []
            return
        }
        try {
            const response = await axios.get('/maps/search', {
                params: {
                    query: cursor_string,
                },
            })
            console.log('Found maps:', response.data)

            foundMaps = response.data
        } catch (error) {
            console.error('Error fetching maps:', error)
        }
    }, 500)
</script>

<div class="relative flex flex-col items-center">
    <input
        name="map"
        type="text"
        bind:value={cursor_string}
        on:input={fetchMaps}
        class="w-full rounded border border-gray-300 px-4 py-2 text-black focus:border-blue-500 focus:outline-none"
        placeholder="Search for a map..."
    />
    {#if foundMaps.length > 0}
        <div
            class="absolute z-50 mt-2 max-h-96 w-full overflow-y-auto rounded border border-gray-200 bg-white shadow-lg"
        >
            <ul>
                {#each foundMaps as map}
                    <li
                        class="flex cursor-pointer items-center space-x-3 p-2 hover:bg-gray-100"
                        on:click={() => {
                            router.patch(`/map_pool_maps/${mapPoolMap.id}`, {
                                map_pool_map_id: mapPoolMap.id,
                                map_id: map.id,
                            })
                        }}
                    >
                        <img src={map.cover} alt="" class="h-10 w-10 flex-shrink-0 rounded object-cover" />
                        <div class="flex-1 text-sm text-gray-800">
                            <div class="font-semibold">{map.artist}</div>
                            <div>{map.title}</div>
                        </div>
                    </li>
                {/each}
            </ul>
        </div>
    {/if}
</div>
