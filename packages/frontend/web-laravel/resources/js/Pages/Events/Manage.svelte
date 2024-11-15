<script>
    import Layout from '@/Shared/Layout.svelte'

    let { event } = $props()

    console.log(event)
</script>

<Layout>
    <h1 class="mb-5 text-center text-2xl font-bold text-white">
        {event.event_group ? `${event.event_group} -` : ''}{event.name || 'Manage Event Name'}
    </h1>

    <form>
        <div class="mb-5 flex flex-col items-center rounded bg-secondary">
            <div class="my-1">
                <label for="event_group">Event Group</label>
                <select id="event_group" name="event_group" value={event.event_group}>
                    <option value="1">Group 1</option>
                    <option value="2">Group 2</option>
                </select>
            </div>

            <div class="my-1">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value={event.name} />
            </div>
        </div>
    </form>

    <div class="mb-5 flex flex-col items-center rounded bg-secondary">
        <h2 class="text-xl font-bold">Participants ({0})</h2>

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
</Layout>
