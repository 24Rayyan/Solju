<nav class="navbar bg-white shadow-sm border-b border-gray-200" style="color: #FCFCFD">
  <div class="container mx-auto px-4 py-3 flex justify-between items-center">
    
    {{-- Hamburger Button (Visible on Mobile) --}}
    <div class="md:hidden">
      <button type="button" onclick="window.toggleSidebar()" class="text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300 rounded-md p-1" aria-label="Menu">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
        </svg>
      </button>
    </div>

    {{-- Breadcrumb / Current Page Name --}}
    <a class="text-lg md:text-2xl font-extrabold text-gray-800">
      @yield('menu')
    </a>

    {{-- Placeholder for User/Settings (Optional) --}}
    <div class="hidden md:block">
        <!-- Tambahkan elemen user atau settings di sini jika ada -->
    </div>
  </div>
</nav>