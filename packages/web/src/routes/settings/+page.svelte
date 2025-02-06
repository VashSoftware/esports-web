<script lang="ts">
	import { goto } from '$app/navigation';

	let { data } = $props();
</script>

<!-- Page container -->
<div class="py-10">
	<div class="mx-auto max-w-3xl px-4">
		<h1 class="mb-6 text-3xl font-bold">Settings</h1>

		<!-- Profile Information Section -->
		<div class="bg-secondary mb-6 rounded-lg p-6 shadow">
			<h2 class="mb-4 text-xl font-semibold">Profile Information</h2>
			<div class="space-y-4">
				<!-- Profile Picture -->
				<div>
					<label for="profile_pic" class="block text-sm font-medium text-white">
						Profile Picture
					</label>
					<input
						id="profile_pic"
						type="file"
						accept="image/*"
						class="mt-1 block w-full cursor-pointer rounded-lg border border-gray-300 text-sm text-white focus:outline-none"
					/>
				</div>
				<!-- Username -->
				<div>
					<label for="username" class="block text-sm font-medium text-white"> Username </label>
					<input
						id="username"
						type="text"
						placeholder="Username"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
					/>
				</div>
				<!-- Display Name -->
				<div>
					<label for="displayName" class="block text-sm font-medium text-white">
						Display Name
					</label>
					<input
						id="displayName"
						type="text"
						placeholder="Display Name"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
					/>
				</div>
				<!-- Email -->
				<div>
					<label for="email" class="block text-sm font-medium text-white"> Email </label>
					<input
						id="email"
						type="email"
						placeholder="Email"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
					/>
				</div>
				<!-- Password -->
				<div>
					<label for="password" class="block text-sm font-medium text-white"> Password </label>
					<input
						id="password"
						type="password"
						placeholder="Password"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
					/>
				</div>
			</div>
			<!-- Save Button -->
			<div class="mt-6 flex justify-end">
				<button
					class="rounded bg-green-600 px-4 py-2 text-white transition-colors hover:bg-green-700"
				>
					Save Changes
				</button>
			</div>
		</div>

		<!-- Social Accounts Section -->
		<div class="bg-secondary mb-6 rounded-lg p-6 shadow">
			<h2 class="mb-4 text-xl font-semibold">Social Accounts</h2>
			<div class="space-y-4">
				<!-- osu! -->
				<div class="flex items-center justify-between">
					<span class="font-medium text-white">osu!</span>
					<button
						class="rounded bg-blue-600 px-4 py-2 text-white transition-colors hover:bg-blue-700"
					>
						Connect
					</button>
				</div>
				<!-- Discord -->
				<div class="flex items-center justify-between">
					<span class="font-medium text-white">Discord</span>
					<button
						class="rounded bg-indigo-600 px-4 py-2 text-white transition-colors hover:bg-indigo-700"
					>
						Connect
					</button>
				</div>
				<!-- Twitch -->
				<div class="flex items-center justify-between">
					<span class="font-medium text-white">Twitch</span>
					<button
						class="rounded bg-purple-600 px-4 py-2 text-white transition-colors hover:bg-purple-700"
					>
						Connect
					</button>
				</div>
			</div>
		</div>

		<!-- Log Out Button -->
		<div class="flex justify-end">
			<button
				onclick={async () => {
					await data.supabase.auth.signOut();
					await goto('/login');
				}}
				class="rounded bg-red-600 px-4 py-2 text-white transition-colors hover:bg-red-700"
			>
				Log Out
			</button>
		</div>
	</div>
</div>
