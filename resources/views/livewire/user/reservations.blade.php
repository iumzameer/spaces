<div class="bg-gray-50 text-gray-800 min-h-screen">

    <x-user.components.nav />

    <div class="container mx-auto p-6">
        <header class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-semibold">Dashboard</h2>
            <a href="{{ route('user.wizard') }}" class="px-6 py-2 text-white bg-blue-600 rounded-full shadow hover:bg-blue-700 focus:outline-none" wire:click="newReservation">
                New Reservation
            </a>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($reservations as $reservation)
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-2">#{{$reservation->id}}</h3>
                    <p class="text-gray-600 my-3"><strong>No of Locations:</strong> {{$reservation->locations()->count()}}</p>
                    <p class="text-gray-600 my-3"><strong>No of Items:</strong> {{$reservation->items()->count()}}</p>
                    <p class="text-gray-600 my-3"><strong>Date:</strong> {{$reservation->created_at->format('jS M, Y')}}</p>
                    
                    @php
                        if($reservation->status == "approved")
                        {
                            $color = "green-600";
                            $txt = "Approved";
                        }
                        elseif($reservation->status == "rejected")
                        {
                            $color = "red-600";
                            $txt = "Rejected";
                        }
                        elseif($reservation->status == "payment")
                        {
                            $color = "amber-600";
                            $txt = "Payment Pending";
                        }
                        else
                        {
                            $color = "gray-400";
                            $txt = "Pending";
                        }
                    @endphp

                    <p class="text-gray-600 my-3"><strong>Status:</strong> <span class="rounded-lg py-1 px-2 text-{{$color}}">{{$txt}}</span></p>
                    <div class="flex justify-center">
                        <button class="mt-4 py-1 px-2 bg-blue-500 text-white rounded hover:bg-blue-600">View</button>
                        @if($reservation->status == "payment")
                            <button class="ml-2 mt-4 py-1 px-2 bg-green-500 text-white rounded hover:bg-green-600">Pay</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
