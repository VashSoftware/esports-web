<script>
	let { data } = $props();
</script>

<h1>{data.event.title}</h1>

<a href="/events/{data.event.id}/manage">
	<button>Manage</button>
</a>

<a href="/events/{data.event.id}/register">
	<button>Register</button>
</a>

<h2>Matches</h2>
<table>
	<thead>
		<tr>
			<th> Time </th>
			<th> Name </th>
		</tr>
	</thead>
	<tbody>
		{#each data.event.matches as match}
			<tr>
				<td>{match.time}</td>
				<td>{match.match_participants[0]} - {match.match_participants[1]}</td>
			</tr>
		{/each}
	</tbody>
</table>
