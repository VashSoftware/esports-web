<div class="flex min-h-screen items-center justify-center">
	<!-- Form card -->
	<form
		method="POST"
		action="?/login"
		class="w-full max-w-sm space-y-6 rounded-lg border border-white p-8 shadow-lg"
	>
		<h2 class="text-center text-2xl font-semibold text-white">Login</h2>

		<!-- Email Input -->
		<div>
			<label for="email" class="mb-2 block text-gray-300"> Email </label>
			<input
				id="email"
				name="email"
				type="email"
				required
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
				required
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
				type="button"
				formaction="?/signup"
				class="rounded bg-gray-600 px-4 py-2 font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
			>
				Sign Up
			</button>
		</div>
	</form>
</div>
