<script>
    import Layout from '../../Shared/Layout.svelte'
    import { Link } from '@inertiajs/svelte'

    let { event } = $props()
</script>

<Layout>
    <h1>{event.title}</h1>

    <Link href="/events/{event.id}/manage">
        <button>Manage</button>
    </Link>

    <Link href="/events/{event.id}/register">
        <button>Register</button>
    </Link>

    <h2>Matches</h2>
    <table>
        <thead>
            <tr>
                <th> Time </th>
                <th> Name </th>
            </tr>
        </thead>
        <tbody>
            {#each event.matches as match}
                <tr>
                    <td>{match.time}</td>
                    <td>{match.match_participants[0]} - {match.match_participants[1]}</td>
                </tr>
            {/each}
        </tbody>
    </table>
</Layout>
