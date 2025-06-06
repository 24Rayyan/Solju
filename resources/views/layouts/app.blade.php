<!DOCTYPE html>
 <html lang="id">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Solju Order Management</title>
     <script src="https://cdn.tailwindcss.com"></script>
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

     <style>
         @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap');

         body {
             font-family: "Plus Jakarta Sans", sans-serif;
             font-optical-sizing: auto;
             font-weight: 400;
             font-style: normal;
             background: linear-gradient(135deg, #f9fafb, #f3f4f6);
         }

         /* Style untuk notifikasi */
         .notification-popup {
             position: fixed;
             top: 20px;
             right: -400px; /* Mulai dari luar layar di kanan */
             width: 350px;
             padding: 15px 20px;
             background-color: #f0f0f0; /* Latar belakang abu-abu terang */
             color: #333; /* Warna teks abu-abu gelap */
             border-radius: 12px;
             box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
             opacity: 0;
             transition: right 0.5s ease-out, opacity 0.5s ease-out;
             z-index: 1000;
             display: flex;
             align-items: flex-start;
             gap: 15px;
             border: 1px solid #e0e0e0;
         }

         .notification-popup.show {
             right: 20px;
             opacity: 1;
         }


         .notification-icon-wrapper {
             display: flex;
             align-items: center;
             justify-content: center;
             width: 30px;
             height: 30px;
             border-radius: 50%;
             flex-shrink: 0;
         }

         .notification-icon {
             font-size: 20px;
             /* Default icon color */
             color: #666; /* Warna ikon default abu-abu */
         }

         /* Warna ikon khusus berdasarkan tipe notifikasi (ini tetap bisa dipertahankan) */
         .notification-popup.success .notification-icon {
             color: #28a745; /* Tetap hijau untuk ikon sukses */
         }

         .notification-popup.error .notification-icon {
             color: #ff9800; /* Tetap oranye untuk ikon error */
         }

         .notification-content {
             flex-grow: 1;
             display: flex;
             flex-direction: column;
         }

         .notification-title {
             font-weight: 600;
             font-size: 1.1em;
             margin-bottom: 3px;
             color: #333;
         }

         .notification-message {
             font-size: 0.95em;
             color: #555;
         }

         .notification-close {
             background: none;
             border: none;
             font-size: 1.5em;
             color: #888;
             cursor: pointer;
             padding: 0;
             line-height: 1;
             transition: color 0.2s ease;
         }

         .notification-close:hover {
             color: #555;
         }
     </style>
 </head>

 <body class="text-gray-800">

     <div class="min-h-screen flex">
         {{-- Sidebar --}}
         @include('layouts.sidebar')

         {{-- Main Content --}}
         <div class="flex-1 flex flex-col w-full">
             {{-- Navbar (optional) --}}
             @include('layouts.navbar')

             {{-- Content --}}
             <div class="p-6">
                 @yield('content')
             </div>
         </div>
     </div>

     {{-- Elemen Notifikasi Pop-up --}}
     <div id="notificationPopup" class="notification-popup">
         <div class="notification-icon-wrapper">
             <i id="notificationIcon" class="notification-icon fas"></i>
         </div>
         <div class="notification-content">
             <div id="notificationTitle" class="notification-title"></div>
             <div id="notificationMessage" class="notification-message"></div>
         </div>
         <button id="notificationClose" class="notification-close">&times;</button>
     </div>

     <script>
         let notificationTimeout;

         function showNotification(title, message, type = 'success') {
             const popup = document.getElementById('notificationPopup');
             const icon = document.getElementById('notificationIcon');
             const notificationTitle = document.getElementById('notificationTitle');
             const notificationMessage = document.getElementById('notificationMessage');
             const closeButton = document.getElementById('notificationClose');

             clearTimeout(notificationTimeout);

             // Reset class - Penting: Ini akan menghapus kelas 'success' atau 'error' yang mungkin menimpa gaya default.
             popup.classList.remove('success', 'error', 'show');

             notificationTitle.textContent = title;
             notificationMessage.textContent = message;

             if (type === 'success') {
                 // Anda bisa menambahkan kelas 'success' di sini jika ingin tetap ada perbedaan visual pada icon/text
                 // atau menghapusnya sama sekali jika ingin benar-benar abu-abu total.
                 // Saya akan menambahkan kelas 'success' agar selektor CSS untuk ikon tetap bekerja.
                 popup.classList.add('success');
                 icon.classList.remove('fa-exclamation-triangle');
                 icon.classList.add('fa-check-circle');
             } else if (type === 'error') {
                 // Sama seperti success, tambahkan kelas 'error'
                 popup.classList.add('error');
                 icon.classList.remove('fa-check-circle');
                 icon.classList.add('fa-exclamation-triangle');
             }

             // Show the notification
             popup.classList.add('show');

             notificationTimeout = setTimeout(() => {
                 popup.classList.remove('show');
             }, 3000);

             closeButton.onclick = () => {
                 popup.classList.remove('show');
                 clearTimeout(notificationTimeout);
             };
         }

         @if(session('success'))
             document.addEventListener('DOMContentLoaded', function() {
                 showNotification('Berhasil!', '{{ session('success') }}', 'success');
             });
         @endif

         @if(session('error'))
             document.addEventListener('DOMContentLoaded', function() {
                 showNotification('Peringatan!', '{{ session('error') }}', 'error');
             });
         @endif
     </script>

 </body>

 </html>