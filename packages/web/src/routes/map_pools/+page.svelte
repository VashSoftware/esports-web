<script>
	import { goto } from '$app/navigation';
	import * as Table from '$lib/components/ui/table';

	let { data } = $props();
</script>

<div class="my-5 flex items-center justify-between">
	<div></div>
	<h1 class="text-center text-2xl">Map Pools</h1>

	<a href="/map_pools/create">
		<button class="mx-16 rounded bg-blue-500 px-4 py-2">Create</button>
	</a>
</div>

<div class="my-16 flex flex-col content-center">
	<Table.Root>
		<Table.Header>
			<Table.Row>
				<Table.Head class="w-[100px]">Invoice</Table.Head>
				<Table.Head>Status</Table.Head>
				<Table.Head>Method</Table.Head>
				<Table.Head class="text-right">Amount</Table.Head>
			</Table.Row>
		</Table.Header>
	</Table.Root>

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
				<tr onclick={() => goto(`/map_pools/${pool.id}`)}>
					<td>
						{#if pool.verified_at}
							<div>Verified</div>
						{/if}
						{pool.name}</td
					>
					<td>{pool.description}</td>
					<td>{pool.created_at}</td>
				</tr>
			{/each}
		</tbody>
	</table>
</div>
