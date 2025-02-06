<script>
	let { data } = $props();
</script>

<div>
	<div class="flex">
		<img src="" alt="" />
		<h1>{data.user.username}</h1>
		{#each data.user.organisation_members as organisation}
			<a href="/organisations/{organisation.organisation.id}">
				<img src="" alt="Organization logo" />
			</a>
		{/each}
		<a href="/organisations/create">+</a>
		{#each data.user.team_members as team}
			<a href="/teams/{team.id}">
				<img src="" alt="Team logo" />
			</a>
		{/each}
		<a href="/teams/create">+</a>
	</div>
</div>

<h2>Results</h2>
<table></table>

<h2>Top Scores</h2>
<table></table>
