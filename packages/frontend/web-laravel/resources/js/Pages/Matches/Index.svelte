<script>
    import { useForm } from "@inertiajs/svelte";
    import Layout from "../../Shared/Layout.svelte";

    export let matches;

    let form = useForm({
        map_pool_id: 1,
    });

    function createMatch() {
        $form.post("/matches");
    }
</script>

<Layout>
    <div class="text-center my-10">
        <h2 class="text-2xl font-semibold">
            Matches ({matches.length})
        </h2>

        <form on:submit|preventDefault={createMatch}>
            <button class="bg-slate-500 px-4 py-2 rounded">
                Create Custom Match
            </button>
        </form>
    </div>

    <div class="flex flex-col content-center">
        <a href="/matches">
            <h2 class="text-center text-2xl my-5">Ongoing Matches:</h2>
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
                        <td
                            >{match.match_participants[0]} - {match
                                .match_participants[1]}</td
                        >
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>
</Layout>
