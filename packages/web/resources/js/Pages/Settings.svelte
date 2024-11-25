<script>
    import Layout from '@/Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'

    let form = useForm({
        profile_picture: null,
    })
</script>

<Layout>
    <h1>Setting</h1>

    <label for="profile_pic">Profile Picture</label>
    <input
        type="file"
        accept="image/*"
        onchange={(e) => {
            $form.profile_picture = e.target.files[0]
            $form.post('/profile/picture')
        }}
    />
</Layout>
