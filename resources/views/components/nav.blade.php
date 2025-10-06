<div class="nav flex-column col-md-2 bg-light p-3 border-end nav-pills vh-100">
    <div class="p-2">
        <h5 class="mb-3">👤 {{ Auth::user()->name }}</h5>
    </div>

    <div class="mt-3 ">
        <x-button id="create-btn" style="width: 100%">Create</x-button>
    </div>

    <div class="mt-3">
        <x-form action="{{ route('logout-module') }}">
            <x-button type="submit" variant="dark" style="width: 100%">Logout</x-button>
        </x-form>
    </div>
</div>