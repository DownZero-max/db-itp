<div class="bg-gray-300 text-sm text-black flex justify-between items-center px-2 py-1 border-b border-gray-400">
    <div class="flex space-x-4">
        <button class="hover:underline">Main</button>
        <button class="hover:underline">Directory</button>
        <button class="hover:underline">Report</button>
        <button class="hover:underline">About the program</button>
        <span class="ml-4">You are currently logged in as: <strong>{{ Auth::user()->name ?? 'Guest' }}</strong></span>
    </div>
</div>
