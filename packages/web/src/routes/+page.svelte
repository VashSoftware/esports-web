<script>
	import { goto } from '$app/navigation';

	let { data } = $props();
</script>

<div class="my-10 text-center">
	<h1 class="text-4xl font-bold">Vash Esports</h1>
	<h2 class="text-2xl font-semibold">The best way to play competitively.</h2>
</div>

<div class="flex flex-col content-center">
	<a href="/matches">
		<h2 class="my-5 text-center text-2xl">Ongoing Matches:</h2>
	</a>
	<table>
		<thead>
			<tr>
				<th> Time </th>
				<th> Name</th>
				<th>Score</th>
			</tr>
		</thead>
		<tbody>
			{#each data.matches as match}
				<tr onclick={() => goto(`/matches/${match.id}`)}>
					<td>{match.time}</td>
					<td>{match.match_participants[0].team.name} - {match.match_participants[1].team.name}</td>
				</tr>
			{/each}
		</tbody>
	</table>
</div>
