<script lang="ts">
	const { data } = $props();
</script>

<a href="/events/create">
	<button>Create Event</button>
</a>

<table>
	<thead>
		<tr>
			<th> Title </th>
			<th> Description</th>
			<th>Date</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		{#each data.events as event}
			<tr>
				<td>{event.title}</td>
				<td>{event.description}</td>
				<td>{event.date}</td>
				<td>
					<a href={`/events/${event.id}`}>View</a>
				</td>
			</tr>
		{/each}
	</tbody>
</table>
