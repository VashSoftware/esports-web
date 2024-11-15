<script>
    import Layout from '@/Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'
    import { preventDefault } from 'svelte/legacy'

    let { mods = [] } = $props()

    let form = useForm({
        name: '',
        code: '',
    })
</script>

<Layout>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
            </tr>
        </thead>
        <tbody>
            {#each mods as mod}
                <tr>
                    <td>{mod.name}</td>
                    <td>{mod.code}</td>
                </tr>
            {/each}
        </tbody>
    </table>

    <form onsubmit={preventDefault(() => $form.post('/mods'))}>
        <input type="text" name="name" placeholder="Name" class="text-black" bind:value={$form.name} />
        <input type="text" name="code" placeholder="Code" class="text-black" bind:value={$form.code} />
        <button>Add Mod</button>
    </form>
</Layout>
