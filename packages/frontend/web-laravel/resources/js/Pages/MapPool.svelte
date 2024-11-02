<script>
    import Layout from "../Shared/Layout.svelte";

    export let mapPool;
</script>

<Layout>
    <h1>{mapPool.id}</h1>

    <table>
        <thead></thead>
        <tbody>
            {#each mapPool.maps as map, index (map.id)}
                <tr>
                    <td>{index + 1}</td>
                    <td>{map.name}</td>
                    <td>{map.description}</td>
                </tr>
                }
            {/each}
        </tbody>
    </table>
</Layout>
