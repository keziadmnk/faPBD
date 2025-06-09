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
      <h1 class="text-2xl font-semibold mb-6 mt-8 text-gray-900">
        Account Settings
      </h1>

      <!-- Tabs -->
      <div
        class="bg-white rounded-xl flex gap-6 text-gray-700 text-sm font-normal mb-6 px-6 py-3"
      >
        <a href="/dashboard/account">
          <button class="hover:text-gray-900 transition">Account</button>
        </a>

        <a href="/20security.html">
          <button
            class="text-[#3b9adf] border-b-2 border-[#3b9adf] pb-1 font-normal"
          >
            Security
          </button>
        </a>
      </div>

      <section
        aria-label="Email and phone settings"
        class="bg-white rounded-xl p-6 mb-8 max-w-4xl mx-auto shadow-sm"
      >
        <div class="text-center mb-4 font-semibold">Email And Phone</div>
        <div class="text-sm">
          <!-- Email Section -->
          <div class="mb-4 text-center">
            <div class="flex justify-center items-center gap-2">
              <span>Email</span>
              <span class="font-bold">keziadamanik20@gmail.com</span>
            </div>
          </div>

          <!-- Phone Number Section -->
          <div class="text-center">
            <div class="flex justify-center items-center gap-2">
              <span>Phone Number</span>
              <a class="text-[#3b9ad9] font-normal" href="#">Add Phone</a>
            </div>
          </div>
        </div>
      </section>

      <section
        aria-label="Password settings"
        class="bg-white rounded-xl p-6 max-w-4xl mx-auto shadow-sm"
      >
        <div class="text-center mb-4 font-semibold">Password</div>
        <div class="text-center">
          <a class="text-[#3b9ad9] font-normal" href="#"> Change Password </a>
        </div>
      </section>
    </main>
  </body>
</html>
