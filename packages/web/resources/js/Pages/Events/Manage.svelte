<script>
    import Layout from '@/Shared/Layout.svelte'
    import { router, useForm } from '@inertiajs/svelte'

    let { event, games, game_modes } = $props()

    let form = useForm({
        event_group: event.event_group,
        title: event.title,
        has_qualifier_stage: event.has_qualifier_stage,
        has_group_stage: event.has_group_stage,
        game_id: event.game_id,
        game_mode_id: event.game_mode_id,
    })
</script>

<Layout>
    <h1 class="mb-5 text-center text-2xl font-bold text-white">
        Manage {event.event_group ? `${event.event_group} -` : ''}{event.title}
    </h1>

    <form>
        <div class="mb-5 flex flex-col items-center rounded bg-secondary">
            <h2 class="my-3 text-xl font-bold">Event Details</h2>

            <div class="my-1">
                <label for="event_group">Event Group</label>
                <select class="text-black" id="event_group" name="event_group" value={event.event_group}>
                    <option value="1">Group 1</option>
                    <option value="2">Group 2</option>
                </select>
            </div>

            <div class="my-1">
                <label for="title">Name</label>
                <input type="text" class="text-black" id="title" name="title" value={event.title} />
            </div>

            <div class="my-1">
                <label for="toggle-qualifier-stage">Qualifier stage?</label>
                <input type="checkbox" bind:checked={$form.has_qualifier_stage} />
            </div>

            <div class="my-1">
                <label for="toggle-group-stage">Group stage?</label>
                <input type="checkbox" bind:checked={$form.has_group_stage} />
            </div>
        </div>
    </form>

    <form>
        <div class="mb-5 flex flex-col items-center rounded bg-secondary">
            <h2 class="my-3 text-xl font-bold">Game Settings</h2>

            <div class="my-1">
                <label for="event_group">Game</label>
                <select id="event_group" class="text-black" name="event_group" bind:value={$form.game_id}>
                    {#each games as game}
                        <option value={game.id}>{game.name}</option>
                    {/each}
                </select>
            </div>

            <div class="my-1">
                <label for="title">Game Mode</label>
                <select id="title" name="title" class="text-black" bind:value={$form.game_mode_id}>
                    {#each game_modes.filter((gm) => gm.game_id == $form.game_id) as game_mode}
                        <option value={game_mode.id}>{game_mode.name}</option>
                    {/each}
                </select>
            </div>
        </div>
    </form>

    <div class="mb-5 flex flex-col items-center rounded bg-secondary">
        <div class="my-3 flex content-around">
            <h2 class="text-xl font-bold">Participants ({0})</h2>
            <button
                class=" p x-4 mx-3 rounded
                bg-white py-2 text-black">Invite Teams</button
            >
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {#each event.teams as team}
                    <tr>
                        <td>{team.name}</td>
                        <td>{team.rating}</td>
                        <td>
                            <button class="rounded px-4 py-2 text-red-500">Delete</button>
                        </td>
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>

    <div class="mb-5 flex flex-col items-center rounded bg-secondary">
        <div class="my-3 flex">
            <h2 class="text-xl font-bold">Rounds ({0})</h2>
            <button
                class="rounded bg-white px-4 py-2 text-black"
                on:click={() =>
                    router.post('/rounds', {
                        event_id: event.id,
                    })}>Add Round</button
            >
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {#each event.rounds as round}
                    <tr>
                        <td>{round.name}</td>
                        <td>
                            <button class="rounded bg-red-500 px-4 py-2">Delete</button>
                        </td>
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>

    <div class="mb-5 flex flex-col items-center rounded bg-secondary">
        <h2 class="my-3 text-xl font-bold">Matches ({0})</h2>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {#each event.teams as team}
                    <tr>
                        <td>{team.name}</td>
                        <td>{team.rating}</td>
                        <td>
                            <button class="rounded px-4 py-2 text-red-500">Delete</button>
                        </td>
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>

    <div class="mb-5 flex flex-col items-center rounded bg-secondary">
        <h2 class="my-3 text-xl font-bold text-red-600">Danger Zone</h2>

        <div>
            <label for="delete">Delete Event</label>
            <button class="rounded bg-red-500 px-4 py-2">Delete</button>
        </div>
    </div>
</Layout>
