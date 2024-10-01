<div class="bg-gray-50 text-gray-800 min-h-screen">

    <x-user.components.nav />

    <div class="container mx-auto p-6">
        <header class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-semibold">Profile</h2>
        </header>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6 bg-white shadow-lg rounded-lg p-8">
          <!-- Name -->
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input type="text" placeholder="Enter your name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" required wire:model = "name">
          </div>

          <!-- NID No -->
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">NID No</label>
            <input type="text" placeholder="Enter your NID No" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" required wire:model = "nid">
          </div>

          <!-- Contact No -->
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Contact No</label>
            <input type="text" placeholder="Enter your contact number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" required wire:model = "contact">
          </div>

          <!-- Email -->
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" placeholder="Enter your email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" required wire:model = "email">
          </div>

          <!-- Present Address -->
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Present Address</label>
            <input type="text" placeholder="Enter your present address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" required wire:model = "address">
          </div>

          <!-- Permanent Address -->
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Permanent Address</label>
            <input type="text" placeholder="Enter your permanent address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" required wire:model = "paddress">
          </div>
          <div class="md:col-span-2 lg:col-span-3 bg-{{ $profileMsgType === 'success' ? 'green' : 'red' }}-100 w-full rounded px-2 py-1 text-sm text-{{ $profileMsgType === 'success' ? 'green' : 'red' }}-800 {{ $showProfileMsg === true ? 'block' : 'hidden' }}">{{$msg}}</div>
        </div>
        <div class="p-5">
            <div class="flex justify-center" bis_skin_checked="1">
               <button class="w-1/6 py-3 bg-green-500 text-white rounded hover:bg-green-600" wire:click="saveProfile">Save</button>
           </div>
        </div>
        <header class="flex items-center justify-between mb-2 mt-7">
            <h2 class="text-2xl font-semibold">Companies/Institutes</h2>
            <button class="w-1/6 my-2 py-2 bg-teal-500 text-white rounded hover:bg-teal-600 " wire:click="addCompany">Add</button>
        </header>
        @if($action == "add")
          <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-x-6 mb-6 bg-white shadow-lg rounded-lg p-6">
            <!-- Name -->
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" placeholder="Enter your name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" wire:model="company_name">
            </div>

            <!-- Contact No -->
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Contact No</label>
                <input type="number" placeholder="Enter your contact number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" wire:model="company_contact">
              
            </div>

            <!-- Email -->
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" placeholder="Enter your email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" wire:model="company_email">
            </div>

            <!-- Present Address -->
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                <input type="text" placeholder="Enter your present address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" wire:model="company_address">
            </div>
            <div>
              <div class="flex justify-end">
                  <button class="w-1/3 mt-7 py-2 bg-green-500 text-white rounded hover:bg-green-600 " wire:click="saveCompany({{$company}})">Save</button>
                  <button class="w-1/3 ml-2 mt-7 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 " wire:click="cancel">Cancel</button>
              </div>
            </div>
            @if($editIndex == "new")
              <div class="mt-5 col-span-5 bg-red-100 w-full rounded px-2 py-1 text-sm text-red-800 {{ $showError === true ? 'block' : 'hidden' }}">{{$msg}}</div>
            @endif
          </div>
        @endif
        @foreach(\Auth::user()->companies as $key => $company)
          <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-x-6 mb-6 bg-white shadow-lg rounded-lg p-6">
            <!-- Name -->
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
              @if(($action == "edit")&&($editIndex == $key))
                <input type="text" placeholder="Enter your name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" wire:model="company_name">
              @else
                <span>{{ $company->name }}</span>
              @endif
              
            </div>

            <!-- Contact No -->
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Contact No</label>
              @if(($action == "edit")&&($editIndex == $key))
                <input type="number" placeholder="Enter your contact number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" wire:model="company_contact">
              @else
                <span>{{ $company->contact }}</span>
              @endif
              
            </div>

            <!-- Email -->
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
              @if(($action == "edit")&&($editIndex == $key))
                <input type="email" placeholder="Enter your email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" wire:model="company_email">
              @else
                <span>{{ $company->email }}</span>
              @endif
              
            </div>

            <!-- Present Address -->
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Address</label>
              @if(($action == "edit")&&($editIndex == $key))
                <input type="text" placeholder="Enter your present address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" wire:model="company_address">
              @else
                <span>{{ $company->address }}</span>
              @endif
              
            </div>
            <div>
              <div class="flex justify-center md:justify-end">
                @if(($action == "delete")&&($editIndex == $key))
                  <button class="w-1/3 mt-4 mb-3 py-2 bg-rose-500 text-white rounded hover:bg-rose-600 " wire:click="confirmDelete({{$company}})">Yes</button>
                  <button class="w-1/3 ml-2 mt-4 mb-3 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 " wire:click="cancel">No</button>
                @elseif(($action == "edit")&&($editIndex == $key))
                  <button class="w-1/3 mt-7 py-2 bg-green-500 text-white rounded hover:bg-green-600 " wire:click="saveCompany({{$company}})">Save</button>
                  <button class="w-1/3 ml-2 mt-7 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 " wire:click="cancel">Cancel</button>
                @else
                  <button class="w-1/3 mt-4 mb-3 py-2 bg-green-500 text-white rounded hover:bg-green-600 " wire:click="editCompany({{$key}}, {{$company}})">Edit</button>
                  @if($company->reservations()->count() == 0)
                    <button class="w-1/3 ml-2 mt-4 mb-3 py-2 bg-rose-500 text-white rounded hover:bg-rose-600 " wire:click="deleteCompany({{$key}})">Delete</button>
                  @endif
                @endif
              </div>
            </div>
            @if($editIndex == $key)
              <div class="mt-5 col-span-5 bg-red-100 w-full rounded px-2 py-1 text-sm text-red-800 {{ $showError === true ? 'block' : 'hidden' }}">{{$msg}}</div>
            @endif
          </div>
        @endforeach
    </div>
</div>
