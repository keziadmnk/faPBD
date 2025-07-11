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

     <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <h2 class="text-slate-900 text-xl font-semibold mb-6">Pilih Institusi</h2>
        <div class="flex flex-wrap gap-6">
            <?php foreach ($kategori as $kat): ?>
                <div class="bg-white rounded-md shadow-sm w-60 p-5 flex flex-col justify-between">
                    <h3 class="text-slate-900 font-semibold text-lg mb-5"><?= $kat['nama_kategori'] ?></h3>
                    <button
                        class="bg-[#3a9ad9] text-white text-sm rounded-full py-2 w-full"
                        type="button"
                        onclick="window.location.href='/dashboard/user/kategori/<?= $kat['id_kategori'] ?>';"
                    >
                        Pilih
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>