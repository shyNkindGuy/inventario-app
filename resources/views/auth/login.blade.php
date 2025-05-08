<x-layout title="Login">
    <div class="container min-vh-100 d-flex align-items-center">
        <div class="row justify-content-center w-100">
            <div class="col-lg-10 col-xl-9">
                <div class="card border-0 shadow-lg">
                    <div class="row g-0">
                        <div class="col-md-6 d-none d-md-block position-relative">
                            <div class="p-5 h-100 d-flex align-items-center">
                                <img src="{{ asset('img/logo_login.png') }} "draggable="false" class="img-fluid w-100">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card-body p-5">
                                <h2 class="mb-12 text-center fw-bold display-6 text-primary">Bienvenid@</h2>
                                
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    
                                    <div class="mb-14">
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent border-end-0">
                                                <i class="bi bi-person fs-5 text-primary"></i>
                                            </span>
                                            <input type="email" 
                                                   class="form-control form-control-lg border-start-0 @error('email') is-invalid @enderror" 
                                                   name="email" 
                                                   placeholder="Correo electrónico">
                                        </div>
                                        @error('email')<div class="text-danger small mt-2">{{$message}}</div>@enderror
                                    </div>
    
                                    <div class="mb-14">
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent border-end-0">
                                                <i class="bi bi-lock fs-5 text-primary"></i>
                                            </span>
                                            <input type="password" 
                                                   class="form-control form-control-lg border-start-0 @error('password') is-invalid @enderror" 
                                                   name="password" 
                                                   placeholder="Contraseña">
                                        </div>
                                        @error('password')<div class="text-danger small mt-2">{{$message}}</div>@enderror
                                    </div>
    
                                    <button type="submit" class="btn btn-primary btn-lg w-100 py-4 fw-bold">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                        INGRESAR
                                    </button>
    
                                    <div class="mt-4 text-center">
                                        ¿No tienes una cuenta?
                                        <a href="{{ route('register') }}" class="text-decoration-none text-primary fw-semibold">
                                        Regístrate
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </x-layout>