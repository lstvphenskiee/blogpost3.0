<x-loginRegister title="Register">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="row w-100" style="max-width: 900px; min-height: 65vh;" id="register-module"> 
            <!-- Image Column -->
            <div class="col-md-6 d-none d-md-flex justify-content-center align-items-center bg-light">
                <img src="{{ Vite::asset('resources/img/register.jpg') }}" class="img-fluid" alt="Register Image">
            </div>

            <!-- Register Column -->
            <div class="col-md-6 bg-white p-4 shadow rounded form-floating mb-3">
                <h3 class="mb-4 text-center">Register</h3>
                <x-form action="{{ route('register-form') }}">
                    <div class="container">
                        <x-input name="name" type="text" label="Name" placeholder="Enter Name" class="form-floating mb-3"/>
                        <x-input name="email" type="email" label="Email" placeholder="Enter email" class="form-floating mb-3"/>
                        <x-input name="password" type="password" label="Password" placeholder="Enter password"/>
                        <x-input name="password_confirmation" type="password" label="password_confirmation" placeholder="Confirm password"/>
                    </div>
                    <div class="d-grid gap-2">
                        <x-button type="submit" variant="primary" class="w-100">Register</x-button>
                    </div>
                </x-form>
                {{-- <a href="{{ route('login-module')}}">Login</a> --}}
                <button id="show-login" class="bt btn-dark">Login</button>
            </div>
        </div>
    </div>
</x-loginRegister>