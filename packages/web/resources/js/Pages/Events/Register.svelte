<script>
    import Layout from '@/Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'

    let { event, team_members } = $props()

    let form = useForm({
        team_id: null,
        event_id: event.id,
    })

    function register() {
        $form.post(`/participants`)
    }
</script>

<Layout>
    <h1 class="my-5 text-center text-2xl">Register for {event.title}</h1>

    <form class="flex flex-col text-center">
        <div class="my-2">
            <label>Team</label>
            <select bind:value={$form.team_id} class="text-black">
                {#each team_members as team_member}
                    <option value={team_member.team.id}>{team_member.team.name}</option>
                {/each}
            </select>
        </div>

        <div class="my-2">
            <input id="terms" type="checkbox" />
            <label for="terms">I accept the event organizer's Terms of Service</label>
        </div>

        <div>
            <button class="my-4 rounded-lg bg-green-500 px-8 py-4" type="button" onclick={register}>Register</button>
        </div>
    </form>
</Layout>
