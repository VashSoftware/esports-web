<script>
    import { useForm, router } from "@inertiajs/svelte";
    import Layout from "../Shared/Layout.svelte";

    export let mapPools;

    let values = {
        mods: [
            {
                id: 1,
            },
        ],
    };

    let form = useForm();

    function storeMapPool() {
        $form.post("/map_pools");
    }
</script>

<Layout>
    <form on:submit|preventDefault={storeMapPool}>
        <input type="text" />

        <button>Create</button>
    </form>

    <table class="table-auto">
        <thead>
            <tr>
                <th>Name</th>
                <th>Created At</th>
                <th>Mods</th>
            </tr>
        </thead>
        <tbody>
            {#each mapPools as pool}
                <tr on:click={router.visit(`/map_pools/${pool.id}`)}>
                    <td>{pool.name}</td>
                    <td>{pool.description}</td>
                    <td>{pool.created_at}</td>
                </tr>
            {/each}
        </tbody>
    </table>
</Layout>
