<x-loginRegister title="Login">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="row w-100" style="max-width: 900px; min-height: 65vh;" id="login-module"> 
            <!-- Image Column -->
            <div class="col-md-6 d-none d-md-flex rounded-start justify-content-center align-items-center bg-light">
                <img src="{{ asset('img/login.jpg') }}" class="img-fluid" alt="Login Image">
            </div>

            <!-- Form Column -->
            <div class="col-md-6 bg-white  shadow rounded-end form-floating">
                <h3 class="mb-4 text-center">Login</h3>
                <x-form action="{{ route('login-form') }}">
                    <div class="container">
                        <x-input name="email" type="email" label="Email" placeholder="Enter email" class="form-floating mb-3"/>
                        <x-input name="password" type="password" label="Password" placeholder="Enter password"/>
                    </div>
                    <div class="d-grid gap-2">
                        <x-button type="submit" variant="primary" class="w-100">Login</x-button>
                    </div>
                </x-form>
                <button id="show-register" class="bt btn-dark cursor-pointer">Register</button>
            </div>
        </div>
    </div>
    <script>
        window.loginError = @json(session('error'));
        window.registerSuccess = @json(session('success'));
    </script>


</x-loginRegister>