<script>
    import Layout from '@/Shared/Layout.svelte'

    let { match } = $props()

    console.log(match)
</script>

<Layout>
    {match}

    <div class="flex justify-evenly">
        <div>
            <img src="" alt="" />
            <h2>{match.match_participants[0].team.name}</h2>
        </div>
        <div>-</div>
        <div>
            <img src="" alt="" />
            <h2>{match.match_participants[1].team.name}</h2>
        </div>
    </div>
</Layout>
