<div class="font-sans text-gray-900 antialiased">
    @php \Auth::logout(); @endphp
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="justify-center">
            <img class="mx-auto" src="{{asset('/assets/img/logo.svg')}}">

            <h1 class="my-4 text-3xl font-bold leading-none tracking-tight text-gray-900">IUM Spaces</h1>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div>
                <label class="block font-medium text-sm text-gray-700 mt-4 mb-2">
                    {{ $label }}
                </label>
                <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="number" required="required" autofocus="autofocus" wire:model="input">
            </div>

            <div class="flex items-center justify-center mt-4">
                <button class="mt-4 mb-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-4" wire:click="submit">
                    {{ $button }}
                </button>
            </div>
            <div class="bg-red-100 w-full rounded px-2 py-1 my-2 text-sm text-red-800 {{ $showError === true ? 'block' : 'hidden' }}">{{$msg}}</div>
        </div>
    </div>
</div>