<div class="bg-gray-50 text-gray-800 min-h-screen">

    <x-user.components.nav />

    <div class="container mx-auto p-6">
        <header class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-semibold">New Reservation - {{ $stepDescription }}</h2>
        </header>
        <section class="{{ $infoSection == false ? 'hidden' : 'block' }}">
            <div class="p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <p class="text-lg"><span class="font-semibold">Name:</span> {{\Auth::user()->name}}</p>
                        <p class="text-lg"><span class="font-semibold">NID No:</span> {{\Auth::user()->nid}}</p>
                        <p class="text-lg"><span class="font-semibold">Contact:</span> {{\Auth::user()->contact}}</p>
                    </div>
                    <div>
                        <p class="text-lg"><span class="font-semibold">Email:</span> {{\Auth::user()->email}}</p>
                        <p class="text-lg"><span class="font-semibold">Permanent Address:</span> {{\Auth::user()->paddress}}</p>
                        <p class="text-lg"><span class="font-semibold">Present Address:</span> {{\Auth::user()->address}}</p>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 mt-5">
                <div class="mb-4">
                    <select wire:model.lazy="rType" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-1/5">
                      <option value="">Select Reservation Type</option>
                      <option value="2">Individual</option>
                      <option value="1">Company/Institute</option>
                    </select>
                    @if((!is_null($rType))&&($rType == "1"))
                    <select wire:model.lazy="companyId" class="ml-10 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-1/5">
                      <option value="">Select Company/Institute</option>
                      @foreach(\Auth::user()->companies as $companyx)
                        <option value="{{ $companyx->id }}">{{ $companyx->name }}</option>
                      @endforeach
                    </select>
                    @endif
                </div>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 {{ $companySection == false ? 'hidden' : 'block' }}">
                   <div>
                        <p class="text-lg"><span class="font-semibold">Company/Institute Name:</span> {{$company->name}}</p>
                        <p class="text-lg"><span class="font-semibold">Contact:</span> {{$company->contact}}</p>
                    </div>
                   <div>
                        <p class="text-lg"><span class="font-semibold">Email:</span> {{$company->email}}</p>
                        <p class="text-lg"><span class="font-semibold">Address:</span> {{$company->address}}</p>
                   </div>
               </div>
            </div>
        </section>
        <section class="{{ $locationSection == false ? 'hidden' : 'block' }}">
            <div class="p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 mt-5">
                <div class="grid grid-cols-3 gap-6">
                    <select wire:model.lazy="locationId" class="w-full shadow appearance-none border rounded mt-7 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-1/5">
                        <option value="">Select Location</option>
                        @foreach($locations as $location)
                            <option value="{{$location->id}}">{{ $location->description }} ({{$location->capacity}} pax)</option>
                        @endforeach
                    </select>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">From</label>
                            <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" required wire:model.lazy="from" min="{{\Carbon\Carbon::now()->addDay()->format('Y-m-d')}}">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">To</label>
                            @php
                                if(is_null($from) || ($from == ""))
                                {
                                    $to_min = \Carbon\Carbon::now()->addDay()->format('Y-m-d');
                                }
                                else
                                {
                                    $to_min = $from;
                                }
                            @endphp
                            <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" required wire:model.lazy="to" min="{{$to_min}}">
                    </div>
                    <select wire:model="etypeId" class="w-full shadow appearance-none border rounded mt-7 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-1/5">
                        <option value="">Select Purpose</option>
                        @foreach($etypes as $etype)
                            <option value="{{$etype->id}}">{{$etype->description}}</option>
                        @endforeach
                    </select>
                    <select wire:model="tierId" class="w-full shadow appearance-none border rounded mt-7 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-1/5 {{ $showDuration == false ? 'opacity-0 -z-index-10' : 'opacity-100 z-index-10' }}">
                        <option value="">Select Duration</option>
                        @foreach($tiers as $tier)
                            <option value="{{ $tier->id }}">{{$tier->hrs}} Hrs</option>
                        @endforeach
                    </select>
                    <div class="flex justify-end">
                        <button class="w-full mt-7 py-3 bg-lime-500 text-white rounded hover:bg-lime-600" wire:click="addLocation">Add Location</button>
                    </div>
                </div>
                <div class="mt-5 col-span-5 bg-red-100 w-full rounded px-2 py-1 text-sm text-red-800 {{ $showLocationError === true ? 'block' : 'hidden' }}">{{$msg}}</div>
            </div>
        </section>
        @foreach($rlocations as $rlocation)
        <div class="p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 mt-5 {{ $locationDetails == false ? 'hidden' : 'block' }}">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                <div class="border-r pr-10 text-left">
                    <p class="text-lg"><span class="font-semibold">Location:</span> {{$rlocation["location"]->description}}</p>
                    <p class="text-lg"><span class="font-semibold">Purpose:</span> {{$rlocation["etype"]->description}}</p>
                    <p class="text-lg"><span class="font-semibold">Duration:</span> 
                        @if(!isset($rlocation["tier"]->hrs))
                            {{$rlocation["tier"]}} Day(s)
                        @else
                            {{$rlocation["tier"]->hrs}} Hrs
                        @endif
                    </p>
                </div>
                <div class="col-span-2">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase border-b">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Item
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Qty
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ritems as $ritem)
                            <tr>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{$ritem->description}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$ritem->qty}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>    
            </div>
            <div class="flex justify-between mt-10">
                <select wire:model="itemId" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-1/3">
                    <option value="">Select Item</option>
                    @foreach($items as $item)
                        <option value="{{$item->id}}">{{$item->description}}</option>
                    @endforeach
                </select>
                <input type="number" placeholder="Quantity" wire:model="qty" class="mx-5 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-1/3" min="1" value="1">
                <button class="w-1/3 py-3 bg-lime-500 text-white rounded hover:bg-lime-600" wire:click="addItem">Add Item</button>
            </div>
        </div>
        @endforeach
        <section class="{{ $confirmSection == false ? 'hidden' : 'block' }}">
            <div class="p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 mt-5">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>
        </section>
        <div class="p-6 mt-5">
            <div class="flex justify-center">
                @if($locationSection == true)
                    @if($rlocations != [])
                        <button class="w-1/6 mt-4 py-3 bg-green-600 text-white rounded hover:bg-green-700" wire:click="nextStep">{{$buttonText}}</button>
                    @endif
                @elseif((($rType == 1) && !is_null($companyId))||($rType == 2))
                    <button class="w-1/6 mt-4 py-3 bg-green-600 text-white rounded hover:bg-green-700" wire:click="nextStep">{{$buttonText}}</button>
                @endif
           </div>
        </div>   
    </div>
</div>
