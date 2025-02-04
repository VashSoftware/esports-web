<script lang="ts">
	import { goto } from '$app/navigation';
	import { Button, buttonVariants } from '$lib/components/ui/button/index.js';
	import * as Dialog from '$lib/components/ui/dialog/index.js';
	import { Input } from '$lib/components/ui/input/index.js';
	import { Label } from '$lib/components/ui/label/index.js';

	let { data } = $props();
</script>

<Dialog.Root>
	<div class="my-5 flex items-center justify-between">
		<div></div>
		<h1 class="text-center text-2xl">Map Pools</h1>
		<Dialog.Trigger class={buttonVariants({ variant: 'outline' })}>Edit Profile</Dialog.Trigger>
	</div>

	<div class="my-16 flex flex-col content-center">
		<table class="table-auto">
			<thead>
				<tr>
					<th>Name</th>
					<th>Created At</th>
					<th>Mods</th>
				</tr>
			</thead>
			<tbody>
				{#each data.mapPools as pool}
					<tr
						onclick={() => goto(`/map_pools/${pool.id}`)}
						class="cursor-pointer hover:bg-gray-100"
					>
						<td>
							{#if pool.verified_at}
								<div>Verified</div>
							{/if}
							{pool.name}
						</td>
						<td>{pool.description}</td>
						<td>{pool.created_at}</td>
					</tr>
				{/each}
			</tbody>
		</table>
	</div>

	<Dialog.Content class="sm:max-w-[425px]">
		<form action="?/createMapPool" method="post">
			<Dialog.Header>
				<Dialog.Title>Create Map Pool</Dialog.Title>
				<Dialog.Description>You can add maps after you create the pool.</Dialog.Description>
			</Dialog.Header>
			<div class="grid gap-4 py-4">
				<div class="grid grid-cols-4 items-center gap-4">
					<Label for="name" class="text-right">Name</Label>
					<Input id="name" name="name" value="My Map Pool" class="col-span-3" />
				</div>
			</div>
			<Dialog.Footer>
				<Button type="submit">Create</Button>
			</Dialog.Footer>
		</form>
	</Dialog.Content>
</Dialog.Root>
