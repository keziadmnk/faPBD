<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>Pembelian Tryout Berhasil</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter&amp;display=swap" rel="stylesheet"/>
</head>
<body class="bg-[#f5f8fa] min-h-screen flex">
  <?= view('components/sidebar', ['pengguna' => $pengguna]) ?>
   <main class="flex-1 p-8">
    <h1 class="text-base font-normal text-gray-900 mb-6">Pembelian tryout berhasil</h1>
    <section class="bg-white rounded-lg p-8 max-w-3xl mx-auto flex flex-col items-center">
     <p class="text-sm font-normal text-gray-900 mb-6 text-center">
      Yeayyy !! Kamu berhasil beli tryout
     </p>
     <img alt="Green rounded square with white check mark icon" class="mb-6" height="96" src="https://storage.googleapis.com/a1aa/image/345a151a-e25b-4041-1b4b-8b0a700ac388.jpg" width="96"/>
     <hr class="border-gray-200 w-full mb-6"/>
     <div class="text-center mb-6">
      <p class="text-xs font-semibold text-[#0a3d5d] mb-1">
       Nama Tryout :
       <span class="font-normal"><?= $tryout['nama_tryout'] ?></span>
      </p>
      <p class="text-xs font-normal text-gray-500 mb-1">
       Transaksi pada <?= $tanggal_transaksi ?>
      </p>
      <p class="text-sm font-semibold text-[#2a9fd6] mb-1">
       Rp <?= number_format($harga, 2) ?>
      </p>
      <p class="text-xs font-normal text-[#2a6a5a]">
       Success
      </p>
     </div>
     <hr class="border-gray-200 w-full mb-6"/>
     <a href="/dashboard/user/tryout">
      <button class="bg-[#2a9fd6] text-white text-xs font-normal rounded-full px-6 py-2 hover:bg-[#2384b8] transition">
       Lihat tryout
      </button>
     </a>
    </section>
   </main>
</body>
</html>
