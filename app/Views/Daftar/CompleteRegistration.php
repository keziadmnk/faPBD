<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Focus Academy - Lengkapi Identitas</title>
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
    
    <!-- Main content -->
    <main class="flex flex-1 pl-36 px-6 py-12 mb-12">
      <section
        aria-label="Complete registration form section"
        class="bg-white rounded-xl max-w-lg w-full px-16 shadow-lg"
      >
        <!-- Form -->
        <form aria-label="Complete registration form" class="space-y-6 mt-16 mb-16" action="/complete-registration" method="post">
            <h3 class="text-center text-[#0a3c40] font-semibold text-sm">Lengkapi Identitas Anda</h3>
            
            <div>
                <label class="block mb-1 text-sm text-[#4a4a4a] font-normal" for="nama">Nama Lengkap</label>
                <input
                    class="w-full rounded-lg bg-[#eaf2fa] px-4 py-2 text-sm text-[#0a3c40] font-normal placeholder:text-[#0a3c40] focus:outline-none"
                    id="nama" type="text" name="nama" required value="<?= esc($pengguna['nama']) ?>" />
            </div>
            
            <div>
                <label class="block mb-1 text-sm text-[#4a4a4a] font-normal" for="tanggal_lahir">Tanggal Lahir</label>
                <input
                    class="w-full rounded-lg bg-[#eaf2fa] px-4 py-2 text-sm text-[#0a3c40] font-normal placeholder:text-[#0a3c40] focus:outline-none"
                    id="tanggal_lahir" type="date" name="tanggal_lahir" required value="<?= esc($pengguna['tanggal_lahir']) ?>" />
            </div>
            
            <div>
                <label class="block mb-1 text-sm text-[#4a4a4a] font-normal" for="nomor_hp">Nomor HP</label>
                <input
                    class="w-full rounded-lg bg-[#eaf2fa] px-4 py-2 text-sm text-[#0a3c40] font-normal placeholder:text-[#0a3c40] focus:outline-none"
                    id="nomor_hp" type="text" name="nomor_hp" required value="<?= esc($pengguna['nomor_hp']) ?>" />
            </div>
            
            <div>
                <label class="block mb-1 text-sm text-[#4a4a4a] font-normal" for="provinsi">Provinsi</label>
                <input
                    class="w-full rounded-lg bg-[#eaf2fa] px-4 py-2 text-sm text-[#0a3c40] font-normal placeholder:text-[#0a3c40] focus:outline-none"
                    id="provinsi" type="text" name="provinsi" required value="<?= esc($pengguna['provinsi']) ?>" />
            </div>
            
            <div>
                <label class="block mb-1 text-sm text-[#4a4a4a] font-normal" for="kabupaten">Kabupaten/Kota</label>
                <input
                    class="w-full rounded-lg bg-[#eaf2fa] px-4 py-2 text-sm text-[#0a3c40] font-normal placeholder:text-[#0a3c40] focus:outline-none"
                    id="kabupaten" type="text" name="kabupaten" required value="<?= esc($pengguna['kabupaten']) ?>" />
            </div>
            
            <!-- Menampilkan error jika ada -->
            <?php if (session()->getFlashdata('error')): ?>
                <div style="color: red;">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <button
                class="w-full bg-[#3a9ad9] text-white text-sm font-normal py-3 rounded-full hover:bg-[#2e7cc1] transition-colors block text-center"
                type="submit">
                Simpan
            </button>
        </form>
      </section>
      
      <section
        aria-label="Focus academy branding and registration encouragement"
        class="ml-16 text-white flex flex-col justify-center"
      >
        <p class="text-8xl font-semibold">focus</p>
        <p class="text-5xl" >academy</p>
        <h2 class="text-3xl font-extrabold mb-2 mt-20">Lengkapi Profil !</h2>
        <p class="font-bold text-sm max-w-xs">
          Isi data diri Anda untuk melengkapi pendaftaran
        </p>
      </section>
    </main>
  </body>
</html> 