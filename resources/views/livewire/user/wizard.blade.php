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
                        <p class="text-lg"><span class="font-semibold">Name:</span> Ahmed Mohamed</p>
                        <p class="text-lg"><span class="font-semibold">NID No:</span> A000000</p>
                        <p class="text-lg"><span class="font-semibold">Contact:</span> 9999999</p>
                    </div>
                    <div>
                        <p class="text-lg"><span class="font-semibold">Email:</span> ahmed@mohamed.com</p>
                        <p class="text-lg"><span class="font-semibold">Permanent Address:</span> Kanburudooge, K.Huraa</p>
                        <p class="text-lg"><span class="font-semibold">Present Address:</span> H. Henveyruge, Male</p>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 mt-5">
                <div class="mb-4">
                    <select wire:model.lazy="company" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-1/5">
                      <option value="">Select Company/Institute</option>
                      <option value="company1">Company A</option>
                      <option value="company2">Company B</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 {{ $companySection == false ? 'hidden' : 'block' }}">
                   <div>
                        <p class="text-lg"><span class="font-semibold">Company/Institute Name:</span> Company A</p>
                        <p class="text-lg"><span class="font-semibold">Contact:</span> 3000000</p>
                    </div>
                   <div>
                        <p class="text-lg"><span class="font-semibold">Email:</span> info@company.com</p>
                        <p class="text-lg"><span class="font-semibold">Address:</span> H. Companyge, Male</p>
                   </div>
               </div>
            </div>
        </section>
        <section class="{{ $locationSection == false ? 'hidden' : 'block' }}">
            <div class="p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 mt-5">
                <div class="flex justify-between">
                    <select wire:model="location" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-1/5">
                      <option value="">Select Location</option>
                      <option value="company1">Location A</option>
                      <option value="company2">Location B</option>
                    </select>
                    <select wire:model="purpose" class="ml-5 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-1/5">
                      <option value="">Select Purpose</option>
                      <option value="company1">Purpose 1</option>
                      <option value="company2">Purpose 2</option>
                    </select>
                    <select wire:model="company" class="ml-5 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-1/5">
                      <option value="">Select Duration</option>
                      <option value="company1">8 Hrs</option>
                      <option value="company2">12 Hrs</option>
                      <option value="company2">24 Hrs</option>
                    </select>
                    <button class="w-1/6 py-3 bg-teal-500 text-white rounded hover:bg-teal-600" wire:click="addLocation">Add Location</button>
                </div>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 mt-2 {{ $locationDetails == false ? 'hidden' : 'block' }}">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div class="border-r pr-10 text-left">
                        <p class="text-lg"><span class="font-semibold">Location:</span> Location A</p>
                        <p class="text-lg"><span class="font-semibold">Purpose:</span> Purpose 1</p>
                        <p class="text-lg"><span class="font-semibold">Duration:</span> 8 Hrs</p>
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
                                    <th scope="col" class="px-6 py-3">
                                        Duration
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="{{ $showItem == false ? 'opacity-0' : 'opacity-100' }}">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Item 1
                                    </th>
                                    <td class="px-6 py-4">
                                        1
                                    </td>
                                    <td class="px-6 py-4">
                                        1 day(s)
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>    
                </div>
                <div class="flex justify-between mt-10">
                    <select wire:model="item" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-1/5">
                      <option value="">Select Item</option>
                      <option value="company1">Item 1</option>
                      <option value="company2">Item 2</option>
                      <option value="company2">Item 3</option>
                    </select>
                    <input type="number" placeholder="Quantity" wire:model="qty" class="ml-5 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-1/5">
                    <input type="number" placeholder="Duration (Days)" wire:model="duration" class="ml-5 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-1/5">
                    <button class="w-1/6 py-3 bg-lime-500 text-white rounded hover:bg-lime-600" wire:click="addItem">Add Item</button>
                </div>
            </div>
        </section>
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
               <button class="w-1/6 mt-4 py-3 bg-green-500 text-white rounded hover:bg-green-600" wire:click="nextStep">{{$buttonText}}</button>
           </div>
        </div>   
    </div>
</div>
