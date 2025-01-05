<script>
    import Layout from '@/Shared/Layout.svelte'
    import { Link, router } from '@inertiajs/svelte'

    let { team } = $props()
</script>

<Layout>
    <div class="text-center">
        <h1 class=" text-2xl font-bold">{team.name}</h1>
        <p>Rating: {team.rating}</p>
    </div>

    <form>
        <label for="">Logo</label>
        <input type="file" accept="image/*" />
    </form>

    <h2 class=" text-xl font-bold">Team Members</h2>
    <table>
        <thead>
            <tr>
                <th> Name </th>
                <th> Rating </th>
            </tr>
        </thead>
        <tbody>
            {#each team.team_members as team_member}
                <tr onclick={() => router.visit(`/users/${team_member.profile.id}`)}>
                    <td>{'Bruh'}</td>
                    <td>{''}</td>
                </tr>
            {/each}
        </tbody>
    </table>
</Layout>
