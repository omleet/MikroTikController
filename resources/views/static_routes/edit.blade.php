<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col space-y-1">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Edit Static Route "{{$route['dst-address']}}"
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Update the static route configuration
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
            <!-- Static Route Edit Form Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Static Route Configuration</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Update the settings for route "{{$route['dst-address']}}"</p>
                        </div>
                    </div>

                    <form method="POST" action="{{route('StaticRoutes.update',[$deviceParam, $route['.id']])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <!-- Destination Address Field -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="dst-address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Destination Address</label>
                                <input type="text" id="dst-address" name="dst-address" value="{{$route['dst-address']}}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('dst-address') border-red-500 @enderror"
                                       placeholder="0.0.0.0/0" required>
                                @error('dst-address')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gateway Field -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="gateway" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gateway</label>
                                <select id="gateway" name="gateway" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                                    @foreach ($interfaces as $interface)
                                    <option {{$route['gateway'] == $interface['name'] ? "selected" : ""}}>{{$interface['name']}}</option>
                                    @endforeach
                                </select>
                                @error('gateway')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Check Gateway Field -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="check-gateway" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Check Gateway</label>
                                <select id="check-gateway" name="check-gateway" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                                    <option value="ping" {{ isset($route['check-gateway']) && $route['check-gateway'] == "ping" ? "selected" : ""}}>Ping</option>
                                    <option value="arp" {{isset($route['check-gateway']) && $route['check-gateway'] == "arp" ? "selected" : ""}}>ARP</option>
                                    <option value="none" {{isset($route['check-gateway']) && $route['check-gateway'] == "none" ? "selected" : ""}}>None</option>
                                </select>
                                @error('check-gateway')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Suppress HW Offload -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label class="flex items-center">
                                    <input type="checkbox" name="suppress-hw-offload" value="true" 
                                        {{ isset($route['suppress-hw-offload']) && $route['suppress-hw-offload'] == "true" ? "checked" : "" }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700">
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Suppress HW Offload</span>
                                </label>
                                @error('suppress-hw-offload')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Distance Field -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="distance" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Distance (optional)</label>
                                <input type="text" id="distance" name="distance" value="{{$route['distance']}}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('distance') border-red-500 @enderror"
                                       placeholder="0">
                                @error('distance')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Scope Field -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="scope" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Scope (optional)</label>
                                <input type="text" id="scope" name="scope" value="{{$route['scope']}}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('scope') border-red-500 @enderror"
                                       placeholder="30">
                                @error('scope')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Target Scope Field -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="target-scope" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Target Scope (optional)</label>
                                <input type="text" id="target-scope" name="target-scope" value="{{isset($route['target-scope']) ? $route['target-scope'] : ''}}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('target-scope') border-red-500 @enderror"
                                       placeholder="10">
                                @error('target-scope')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-gradient-to-r from-indigo-600 to-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Update Route
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Custom JSON Request Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Advanced Configuration</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Custom JSON request for advanced users</p>
                        </div>
                    </div>

                    <form method="POST" action="{{route('sr_updateCustom',[$deviceParam, $route['.id']])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                    Check the <a href="https://help.mikrotik.com/docs/display/ROS" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Mikrotik Support</a> for the correct parameters
                                </p>
                                <textarea id="custom" name="custom" rows="8"
                                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('custom') border-red-500 @enderror">{{ old('custom') }}</textarea>
                                @error('custom')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex justify-end space-x-3 pt-2">
                                <button type="button" onclick="prettyPrint()" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                                    Beautify JSON
                                </button>
                                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-gradient-to-r from-purple-600 to-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Submit Custom Request
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>