<script>
    import Layout from '@/Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'

    let form = useForm({
        name: '',
    })

    function store() {
        $form.post('/teams')
    }
</script>

<Layout>
    <h1>Create Team</h1>

    <form on:click|preventDefault={store}>
        <label for="name">Name</label>
        <input id="name" type="text" class="text-black" bind:value={$form.name} />

        <button class="rounded bg-green-500 px-4 py-2"> Save</button>
    </form>
</Layout>
