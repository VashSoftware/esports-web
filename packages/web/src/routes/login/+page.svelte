<div class="flex min-h-screen items-center justify-center">
	<!-- Form card -->
	<form
		method="POST"
		action="?/login"
		class="w-full max-w-sm space-y-6 rounded-lg border border-white p-8 shadow-lg"
	>
		<h2 class="text-center text-2xl font-semibold text-white">Log in to Vash Esports</h2>

		<!-- Email Input -->
		<div>
			<label for="email" class="mb-2 block text-gray-300"> Email </label>
			<input
				id="email"
				name="email"
				type="text"
				placeholder="you@example.com"
				class="w-full rounded bg-gray-700 px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
			/>
		</div>

		<!-- Password Input -->
		<div>
			<label for="password" class="mb-2 block text-gray-300"> Password </label>
			<input
				id="password"
				name="password"
				type="password"
				placeholder="Your password"
				class="w-full rounded bg-gray-700 px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
			/>
		</div>

		<!-- Buttons -->
		<div class="flex items-center justify-between">
			<button
				type="submit"
				class="rounded bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
			>
				Login
			</button>
			<button
				type="submit"
				formaction="?/signup"
				class="rounded bg-gray-600 px-4 py-2 font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
			>
				Sign Up
			</button>
		</div>

		<div class="py-4 text-center">or, log in with these platforms:</div>

		<div>
			<div class="align-center flex flex-col gap-2">
				<button
					type="button"
					class="flex items-center space-x-2 rounded bg-pink-600 px-4 py-2 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
					formaction="?/signInWithOsu"
				>
					<!-- Osu Icon could go here -->
					<span>osu!</span>
				</button>
				<button
					type="button"
					class="flex items-center space-x-2 rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
					formaction="?/signInWithDiscord"
				>
					<!-- Discord Icon could go here -->
					<span>Discord</span>
				</button>
				<button
					type="button"
					class="flex items-center space-x-2 rounded bg-purple-600 px-4 py-2 text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
					formaction="?/signInWithTwitch"
				>
					<!-- Twitch Icon could go here -->
					<span>Twitch</span>
				</button>
				<button
					type="submit"
					formaction="?/signInWithGoogle"
					class="flex items-center space-x-2 rounded bg-red-600 px-4 py-2 text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
				>
					<!-- Google Icon could go here -->
					<span>Google</span>
				</button>
			</div>
		</div>
	</form>
</div>
