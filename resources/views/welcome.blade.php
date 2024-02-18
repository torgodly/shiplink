<x-app-layout>
    <div class="flex justify-center items-center gap-3">
        <div class="flex justify-center items-center h-screen">
            <a href="user/login" class="text-blue-500 text-3xl font-bold">
                <div class="border-2 rounded-xl border-blue-500 p-3 flex justify-center items-center">
                    <x-tabler-user class="w-20 h-20 stroke-blue-500"/>
                    Login to user panel
                </div>
            </a>
        </div>
        <div class="flex justify-center items-center h-screen">
            <a href="office/login" class="text-blue-500 text-3xl font-bold">
                <div class="border-2 rounded-xl border-blue-500 p-3 flex justify-center items-center">
                    <x-tabler-building class="w-20 h-20 stroke-blue-500"/>
                    Login to office panel
                </div>
            </a>
        </div>
        <div class="flex justify-center items-center h-screen">
            <a href="admin/login" class="text-blue-500 text-3xl font-bold">
                <div class="border-2 rounded-xl border-blue-500 p-3 flex justify-center items-center">
                    <x-tabler-shield-check class="w-20 h-20 stroke-blue-500"/>
                    Login to admin panel
                </div>
            </a>
        </div>
    </div>

</x-app-layout>
