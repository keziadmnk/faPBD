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
    
  <?= view('components/sidebar', ['pengguna' => $pengguna]) ?>

    <!-- Main content -->
    <main class="flex-1 p-8">
      <h1 class="text-2xl font-semibold mb-6 mt-8 text-gray-900">
        Account Settings
      </h1>

      <!-- Tabs -->
      <div
        class="bg-white rounded-xl flex gap-6 text-gray-700 text-sm font-normal mb-6 px-6 py-3"
      >
        <a href="/19account.html">
          <button
            class="text-[#3b9adf] border-b-2 border-[#3b9adf] pb-1 font-normal"
          >
            Account
          </button>
        </a>
        <a href="/dashboard/security">
          <button class="hover:text-gray-900 transition">Security</button>
        </a>
      </div>

      <!-- Account info card -->
      <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
          <strong class="font-bold">Error!</strong>
          <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
        </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
          <strong class="font-bold">Sukses!</strong>
          <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
        </div>
      <?php endif; ?>
      <section
        class="bg-white rounded-xl p-10 flex flex-col items-center gap-4 text-center mx-auto"
      >
        <div
          class="bg-[#3498db] rounded-full w-20 h-20 flex items-center justify-center"
        >
          <i class="fas fa-user text-white text-4xl"> </i>
        </div>

        <a href="#" class="text-[#3b9adf] text-xs font-normal">Ubah Foto</a>

        <dl
          class="grid grid-cols-2 gap-x-6 gap-y-2 text-gray-900 text-sm max-w-md mx-auto"
        >
          <dt class="text-right font-normal">Nama Lengkap</dt>
          <dd class="font-semibold text-left"><?= $pengguna['nama'] ?? '-' ?></dd>

          <dt class="text-right font-normal">Tanggal Lahir</dt>
          <dd class="font-semibold text-left">
    <?php if (!empty($pengguna['tanggal_lahir']) && $pengguna['tanggal_lahir'] !== '0000-00-00'): ?>
        <?= date('l, d F Y', strtotime($pengguna['tanggal_lahir'])) ?>
    <?php else: ?>
        -
    <?php endif; ?>
</dd>

          <dt class="text-right font-normal">Provinsi</dt>
          <dd class="font-semibold text-left"><?= $pengguna['provinsi'] ?? '-' ?></dd>

          <dt class="text-right font-normal">Kabupaten</dt>
          <dd class="font-semibold text-left"><?= $pengguna['kabupaten'] ?? '-' ?></dd>

          <dt class="text-right font-normal">Join Sejak</dt>
          <dd class="font-semibold text-left">
    <?php if (!empty($pengguna['tanggal_daftar']) && $pengguna['tanggal_daftar'] !== '0000-00-00 00:00:00'): ?>
        <?= date('l, d F Y', strtotime($pengguna['tanggal_daftar'])) ?>
    <?php else: ?>
        -
    <?php endif; ?>
</dd>
        </dl>

        <a href="/dashboard/account/edit" class="text-[#3b9adf] text-s font-semibold mt-4">Edit Data</a>
      </section>
    </main>
  </body>
</html>
