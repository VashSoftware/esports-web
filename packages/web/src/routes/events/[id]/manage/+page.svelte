<script lang="ts">
	import { debounce } from 'lodash';

	let { data } = $props();
</script>

<h1 class="mb-5 text-center text-2xl font-bold text-white">
	Manage {data.event.event_group ? `${data.event.event_group} -` : ''}{data.event.title}
</h1>

<div class="bg-secondary mb-5 flex flex-col items-center rounded">
	<h2 class="my-3 text-xl font-bold">Event Details</h2>

	<div class="my-1">
		<label for="event_group">Event Group</label>
		<select class="text-black" id="event_group" name="event_group_id">
			{#each data.event_groups as event_group}
				<option value={event_group.id}>{event_group.name}</option>
			{/each}
		</select>
	</div>

	<div class="my-1">
		<label for="title">Name</label>
		<input type="text" class="text-black" id="title" name="title" />
	</div>

	<div class="my-1">
		<label for="toggle-qualifier-stage">Qualifier stage?</label>
		<input type="checkbox" />
	</div>

	<div class="my-1">
		<label for="toggle-group-stage">Group stage?</label>
		<input type="checkbox" />
	</div>
</div>

<form>
	<div class="bg-secondary mb-5 flex flex-col items-center rounded">
		<h2 class="my-3 text-xl font-bold">Game Settings</h2>

		<div class="my-1">
			<label for="event_group">Game</label>
			<select id="event_group" class="text-black" name="event_group">
				{#each data.games as game}
					<option value={game.id}>{game.name}</option>
				{/each}
			</select>
		</div>

		<div class="my-1">
			<label for="title">Game Mode</label>
			<select id="title" name="title" class="text-black">
				{#each data.game_modes.filter((gm) => gm.game_id == 1) as game_mode}
					<option value={game_mode.id}>{game_mode.name}</option>
				{/each}
			</select>
		</div>
	</div>
</form>

<div class="bg-secondary mb-5 flex flex-col items-center rounded">
	<div class="my-3 flex content-around">
		<h2 class="text-xl font-bold">Participants ({0})</h2>
		<button
			class=" p x-4 mx-3 rounded
                bg-white py-2 text-black">Invite Teams</button
		>
	</div>

	<table>
		<thead>
			<tr>
				<th>Name</th>
				<th>Rating</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			{#each data.event.teams as team}
				<tr>
					<td>{team.name}</td>
					<td>{team.rating}</td>
					<td>
						<button class="rounded px-4 py-2 text-red-500">Delete</button>
					</td>
				</tr>
			{/each}
		</tbody>
	</table>
</div>

<div class="bg-secondary mb-5 flex flex-col items-center rounded">
	<div class="my-3 flex">
		<h2 class="text-xl font-bold">Rounds ({0})</h2>
		<button class="rounded bg-white px-4 py-2 text-black">Add Round</button>
	</div>

	<table>
		<thead>
			<tr>
				<th>Name</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			{#each data.event.rounds as round}
				<tr>
					<td>{round.name}</td>
					<td>
						<button class="rounded bg-red-500 px-4 py-2">Delete</button>
					</td>
				</tr>
			{/each}
		</tbody>
	</table>
</div>

<div class="bg-secondary mb-5 flex flex-col items-center rounded">
	<h2 class="my-3 text-xl font-bold">Matches ({0})</h2>

	<table>
		<thead>
			<tr>
				<th>Name</th>
				<th>Rating</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			{#each data.event.teams as team}
				<tr>
					<td>{team.name}</td>
					<td>{team.rating}</td>
					<td>
						<button class="rounded px-4 py-2 text-red-500">Delete</button>
					</td>
				</tr>
			{/each}
		</tbody>
	</table>
</div>

<div class="bg-secondary mb-5 flex flex-col items-center rounded">
	<h2 class="my-3 text-xl font-bold text-red-600">Danger Zone</h2>

	<div>
		<label for="delete">Delete Event</label>
		<button class="rounded bg-red-500 px-4 py-2">Delete</button>
	</div>
</div>
