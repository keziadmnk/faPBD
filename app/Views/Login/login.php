<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Focus Academy Login</title>
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
  <body class="bg-[#39A2DB]  min-h-screen  flex flex-col">
    
   <!-- Memanggil Navbar dari Folder Components -->
    <?= view('components/navbar'); ?>

    <!-- Main content -->
    <main class="flex flex-1 pl-36 px-6 py-12 mb-12">
      <section
        aria-label="Login form section"
        class="bg-white rounded-xl max-w-lg w-full px-16 shadow-lg"
      >
        <!-- app/Views/Login/Login.php -->
<form aria-label="Login form" class="space-y-6 mt-16 mb-16 " action="/login/submit" method="post">
    <h3 class="text-center text-[#0a3c40] font-semibold text-sm">Login Menggunakan Email</h3>
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
            <span aria-label="Show password icon" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#0a3c40] cursor-pointer">
                <i class="fas fa-eye"> </i>
            </span>
        </div>
    </div>
    <!-- Menampilkan pesan sukses jika ada -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>
    <!-- Menampilkan error jika ada -->
    <?php if (session()->getFlashdata('error')): ?>
        <div style="color: red;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <button
        class="w-full bg-[#3a9ad9] text-white text-sm font-normal py-3 rounded-full hover:bg-[#2e7cc1] transition-colors block text-center"
        type="submit">
        Login
    </button>
</form>
    <p class="my-12 text-center text-sm text-[#4a4a4a]">
        Belum punya akun? <br> 
        <span>Ayo </span><a class="font-semibold underline" href="/daftar">Daftar Sekarang</a>
      </section>
      
      <section
        aria-label="Focus academy branding and login encouragement"
        class="ml-16 text-white flex flex-col justify-center"
      >
        <p class="text-8xl font-semibold">focus</p>
        <p class="text-5xl" >academy</p>
        <h2 class="text-3xl font-extrabold mb-2 mt-20">Login Yuk !</h2>
        <p class="font-bold text-sm max-w-xs">
          Biar lebih gampang akses fitur kita yaa !!
        </p>
      </section>
    </main>
  </body>
    
  <!-- Memanggil Footer dari Folder Components -->
    <?= view('components/footer'); ?>
 
</html>
