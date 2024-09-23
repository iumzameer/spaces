<div class="bg-gray-50 text-gray-800 min-h-screen">

    <x-user.components.nav />

    <div class="container mx-auto p-6">
        <header class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-semibold">Dashboard</h2>
            <a href="{{ route('user.wizard') }}" class="px-6 py-2 text-white bg-blue-600 rounded-full shadow hover:bg-blue-700 focus:outline-none" wire:click="newReservation">
                New Reservation
            </a>
        </header>

        <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Example Card -->
            <div class="p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                <h3 class="mb-4 text-lg font-medium">Upcoming Reservation</h3>
                <p class="text-sm text-gray-600">No confirmed reservations</p>
                <!-- <p class="text-sm text-gray-600">Room A, 10:00 AM - 12:00 PM</p> -->
                <!-- <p class="mt-1 text-sm text-gray-600">Date: 29th August 2024</p> -->
            </div>

            <div class="p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                <h3 class="mb-4 text-lg font-medium">Pending Reservations</h3>
                <p class="text-sm text-gray-600">1 new request</p>
            </div>

            <div class="p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                <h3 class="mb-4 text-lg font-medium">Available Spaces</h3>
                <p class="text-sm text-gray-600">5 spaces available today</p>
            </div>
        </section>
    </div>
</div>
