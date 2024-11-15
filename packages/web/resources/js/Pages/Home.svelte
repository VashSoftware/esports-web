<script>
    import Layout from '../Shared/Layout.svelte'

    let { matches } = $props()
</script>

<Layout>
    <div class="my-10 text-center">
        <h1 class="text-4xl font-bold">Vash Esports</h1>
        <h2 class="text-2xl font-semibold">The best way to play competitively.</h2>
    </div>

    <div class="flex flex-col content-center">
        <a href="/matches">
            <h2 class="my-5 text-center text-2xl">Ongoing Matches:</h2>
        </a>
        <table>
            <thead>
                <tr>
                    <th> Time </th>
                    <th> Name</th>
                    <th>Score</th>
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
    </div>
</Layout>
