<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $appSetting->app_name ?? 'LEARN FLOW' }}</title>
    @livewireStyles

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/perfect-scrollbar.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/style.css') }}">
    <link defer="" rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/animate.css') }}">
    <script src="{{ asset('assets/js/perfect-scrollbar.min.js')}}"></script>
    <script defer="" src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script defer="" src="{{ asset('assets/js/tippy-bundle.umd.min.js') }}"></script>
    <script defer="" src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <link rel="stylesheet" href="{{asset('filepond/filepond.css')}}">
    <link rel="stylesheet" href="{{asset('filepond-plugin-image-preview/filepond-plugin-image-preview.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    @stack('css')

</head>

<body x-data="main" class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased"
    :class="[ $store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ?  'dark' : '', $store.app.menu, $store.app.layout,$store.app.rtlClass]">
    <!-- sidebar menu overlay -->
    <div x-cloak="" class="fixed inset-0 z-50 bg-[black]/60 lg:hidden" :class="{'hidden' : !$store.app.sidebar}"
        @click="$store.app.toggleSidebar()"></div>

    <!-- scroll to top button -->
    <div class="fixed bottom-6 z-50 ltr:right-6 rtl:left-6" x-data="scrollToTop">
        <template x-if="showTopButton">
            <button type="button"
                class="btn btn-outline-primary animate-pulse rounded-full bg-[#fafafa] p-2 dark:bg-[#060818] dark:hover:bg-primary"
                @click="goToTop">
                <svg width="24" height="24" class="h-4 w-4" viewbox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 20.75C12.4142 20.75 12.75 20.4142 12.75 20L12.75 10.75L11.25 10.75L11.25 20C11.25 20.4142 11.5858 20.75 12 20.75Z"
                        fill="currentColor"></path>
                    <path
                        d="M6.00002 10.75C5.69667 10.75 5.4232 10.5673 5.30711 10.287C5.19103 10.0068 5.25519 9.68417 5.46969 9.46967L11.4697 3.46967C11.6103 3.32902 11.8011 3.25 12 3.25C12.1989 3.25 12.3897 3.32902 12.5304 3.46967L18.5304 9.46967C18.7449 9.68417 18.809 10.0068 18.6929 10.287C18.5768 10.5673 18.3034 10.75 18 10.75L6.00002 10.75Z"
                        fill="currentColor"></path>
                </svg>
            </button>
        </template>
    </div>

    <!-- start theme customizer section -->
    <div x-data="customizer">
        <div class="fixed inset-0 z-[51] hidden bg-[black]/60 px-4 transition-[display]"
            :class="{'!block': showCustomizer}" @click="showCustomizer = false"></div>

        <nav class="fixed top-0 bottom-0 z-[51] w-full max-w-[400px] bg-white p-4 shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-[right] duration-300 ltr:-right-[400px] rtl:-left-[400px] dark:bg-[#0e1726]"
            :class="{'ltr:!right-0 rtl:!left-0' : showCustomizer}">
            {{-- <a href="javascript:;"
                class="absolute top-0 bottom-0 my-auto flex h-10 w-12 cursor-pointer items-center justify-center bg-primary text-white ltr:-left-12 ltr:rounded-tl-full ltr:rounded-bl-full rtl:-right-12 rtl:rounded-tr-full rtl:rounded-br-full"
                @click="showCustomizer = !showCustomizer">
                <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 animate-[spin_3s_linear_infinite]">
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"></circle>
                    <path opacity="0.5"
                        d="M13.7654 2.15224C13.3978 2 12.9319 2 12 2C11.0681 2 10.6022 2 10.2346 2.15224C9.74457 2.35523 9.35522 2.74458 9.15223 3.23463C9.05957 3.45834 9.0233 3.7185 9.00911 4.09799C8.98826 4.65568 8.70226 5.17189 8.21894 5.45093C7.73564 5.72996 7.14559 5.71954 6.65219 5.45876C6.31645 5.2813 6.07301 5.18262 5.83294 5.15102C5.30704 5.08178 4.77518 5.22429 4.35436 5.5472C4.03874 5.78938 3.80577 6.1929 3.33983 6.99993C2.87389 7.80697 2.64092 8.21048 2.58899 8.60491C2.51976 9.1308 2.66227 9.66266 2.98518 10.0835C3.13256 10.2756 3.3397 10.437 3.66119 10.639C4.1338 10.936 4.43789 11.4419 4.43786 12C4.43783 12.5581 4.13375 13.0639 3.66118 13.3608C3.33965 13.5629 3.13248 13.7244 2.98508 13.9165C2.66217 14.3373 2.51966 14.8691 2.5889 15.395C2.64082 15.7894 2.87379 16.193 3.33973 17C3.80568 17.807 4.03865 18.2106 4.35426 18.4527C4.77508 18.7756 5.30694 18.9181 5.83284 18.8489C6.07289 18.8173 6.31632 18.7186 6.65204 18.5412C7.14547 18.2804 7.73556 18.27 8.2189 18.549C8.70224 18.8281 8.98826 19.3443 9.00911 19.9021C9.02331 20.2815 9.05957 20.5417 9.15223 20.7654C9.35522 21.2554 9.74457 21.6448 10.2346 21.8478C10.6022 22 11.0681 22 12 22C12.9319 22 13.3978 22 13.7654 21.8478C14.2554 21.6448 14.6448 21.2554 14.8477 20.7654C14.9404 20.5417 14.9767 20.2815 14.9909 19.902C15.0117 19.3443 15.2977 18.8281 15.781 18.549C16.2643 18.2699 16.8544 18.2804 17.3479 18.5412C17.6836 18.7186 17.927 18.8172 18.167 18.8488C18.6929 18.9181 19.2248 18.7756 19.6456 18.4527C19.9612 18.2105 20.1942 17.807 20.6601 16.9999C21.1261 16.1929 21.3591 15.7894 21.411 15.395C21.4802 14.8691 21.3377 14.3372 21.0148 13.9164C20.8674 13.7243 20.6602 13.5628 20.3387 13.3608C19.8662 13.0639 19.5621 12.558 19.5621 11.9999C19.5621 11.4418 19.8662 10.9361 20.3387 10.6392C20.6603 10.4371 20.8675 10.2757 21.0149 10.0835C21.3378 9.66273 21.4803 9.13087 21.4111 8.60497C21.3592 8.21055 21.1262 7.80703 20.6602 7C20.1943 6.19297 19.9613 5.78945 19.6457 5.54727C19.2249 5.22436 18.693 5.08185 18.1671 5.15109C17.9271 5.18269 17.6837 5.28136 17.3479 5.4588C16.8545 5.71959 16.2644 5.73002 15.7811 5.45096C15.2977 5.17191 15.0117 4.65566 14.9909 4.09794C14.9767 3.71848 14.9404 3.45833 14.8477 3.23463C14.6448 2.74458 14.2554 2.35523 13.7654 2.15224Z"
                        stroke="currentColor" stroke-width="1.5"></path>
                </svg>
            </a> --}}
            <div class="perfect-scrollbar h-full overflow-y-auto overflow-x-hidden">
                <div class="relative pb-5 text-center">
                    <a href="javascript:;"
                        class="absolute top-0 opacity-30 hover:opacity-100 ltr:right-0 rtl:left-0 dark:text-white"
                        @click="showCustomizer = false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewbox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" class="h-5 w-5">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </a>
                    <h4 class="mb-1 dark:text-white">TEMPLATE CUSTOMIZER</h4>
                    <p class="text-white-dark">Set preferences that will be cookied for your live preview demonstration.
                    </p>
                </div>
                <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                    <h5 class="mb-1 text-base leading-none dark:text-white">Color Scheme</h5>
                    <p class="text-xs text-white-dark">Overall light or dark presentation.</p>
                    <div class="mt-3 grid grid-cols-3 gap-2">
                        <button type="button" class="btn"
                            :class="[$store.app.theme === 'light' ? 'btn-primary' :'btn-outline-primary']"
                            @click="$store.app.toggleTheme('light')">
                            <svg width="20" height="20" viewbox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
                                <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5"></circle>
                                <path d="M12 2V4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                </path>
                                <path d="M12 20V22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                </path>
                                <path d="M4 12L2 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                </path>
                                <path d="M22 12L20 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                </path>
                                <path opacity="0.5" d="M19.7778 4.22266L17.5558 6.25424" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round"></path>
                                <path opacity="0.5" d="M4.22217 4.22266L6.44418 6.25424" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round"></path>
                                <path opacity="0.5" d="M6.44434 17.5557L4.22211 19.7779" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round"></path>
                                <path opacity="0.5" d="M19.7778 19.7773L17.5558 17.5551" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round"></path>
                            </svg>
                            Light
                        </button>
                        <button type="button" class="btn"
                            :class="[$store.app.theme === 'dark' ? 'btn-primary' :'btn-outline-primary']"
                            @click="$store.app.toggleTheme('dark')">
                            <svg width="20" height="20" viewbox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
                                <path
                                    d="M21.0672 11.8568L20.4253 11.469L21.0672 11.8568ZM12.1432 2.93276L11.7553 2.29085V2.29085L12.1432 2.93276ZM21.25 12C21.25 17.1086 17.1086 21.25 12 21.25V22.75C17.9371 22.75 22.75 17.9371 22.75 12H21.25ZM12 21.25C6.89137 21.25 2.75 17.1086 2.75 12H1.25C1.25 17.9371 6.06294 22.75 12 22.75V21.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75V1.25C6.06294 1.25 1.25 6.06294 1.25 12H2.75ZM15.5 14.25C12.3244 14.25 9.75 11.6756 9.75 8.5H8.25C8.25 12.5041 11.4959 15.75 15.5 15.75V14.25ZM20.4253 11.469C19.4172 13.1373 17.5882 14.25 15.5 14.25V15.75C18.1349 15.75 20.4407 14.3439 21.7092 12.2447L20.4253 11.469ZM9.75 8.5C9.75 6.41182 10.8627 4.5828 12.531 3.57467L11.7553 2.29085C9.65609 3.5593 8.25 5.86509 8.25 8.5H9.75ZM12 2.75C11.9115 2.75 11.8077 2.71008 11.7324 2.63168C11.6686 2.56527 11.6538 2.50244 11.6503 2.47703C11.6461 2.44587 11.6482 2.35557 11.7553 2.29085L12.531 3.57467C13.0342 3.27065 13.196 2.71398 13.1368 2.27627C13.0754 1.82126 12.7166 1.25 12 1.25V2.75ZM21.7092 12.2447C21.6444 12.3518 21.5541 12.3539 21.523 12.3497C21.4976 12.3462 21.4347 12.3314 21.3683 12.2676C21.2899 12.1923 21.25 12.0885 21.25 12H22.75C22.75 11.2834 22.1787 10.9246 21.7237 10.8632C21.286 10.804 20.7293 10.9658 20.4253 11.469L21.7092 12.2447Z"
                                    fill="currentColor"></path>
                            </svg>
                            Dark
                        </button>
                        <button type="button" class="btn"
                            :class="[$store.app.theme === 'system' ? 'btn-primary' :'btn-outline-primary']"
                            @click="$store.app.toggleTheme('system')">
                            <svg width="20" height="20" viewbox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
                                <path
                                    d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15C17.8284 3 19.2426 3 20.1213 3.87868C21 4.75736 21 6.17157 21 9V14C21 15.8856 21 16.8284 20.4142 17.4142C19.8284 18 18.8856 18 17 18H7C5.11438 18 4.17157 18 3.58579 17.4142C3 16.8284 3 15.8856 3 14V9Z"
                                    stroke="currentColor" stroke-width="1.5"></path>
                                <path opacity="0.5" d="M22 21H2" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round"></path>
                                <path opacity="0.5" d="M15 15H9" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round"></path>
                            </svg>
                            System
                        </button>
                    </div>
                </div>

                <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                    <h5 class="mb-1 text-base leading-none dark:text-white">Navigation Position</h5>
                    <p class="text-xs text-white-dark">Select the primary navigation paradigm for your app.</p>
                    <div class="mt-3 grid grid-cols-3 gap-2">
                        <button type="button" class="btn"
                            :class="[$store.app.menu === 'horizontal' ? 'btn-primary' :'btn-outline-primary']"
                            @click="$store.app.toggleMenu('horizontal')">
                            Horizontal
                        </button>
                        <button type="button" class="btn"
                            :class="[$store.app.menu === 'vertical' ? 'btn-primary' :'btn-outline-primary']"
                            @click="$store.app.toggleMenu('vertical')">
                            Vertical
                        </button>
                        <button type="button" class="btn"
                            :class="[$store.app.menu === 'collapsible-vertical' ? 'btn-primary' :'btn-outline-primary']"
                            @click="$store.app.toggleMenu('collapsible-vertical')">
                            Collapsible
                        </button>
                    </div>
                    <div class="mt-5 text-primary">
                        <label class="mb-0 inline-flex">
                            <input x-model="$store.app.semidark" type="checkbox" :value="true" class="form-checkbox"
                                @change="$store.app.toggleSemidark()">
                            <span>Semi Dark (Sidebar & Header)</span>
                        </label>
                    </div>
                </div>
                <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                    <h5 class="mb-1 text-base leading-none dark:text-white">Layout Style</h5>
                    <p class="text-xs text-white-dark">Select the primary layout style for your app.</p>
                    <div class="mt-3 flex gap-2">
                        <button type="button" class="btn flex-auto"
                            :class="[$store.app.layout === 'boxed-layout' ? 'btn-primary' :'btn-outline-primary']"
                            @click="$store.app.toggleLayout('boxed-layout')">
                            Box
                        </button>
                        <button type="button" class="btn flex-auto"
                            :class="[$store.app.layout === 'full' ? 'btn-primary' :'btn-outline-primary']"
                            @click="$store.app.toggleLayout('full')">
                            Full
                        </button>
                    </div>
                </div>
                <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                    <h5 class="mb-1 text-base leading-none dark:text-white">Direction</h5>
                    <p class="text-xs text-white-dark">Select the direction for your app.</p>
                    <div class="mt-3 flex gap-2">
                        <button type="button" class="btn flex-auto"
                            :class="[$store.app.rtlClass === 'ltr' ? 'btn-primary' :'btn-outline-primary']"
                            @click="$store.app.toggleRTL('ltr')">
                            LTR
                        </button>
                        <button type="button" class="btn flex-auto"
                            :class="[$store.app.rtlClass === 'rtl' ? 'btn-primary' :'btn-outline-primary']"
                            @click="$store.app.toggleRTL('rtl')">
                            RTL
                        </button>
                    </div>
                </div>

                <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                    <h5 class="mb-1 text-base leading-none dark:text-white">Navbar Type</h5>
                    <p class="text-xs text-white-dark">Sticky or Floating.</p>
                    <div class="mt-3 flex items-center gap-3 text-primary">
                        <label class="mb-0 inline-flex">
                            <input x-model="$store.app.navbar" type="radio" value="navbar-sticky" class="form-radio"
                                @change="$store.app.toggleNavbar()">
                            <span>Sticky</span>
                        </label>
                        <label class="mb-0 inline-flex">
                            <input x-model="$store.app.navbar" type="radio" value="navbar-floating" class="form-radio"
                                @change="$store.app.toggleNavbar()">
                            <span>Floating</span>
                        </label>
                        <label class="mb-0 inline-flex">
                            <input x-model="$store.app.navbar" type="radio" value="navbar-static" class="form-radio"
                                @change="$store.app.toggleNavbar()">
                            <span>Static</span>
                        </label>
                    </div>
                </div>

                <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                    <h5 class="mb-1 text-base leading-none dark:text-white">Router Transition</h5>
                    <p class="text-xs text-white-dark">Animation of main content.</p>
                    <div class="mt-3">
                        <select x-model="$store.app.animation" class="form-select border-primary text-primary"
                            @change="$store.app.toggleAnimation()">
                            <option value="">None</option>
                            <option value="animate__fadeIn">Fade</option>
                            <option value="animate__fadeInDown">Fade Down</option>
                            <option value="animate__fadeInUp">Fade Up</option>
                            <option value="animate__fadeInLeft">Fade Left</option>
                            <option value="animate__fadeInRight">Fade Right</option>
                            <option value="animate__slideInDown">Slide Down</option>
                            <option value="animate__slideInLeft">Slide Left</option>
                            <option value="animate__slideInRight">Slide Right</option>
                            <option value="animate__zoomIn">Zoom In</option>
                        </select>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- end theme customizer section -->

    <div class="main-container min-h-screen text-black dark:text-white-dark" :class="[$store.app.navbar]">
        <!-- start sidebar section -->
        <div :class="{'dark text-white-dark' : $store.app.semidark}">
            <nav x-data="sidebar"
                class="sidebar fixed top-0 bottom-0 z-50 h-full min-h-screen w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-all duration-300">
                <div class="h-full bg-white dark:bg-[#0e1726]">
                    <div class="flex items-center justify-between px-4 py-3">
                        <a href="{{url('/dashboard')}}" class="main-logo flex shrink-0 items-center"
                            x-data="{
                                showLogo: {{ $appSetting->show_logo ? 'true' : 'false' }},
                                showName: {{ $appSetting->show_name ? 'true' : 'false' }}
                            }" @show-logo-updated.window="showLogo = Boolean($event.detail)"
                            @show-name-updated.window="showName = Boolean($event.detail)">

                            <template x-if="showLogo">
                                <img id="app-logo" class="ml-[5px] w-8 flex-none"
                                    x-data="{ logo: '{{ asset('storage') }}/{{ $appSetting->app_logo ?? 'default-logo.png' }}' }"
                                    x-bind:src="logo" @logo-updated.window="logo = $event.detail" alt="Logo">
                            </template>

                            <template x-if="showName">
                                <span
                                    class="align-middle text-2xl font-semibold ltr:ml-1.5 rtl:mr-1.5 dark:text-white-light lg:inline"
                                    x-data="{ appName: '{{ $appSetting->app_name }}' }" x-text="appName"
                                    @app-name-updated.window="appName = $event.detail">
                                </span>
                            </template>
                        </a>


                        <a href="javascript:;"
                            class="collapse-icon flex h-8 w-8 items-center rounded-full transition duration-300 hover:bg-gray-500/10 rtl:rotate-180 dark:text-white-light dark:hover:bg-dark-light/10"
                            @click="$store.app.toggleSidebar()">
                            <svg class="m-auto h-5 w-5" width="20" height="20" viewbox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </div>
                    <ul class="perfect-scrollbar relative h-[calc(100vh-80px)] space-y-0.5 overflow-y-auto overflow-x-hidden p-4 py-0 font-semibold"
                        x-data="{ activeDropdown: 'dashboard' }">
                            <li class="menu nav-item">
                                <a href="{{url('/dashboard')}}" wire:current.strict="active group"
                                    class="nav-link group">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20"
                                            viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.5"
                                                d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z"
                                                fill="currentColor"></path>
                                        </svg>

                                        <span
                                            class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Dashboard</span>
                                    </div>
                                </a>
                            </li>
                        @if(auth()->user()->role === 'admin')
                            <h2
                                class="-mx-4 mb-1 flex items-center bg-white-light/30 py-3 px-7 font-extrabold uppercase dark:bg-dark dark:bg-opacity-[0.08]">
                                <svg class="hidden h-5 w-4 flex-none" viewbox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Pengguna</span>
                            </h2>

                            <li class="nav-item">
                                <ul>
                                    <li class="nav-item">
                                        <a href="{{url('/wali-kelas')}}" wire:navigate wire:current.strict="active group">
                                            <div class="flex items-center">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M15.5 7.5C15.5 9.433 13.933 11 12 11C10.067 11 8.5 9.433 8.5 7.5C8.5 5.567 10.067 4 12 4C13.933 4 15.5 5.567 15.5 7.5Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M18 16.5C18 18.433 15.3137 20 12 20C8.68629 20 6 18.433 6 16.5C6 14.567 8.68629 13 12 13C15.3137 13 18 14.567 18 16.5Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M7.12205 5C7.29951 5 7.47276 5.01741 7.64005 5.05056C7.23249 5.77446 7 6.61008 7 7.5C7 8.36825 7.22131 9.18482 7.61059 9.89636C7.45245 9.92583 7.28912 9.94126 7.12205 9.94126C5.70763 9.94126 4.56102 8.83512 4.56102 7.47063C4.56102 6.10614 5.70763 5 7.12205 5Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M5.44734 18.986C4.87942 18.3071 4.5 17.474 4.5 16.5C4.5 15.5558 4.85657 14.744 5.39578 14.0767C3.4911 14.2245 2 15.2662 2 16.5294C2 17.8044 3.5173 18.8538 5.44734 18.986Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M16.9999 7.5C16.9999 8.36825 16.7786 9.18482 16.3893 9.89636C16.5475 9.92583 16.7108 9.94126 16.8779 9.94126C18.2923 9.94126 19.4389 8.83512 19.4389 7.47063C19.4389 6.10614 18.2923 5 16.8779 5C16.7004 5 16.5272 5.01741 16.3599 5.05056C16.7674 5.77446 16.9999 6.61008 16.9999 7.5Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M18.5526 18.986C20.4826 18.8538 21.9999 17.8044 21.9999 16.5294C21.9999 15.2662 20.5088 14.2245 18.6041 14.0767C19.1433 14.744 19.4999 15.5558 19.4999 16.5C19.4999 17.474 19.1205 18.3071 18.5526 18.986Z"
                                                        fill="currentColor" />
                                                </svg>


                                                <span
                                                    class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Wali
                                                    Kelas</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        @endif

                        <h2
                            class="-mx-4 mb-1 flex items-center bg-white-light/30 py-3 px-7 font-extrabold uppercase dark:bg-dark dark:bg-opacity-[0.08]">
                            <svg class="hidden h-5 w-4 flex-none" viewbox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            <span>Master Data</span>
                        </h2>

                        @if(auth()->user()->role === 'admin')

                            <li class="nav-item">
                                <ul>
                                    <li class="nav-item">
                                        <a href="{{url('/kelas')}}" wire:navigate wire:current.strict="active group">
                                            <div class="flex items-center">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M21.5315 11.5857L20.75 10.9605V21.25H22C22.4142 21.25 22.75 21.5858 22.75 22C22.75 22.4143 22.4142 22.75 22 22.75H2.00003C1.58581 22.75 1.25003 22.4143 1.25003 22C1.25003 21.5858 1.58581 21.25 2.00003 21.25H3.25003V10.9605L2.46855 11.5857C2.1451 11.8445 1.67313 11.792 1.41438 11.4686C1.15562 11.1451 1.20806 10.6731 1.53151 10.4144L9.65742 3.91366C11.027 2.818 12.9731 2.818 14.3426 3.91366L22.4685 10.4144C22.792 10.6731 22.8444 11.1451 22.5857 11.4686C22.3269 11.792 21.855 11.8445 21.5315 11.5857ZM12 6.75004C10.4812 6.75004 9.25003 7.98126 9.25003 9.50004C9.25003 11.0188 10.4812 12.25 12 12.25C13.5188 12.25 14.75 11.0188 14.75 9.50004C14.75 7.98126 13.5188 6.75004 12 6.75004ZM13.7459 13.3116C13.2871 13.25 12.7143 13.25 12.0494 13.25H11.9507C11.2858 13.25 10.7129 13.25 10.2542 13.3116C9.76255 13.3777 9.29128 13.5268 8.90904 13.9091C8.52679 14.2913 8.37773 14.7626 8.31163 15.2542C8.24996 15.7129 8.24999 16.2858 8.25003 16.9507L8.25003 21.25H9.75003H14.25H15.75L15.75 16.9507L15.75 16.8271C15.7498 16.2146 15.7462 15.6843 15.6884 15.2542C15.6223 14.7626 15.4733 14.2913 15.091 13.9091C14.7088 13.5268 14.2375 13.3777 13.7459 13.3116Z"
                                                        fill="currentColor" />
                                                    <g opacity="0.5">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M10.75 9.5C10.75 8.80964 11.3096 8.25 12 8.25C12.6904 8.25 13.25 8.80964 13.25 9.5C13.25 10.1904 12.6904 10.75 12 10.75C11.3096 10.75 10.75 10.1904 10.75 9.5Z"
                                                            fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M10.75 9.5C10.75 8.80964 11.3096 8.25 12 8.25C12.6904 8.25 13.25 8.80964 13.25 9.5C13.25 10.1904 12.6904 10.75 12 10.75C11.3096 10.75 10.75 10.1904 10.75 9.5Z"
                                                            fill="currentColor" />
                                                    </g>
                                                    <path opacity="0.5"
                                                        d="M12.0494 13.25C12.7142 13.25 13.2871 13.2499 13.7458 13.3116C14.2375 13.3777 14.7087 13.5268 15.091 13.909C15.4732 14.2913 15.6223 14.7625 15.6884 15.2542C15.7462 15.6842 15.7498 16.2146 15.75 16.827L15.75 21.25H8.25L8.25 16.9506C8.24997 16.2858 8.24993 15.7129 8.31161 15.2542C8.37771 14.7625 8.52677 14.2913 8.90901 13.909C9.29126 13.5268 9.76252 13.3777 10.2542 13.3116C10.7129 13.2499 11.2858 13.25 11.9506 13.25H12.0494Z"
                                                        fill="currentColor" />
                                                    <path opacity="0.5"
                                                        d="M16 3H18.5C18.7761 3 19 3.22386 19 3.5L19 7.63955L15.5 4.83955V3.5C15.5 3.22386 15.7239 3 16 3Z"
                                                        fill="currentColor" />
                                                </svg>


                                                <span
                                                    class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Kelas</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <ul>
                                    <li class="nav-item">
                                        <a href="{{url('/kategori')}}" wire:navigate wire:current.strict="active group">
                                            <div class="flex items-center">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.97883 9.68508C2.99294 8.89073 2 8.49355 2 8C2 7.50645 2.99294 7.10927 4.97883 6.31492L7.7873 5.19153C9.77318 4.39718 10.7661 4 12 4C13.2339 4 14.2268 4.39718 16.2127 5.19153L19.0212 6.31492C21.0071 7.10927 22 7.50645 22 8C22 8.49355 21.0071 8.89073 19.0212 9.68508L16.2127 10.8085C14.2268 11.6028 13.2339 12 12 12C10.7661 12 9.77318 11.6028 7.7873 10.8085L4.97883 9.68508Z"
                                                        fill="currentColor" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2 8C2 8.49355 2.99294 8.89073 4.97883 9.68508L7.7873 10.8085C9.77318 11.6028 10.7661 12 12 12C13.2339 12 14.2268 11.6028 16.2127 10.8085L19.0212 9.68508C21.0071 8.89073 22 8.49355 22 8C22 7.50645 21.0071 7.10927 19.0212 6.31492L16.2127 5.19153C14.2268 4.39718 13.2339 4 12 4C10.7661 4 9.77318 4.39718 7.7873 5.19153L4.97883 6.31492C2.99294 7.10927 2 7.50645 2 8Z"
                                                        fill="currentColor" />
                                                    <path opacity="0.7"
                                                        d="M5.76613 10L4.97883 10.3149C2.99294 11.1093 2 11.5065 2 12C2 12.4935 2.99294 12.8907 4.97883 13.6851L7.7873 14.8085C9.77318 15.6028 10.7661 16 12 16C13.2339 16 14.2268 15.6028 16.2127 14.8085L19.0212 13.6851C21.0071 12.8907 22 12.4935 22 12C22 11.5065 21.0071 11.1093 19.0212 10.3149L18.2339 10L16.2127 10.8085C14.2268 11.6028 13.2339 12 12 12C10.7661 12 9.77318 11.6028 7.7873 10.8085L5.76613 10Z"
                                                        fill="currentColor" />
                                                    <path opacity="0.4"
                                                        d="M5.76613 14L4.97883 14.3149C2.99294 15.1093 2 15.5065 2 16C2 16.4935 2.99294 16.8907 4.97883 17.6851L7.7873 18.8085C9.77318 19.6028 10.7661 20 12 20C13.2339 20 14.2268 19.6028 16.2127 18.8085L19.0212 17.6851C21.0071 16.8907 22 16.4935 22 16C22 15.5065 21.0071 15.1093 19.0212 14.3149L18.2339 14L16.2127 14.8085C14.2268 15.6028 13.2339 16 12 16C10.7661 16 9.77318 15.6028 7.7873 14.8085L5.76613 14Z"
                                                        fill="currentColor" />
                                                </svg>

                                                <span
                                                    class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Kategori</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <ul>
                                    <li class="nav-item">
                                        <a href="{{url('/indikator')}}" wire:navigate wire:current.strict="active group">
                                            <div class="flex items-center">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.5092 2.2601L11.5 5.0945C11.4999 6.1916 11.4998 7.16117 11.6049 7.94269C11.7188 8.78981 11.9803 9.6368 12.6716 10.3281C13.3629 11.0193 14.2098 11.2808 15.057 11.3947C15.8385 11.4998 16.808 11.4997 17.9051 11.4996L21.9574 11.4996C21.9698 11.6552 21.9786 11.821 21.9848 11.9995H22C22 11.732 22 11.5983 21.9901 11.4408C21.9335 10.5463 21.5617 9.52125 21.0315 8.79853C20.9382 8.6713 20.8743 8.59493 20.7467 8.44218C19.9542 7.49359 18.911 6.31193 18 5.49953C17.1892 4.77645 16.0787 3.98536 15.1101 3.3385C14.2781 2.78275 13.862 2.50487 13.2915 2.29834C13.1403 2.24359 12.9408 2.18311 12.7846 2.14466C12.4006 2.05013 12.0268 2.01725 11.5 2.00586L11.5092 2.2601Z" fill="currentColor"/>
                                                    <path opacity="0.5" d="M2 13.6624V9.77493C2 6.10979 2 4.27723 3.17157 3.13861C4.34315 2 6.23869 2 10.0298 2C10.6212 2 11.0979 2 11.5003 2.01505L11.5092 2.25928L11.5 5.0079C11.5 5.06835 11.5 5.12842 11.5 5.18806C11.5 6.24676 11.5028 7.18347 11.6049 7.94269C11.7188 8.78981 11.9803 9.6368 12.6716 10.3281C13.3629 11.0193 14.2098 11.2808 15.057 11.3947C15.8385 11.4998 16.808 11.4997 17.9051 11.4996L21.9574 11.4996C21.9698 11.6552 21.9786 11.821 21.9848 11.9995H21.9926C22 12.3574 22 12.7647 22 13.2376V13.6624C22 13.897 22 14.1241 21.9997 14.3439L21.9877 14.3502C21.8628 14.4156 21.7638 14.4675 21.7205 14.4956C20.682 15.1681 19.3292 15.1681 18.2908 14.4956C17.5119 13.9911 16.4973 13.9911 15.7185 14.4956C14.6801 15.1681 13.3272 15.1681 12.2888 14.4956C11.51 13.9911 10.4954 13.9911 9.71653 14.4956C8.67811 15.1681 7.32527 15.1681 6.28684 14.4956C5.50802 13.9911 4.49339 13.9911 3.71457 14.4956C3.57738 14.5844 3.50878 14.6289 3.4595 14.6536C3.07304 14.8477 2.44233 14.6806 2.00034 14.364C2 14.1379 2 13.9041 2 13.6624Z" fill="currentColor"/>
                                                    <path d="M9.99992 22H14.0001C17.7714 22 19.6571 22 20.8287 21.0667C21.9253 20.1932 21.9955 18.8213 22 16.1858L21.988 16.191C21.8631 16.2446 21.7641 16.2871 21.7208 16.3101C20.6823 16.8614 19.3294 16.8614 18.291 16.3101C17.5121 15.8966 16.4974 15.8966 15.7186 16.3101C14.6801 16.8614 13.3273 16.8614 12.2888 16.3101C11.51 15.8966 10.4953 15.8966 9.71645 16.3101C8.67798 16.8614 7.3251 16.8614 6.28664 16.3101C5.5078 15.8966 4.49314 15.8966 3.71429 16.3101C3.57709 16.3829 3.50849 16.4194 3.45921 16.4396C3.07274 16.5988 2.44201 16.4617 2 16.2022C2.00476 18.827 2.07693 20.195 3.17127 21.0667C4.34289 22 6.22856 22 9.99992 22Z" fill="currentColor"/>
                                                    </svg>
                                                    

                                                <span
                                                    class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Indikator</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if(auth()->user()->role === 'admin'|| auth()->user()->role === 'wali_kelas' || auth()->user()->role === 'wali_siswa')
                            <li class="nav-item">
                                <ul>
                                    <li class="nav-item">
                                        <a href="{{url('/siswa')}}" wire:navigate wire:current.strict="active group">
                                            <div class="flex items-center">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M14.2172 3.49965C12.7962 2.83345 11.2037 2.83345 9.78272 3.49965L3.0916 6.63659C2.0156 7.14105 1.73507 8.56352 2.25 9.54666L2.25 14.5C2.25 14.9142 2.58579 15.25 3 15.25C3.41421 15.25 3.75 14.9142 3.75 14.5V10.672L9.78281 13.5003C11.2038 14.1665 12.7963 14.1665 14.2173 13.5003L20.9084 10.3634C22.3639 9.68105 22.3639 7.31899 20.9084 6.63664L14.2172 3.49965Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M5 12.9147V16.6254C5 17.6334 5.5035 18.5772 6.38533 19.0656C7.8537 19.8787 10.204 21 12 21C13.796 21 16.1463 19.8787 17.6147 19.0656C18.4965 18.5772 19 17.6334 19 16.6254V12.9148L14.854 14.8585C13.0296 15.7138 10.9705 15.7138 9.14607 14.8585L5 12.9147Z"
                                                        fill="currentColor" />
                                                </svg>
                                                <span
                                                    class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Siswa</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                            <h2
                                class="-mx-4 mb-1 flex items-center bg-white-light/30 py-3 px-7 font-extrabold uppercase dark:bg-dark dark:bg-opacity-[0.08]">
                                <svg class="hidden h-5 w-4 flex-none" viewbox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Penilaian</span>
                            </h2>
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'wali_kelas')
                            <li class="nav-item">
                                <ul>
                                    <li class="nav-item">
                                        <a href="{{url('/penilaian')}}" wire:navigate wire:current.strict="active group">
                                            <div class="flex items-center">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" fill="currentColor"/>
                                                    <path d="M22 5C22 6.65685 20.6569 8 19 8C17.3431 8 16 6.65685 16 5C16 3.34315 17.3431 2 19 2C20.6569 2 22 3.34315 22 5Z" fill="currentColor"/>
                                                    <path d="M14.5 13.25C14.0858 13.25 13.75 13.5858 13.75 14C13.75 14.4142 14.0858 14.75 14.5 14.75H17C17.4142 14.75 17.75 14.4142 17.75 14V11.5C17.75 11.0858 17.4142 10.75 17 10.75C16.5858 10.75 16.25 11.0858 16.25 11.5V12.1893L14.2374 10.1768C13.554 9.49336 12.446 9.49336 11.7626 10.1768L10.1768 11.7626C10.0791 11.8602 9.92085 11.8602 9.82322 11.7626L7.53033 9.46967C7.23744 9.17678 6.76256 9.17678 6.46967 9.46967C6.17678 9.76256 6.17678 10.2374 6.46967 10.5303L8.76256 12.8232C9.44598 13.5066 10.554 13.5066 11.2374 12.8232L12.8232 11.2374C12.9209 11.1398 13.0791 11.1398 13.1768 11.2374L15.1893 13.25H14.5Z" fill="currentColor"/>
                                                    </svg>
                                                    
                                                    

                                                <span
                                                    class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark"> Penilaian</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'wali_kelas' || auth()->user()->role === 'wali_siswa')
                            <li class="nav-item">
                                <ul>
                                    <li class="nav-item">
                                        <a href="{{url('/laporan-siswa')}}" wire:navigate wire:current.strict="active group">
                                            <div class="flex items-center">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.25 4.47954L14.25 7.5372C14.2498 7.64842 14.2496 7.80699 14.2709 7.9431C14.2969 8.10951 14.3824 8.43079 14.7151 8.62611C15.0355 8.81422 15.3488 8.74436 15.4978 8.69806C15.6276 8.6577 15.77 8.58988 15.8762 8.5393L17 8.00545L18.1238 8.5393C18.23 8.58987 18.3724 8.6577 18.5022 8.69806C18.6512 8.74436 18.9645 8.81422 19.2849 8.62611C19.6176 8.43079 19.7031 8.10952 19.7291 7.9431C19.7504 7.807 19.7502 7.64845 19.75 7.53723L19.75 3.0313C19.8628 3.026 19.9736 3.02152 20.0818 3.01775C21.1536 2.98041 21.9998 3.86075 21.9998 4.93319V16.1436C21.9998 17.2546 21.0938 18.1535 19.985 18.2228C19.0155 18.2835 17.8765 18.402 16.9998 18.6334C15.9184 18.9187 15.0106 19.7008 13.6274 20.0692C13.0013 20.236 12.3029 20.3257 12 20.3925V5.17387C12.3208 5.0953 13.3822 4.97142 13.6737 4.80275C13.8579 4.6961 14.0512 4.58732 14.25 4.47954ZM19.7276 12.8181C19.8281 13.2199 19.5837 13.6271 19.1819 13.7276L15.1819 14.7276C14.7801 14.8281 14.3729 14.5837 14.2724 14.1819C14.1719 13.7801 14.4163 13.3729 14.8181 13.2724L18.8181 12.2724C19.2199 12.1719 19.6271 12.4163 19.7276 12.8181Z" fill="currentColor"/>
                                                    <path d="M18.25 3.15101C17.63 3.22431 17.0204 3.33159 16.4998 3.48744C16.2583 3.55975 16.0062 3.65141 15.75 3.7564V3.95002V6.93859L16.4993 6.58266L16.5081 6.57822C16.5571 6.55316 16.7636 6.44757 17 6.44757C17.0475 6.44757 17.0939 6.45184 17.138 6.45887C17.3131 6.48679 17.4527 6.5582 17.4919 6.57822L17.5007 6.58265L18.25 6.93859V3.64665V3.15101Z" fill="currentColor"/>
                                                    <path opacity="0.5" d="M12 5.21395C11.6658 5.15047 10.9426 5.05264 10.2823 4.87544C8.9381 4.51475 8.04921 3.76429 7 3.48742C6.11349 3.25349 4.95877 3.13488 3.9824 3.07487C2.8863 3.0075 2 3.89961 2 4.99778V16.1436C2 17.2545 2.90605 18.1534 4.01486 18.2228C4.98428 18.2834 6.12329 18.402 7 18.6333C7.48596 18.7616 8.21615 19.0645 8.87295 19.3592C9.87752 19.81 10.9247 20.1556 12 20.3926V5.21395Z" fill="currentColor"/>
                                                    <path d="M4.27257 12.8183C4.37303 12.4164 4.78023 12.1721 5.18208 12.2726L9.18208 13.2726C9.58393 13.373 9.82825 13.7802 9.72778 14.1821C9.62732 14.5839 9.22012 14.8282 8.81828 14.7278L4.81828 13.7278C4.41643 13.6273 4.17211 13.2201 4.27257 12.8183Z" fill="currentColor"/>
                                                    <path d="M5.18208 8.27257C4.78023 8.17211 4.37303 8.41643 4.27257 8.81828C4.17211 9.22012 4.41643 9.62732 4.81828 9.72778L8.81828 10.7278C9.22012 10.8282 9.62732 10.5839 9.72778 10.1821C9.82825 9.78023 9.58393 9.37303 9.18208 9.27257L5.18208 8.27257Z" fill="currentColor"/>
                                                    </svg>
                                                    <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark"> Laporan</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                    </ul>
                </div>
            </nav>
        </div>
        <!-- end sidebar section -->

        <div class="main-content flex flex-col min-h-screen">
            <!-- start header section -->
            <header class="z-40" :class="{'dark' : $store.app.semidark && $store.app.menu === 'horizontal'}">
                <div class="shadow-sm">
                    <div class="relative flex w-full items-center bg-white px-5 py-2.5 dark:bg-[#0e1726]">
                        <div class="horizontal-logo flex items-center justify-between ltr:mr-2 rtl:ml-2 lg:hidden">
                            <a href="{{url('/dashboard')}}" wire:navigate class="main-logo flex shrink-0 items-center"
                                x-data="{
                                    showLogo: {{ $appSetting->show_logo ? 'true' : 'false' }},
                                    showName: {{ $appSetting->show_name ? 'true' : 'false' }}
                                }" @show-logo-updated.window="showLogo = Boolean($event.detail)"
                                @show-name-updated.window="showName = Boolean($event.detail)">

                                <template x-if="showLogo">
                                    <img id="app-logo" class="ml-[5px] w-8 flex-none"
                                        x-data="{ logo: '{{ asset('storage') }}/{{ $appSetting->app_logo ?? 'default-logo.png' }}' }"
                                        x-bind:src="logo" @logo-updated.window="logo = $event.detail" alt="Logo">
                                </template>
                            </a>

                            <a href="javascript:;"
                                class="collapse-icon flex flex-none rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary ltr:ml-2 rtl:mr-2 dark:bg-dark/40 dark:text-[#d0d2d6] dark:hover:bg-dark/60 dark:hover:text-primary lg:hidden"
                                @click="$store.app.toggleSidebar()">
                                <svg width="20" height="20" viewbox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 7L4 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                    </path>
                                    <path opacity="0.5" d="M20 12L4 12" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round"></path>
                                    <path d="M20 17L4 17" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="hidden ltr:mr-2 rtl:ml-2 sm:block">
                            <ul class="flex items-center space-x-2 rtl:space-x-reverse dark:text-[#d0d2d6]">
                                <li>
                                    <a href="#"
                                        class="block rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60">
                                        <svg width="20" height="20" viewbox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C22 6.34315 22 8.22876 22 12V14C22 17.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V12Z"
                                                stroke="currentColor" stroke-width="1.5"></path>
                                            <path opacity="0.5" d="M7 4V2.5" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round"></path>
                                            <path opacity="0.5" d="M17 4V2.5" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round"></path>
                                            <path opacity="0.5" d="M2 9H22" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round"></path>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div
                            class="flex items-center space-x-1.5 ltr:ml-auto rtl:mr-auto rtl:space-x-reverse dark:text-[#d0d2d6] sm:flex-1 ltr:sm:ml-0 sm:rtl:mr-0 lg:space-x-2">
                            <div class="sm:ltr:mr-auto sm:rtl:ml-auto">
                            </div>


                            {{-- theme tombol --}}
                            @if(in_array(Auth::user()->role, ['admin']))
                                <div class="dropdown" x-data="dropdown" @click.outside="open = false">
                                    <a href="{{route('setting')}}" wire:navigate
                                            class="block rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M14.2788 2.15224C13.9085 2 13.439 2 12.5 2C11.561 2 11.0915 2 10.7212 2.15224C10.2274 2.35523 9.83509 2.74458 9.63056 3.23463C9.53719 3.45834 9.50065 3.7185 9.48635 4.09799C9.46534 4.65568 9.17716 5.17189 8.69017 5.45093C8.20318 5.72996 7.60864 5.71954 7.11149 5.45876C6.77318 5.2813 6.52789 5.18262 6.28599 5.15102C5.75609 5.08178 5.22018 5.22429 4.79616 5.5472C4.47814 5.78938 4.24339 6.1929 3.7739 6.99993C3.30441 7.80697 3.06967 8.21048 3.01735 8.60491C2.94758 9.1308 3.09118 9.66266 3.41655 10.0835C3.56506 10.2756 3.77377 10.437 4.0977 10.639C4.57391 10.936 4.88032 11.4419 4.88029 12C4.88026 12.5581 4.57386 13.0639 4.0977 13.3608C3.77372 13.5629 3.56497 13.7244 3.41645 13.9165C3.09108 14.3373 2.94749 14.8691 3.01725 15.395C3.06957 15.7894 3.30432 16.193 3.7738 17C4.24329 17.807 4.47804 18.2106 4.79606 18.4527C5.22008 18.7756 5.75599 18.9181 6.28589 18.8489C6.52778 18.8173 6.77305 18.7186 7.11133 18.5412C7.60852 18.2804 8.2031 18.27 8.69012 18.549C9.17714 18.8281 9.46533 19.3443 9.48635 19.9021C9.50065 20.2815 9.53719 20.5417 9.63056 20.7654C9.83509 21.2554 10.2274 21.6448 10.7212 21.8478C11.0915 22 11.561 22 12.5 22C13.439 22 13.9085 22 14.2788 21.8478C14.7726 21.6448 15.1649 21.2554 15.3694 20.7654C15.4628 20.5417 15.4994 20.2815 15.5137 19.902C15.5347 19.3443 15.8228 18.8281 16.3098 18.549C16.7968 18.2699 17.3914 18.2804 17.8886 18.5412C18.2269 18.7186 18.4721 18.8172 18.714 18.8488C19.2439 18.9181 19.7798 18.7756 20.2038 18.4527C20.5219 18.2105 20.7566 17.807 21.2261 16.9999C21.6956 16.1929 21.9303 15.7894 21.9827 15.395C22.0524 14.8691 21.9088 14.3372 21.5835 13.9164C21.4349 13.7243 21.2262 13.5628 20.9022 13.3608C20.4261 13.0639 20.1197 12.558 20.1197 11.9999C20.1197 11.4418 20.4261 10.9361 20.9022 10.6392C21.2263 10.4371 21.435 10.2757 21.5836 10.0835C21.9089 9.66273 22.0525 9.13087 21.9828 8.60497C21.9304 8.21055 21.6957 7.80703 21.2262 7C20.7567 6.19297 20.522 5.78945 20.2039 5.54727C19.7799 5.22436 19.244 5.08185 18.7141 5.15109C18.4722 5.18269 18.2269 5.28136 17.8887 5.4588C17.3915 5.71959 16.7969 5.73002 16.3099 5.45096C15.8229 5.17191 15.5347 4.65566 15.5136 4.09794C15.4993 3.71848 15.4628 3.45833 15.3694 3.23463C15.1649 2.74458 14.7726 2.35523 14.2788 2.15224Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M15.5227 12C15.5227 13.6569 14.1694 15 12.4999 15C10.8304 15 9.47705 13.6569 9.47705 12C9.47705 10.3431 10.8304 9 12.4999 9C14.1694 9 15.5227 10.3431 15.5227 12Z"
                                                    fill="currentColor" />
                                            </svg>




                                        </a>
                                </div>

                                <div class="dropdown" x-data="dropdown" @click.outside="open = false">
                                    <a href="{{route('user')}}" wire:navigate
                                        class="block rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.5"
                                                d="M3 10.4167C3 7.21907 3 5.62028 3.37752 5.08241C3.75503 4.54454 5.25832 4.02996 8.26491 3.00079L8.83772 2.80472C10.405 2.26824 11.1886 2 12 2C12.8114 2 13.595 2.26824 15.1623 2.80472L15.7351 3.00079C18.7417 4.02996 20.245 4.54454 20.6225 5.08241C21 5.62028 21 7.21907 21 10.4167V11.9914C21 17.6294 16.761 20.3655 14.1014 21.5273C13.38 21.8424 13.0193 22 12 22C10.9807 22 10.62 21.8424 9.89856 21.5273C7.23896 20.3655 3 17.6294 3 11.9914V10.4167Z"
                                                fill="currentColor" />
                                            <path
                                                d="M14 9C14 10.1046 13.1046 11 12 11C10.8954 11 10 10.1046 10 9C10 7.89543 10.8954 7 12 7C13.1046 7 14 7.89543 14 9Z"
                                                fill="currentColor" />
                                            <path
                                                d="M12 17C16 17 16 16.1046 16 15C16 13.8954 14.2091 13 12 13C9.79086 13 8 13.8954 8 15C8 16.1046 8 17 12 17Z"
                                                fill="currentColor" />
                                        </svg>

                                    </a>
                                </div>
                            @endif

                            <div>
                                <a href="javascript:;" x-cloak="" x-show="$store.app.theme === 'light'"
                                    href="javascript:;"
                                    class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
                                    @click="$store.app.toggleTheme('dark')">
                                    <svg width="20" height="20" viewbox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5"></circle>
                                        <path d="M12 2V4" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                        <path d="M12 20V22" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                        <path d="M4 12L2 12" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                        <path d="M22 12L20 12" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                        <path opacity="0.5" d="M19.7778 4.22266L17.5558 6.25424" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round"></path>
                                        <path opacity="0.5" d="M4.22217 4.22266L6.44418 6.25424" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round"></path>
                                        <path opacity="0.5" d="M6.44434 17.5557L4.22211 19.7779" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round"></path>
                                        <path opacity="0.5" d="M19.7778 19.7773L17.5558 17.5551" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </a>
                                <a href="javascript:;" x-cloak="" x-show="$store.app.theme === 'dark'"
                                    href="javascript:;"
                                    class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
                                    @click="$store.app.toggleTheme('system')">
                                    <svg width="20" height="20" viewbox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21.0672 11.8568L20.4253 11.469L21.0672 11.8568ZM12.1432 2.93276L11.7553 2.29085V2.29085L12.1432 2.93276ZM21.25 12C21.25 17.1086 17.1086 21.25 12 21.25V22.75C17.9371 22.75 22.75 17.9371 22.75 12H21.25ZM12 21.25C6.89137 21.25 2.75 17.1086 2.75 12H1.25C1.25 17.9371 6.06294 22.75 12 22.75V21.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75V1.25C6.06294 1.25 1.25 6.06294 1.25 12H2.75ZM15.5 14.25C12.3244 14.25 9.75 11.6756 9.75 8.5H8.25C8.25 12.5041 11.4959 15.75 15.5 15.75V14.25ZM20.4253 11.469C19.4172 13.1373 17.5882 14.25 15.5 14.25V15.75C18.1349 15.75 20.4407 14.3439 21.7092 12.2447L20.4253 11.469ZM9.75 8.5C9.75 6.41182 10.8627 4.5828 12.531 3.57467L11.7553 2.29085C9.65609 3.5593 8.25 5.86509 8.25 8.5H9.75ZM12 2.75C11.9115 2.75 11.8077 2.71008 11.7324 2.63168C11.6686 2.56527 11.6538 2.50244 11.6503 2.47703C11.6461 2.44587 11.6482 2.35557 11.7553 2.29085L12.531 3.57467C13.0342 3.27065 13.196 2.71398 13.1368 2.27627C13.0754 1.82126 12.7166 1.25 12 1.25V2.75ZM21.7092 12.2447C21.6444 12.3518 21.5541 12.3539 21.523 12.3497C21.4976 12.3462 21.4347 12.3314 21.3683 12.2676C21.2899 12.1923 21.25 12.0885 21.25 12H22.75C22.75 11.2834 22.1787 10.9246 21.7237 10.8632C21.286 10.804 20.7293 10.9658 20.4253 11.469L21.7092 12.2447Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </a>
                                <a href="javascript:;" x-cloak="" x-show="$store.app.theme === 'system'"
                                    href="javascript:;"
                                    class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
                                    @click="$store.app.toggleTheme('light')">
                                    <svg width="20" height="20" viewbox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15C17.8284 3 19.2426 3 20.1213 3.87868C21 4.75736 21 6.17157 21 9V14C21 15.8856 21 16.8284 20.4142 17.4142C19.8284 18 18.8856 18 17 18H7C5.11438 18 4.17157 18 3.58579 17.4142C3 16.8284 3 15.8856 3 14V9Z"
                                            stroke="currentColor" stroke-width="1.5"></path>
                                        <path opacity="0.5" d="M22 21H2" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                        <path opacity="0.5" d="M15 15H9" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                    </svg>
                                </a>
                            </div>

                            <div class="dropdown flex-shrink-0" x-data="dropdown" @click.outside="open = false">
                                <a href="javascript:;" class="group relative" @click="toggle()">
                                    <span><img
                                            class="h-9 w-9 rounded-full object-cover saturate-50 group-hover:saturate-100"
                                            src="{{ asset('assets/images/user-profile.jpeg') }}" alt="image"></span>
                                </a>
                                <ul x-cloak="" x-show="open" x-transition="" x-transition.duration.300ms=""
                                    class="top-11 w-[230px] !py-0 font-semibold text-dark ltr:right-0 rtl:left-0 dark:text-white-dark dark:text-white-light/90">
                                    <li>
                                        <div class="flex items-center px-4 py-4">
                                            <div class="flex-none">
                                                <img class="h-10 w-10 rounded-md object-cover"
                                                    src="{{ asset('assets/images/user-profile.jpeg') }}" alt="image">
                                            </div>
                                            {{-- <div class="truncate ltr:pl-4 rtl:pr-4">
                                                <h4 class="text-base">
                                                    {{ Auth::user()->name }}
                                                </h4>
                                                <a class="text-black/60 hover:text-primary dark:text-dark-light/60 dark:hover:text-white"
                                                    href="javascript:;">{{ Auth::user()->email }}</a>
                                            </div> --}}
                                            <div class="truncate ltr:pl-4 rtl:pr-4">
                                                <h4 class="text-base">
                                                    {{ Auth::user()->name }}
                                                </h4>
                                                <a class="text-black/60 hover:text-primary dark:text-dark-light/60 dark:hover:text-white"
                                                    href="javascript:;">{{ Auth::user()->email }}</a>
                                            </div>

                                        </div>
                                    </li>
                                    <li class="border-t border-white-light dark:border-white-light/10">
                                        <a href="{{ route('edit.user', Auth::user()->id) }}" 
                                        class="inline-flex items-center px-3 py-1 text-sm">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li class="border-t border-white-light dark:border-white-light/10">
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                            class="!py-3 text-danger">
                                            <svg class="h-4.5 w-4.5 rotate-90 ltr:mr-2 rtl:ml-2" width="18" height="18"
                                                viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.5"
                                                    d="M17 9.00195C19.175 9.01406 20.3529 9.11051 21.1213 9.8789C22 10.7576 22 12.1718 22 15.0002V16.0002C22 18.8286 22 20.2429 21.1213 21.1215C20.2426 22.0002 18.8284 22.0002 16 22.0002H8C5.17157 22.0002 3.75736 22.0002 2.87868 21.1215C2 20.2429 2 18.8286 2 16.0002L2 15.0002C2 12.1718 2 10.7576 2.87868 9.87889C3.64706 9.11051 4.82497 9.01406 7 9.00195"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                                </path>
                                                <path d="M12 15L12 2M12 2L15 5.5M12 2L9 5.5" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                </path>
                                            </svg>
                                            Sign Out
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" wire:navigate
                                            method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- horizontal menu -->
                    <ul
                        class="horizontal-menu hidden border-t border-[#ebedf2] bg-white py-1.5 px-6 font-semibold text-black rtl:space-x-reverse dark:border-[#191e3a] dark:bg-[#0e1726] dark:text-white-dark lg:space-x-1.5 xl:space-x-8">
                        <li class="menu nav-item relative">
                            <a href="{{url('/dashboard')}}" wire:navigate wire:current.strict="active" class="nav-link">
                                <div class="flex items-center">
                                    <svg width="20" height="20" viewbox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                        <path opacity="0.5"
                                            d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z"
                                            fill="currentColor"></path>
                                    </svg>
                                    <span class="px-1">Dashboard</span>
                                </div>
                            </a>
                        </li>
                        @if(auth()->user()->role === 'admin')
                            <li class="menu nav-item relative">
                                <a href="javascript:;" class="nav-link">
                                    <div class="flex items-center">
                                        <svg width="20" height="20" viewbox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                            <g opacity="0.5">
                                                <path
                                                    d="M14 2.75C15.9068 2.75 17.2615 2.75159 18.2892 2.88976C19.2952 3.02503 19.8749 3.27869 20.2981 3.7019C20.7213 4.12511 20.975 4.70476 21.1102 5.71085C21.2484 6.73851 21.25 8.09318 21.25 10C21.25 10.4142 21.5858 10.75 22 10.75C22.4142 10.75 22.75 10.4142 22.75 10V9.94359C22.75 8.10583 22.75 6.65019 22.5969 5.51098C22.4392 4.33856 22.1071 3.38961 21.3588 2.64124C20.6104 1.89288 19.6614 1.56076 18.489 1.40314C17.3498 1.24997 15.8942 1.24998 14.0564 1.25H14C13.5858 1.25 13.25 1.58579 13.25 2C13.25 2.41421 13.5858 2.75 14 2.75Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M9.94358 1.25H10C10.4142 1.25 10.75 1.58579 10.75 2C10.75 2.41421 10.4142 2.75 10 2.75C8.09318 2.75 6.73851 2.75159 5.71085 2.88976C4.70476 3.02503 4.12511 3.27869 3.7019 3.7019C3.27869 4.12511 3.02503 4.70476 2.88976 5.71085C2.75159 6.73851 2.75 8.09318 2.75 10C2.75 10.4142 2.41421 10.75 2 10.75C1.58579 10.75 1.25 10.4142 1.25 10V9.94358C1.24998 8.10583 1.24997 6.65019 1.40314 5.51098C1.56076 4.33856 1.89288 3.38961 2.64124 2.64124C3.38961 1.89288 4.33856 1.56076 5.51098 1.40314C6.65019 1.24997 8.10583 1.24998 9.94358 1.25Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M22 13.25C22.4142 13.25 22.75 13.5858 22.75 14V14.0564C22.75 15.8942 22.75 17.3498 22.5969 18.489C22.4392 19.6614 22.1071 20.6104 21.3588 21.3588C20.6104 22.1071 19.6614 22.4392 18.489 22.5969C17.3498 22.75 15.8942 22.75 14.0564 22.75H14C13.5858 22.75 13.25 22.4142 13.25 22C13.25 21.5858 13.5858 21.25 14 21.25C15.9068 21.25 17.2615 21.2484 18.2892 21.1102C19.2952 20.975 19.8749 20.7213 20.2981 20.2981C20.7213 19.8749 20.975 19.2952 21.1102 18.2892C21.2484 17.2615 21.25 15.9068 21.25 14C21.25 13.5858 21.5858 13.25 22 13.25Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M2.75 14C2.75 13.5858 2.41421 13.25 2 13.25C1.58579 13.25 1.25 13.5858 1.25 14V14.0564C1.24998 15.8942 1.24997 17.3498 1.40314 18.489C1.56076 19.6614 1.89288 20.6104 2.64124 21.3588C3.38961 22.1071 4.33856 22.4392 5.51098 22.5969C6.65019 22.75 8.10583 22.75 9.94359 22.75H10C10.4142 22.75 10.75 22.4142 10.75 22C10.75 21.5858 10.4142 21.25 10 21.25C8.09318 21.25 6.73851 21.2484 5.71085 21.1102C4.70476 20.975 4.12511 20.7213 3.7019 20.2981C3.27869 19.8749 3.02503 19.2952 2.88976 18.2892C2.75159 17.2615 2.75 15.9068 2.75 14Z"
                                                    fill="currentColor"></path>
                                            </g>
                                            <path
                                                d="M5.52721 5.52721C5 6.05442 5 6.90294 5 8.6C5 9.73137 5 10.2971 5.35147 10.6485C5.70294 11 6.26863 11 7.4 11H8.6C9.73137 11 10.2971 11 10.6485 10.6485C11 10.2971 11 9.73137 11 8.6V7.4C11 6.26863 11 5.70294 10.6485 5.35147C10.2971 5 9.73137 5 8.6 5C6.90294 5 6.05442 5 5.52721 5.52721Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M5.52721 18.4728C5 17.9456 5 17.0971 5 15.4C5 14.2686 5 13.7029 5.35147 13.3515C5.70294 13 6.26863 13 7.4 13H8.6C9.73137 13 10.2971 13 10.6485 13.3515C11 13.7029 11 14.2686 11 15.4V16.6C11 17.7314 11 18.2971 10.6485 18.6485C10.2971 19 9.73138 19 8.60002 19C6.90298 19 6.05441 19 5.52721 18.4728Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M13 7.4C13 6.26863 13 5.70294 13.3515 5.35147C13.7029 5 14.2686 5 15.4 5C17.0971 5 17.9456 5 18.4728 5.52721C19 6.05442 19 6.90294 19 8.6C19 9.73137 19 10.2971 18.6485 10.6485C18.2971 11 17.7314 11 16.6 11H15.4C14.2686 11 13.7029 11 13.3515 10.6485C13 10.2971 13 9.73137 13 8.6V7.4Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M13.3515 18.6485C13 18.2971 13 17.7314 13 16.6V15.4C13 14.2686 13 13.7029 13.3515 13.3515C13.7029 13 14.2686 13 15.4 13H16.6C17.7314 13 18.2971 13 18.6485 13.3515C19 13.7029 19 14.2686 19 15.4C19 17.097 19 17.9456 18.4728 18.4728C17.9456 19 17.0971 19 15.4 19C14.2687 19 13.7029 19 13.3515 18.6485Z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span class="px-1">Pengguna</span>
                                    </div>
                                    <div class="right_arrow">
                                        <svg class="h-4 w-4 rotate-90" width="16" height="16" viewbox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="{{url('wali-kelas')}}" wire:navigate>Wali Kelas</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="menu nav-item relative">
                            <a href="javascript:;" class="nav-link">
                                <div class="flex items-center">
                                    <svg width="20" height="20" viewbox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                        <path
                                            d="M8.42229 20.6181C10.1779 21.5395 11.0557 22.0001 12 22.0001V12.0001L2.63802 7.07275C2.62423 7.09491 2.6107 7.11727 2.5974 7.13986C2 8.15436 2 9.41678 2 11.9416V12.0586C2 14.5834 2 15.8459 2.5974 16.8604C3.19479 17.8749 4.27063 18.4395 6.42229 19.5686L8.42229 20.6181Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.7"
                                            d="M17.5774 4.43152L15.5774 3.38197C13.8218 2.46066 12.944 2 11.9997 2C11.0554 2 10.1776 2.46066 8.42197 3.38197L6.42197 4.43152C4.31821 5.53552 3.24291 6.09982 2.6377 7.07264L11.9997 12L21.3617 7.07264C20.7564 6.09982 19.6811 5.53552 17.5774 4.43152Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.5"
                                            d="M21.4026 7.13986C21.3893 7.11727 21.3758 7.09491 21.362 7.07275L12 12.0001V22.0001C12.9443 22.0001 13.8221 21.5395 15.5777 20.6181L17.5777 19.5686C19.7294 18.4395 20.8052 17.8749 21.4026 16.8604C22 15.8459 22 14.5834 22 12.0586V11.9416C22 9.41678 22 8.15436 21.4026 7.13986Z"
                                            fill="currentColor"></path>
                                    </svg>
                                    <span class="px-1">Master Data</span>
                                </div>
                                <div class="right_arrow">
                                    <svg class="h-4 w-4 rotate-90" width="16" height="16" viewbox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                            </a>
                            <ul class="sub-menu">
                                @if(auth()->user()->role === 'admin')
                                    <li>
                                        <a href="{{url('kelas')}}" wire:navigate>Kelas</a>
                                    </li>
                                    <li>
                                        <a href="{{url('kategori')}}" wire:navigate>Aspek</a>
                                    </li>
                                @endif
                                @if(auth()->user()->role === 'admin'|| auth()->user()->role === 'wali_kelas' || auth()->user()->role === 'wali_siswa')
                                    <li>
                                        <a href="{{url('siswa')}}" wire:navigate>Siswa</a>
                                    </li>
                                @endif
                                
                            </ul>
                        </li>
                            <li class="menu nav-item relative">
                                <a href="javascript:;" class="nav-link">
                                    <div class="flex items-center">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.73167 5.77133L5.66953 9.91436C4.3848 11.6526 3.74244 12.5217 4.09639 13.205C4.10225 13.2164 4.10829 13.2276 4.1145 13.2387C4.48945 13.9117 5.59888 13.9117 7.81775 13.9117C9.05079 13.9117 9.6673 13.9117 10.054 14.2754L10.074 14.2946L13.946 9.72466L13.926 9.70541C13.5474 9.33386 13.5474 8.74151 13.5474 7.55682V7.24712C13.5474 3.96249 13.5474 2.32018 12.6241 2.03721C11.7007 1.75425 10.711 3.09327 8.73167 5.77133Z"
                                                fill="currentColor"></path>
                                            <path opacity="0.5"
                                                d="M10.4527 16.4432L10.4527 16.7528C10.4527 20.0374 10.4527 21.6798 11.376 21.9627C12.2994 22.2457 13.2891 20.9067 15.2685 18.2286L18.3306 14.0856C19.6154 12.3474 20.2577 11.4783 19.9038 10.7949C19.8979 10.7836 19.8919 10.7724 19.8857 10.7613C19.5107 10.0883 18.4013 10.0883 16.1824 10.0883C14.9494 10.0883 14.3329 10.0883 13.9462 9.72461L10.0742 14.2946C10.4528 14.6661 10.4527 15.2585 10.4527 16.4432Z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span class="px-1">Penilaian</span>
                                    </div>
                                    <div class="right_arrow">
                                        <svg class="h-4 w-4 rotate-90" width="16" height="16" viewbox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </a>
                                <ul class="sub-menu">
                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'wali_kelas')
                                        <li>
                                            <a href="{{url('penilaian')}}" wire:navigate>Penilaian</a>
                                        </li>
                                    @endif
                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'wali_kelas' || auth()->user()->role === 'wali_siswa')
                                    <li>
                                        <a href="{{url('laporan-siswa')}}" wire:navigate>Laporan</a>
                                    </li>
                                    @endif
                                    
                                </ul>
                            </li>
                    </ul>
                    <!-- horizontal menu end-->

                </div>
            </header>
            <!-- end header section -->

            <!-- start main content section -->
            {{$slot}}
            <!-- end main content section -->


            <!-- start footer section -->
            <div class="p-6 pt-0 mt-auto text-center dark:text-white-dark ltr:sm:text-left rtl:sm:text-right">
                © <span id="footer-year">2025</span>. {{ $appSetting->app_name }} All rights reserved.
            </div>
            <!-- end footer section -->
        </div>
    </div>
    @livewireScripts

    <script src="{{ asset('assets/js/alpine-collaspe.min.js')}}"></script>
    <script defer="" src="{{ asset('assets/js/alpine-ui.min.js')}}"></script>
    <script defer="" src="{{ asset('assets/js/alpine-focus.min.js')}}"></script>
    <script src="{{ asset('assets/js/custom.js')}}"></script>
    <script defer="" src="{{ asset('assets/js/apexcharts.js')}}"></script>
    <script src="{{asset('filepond-plugin-image-preview/filepond-plugin-image-preview.js')}}"></script>
    <script src="{{asset('filepond/filepond.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>


    <script>
        // main section
        document.addEventListener('alpine:init', () => {
            Alpine.data('scrollToTop', () => ({
                showTopButton: false,
                init() {
                    window.onscroll = () => {
                        this.scrollFunction();
                    };
                },

                scrollFunction() {
                    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                        this.showTopButton = true;
                    } else {
                        this.showTopButton = false;
                    }
                },

                goToTop() {
                    document.body.scrollTop = 0;
                    document.documentElement.scrollTop = 0;
                },
            }));

            // theme customization
            Alpine.data('customizer', () => ({
                showCustomizer: false,
            }));

            // sidebar section
            Alpine.data('sidebar', () => ({
                init() {
                    const selector = document.querySelector('.sidebar ul a[href="' + window.location
                        .pathname + '"]');
                    if (selector) {
                        selector.classList.add('active');
                        const ul = selector.closest('ul.sub-menu');
                        if (ul) {
                            let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                            if (ele) {
                                ele = ele[0];
                                setTimeout(() => {
                                    ele.click();
                                });
                            }
                        }
                    }
                },
            }));
        });

    </script>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('konfirmDelete', () => {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete');
                    }
                });
            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('HapusAja', () => {
                new window.Swal('Deleted!', 'Your file has been deleted.', 'success');
            });
        });

        window.addEventListener('gagalHapus', event => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: 'error',
                title: event.detail.message || 'Terjadi kesalahan sistem saat menghapus data.'
            });
        });

        window.addEventListener('mikrotikError', event => {
            Swal.fire({
                title: 'Koneksi Gagal',
                text: event.detail.message || 'Tidak dapat terhubung ke MikroTik.',
                icon: 'error',
                confirmButtonText: 'Tutup'
            });
        });

    </script>
    
    @stack('js')

</body>

</html>
