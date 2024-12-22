<script lang="ts">
    import Layout from '@/Shared/Layout.svelte'
    import { router, Link } from '@inertiajs/svelte'
    import { onMount } from 'svelte'

    let { match, user } = $props()
    console.log(match)

    let shareModalShown = $state(false)
    let forfeitModalShown = $state(false)
    let matchEndedModalShown = $state(false)
    let mapPoolStatus = $state(getMapPoolStatus())

    onMount(() => {
        const channel = window.Echo.channel('match.' + match.id)
        channel.listen('MatchUpdated', (e) => {})
        channel.listen('ScoreUpdated', (e) => console.log('Event: ' + e))
        channel.listen('MatchEnded', (e) => {
            match.finished_at = e.match.finished_at
            matchEndedModalShown = true
            console.log(match)
        })

        const matchTimerInterval = setInterval(() => {
            mapPoolStatus = getMapPoolStatus()
        }, 1000)

        return () => {
            clearInterval(matchTimerInterval)
        }
    })

    function userCanBan() {
        return user.profile.team_members.find((tm) =>
            tm.team.match_participants.find((mp) => mp.id == match.current_banner),
        )
    }

    function userCanPick() {
        return user.profile.team_members.find((tm) =>
            tm.team.match_participants.find((mp) => mp.id == match.current_picker),
        )
    }

    function formatTime(milliseconds: number) {
        const totalSeconds = Math.floor(milliseconds / 1000)
        const minutes = Math.floor(totalSeconds / 60)
            .toString()
            .padStart(2, '0')
        const seconds = (totalSeconds % 60).toString().padStart(2, '0')
        return `${minutes}:${seconds}`
    }

    function getMapPoolStatus() {
        if (match.current_banner) {
            if (userCanBan()) {
                const timeLeft = Math.max(0, new Date(match.action_limit) - Date.now())
                return `You have ${formatTime(timeLeft)} to ban a map.`
            }

            return `Waiting for ${match.current_banner} to a ban a map.`
        }

        if (userCanPick()) {
            const timeLeft = Math.max(0, new Date(match.action_limit) - Date.now())
            return `You have ${formatTime(timeLeft)} to pick a map.`
        }

        return `${''} has ${''} to pick a map.`
    }

    function getPlayerStatusIcon() {
        return '👍'
    }

    function getMatchParticipantScores(match_map_id: number, match_participant_id: number) {
        return match.match_maps
            .find((mm) => mm.id == match_map_id)
            .scores.filter((s) => s.match_participant_player.match_participant_id == match_participant_id)
    }
</script>

<Layout>
    <div class="mx-8 my-8 flex items-center justify-between rounded-xl bg-secondary p-4">
        <div>
            <Link href="/events/1">
                <h1 class="text-2xl font-bold">{match.event?.name}</h1>
                <h2 class="text-xl font-bold">{match.round?.name}</h2>
            </Link>
        </div>
        <div class="flex justify-center">
            {#each match.match_participants as participant, i}
                <h1 class="mx-1 text-4xl font-black">
                    0
                    {#if i != match.match_participants.length - 1}-{/if}
                </h1>
            {/each}
        </div>
        <div class="flex items-center gap-2">
            <button onclick={() => (shareModalShown = true)} class="bg-gray-500 p-2"
                ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    ><path
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8m-4-6l-4-4l-4 4m4-4v13"
                    /></svg
                ></button
            >
            <button onclick={() => (forfeitModalShown = true)} class="bg-red-500 p-2">Forfeit</button>
        </div>
    </div>

    <div class="m-8 flex justify-evenly text-center">
        {#each match.match_participants as participant}
            <div class="flex flex-col gap-2">
                <div class="rounded-xl bg-secondary p-4">
                    <h2 class="text-xl font-bold">{participant.team.name}</h2>
                    <img src="/public/" alt="Team Logo" />
                </div>

                {#each participant.match_participant_players as player}
                    <div class="flex justify-between gap-2 rounded bg-secondary p-2">
                        <img src="" alt="Player" />
                        <h3>{player.team_member.profile?.username}</h3>
                        <p>{getPlayerStatusIcon()}</p>
                    </div>
                {/each}
            </div>
        {/each}
    </div>

    <div class="grid grid-cols-2">
        <div>
            <h2 class="my-4 text-center text-xl font-bold">Match Maps</h2>

            {#each match.match_maps as map}
                <div class="flex justify-center">
                    <div class="flex gap-2">
                        {#each getMatchParticipantScores(map.id, match.match_participants[0].id) as score}
                            <div class="rounded bg-secondary p-2">
                                <img src="" class="rounded-full" alt="" />
                                <h1 class="text-l font-bold">{score.score}</h1>
                            </div>
                        {/each}
                    </div>
                    <div class="mx-8 my-2 rounded-xl bg-secondary px-8 py-4 text-center">
                        <h1 class="text-l font-bold">
                            {map.map_pool_map.map.map_set.artist} - {map.map_pool_map.map.map_set.title} [{map
                                .map_pool_map.map.difficulty_name}]
                        </h1>
                    </div>
                    <div class="flex gap-2">
                        {#each getMatchParticipantScores(map.id, match.match_participants[1].id) as score}
                            <div class="rounded bg-secondary p-2">
                                <img src="" class="rounded-full" alt="" />
                                <h1 class="text-l font-bold">{score.score}</h1>
                            </div>
                        {/each}
                    </div>
                </div>
            {/each}
        </div>

        <div>
            <div class="my-4 text-center">
                <h2 class="text-center text-xl font-bold">Map Pool</h2>
                <p>{mapPoolStatus}</p>
            </div>

            {#each Object.entries(match.map_pool.map_pool_maps.reduce((acc, map) => {
                    const modsKey = map.mods.sort().join(',') || 'NM'

                    if (!acc[modsKey]) {
                        acc[modsKey] = []
                    }

                    acc[modsKey].push(map)

                    return acc
                }, {})) as [modsKey, maps]}
                <div class="mx-8 my-2 flex items-center rounded-xl bg-secondary p-2">
                    <h3 class="mx-4 text-xl font-bold">{modsKey}</h3>

                    <div class="flex flex-wrap">
                        {#each maps as map}
                            <div
                                class="bg-secondary p-2"
                                onclick={() => {
                                    router.post('/match_bans', {
                                        match_id: match.id,
                                        map_pool_map_id: map.id,
                                    })
                                }}
                            >
                                <p>{map.map.map_set.artist} - {map.map.map_set.title}</p>
                                <p>[{map.map.difficulty_name}]</p>

                                {#if userCanBan()}
                                    <button class="rounded bg-red-500 px-4 py-2">BAN</button>
                                {/if}

                                {#if userCanPick()}
                                    <form
                                        onsubmit={(e) => {
                                            e.preventDefault()
                                            router.post('/match_maps', {
                                                vash_match_id: match.id,
                                                map_pool_map_id: map.id,
                                            })
                                        }}
                                    >
                                        <button class="rounded bg-green-500 px-4 py-2">PICK</button>
                                    </form>
                                {/if}
                            </div>
                        {/each}
                    </div>
                </div>
            {/each}
        </div>
    </div>
</Layout>

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

{#if forfeitModalShown}
    <div class="fixed inset-0 z-10 bg-black opacity-50"></div>
    <div class="fixed inset-0 z-20 flex items-center justify-center" onclick={() => (forfeitModalShown = false)}>
        <div class="relative w-1/3 rounded-xl bg-white p-8 text-center shadow-xl" onclick={(e) => e.stopPropagation()}>
            <h3 class="text-xl font-bold">Are You Sure?</h3>
            <p>coward lol</p>

            <div class="my-8 flex justify-around">
                <button class="rounded bg-red-500 px-4 py-2">Yes</button>
                <button class="rounded bg-gray-500 px-4 py-2" onclick={() => (forfeitModalShown = false)}>Cancel</button
                >
            </div>
        </div>
    </div>
{/if}

{#if matchEndedModalShown}
    <div class="fixed inset-0 z-10 bg-black opacity-50"></div>
    <div class="fixed inset-0 z-20 flex items-center justify-center" onclick={() => (forfeitModalShown = false)}>
        <div class="relative w-1/3 rounded-xl bg-white p-8 text-center shadow-xl" onclick={(e) => e.stopPropagation()}>
            <h3 class="text-xl font-bold">Match Ended</h3>
            <p>coward lol</p>

            <div class="my-8 flex justify-around">
                <button class="rounded bg-red-500 px-4 py-2">Yes</button>
                <button class="rounded bg-gray-500 px-4 py-2" onclick={() => (forfeitModalShown = false)}>Cancel</button
                >
            </div>
        </div>
    </div>
{/if}
