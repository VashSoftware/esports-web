<script>
    import { preventDefault } from 'svelte/legacy';

    import { useForm, router } from "@inertiajs/svelte";
    import Layout from "../Shared/Layout.svelte";

    let { mapPools } = $props();

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
    <form onsubmit={preventDefault(storeMapPool)}>
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
                <tr onclick={router.visit(`/map_pools/${pool.id}`)}>
                    <td>{pool.name}</td>
                    <td>{pool.description}</td>
                    <td>{pool.created_at}</td>
                </tr>
            {/each}
        </tbody>
    </table>
</Layout>
