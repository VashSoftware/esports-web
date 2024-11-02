<script>
    import Layout from "../Shared/Layout.svelte";

    let { top_players, top_teams, top_scores } = $props();
</script>

<Layout>
    <h1>Leaderboard</h1>

    {#each top_players as player, index (player.id)}
        <div>
            <h2>{index + 1}. {player.name}</h2>
            <p>{player.score}</p>
        </div>
    {/each}
    {#each top_teams as team, index (team.id)}
        <div>
            <h2>{index + 1}. {team.name}</h2>
            <p>{team.score}</p>
        </div>
    {/each}
    {#each top_scores as score, index (score.id)}
        <div>
            <h2>{index + 1}. {score.score}</h2>
        </div>
    {/each}
</Layout>
