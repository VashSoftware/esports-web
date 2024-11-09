<script>
    import { preventDefault } from 'svelte/legacy'

    import { useForm } from '@inertiajs/svelte'
    import Layout from '../../Shared/Layout.svelte'

    let { matches } = $props()

    let form = useForm({
        map_pool_id: 1,
    })

    function createMatch() {
        $form.post('/matches')
    }
</script>

<Layout>
    <div class="my-10 text-center">
        <h2 class="text-2xl font-semibold">
            Matches ({matches.length})
        </h2>

        <form onsubmit={preventDefault(createMatch)}>
            <button class="rounded bg-slate-500 px-4 py-2"> Create Custom Match </button>
        </form>
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
