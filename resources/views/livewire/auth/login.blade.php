<div class="flex flex-col items-center justify-center w-full py-20 gap-2">
    <img src="{{ asset('img/logo.png') }}" class="w-32" alt="logo">
    <div
        class="mt-7 bg-white border border-slate-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700 md:min-w-[400px]">
        <div class="p-4 sm:p-7">
            <div class="text-center">
                <h1 class="block text-2xl font-bold text-slate-800 dark:text-white">Login form</h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-neutral-400">
                    Belum memiliki akun?
                    <a wire:navigate class="text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500"
                        href="{{route('auth.register')}}">
                        Registrasi disini
                    </a>
                </p>
            </div>

            <div class="mt-5">


                <div
                    class="py-3 flex items-center text-xs text-slate-400 uppercase before:flex-1 before:border-t before:border-slate-200 before:me-6 after:flex-1 after:border-t after:border-slate-200 after:ms-6 dark:text-neutral-500 dark:before:border-neutral-600 dark:after:border-neutral-600">
                </div>

                <!-- Form -->
                <form wire:submit.prevent='login'>
                    <div class="grid gap-y-4">
                        <!-- Form Group -->
                        <div>
                            <label for="email" class="block text-sm mb-2 dark:text-white">Email</label>
                            <div class="relative">
                                <input wire:model='email' type="email" id="email" name="email"
                                    class="py-3 px-4 block w-full border-slate-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    required aria-describedby="email-error">
                                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16" aria-hidden="true">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                </div>
                            </div>
                            @error('email')
                                <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- End Form Group -->

                        <!-- Form Group -->
                        <div>
                            <div class="flex justify-between items-center">
                                <label for="password" class="block text-sm mb-2 dark:text-white">Password</label>
                                <a class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500"
                                    href="../examples/html/recover-account.html">Lupa password?</a>
                            </div>
                            <div class="relative">
                                <input wire:model='password' type="password" id="password" name="password"
                                    class="py-3 px-4 block w-full border-slate-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    required aria-describedby="password-error">
                                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16" aria-hidden="true">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                </div>
                            </div>
                            @error('password')
                            <p class="text-xs text-red-600 mt-2" id="password-error">{{$message}}</p>

                            @enderror
                        </div>
                        <!-- End Form Group -->

                        <!-- Checkbox -->
                        <div class="flex items-center">
                            <div class="flex">
                                <input wire:model='remember' id="remember-me" name="remember-me" type="checkbox"
                                    class="shrink-0 mt-0.5 border-slate-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-slate-800">
                            </div>
                            <div class="ms-3">
                                <label for="remember-me" class="text-sm dark:text-white">Ingat saya</label>
                            </div>
                        </div>
                        <!-- End Checkbox -->

                        <button type="submit"
                            class="w-full mt-7 py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">



                            <span wire:loading wire:target='login' class="animate-spin inline-block size-4 border-[3px] border-current border-t-transparent text-white rounded-full dark:text-white " role="status" aria-label="loading">
                                <span class="sr-only">Loading...</span>
                              </span> Login</button>


                              @if (session()->has('message'))
                              <div class="mt-1 px-1 flex flex-col gap-1 md:max-w-[400px]">
                                  <p class="text-red-600 text-xs">Ada kesalahan : </p>
                                  <p class="text-xs font-semibold text-red-600 mt-2" id="password-error">
                                      {{session('message')}}
                                  </p>
                              </div>

                              @endif
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>
    </div>

</div>
