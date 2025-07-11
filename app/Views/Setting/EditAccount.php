<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Edit Account - Focus Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
      ::-webkit-scrollbar { width: 8px; }
      ::-webkit-scrollbar-track { background: transparent; }
      ::-webkit-scrollbar-thumb { background-color: #4b5563; border-radius: 10px; border: 2px solid transparent; background-clip: content-box; }
    </style>
  </head>
  <body class="bg-slate-50 min-h-screen flex">
    <?= view('components/sidebar', ['pengguna' => $pengguna]) ?>
    <main class="flex-1 p-8">
      <h1 class="text-2xl font-semibold mb-6 mt-8 text-gray-900">Edit Account</h1>
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
      <form class="bg-white rounded-xl p-10 max-w-lg mx-auto flex flex-col gap-6 shadow" action="/dashboard/account/edit" method="post">
        <?= csrf_field() ?>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1" for="nama">Nama Lengkap</label>
          <input class="w-full rounded-lg border px-4 py-2 text-sm" type="text" id="nama" name="nama" value="<?= htmlspecialchars($pengguna['nama'] ?? '') ?>" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1" for="tanggal_lahir">Tanggal Lahir</label>
          <input class="w-full rounded-lg border px-4 py-2 text-sm" type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?= htmlspecialchars($pengguna['tanggal_lahir'] ?? '') ?>" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1" for="provinsi">Provinsi</label>
          <input class="w-full rounded-lg border px-4 py-2 text-sm" type="text" id="provinsi" name="provinsi" value="<?= htmlspecialchars($pengguna['provinsi'] ?? '') ?>" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1" for="kabupaten">Kabupaten</label>
          <input class="w-full rounded-lg border px-4 py-2 text-sm" type="text" id="kabupaten" name="kabupaten" value="<?= htmlspecialchars($pengguna['kabupaten'] ?? '') ?>" />
        </div>
        <div class="flex gap-4 mt-6">
          <button type="submit" class="bg-[#3b9ad9] text-white px-6 py-2 rounded hover:bg-[#2e7cc1] transition">Simpan</button>
          <a href="/dashboard/account" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400 transition">Batal</a>
        </div>
      </form>
    </main>
  </body>
</html> 