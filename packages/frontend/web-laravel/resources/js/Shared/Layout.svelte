<script>
    export let auth;

    let showMenu = false;

    // Function to handle click outside the menu to close it
    const handleClickOutside = (event) => {
        const menu = document.getElementById("create-menu");
        const button = document.getElementById("create-button");
        if (
            menu &&
            !menu.contains(event.target) &&
            button &&
            !button.contains(event.target)
        ) {
            showMenu = false;
        }
    };

    // Add event listener when menu is open
    $: if (showMenu) {
        window.addEventListener("click", handleClickOutside);
    } else {
        window.removeEventListener("click", handleClickOutside);
    }
</script>

<div class="flex h-screen">
    <!-- Sidebar -->
    <aside
        class="w-64 bg-secondary text-white flex flex-col justify-between relative"
    >
        <!-- Top Section -->
        <div>
            <!-- Logo and Create Button -->
            <div class="flex items-center justify-between p-6">
                <a href="/" class="text-2xl font-bold">Vash Esports</a>
                <button
                    id="create-button"
                    on:click={() => (showMenu = !showMenu)}
                    class="text-3xl focus:outline-none hover:text-gray-400"
                    aria-label="Create"
                >
                    +
                </button>
            </div>

            <!-- Create Menu -->
            {#if showMenu}
                <div
                    id="create-menu"
                    class="absolute top-full right-6 mt-2 w-60 bg-secondary rounded-lg shadow-lg z-50"
                >
                    <div class="py-2 border-b border-gray-700">
                        <p class="px-4 text-sm font-semibold">Play</p>
                        <ul class="mt-2">
                            <li>
                                <a
                                    href="#"
                                    class="block px-4 py-2 text-sm hover:bg-primary hover:bg-opacity-75 rounded-t-lg"
                                >
                                    Matchmaking
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="block px-4 py-2 text-sm hover:bg-primary hover:bg-opacity-75 rounded-b-lg"
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
                                    class="block px-4 py-2 text-sm hover:bg-primary hover:bg-opacity-75 rounded-t-lg"
                                >
                                    Team
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="block px-4 py-2 text-sm hover:bg-primary hover:bg-opacity-75"
                                >
                                    Organization
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="block px-4 py-2 text-sm hover:bg-primary hover:bg-opacity-75 rounded-b-lg"
                                >
                                    Event
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            {/if}

            <!-- Navigation Links -->
            <nav class="px-6 mt-8">
                <ul class="space-y-2">
                    <li>
                        <a
                            href="/matches"
                            class="block py-2 px-4 rounded hover:bg-primary hover:bg-opacity-75 transition-colors"
                        >
                            Matches
                        </a>
                    </li>
                    <li>
                        <a
                            href="/events"
                            class="block py-2 px-4 rounded hover:bg-primary hover:bg-opacity-75 transition-colors"
                        >
                            Events
                        </a>
                    </li>
                    <li>
                        <a
                            href="/leaderboard"
                            class="block py-2 px-4 rounded hover:bg-primary hover:bg-opacity-75 transition-colors"
                        >
                            Leaderboard
                        </a>
                    </li>
                    <li>
                        <a
                            href="/map_pools"
                            class="block py-2 px-4 rounded hover:bg-primary hover:bg-opacity-75 transition-colors"
                        >
                            Map Pools
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Profile Section -->
        <div class="p-6 bg-secondary">
            <div class="flex items-center">
                <img
                    src="https://via.placeholder.com/40"
                    alt="Profile"
                    class="rounded-full w-10 h-10 object-cover"
                />
                <div class="ml-3">
                    <a href="/users/{auth}">
                        <p class="text-sm font-medium">Stan</p>
                        <p class="text-xs text-gray-400">@stanrunge</p>
                    </a>
                </div>
                <button
                    class="ml-auto bg-primary p-2 rounded hover:bg-opacity-75 focus:outline-none"
                    aria-label="Settings"
                >
                    <!-- Settings Icon -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-white"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <!-- SVG path for the settings icon -->
                        <path
                            d="M11.3 1.046a1 1 0 00-2.6 0l-.5 2a1 1 0 01-.9.654l-2.05.146a1 1 0 00-.554 1.706l1.483 1.484a1 1 0 01.291.958l-.396 1.984a1 1 0 00.972 1.194l2.07-.147a1 1 0 01.957.29l1.483 1.483a1 1 0 001.706-.554l.146-2.05a1 1 0 01.654-.9l2-.5a1 1 0 000-2.6l-2-.5a1 1 0 01-.654-.9l-.146-2.05a1 1 0 00-1.706-.554L12.247 3.09a1 1 0 01-.958.291l-1.984-.396a1 1 0 00-1.194.972l.147 2.07a1 1 0 01-.29.957L7.387 9.345a1 1 0 00.554 1.706l2.05.146a1 1 0 01.9.654l.5 2a1 1 0 002.6 0l.5-2a1 1 0 01.9-.654l2.05-.146a1 1 0 00.554-1.706l-1.483-1.484a1 1 0 01-.291-.958l.396-1.984a1 1 0 00-.972-1.194l-2.07.147a1 1 0 01-.957-.29L9.86 2.6a1 1 0 00-1.706.554l-.146 2.05a1 1 0 01-.654.9l-2 .5z"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 bg-primary text-white overflow-auto p-6">
        <!-- Content goes here -->
        <slot />
    </main>
</div>
