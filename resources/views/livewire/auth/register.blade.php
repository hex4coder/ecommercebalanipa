<div class="flex flex-col items-center justify-center w-full py-20 gap-2 bg-blue-50">
    <img src="{{ asset('img/logo.png') }}" class="w-32" alt="logo">
    <div
        class="w-full lg:w-[60rem] mt-7 bg-white border border-slate-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
        <div class="p-4 sm:p-7">
            <div class="text-center">
                <h1 class="block text-2xl font-bold text-slate-800 dark:text-white">Register form</h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-neutral-400">
                    Anda sudah memiliki akun?
                    <a wire:navigate
                        class="text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500"
                        href="{{route('auth.login')}}">
                        Login disini
                    </a>
                </p>
            </div>

            <div class="mt-5">
                <div
                    class="py-3 flex items-center text-xs text-slate-400 uppercase before:flex-1 before:border-t before:border-slate-200 before:me-6 after:flex-1 after:border-t after:border-slate-200 after:ms-6 dark:text-neutral-500 dark:before:border-neutral-600 dark:after:border-neutral-600">
                </div>

                <!-- Form -->
                <div>
                    <form wire:submit="register">
                        {{ $this->form }}

                        <button type="submit"
                            class="my-7 w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">Sign
                            up</button>

                        @if (session()->has('error'))
                        <div class="bg-red-50 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500"
                            role="alert" tabindex="-1" aria-labelledby="hs-with-list-label">
                            <div class="flex">
                                <div class="shrink-0">
                                    <svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m15 9-6 6"></path>
                                        <path d="m9 9 6 6"></path>
                                    </svg>
                                </div>
                                <div class="ms-4">
                                    <h3 id="hs-with-list-label" class="text-sm font-semibold">
                                        Terjadi kesalahan saat pendaftaran.
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700 dark:text-red-400">
                                        <ul class="list-disc space-y-1 ps-5">
                                            <li>
                                                {{session('error')}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endif
                    </form>
                    <x-filament-actions::modals />
                </div>
                <!-- End Form -->
            </div>
        </div>
    </div>
</div>
