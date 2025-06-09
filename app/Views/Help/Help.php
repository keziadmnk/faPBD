<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Focus Academy - Aplikasi Tryout Kedinasan No.1 di Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
    <style>
      /* Scrollbar styling for sidebar */
      ::-webkit-scrollbar {
        width: 8px;
      }
      ::-webkit-scrollbar-track {
        background: transparent;
      }
      ::-webkit-scrollbar-thumb {
        background-color: #4b5563; /* gray-700 */
        border-radius: 10px;
        border: 2px solid transparent;
        background-clip: content-box;
      }
    </style>
  </head>
  <body class="bg-slate-50 min-h-screen flex">
    
  <?= view('components/sidebar'); ?>


    <!-- Main content -->
    <main class="flex-1 p-8">
      <h1 class="text-2xl font-semibold mb-6 mt-8">Help Center</h1>
      <section
        class="bg-white rounded-xl p-8 border border-transparent shadow-sm mx-auto"
      >
        <div class="text-center mb-6">
          <h2 class="text-base font-normal mb-4">Butuh Bantuan ??</h2>
          <img
            alt="Cartoon style illustration of two hands shaking, one light skin tone and one dark skin tone, symbolizing help and support"
            class="mx-auto mb-4"
            src="https://storage.googleapis.com/a1aa/image/082da266-1c45-41a5-be7e-96fc9883b0ff.jpg"
            width="190"
          />
          <p class="text-sm font-semibold text-[#0a3749]">
            Dengan senang hati,
            <a class="text-[#3b7bbf] hover:underline" href="#">
              kami akan membantu
            </a>
          </p>
          <p class="text-s text-[#0a3749]">
            Hubungi customer support kami lewat berbagai channel di bawah
          </p>
        </div>
        <div
          class="flex justify-center space-x-20 border-t border-gray-200 pt-6 text-center"
        >
          <div>
    <p class="text-s font-semibold mb-1">Instagram</p>
    <!-- Link ke Instagram -->
    <a href="https://www.instagram.com/focusacademy.co.id" target="_blank">
        <img
            alt="Instagram logo with gradient colors in PNG format"
            class="mx-auto"
            height="40"
            src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e7/Instagram_logo_2016.svg/1200px-Instagram_logo_2016.svg.png"
            width="40"
        />
    </a>
</div>
<div>
    <p class="text-s font-semibold mb-1">Gmail</p>
    <!-- Link ke Gmail -->
    <a href="mailto:csfocusacademy@gmail.com">
        <img
            alt="Email logo with red and white envelope in PNG format"
            class="mx-auto"
            height="40"
            src="https://upload.wikimedia.org/wikipedia/commons/4/4e/Gmail_Icon.png"
            width="40"
        />
    </a>
</div>

        </div>
      </section>
    </main>
  </body>
</html>
