<script>
	let { data } = $props();
</script>

<h1 class="my-8 text-center text-2xl">Leaderboard</h1>

<div class="flex justify-center gap-16">
	<div>
		<h2 class="my-4 text-xl">Top Players</h2>
		{#each data.top_players as player, index (player.id)}
			<div onclick={() => router.visit(`/users/${player.profile.id}`)}>
				<h2>{index + 1}. {player.profile.display_name}</h2>
				<p>{player.score}</p>
			</div>
		{/each}
	</div>

	<div>
		<h2 class="my-4 text-xl">Top Teams</h2>
		{#each data.top_teams as team, index (team.id)}
			<div onclick={() => router.visit(`/teams/${team.id}`)}>
				<h2>{index + 1}. {team.name}</h2>
				<p>{team.score}</p>
			</div>
		{/each}
	</div>

	<div>
		<h2 class="my-4 text-xl">Top Scores</h2>
		{#each data.top_scores as score, index (score.id)}
			<div>
				<h2>{index + 1}. {score.score}</h2>
			</div>
		{/each}
	</div>
</div>
