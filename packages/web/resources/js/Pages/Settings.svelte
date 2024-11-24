<script>
    import Layout from '@/Shared/Layout.svelte'
    import { router, useForm } from '@inertiajs/svelte'

    let form = useForm({
        profile_picture: null,
    })
</script>

<Layout>
    <h1>Setting</h1>

    <label for="profile_pic">Profile Picture</label>
    <input type="file" accept="image/*" bind:value={$form.profile_picture} onchange={(e) => $form.patch('/profile')} />
</Layout>
