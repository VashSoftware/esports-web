<script>
    import { Link, page } from '@inertiajs/svelte'

    console.log($page.props.user)

    let { children } = $props()
</script>

<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="relative flex w-64 flex-col justify-between bg-secondary text-white">
        <!-- Top Section -->
        <div>
            <!-- Logo and Create Button -->
            <div class="flex items-center justify-between p-6">
                <Link href="/" class="text-2xl font-bold">Vash Esports</Link>
                <button
                    id="create-button"
                    onclick={() => (showMenu = !showMenu)}
                    class="text-3xl hover:text-gray-400 focus:outline-none"
                    aria-label="Create"
                >
                    +
                </button>
            </div>

            <!-- Create Menu -->
            {#if false}
                <div
                    id="create-menu"
                    class="absolute right-6 top-full z-50 mt-2 w-60 rounded-lg bg-secondary shadow-lg"
                >
                    <div class="border-b border-gray-700 py-2">
                        <p class="px-4 text-sm font-semibold">Play</p>
                        <ul class="mt-2">
                            <li>
                                <a
                                    href="#"
                                    class="block rounded-t-lg px-4 py-2 text-sm hover:bg-primary hover:bg-opacity-75"
                                >
                                    Matchmaking
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="block rounded-b-lg px-4 py-2 text-sm hover:bg-primary hover:bg-opacity-75"
                                >
                                    Custom Match
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="py-2">
                        <p class="px-4 text-sm font-semibold">Create</p>
                        <ul class="mt-2">
                            <li>
                                <a
                                    href="#"
                                    class="block rounded-t-lg px-4 py-2 text-sm hover:bg-primary hover:bg-opacity-75"
                                >
                                    Team
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm hover:bg-primary hover:bg-opacity-75">
                                    Organization
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="block rounded-b-lg px-4 py-2 text-sm hover:bg-primary hover:bg-opacity-75"
                                >
                                    Event
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            {/if}

            <!-- Navigation Links -->
            <nav class="mt-8 px-6">
                <ul class="space-y-2">
                    <li>
                        <Link
                            href="/matches"
                            class="block rounded px-4 py-2 transition-colors hover:bg-primary hover:bg-opacity-75"
                        >
                            Matches
                        </Link>
                    </li>
                    <li>
                        <Link
                            href="/events"
                            class="block rounded px-4 py-2 transition-colors hover:bg-primary hover:bg-opacity-75"
                        >
                            Events
                        </Link>
                    </li>
                    <li>
                        <Link
                            href="/leaderboard"
                            class="block rounded px-4 py-2 transition-colors hover:bg-primary hover:bg-opacity-75"
                        >
                            Leaderboard
                        </Link>
                    </li>
                    <li>
                        <Link
                            href="/map_pools"
                            class="block rounded px-4 py-2 transition-colors hover:bg-primary hover:bg-opacity-75"
                        >
                            Map Pools
                        </Link>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Profile Section -->
        <div class="bg-secondary p-6">
            <div class="flex items-center">
                <img
                    src={'/storage/' + $page.props.user?.profile.profile_picture}
                    alt="Profile"
                    class="h-10 w-10 rounded-full object-cover"
                />
                <div class="ml-3">
                    <Link href="/users/{$page.props.user?.id}">
                        <p class="text-sm font-medium">Stan</p>
                        <p class="text-xs text-gray-400">@stanrunge</p>
                    </Link>
                </div>
                <Link href="/settings">
                    <button
                        class="ml-auto rounded bg-primary p-2 hover:bg-opacity-75 focus:outline-none"
                        aria-label="Settings"
                    >
                        <!-- Settings Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"
                            ><path
                                fill="currentColor"
                                d="m9.25 22l-.4-3.2q-.325-.125-.612-.3t-.563-.375L4.7 19.375l-2.75-4.75l2.575-1.95Q4.5 12.5 4.5 12.338v-.675q0-.163.025-.338L1.95 9.375l2.75-4.75l2.975 1.25q.275-.2.575-.375t.6-.3l.4-3.2h5.5l.4 3.2q.325.125.613.3t.562.375l2.975-1.25l2.75 4.75l-2.575 1.95q.025.175.025.338v.674q0 .163-.05.338l2.575 1.95l-2.75 4.75l-2.95-1.25q-.275.2-.575.375t-.6.3l-.4 3.2zm2.8-6.5q1.45 0 2.475-1.025T15.55 12t-1.025-2.475T12.05 8.5q-1.475 0-2.488 1.025T8.55 12t1.013 2.475T12.05 15.5"
                            /></svg
                        >
                    </button>
                </Link>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 overflow-auto bg-primary p-6 text-white">
        <!-- Content goes here -->
        {@render children?.()}
    </main>
</div>
