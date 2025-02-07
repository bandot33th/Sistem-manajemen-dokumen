<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])

    <link rel="icon" href="/img/bs-logo-white.png">
    <title>Bridgestone</title>

    <style>
      html, body {
        height: 100%;                
        overflow: hidden;             
      }

      .scroll-container { 
        height: 100vh;                  
        overflow-y: scroll;             
        scrollbar-width: none;          
        -ms-overflow-style: none;       
      }

      .scroll-container::-webkit-scrollbar {
        display: none;                  
      }

      section {
        scroll-snap-align: start;       
        height: 100vh;                  
      }

      /* Smooth transition for image hover effect */
      .group img {
        transition: opacity 0.6s ease-in-out; /* Smooth fade transition */
      }

      /* Smooth transition for all elements inside the group */
      .group .absolute {
        transition: all 0.6s ease-in-out; /* Smooth transition for text, buttons, etc. */
      }
    </style> 
</head>

<body>
    <div class="scroll-container"> 
        {{-- First Page --}}
        <section
            class="first-page relative bg-[url(https://grippingstories.com/wp-content/uploads/2023/04/BS_wallpaper_V02_1.jpg)] bg-cover bg-center bg-no-repeat"
        >
            <div
              class="absolute inset-0 bg-gray-900/75 sm:bg-transparent sm:from-gray-900/95 sm:to-gray-900/25 ltr:sm:bg-gradient-to-r rtl:sm:bg-gradient-to-l"
            ></div>

            <div
              class="relative mx-auto max-w-screen-xl px-4 py-32 sm:px-8 lg:flex lg:h-screen lg:items-center lg:px-8"
            >
              <div class="max-w-xl mt-24 text-center lg:my-auto ltr:lg:text-left rtl:sm:text-right">
                <img src="/img/bs-putih.png" alt="">

                <p class="mt-4 max-w-lg text-white sm:text-xl/relaxed italic">
                  Solutions For Your Journey
                </p>
              </div>
            </div>
        </section>

        {{-- Second Page --}}
        <section>
          <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8 justify-between">
            <header class="text-center mb-5">
              <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Hello Bridgestoners</h2>
            </header>
            
            <span class="flex items-center">
              <span class="h-px flex-1 bg-black"></span>
              <span class="shrink-0 px-6">Explore More</span>
              <span class="h-px flex-1 bg-black"></span>
            </span>

            <ul class="mt-8 sm:grid grid-cols-3 justify-center">
              <li class="mt-2 sm:me-2">
                <a href="{{ route('login') }}" class="group relative block">
                  <div class="relative h-[300px] sm:h-[400px]">
                    <img
                      src="/img/dashboardImg2.avif"
                      alt="card-image1"
                      class="absolute inset-0 h-full w-full object-cover opacity-100 group-hover:blur-md"
                    />
                  </div>
                  <div class="absolute inset-0 flex flex-col items-start justify-end p-6">
                    <h3 class="text-xl font-medium text-white">DMS</h3>
                    <p class="mt-1.5 text-pretty text-xs text-white">
                      An integrated document management system for BSINK Engineering Design Department
                    </p>
                    <span class="mt-3 inline-block bg-black px-5 py-3 text-xs font-medium uppercase tracking-wide text-white">
                      Go To DMS
                    </span>
                  </div>
                </a>
              </li>
        
              <li class="mt-2 sm:me-2">
                <a href="#" class="group relative block">
                  <div class="relative h-[300px] sm:h-[400px]">
                    <img
                      src="/img/dashboardImg4.jpg"
                      alt="card-image2"
                      class="absolute inset-0 h-full w-full object-cover opacity-100 group-hover:blur-md"
                    />
                  </div>
                  <div class="absolute inset-0 flex flex-col items-start justify-end p-6">
                    <h3 class="text-xl font-medium text-white">Unifim</h3>
                    <p class="mt-1.5 text-pretty text-xs text-white">
                      The property of maintenance department
                    </p>
                    <span class="mt-3 inline-block bg-black px-5 py-3 text-xs font-medium uppercase tracking-wide text-white">
                      Go To Unifim
                    </span>
                  </div>
                </a>
              </li>
        
              <li class="mt-2 sm:me-2">
                <a href="#" class="group relative block">
                  <div class="relative h-[300px] sm:h-[400px]">
                    <img
                        src="/img/dashboardImg.jpg"
                        alt="card-image3"
                        class="absolute inset-0 h-full w-full object-cover opacity-100 group-hover:blur-md transform scale-x-[-1]"
                    />
                  </div>
                  <div class="absolute inset-0 flex flex-col items-start justify-end p-6">
                    <h3 class="text-xl font-medium text-white">KPI</h3>
                    <p class="mt-1.5 text-pretty text-xs text-white">
                      An integrated key performance indicator for Engineering Design Department
                    </p>
                    <span class="mt-3 inline-block bg-black px-5 py-3 text-xs font-medium uppercase tracking-wide text-white">
                      Go To KPI
                    </span>
                  </div>
                </a>
              </li>
            </ul>
          </div>
        </section>
    </div> 
</body>

</html>
