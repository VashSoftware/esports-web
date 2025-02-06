<script>
	import { goto } from '$app/navigation';

	let { data } = $props();
	console.log(data.user);

	let createMatchModalHidden = $state(true);
</script>

<div class="my-10 text-center">
	<h2 class="text-2xl font-semibold">
		Matches ({data.matches.length})
	</h2>
	<button
		onclick={() => (createMatchModalHidden = !createMatchModalHidden)}
		class="rounded bg-green-500 px-4 py-2"
	>
		Play a Match
	</button>
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

<div class="fixed inset-0 bg-black bg-opacity-50 py-32" class:hidden={createMatchModalHidden}>
	<div class="text-center">
		<label for="">Team</label>
		<select name="team" id="">
			{#each data.user.profile.team_members as teamMember}
				<option value={teamMember.team.id}>{teamMember.team.name}</option>
			{/each}
		</select>
	</div>
	<div class="flex justify-around">
		<div>
			<h1 class="text-xl font-bold">Matchmaking</h1>
			<p>Team size: 1</p>
			<p>Game: osu! (standard match)</p>

			<button
				class="rounded bg-green-500 px-8 py-4"
				onclick={() => {
					createMatchModalHidden = true;
				}}>Join Queue</button
			>
		</div>

		<form class="flex flex-col items-center">
			<h1 class="text-center text-2xl font-bold">Invite Player/Team to Custom Match</h1>

			<div class="my-4">
				<label for="team">Team</label>
				<input class="text-black" type="text" id="team" placeholder="Team" />
			</div>

			<div class="my-4">
				<label for="map_pool">Map Pool</label>
				<input class="text-black" type="number" id="map_pool" placeholder="Map Pool" />
			</div>

			<div>
				<input type="checkbox" />
				<label for="">Ban maps?</label>
			</div>
			<div>
				<input type="checkbox" />
				<label for="">Pick maps?</label>
			</div>

			<div class="flex justify-center gap-2">
				<button
					class="rounded bg-red-500 px-4 py-2"
					type="button"
					onclick={() => (createMatchModalHidden = !createMatchModalHidden)}>Cancel</button
				>
				<button class="rounded bg-green-500 px-4 py-2">Create</button>
			</div>
		</form>
	</div>
</div>
