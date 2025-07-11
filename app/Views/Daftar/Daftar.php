<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Focus Academy Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins&amp;display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: "Poppins", sans-serif;
      }
    </style>
  </head>
  <body class="bg-[#39A2DB] min-h-screen flex flex-col">
    
     <!-- Memanggil Footer dari Folder Components -->
    <?= view('components/navbar'); ?>

    <main class="flex flex-1 pl-36 px-6 py-12 mb-12">
      <section
        aria-label="Login form section"
        class="bg-white rounded-xl max-w-lg w-full px-16 shadow-lg"
      >
        <!-- app/Views/Login/Login.php -->
<form aria-label="Register form" class="space-y-6 mt-16 mb-16 " action="/daftar/submit" method="post">
    <h3 class="text-center text-[#0a3c40] font-semibold text-sm">Daftar Menggunakan Email</h3>
    <div>
        <label class="block mb-1 text-sm text-[#4a4a4a] font-normal" for="email">Masukan Email</label>
        <input
            class="w-full rounded-lg bg-[#eaf2fa] px-4 py-2 text-sm text-[#0a3c40] font-normal placeholder:text-[#0a3c40] focus:outline-none"
            id="email" type="email" name="email" required />
    </div>
    <div>
        <label class="block mb-1 text-sm text-[#4a4a4a] font-normal" for="password">Masukan Password</label>
        <div class="relative">
            <input
                class="w-full rounded-lg bg-[#eaf2fa] px-4 py-2 text-xs text-[#0a3c40] font-normal placeholder:text-[#0a3c40] focus:outline-none"
                id="password" type="password" name="password" required />
            <span id="togglePassword" aria-label="Show password icon" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#0a3c40] cursor-pointer">
                <i class="fas fa-eye"></i>
            </span>
        </div>
    </div>
    <div>
        <label class="block mb-1 text-sm text-[#4a4a4a] font-normal" for="confirm_password">Konfirmasi Passwordmu</label>
        <div class="relative">
            <input
                class="w-full rounded-lg bg-[#eaf2fa] px-4 py-2 text-xs text-[#0a3c40] font-normal placeholder:text-[#0a3c40] focus:outline-none"
                id="confirm_password" type="password" name="confirm_password" required />
            <span id="toggleConfirmPassword" aria-label="Show password icon" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#0a3c40] cursor-pointer">
                <i class="fas fa-eye"></i>
            </span>
        </div>
    </div>
    <button
        class="w-full bg-[#3a9ad9] text-white text-sm font-normal py-3 rounded-full hover:bg-[#2e7cc1] transition-colors block text-center"
        type="submit">
        Register
    </button>
</form>

    <p class="my-12 text-center text-sm text-[#4a4a4a]">
        Sudah punya akun? <br> 
        <span>Masuk </span><a class="font-semibold underline" href="/login">Disini</a>
      </section>


      <section
        aria-label="Focus academy branding and login encouragement"
        class="ml-16 max-w-lg text-white flex flex-col justify-center"
      >
        <p class="text-7xl mb-20 font-semibold">focus 
          <br>
           <span class="text-4xl font-semibold">academy</span> 
          </p>
        <h2 class="text-2xl font-extrabold mb-2">Daftar Yuk !</h2>
        <p class="font-bold text-sm max-w-xs">
          Mulai perjalanan mu menjadi ASN dari sini !
        </p>
      </section>
    </main>

    <script>
        // Password visibility toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');

            // Toggle password visibility
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                // Toggle eye icon
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });

            // Toggle confirm password visibility
            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPassword.setAttribute('type', type);
                
                // Toggle eye icon
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    </script>
  </body>

   <!-- Memanggil Footer dari Folder Components -->
    <?= view('components/footer'); ?>
</html>
