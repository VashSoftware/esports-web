<script lang="ts">
    import Layout from '@/Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'

    let form = useForm({
        title: '',
    })

    function submitForm() {
        $form.post('/events')
    }
</script>

<Layout>
    <form on:submit|preventDefault={submitForm}>
        <input type="text" bind:value={$form.title} />
        <button>Create Event</button>
    </form>
</Layout>
