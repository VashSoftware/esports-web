<script>
    import Layout from '@/Shared/Layout.svelte'
    import { Link, useForm } from '@inertiajs/svelte'

    let { organisation } = $props()

    let modalHidden = $state(true)

    let form = useForm({
        name: '',
        organisation_id: organisation.id,
    })
</script>

<Layout>
    <h1>{organisation.name}</h1>

    <h2>Event Groups</h2>
    <button onclick={() => (modalHidden = !modalHidden)}>+</button>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Events</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {#each organisation.event_groups as event_group}
                <tr>
                    <td>{event_group.name}</td>
                    <td>{event_group.events.length}</td>
                    <td><button>Delete</button></td>
                </tr>
            {/each}
        </tbody>
    </table>

    <div class="fixed inset-0 bg-black bg-opacity-50" class:hidden={modalHidden}></div>
    <div class="fixed inset-0 flex items-center justify-center rounded" class:hidden={modalHidden}>
        <div class="rounded-lg bg-secondary p-8">
            <h2>Create Event Group</h2>
            <form
                onsubmit={(event) => {
                    event.preventDefault()

                    $form.post('/event_groups')
                }}
            >
                <div>
                    <label for="name">Name</label>
                    <input id="name" type="text" class="text-black" bind:value={$form.name} />
                </div>

                <div>
                    <button type="button" onclick={() => (modalHidden = !modalHidden)}>Cancel</button>
                    <button class="rounded bg-green-500 px-4 py-2"> Save</button>
                </div>
            </form>
        </div>
    </div>
</Layout>
