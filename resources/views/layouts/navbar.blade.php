<nav class="navbar" style="color: #FCFCFD">
  <div class="container mx-auto px-4 py-4 flex justify-between items-center">
    <a class="text-3xl font-extrabold text-black">
      @yield('menu')
    </a>

    {{-- <ul class="hidden md:flex gap-10 items-center text-white font-medium">
      <li>
        <a href="{{ route('orders.create') }}" class="relative px-4 py-2 rounded-lg bg-pink-600 hover:bg-pink-700 shadow-md transition duration-300 flex items-center gap-2">
          <!-- Plus icon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
          </svg>
          Tambah Order
        </a>
      </li>
    </ul> --}}

    <!-- Mobile Hamburger (optional, just visual) -->
    <div class="md:hidden">
      <button type="button" class="text-white hover:text-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-300 rounded-md" aria-label="Menu">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
        </svg>
      </button>
    </div>
  </div>
</nav>
