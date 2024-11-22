<script lang="ts">
    import Layout from '@/Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'

    let { organisation_members } = $props()

    let form = useForm({
        title: '',
        organisation_id: null,
        event_group_id: null,
    })

    function submitForm() {
        $form.post('/events')
    }
</script>

<Layout>
    <form on:submit|preventDefault={submitForm} class="flex flex-col text-center">
        <div class="my-3 flex justify-around">
            <label for="organization">Organization</label>
            <select bind:value={$form.organisation_id} class="text-black">
                {#each organisation_members as organisation_member}
                    <option value={organisation_member.organisation.id}>{organisation_member.organisation.name}</option>
                {/each}
            </select>
        </div>

        <div class="my-3 flex justify-around">
            <label for="event_group">Event Group</label>
            <select bind:value={$form.event_group_id} class="text-black">
                {#each organisation_members.find((om) => om.organisation.id == $form.organisation_id)?.organisation.event_groups as event_group}
                    <option value={event_group.id}>{event_group.name}</option>
                {/each}
            </select>
        </div>
        <div class="my-3 flex justify-around">
            <label for="event_group">Title</label>
            <input class="text-black" type="text" bind:value={$form.title} />
        </div>
        <div class="my-3 flex justify-around">
            <label for="event_group">Game</label>
            <select class="text-black">
                {#each [] as game}
                    <option value={game.id}>{game.name}</option>
                {/each}
            </select>
        </div>
        <div class="my-3 flex justify-around">
            <label for="event_group">Game Mode</label>
            <select class="text-black">
                {#each [] as game_mode}
                    <option value={game_mode.id}>{game_mode.name}</option>
                {/each}
            </select>
        </div>

        <p>You will need to finish setting up your event later.</p>

        <div class="my-3">
            <button class=" rounded bg-emerald-500 px-3 py-2 font-bold text-black">Create Event</button>
        </div>
    </form>
</Layout>
