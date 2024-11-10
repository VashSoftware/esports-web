<script>
    import Layout from '@/Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'

    let form = useForm({
        name: '',
    })

    const createMapPool = () => {
        $form.post('/map_pools')
    }
</script>

<Layout>
    <form on:submit|preventDefault={createMapPool}>
        <label for="title">Title</label>
        <input type="text" id="title" bind:value={$form.name} />

        <button type="submit">Create Map Pool</button>
    </form>
</Layout>
