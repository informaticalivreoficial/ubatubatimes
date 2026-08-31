<div class="container-fluid d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="bg-white p-4 rounded shadow-lg" style="width: 25rem;">
        <img
            width="{{ config('app.logomarca_width') }}"
            height="{{ config('app.logomarca_height') }}"
            src="{{ $config?->getlogoadmin() ?? asset('theme/images/image.jpg') }}"
            alt="{{ $config?->app_name ?? config('app.name') }}"
            class="mx-auto d-block mb-4 cursor-pointer"
        />

        <form wire:submit="login">
            <div class="form-group mb-4">
                <label for="email" class="text-sm font-weight-bold text-gray-700 mb-1">E-mail</label>
                <input
                    id="email"
                    wire:model="email"
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    autocomplete="username"
                    autofocus
                >

                @error('email')
                    <p class="text-sm text-danger mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="password" class="text-sm font-weight-bold text-gray-700 mb-1">Senha</label>
                <div class="input-group" x-data="{ show: false }">
                    <input
                        id="password"
                        wire:model="password"
                        type="password"
                        :type="show ? 'text' : 'password'"
                        class="form-control @error('password') is-invalid @enderror"
                        autocomplete="current-password"
                    >
                    <div class="input-group-append">
                        <button
                            type="button"
                            class="btn btn-default btn-flat"
                            @click="show = !show"
                            :aria-label="show ? 'Ocultar senha' : 'Mostrar senha'"
                            :title="show ? 'Ocultar senha' : 'Mostrar senha'"
                        >
                            <span x-show="!show" x-cloak>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                </svg>
                            </span>
                            <span x-show="show" x-cloak>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                    <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
                                    <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                                    <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>

                @error('password')
                    <p class="text-sm text-danger mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="login"
                class="btn btn-primary w-100 d-flex align-items-center justify-content-center"
            >
                <span wire:loading.remove wire:target="login">Entrar</span>
                <span wire:loading wire:target="login" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
            </button>
        </form>
    </div>
</div>
