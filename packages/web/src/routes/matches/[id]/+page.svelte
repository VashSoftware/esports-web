<script>
	const { data } = $props();
</script>

<div>
	<div>{data.match.game}</div>
</div>

<div class="flex justify-evenly">
	<div>
		<img src="" alt="" />
		<h2 class="text-2xl font-bold">{data.match.match_participants[0].team.name}</h2>
	</div>
	<div class="text-center">
		<div class="my-3 text-xl font-bold text-red-500">LIVE</div>
		<div class="flex items-center gap-5">
			<div class="text-2xl font-bold">5</div>
			-
			<div class="text-2xl font-bold">3</div>
		</div>
	</div>
	<div>
		<img src="" alt="" />
		<h2 class="text-2xl font-bold">{data.match.match_participants[1].team.name}</h2>
	</div>
</div>
