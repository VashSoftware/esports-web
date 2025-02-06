<script>
	const { data } = $props();
</script>

<h1>{data.organisation.name}</h1>

<a href="/organisations/{data.organisation.id}/edit">
	<button>Edit</button>
</a>
