<script>
	import '../app.css';

	let { children, data } = $props();

	let showMenu = $state(false);

	// let current_matches = $state($page.props.current_matches )
</script>

<div class="flex h-screen">
	<!-- Sidebar -->
	<aside class="relative flex w-64 flex-col justify-between bg-gray-900 text-white">
		<!-- Top Section -->
		<div>
			<!-- Logo and Create Button -->
			<div class="flex items-center justify-between p-6">
				<a href="/" class="text-2xl font-bold">Vash Esports</a>
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
			{#if showMenu}
				<div
					id="create-menu"
					class="absolute right-6 top-full z-50 mt-2 w-60 rounded-lg bg-black shadow-lg"
				>
					<div class="border-b border-gray-700 py-2">
						<p class="px-4 text-sm font-semibold">Play</p>
						<ul class="mt-2">
							<li>
								<a
									href="#"
									class="hover:bg-black block rounded-t-lg px-4 py-2 text-sm hover:bg-opacity-75"
								>
									Matchmaking
								</a>
							</li>
							<li>
								<a
									href="#"
									class="hover:bg-black block rounded-b-lg px-4 py-2 text-sm hover:bg-opacity-75"
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
									class="hover:bg-black block rounded-t-lg px-4 py-2 text-sm hover:bg-opacity-75"
								>
									Team
								</a>
							</li>
							<li>
								<a href="#" class="hover:bg-black block px-4 py-2 text-sm hover:bg-opacity-75">
									Organization
								</a>
							</li>
							<li>
								<a
									href="#"
									class="hover:bg-black block rounded-b-lg px-4 py-2 text-sm hover:bg-opacity-75"
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
						<a
							href="/matches"
							class="hover:bg-black block rounded px-4 py-2 transition-colors hover:bg-opacity-75"
						>
							Matches
						</a>
					</li>
					<!--                    <li>
                        <a
                            href="/events"
                            class="block rounded px-4 py-2 transition-colors hover:bg-black hover:bg-opacity-75"
                        >
                            Events
                        </a>
                   </li>
   -->
					<li>
						<a
							href="/leaderboard"
							class="hover:bg-black block rounded px-4 py-2 transition-colors hover:bg-opacity-75"
						>
							Leaderboard
						</a>
					</li>
					<li>
						<a
							href="/map_pools"
							class="hover:bg-black block rounded px-4 py-2 transition-colors hover:bg-opacity-75"
						>
							Map Pools
						</a>
					</li>
					<li>
						<a
							href="/premium"
							class="hover:bg-black block rounded px-4 py-2 transition-colors hover:bg-opacity-75"
						>
							Premium
						</a>
					</li>
				</ul>
			</nav>
		</div>

		<!-- Profile Section -->
		<div class="bg-gray-900 p-6">
			<div class="flex items-center justify-between">
				<a href="/users/{data.user?.id}">
					<div class="flex">
						<!-- <img
							src={'/storage/' + data.user?.profile_picture}
							alt="Profile"
							class="h-10 w-10 rounded-full object-cover"
						/> -->
						<div class="ml-3">
							<p class="text-sm font-medium">{data.user?.displayName}</p>
							<p class="text-xs text-gray-400">@{data.user?.username}</p>
						</div>
					</div>
				</a>
				<a href="/settings">
					<button
						class="bg-black ml-auto rounded p-2 hover:bg-opacity-75 focus:outline-none"
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
				</a>
			</div>
		</div>
	</aside>

	<!-- Main Content Area -->
	<main class="bg-black flex-1 overflow-auto text-white">
		<!-- {#if $page.component != 'Matches/Play' && $page.props.match_queue}
			<div
				class="flex items-center justify-between bg-yellow-500 p-2 text-center text-xl font-bold text-black"
			>
				<div></div>
				<p>You're in the queue!</p>
				<button
					onclick={() => router.delete('/match-queue')}
					class="mx-1 rounded bg-black px-2 py-1 text-white">X</button
				>
			</div>
		{/if}

		{#if $page.component != 'Matches/Play' && current_matches.length > 0}
			<a href="/matches/{current_matches[0].id}/play">
				<div
					class="flex items-center justify-between bg-yellow-500 p-2 text-center text-xl font-bold text-black"
				>
					<div></div>
					<p>You're in a match!</p>
					<button class="mx-1 rounded bg-black px-2 py-1 text-white">X</button>
				</div>
			</a>
		{/if} -->
		<!-- Content goes here -->
		{@render children?.()}
	</main>
</div>
