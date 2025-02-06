<script>
	import { goto } from '$app/navigation';

	const { data } = $props();
</script>

<div class="text-center">
	<h1 class=" text-2xl font-bold">{data.team.name}</h1>
	<p>Rating: {data.team.rating}</p>
</div>
<a href="/teams/{data.team.id}/edit">
	<button>Manage</button>
</a>

<h2 class=" text-xl font-bold">Team Members</h2>
<table>
	<thead>
		<tr>
			<th> Name </th>
			<th> Rating </th>
		</tr>
	</thead>
	<tbody>
		{#each data.team.team_members as team_member}
			<tr onclick={() => goto(`/users/${team_member.profile.id}`)}>
				<td>{'Bruh'}</td>
				<td>{''}</td>
			</tr>
		{/each}
	</tbody>
</table>
