<script lang="ts">
    import Layout from '../../Shared/Layout.svelte'
    import { Link } from '@inertiajs/svelte'

    export let events
</script>

<Layout>
    <Link href="/events/create">
        <button>Create Event</button>
    </Link>

    <table>
        <thead>
            <tr>
                <th> Title </th>
                <th> Description</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {#each events as event}
                <tr>
                    <td>{event.title}</td>
                    <td>{event.description}</td>
                    <td>{event.date}</td>
                    <td>
                        <Link href={`/events/${event.id}`}>View</Link>
                    </td>
                </tr>
            {/each}
        </tbody>
    </table>
</Layout>
