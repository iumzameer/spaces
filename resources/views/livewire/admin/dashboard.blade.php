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
                    <tr class="hover:bg-gray-100">
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

                                @case('process')
                                    <span class="text-amber-600 py-1 px-1">Payment Verification Pending</span>
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
                            @if($reservation->status == "pending")
                                <button class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600" wire:click="approveReservation({{$reservation->id}})">Approve</button>
                                <button class="px-2 py-1 bg-rose-500 text-white rounded hover:bg-rose-600" wire:click="rejectReservation({{$reservation->id}})">Reject</button>
                            @elseif($reservation->status == "process")
                                <button class="px-2 py-1 bg-teal-500 text-white rounded hover:bg-teal-600" wire:click="openSlipModal({{$reservation->id}})">Verify Slip</button>
                            @endif
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-100 text-center">
                        <td colspan="5">

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 {{ $slipModal == false ? 'hidden' : '' }} transition-all">
        <!-- Modal Content -->
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 relative">
            <!-- Close Button -->
            <h2 class="text-lg font-semibold p-4">Slip Verification</h2>
            <button class="absolute top-3 right-3 text-gray-500 hover:text-gray-700" wire:click="closeSlipModal">
                x
            </button>

            <div class="p-6">
                <img src="{{url('/')}}/storage/{{$url}}" alt="Portrait" class="w-full rounded-lg mb-4">
                
            </div>

            <div class="px-6 pb-6 flex justify-center gap-2">
                <button class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600" wire:click="verifySlip">Verify</button>
                <button class="bg-red-500 text-white font-semibold py-2 px-4 rounded hover:bg-red-600" wire:click="rejectSlip">Reject</button>
                <button class="bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded hover:bg-gray-400" wire:click="closeSlipModal">Cancel</button>
            </div>
        </div>
    </div>
</div>
