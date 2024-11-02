<script>
    import Layout from "../Shared/Layout.svelte";

    export let profile;

    console.log(profile);
</script>

<Layout>
    <div>
        <div class="flex">
            <img src="" alt="" />
            <h1>{profile.username}</h1>
            {#each [1, 2, 3] as organization}
                <img src="" alt="Organization logo" />
            {/each}
            {#each [1, 2, 3] as team}
                <img src="" alt="Team logo" />
            {/each}
        </div>
    </div>

    <h2>Results</h2>
    <table></table>

    <h2>Top Scores</h2>
    <table></table>
</Layout>
