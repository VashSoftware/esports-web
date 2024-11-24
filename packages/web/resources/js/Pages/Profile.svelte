<script>
    import { Link } from '@inertiajs/svelte'
    import Layout from '../Shared/Layout.svelte'

    let { profile } = $props()
    console.log(profile)
</script>

<Layout>
    <div>
        <div class="flex">
            <img src="" alt="" />
            <h1>{profile.username}</h1>
            {#each profile.organisation_members as organisation}
                <Link href="/organisations/{organisation.organisation.id}">
                    <img src="" alt="Organization logo" />
                </Link>
            {/each}
            <Link href="/organisations/create">+</Link>
            {#each profile.team_members as team}
                <img src="" alt="Team logo" />
            {/each}
            <Link href="/teams/create">+</Link>
        </div>
    </div>

    <h2>Results</h2>
    <table></table>

    <h2>Top Scores</h2>
    <table></table>
</Layout>
