<div class="container mx-auto mt-10">
    
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">ID</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">User</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Company</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Status</th>
                    <th class="py-3 px-4 text-center text-sm font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4 text-sm text-gray-700">{{$reservation->id}}</td>
                        <td class="py-3 px-4 text-sm text-gray-700">{{$reservation->user->name}}</td>
                        <td class="py-3 px-4 text-sm text-gray-700">
                            @if(!is_null($reservation->company))
                                {{$reservation->company->name}}
                            @else
                                -
                            @endif
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700">
                            @switch($reservation->status)
                                @case('pending')
                                    <span class="text-gray-400 py-1 px-1">Pending</span>
                                @break

                                @case('payment')
                                    <span class="text-amber-600 py-1 px-1">Payment Pending</span>
                                @break

                                @case('partial-payment')
                                    <span class="text-amber-600 py-1 px-1">Partial Payment Pending</span>
                                @break

                                @case('confirmed')
                                    <span class="text-green-600 py-1 px-1">Confirmed</span>
                                @break

                                @case('rejected')
                                    <span class="text-rose-600 py-1 px-1">Rejected</span>
                                @break
                            @endswitch
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700 text-center">
                            <button class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600" wire:click="">View</button>
                            <button class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600" wire:click="">Approve</button>
                            <button class="px-2 py-1 bg-rose-500 text-white rounded hover:bg-rose-600" wire:click="">Reject</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
