<script>
    import Layout from '../../Shared/Layout.svelte'

    export let event
    export let matches
</script>

<Layout>
    {event}

    <h2>Matches</h2>
    <table>
        <thead>
            <tr>
                <th> Time </th>
                <th> Name </th>
            </tr>
        </thead>
        <tbody>
            {#each matches as match}
                <tr>
                    <td>{match.time}</td>
                    <td>{match.match_participants[0]} - {match.match_participants[1]}</td>
                </tr>
            {/each}
        </tbody>
    </table>
</Layout>
