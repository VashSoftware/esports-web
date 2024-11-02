<script>
    import { useForm } from "@inertiajs/svelte";
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

    {#each mapPools as pool}
        hiii :3
    {/each}
</Layout>
