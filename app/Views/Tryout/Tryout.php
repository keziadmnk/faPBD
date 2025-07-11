<!-- app/Views/Tryout.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Focus Academy - Aplikasi Tryout Kedinasan No.1 di Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
</head>
<body class="bg-slate-50 min-h-screen flex">
    <?= view('components/sidebar'); ?>

   <main class="flex-1 p-8 overflow-x-auto">
    <!-- Menampilkan pesan success atau error -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-500 text-white p-4 rounded-md mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded-md mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    
    <!-- Filters -->
    <div class="flex space-x-3 mb-6">
        <a href="/dashboard/user/kategori/0" class="text-md rounded-full px-4 py-1 <?= (
            $kategoriId == 0) ? 'bg-[#3b9ad9] text-white' : 'bg-white text-[#3b9ad9]' ?>">
            All
        </a>
        <?php foreach ($kategori as $kat): ?>
            <a href="/dashboard/user/kategori/<?= $kat['id_kategori'] ?>" class="text-md rounded-full px-4 py-1 <?= (
                $kategoriId == $kat['id_kategori']) ? 'bg-[#3b9ad9] text-white' : 'bg-white text-[#3b9ad9]' ?>">
                <?= $kat['nama_kategori'] ?>
            </a>
        <?php endforeach; ?>
    </div>

    <h2 class="text-[#0f3c4b] font-semibold text-xl mb-6">Tryout Terbaru</h2>

    <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($tryout as $item): ?>
            <article class="bg-white rounded-xl p-6 flex flex-col items-center text-center space-y-3">
                <!-- Menampilkan logo berdasarkan kategori -->
                <?php
                    $kategoriModel = new \App\Models\KategoriModel();
                    $kategori = $kategoriModel->find($item['id_kategori']);
                    $logo = $kategori['logo']; // Mengambil logo dari kategori yang sesuai
                ?>
                <img alt="Logo" class="mx-auto" height="40" src="<?= base_url($logo) ?>" width="60" />
                <h3 class="text-[#0f3c4b] font-semibold text-md"><?= $item['nama_tryout'] ?></h3>
                <p class="text-xs text-gray-700">
                    SKD <br />
                    <?= $item['tanggal_mulai'] ?>
                </p>
                <p class="text-orange-500 font-semibold text-base">Rp <?= number_format($item['harga'], 2) ?></p>

                <?php 
                    // Cek jika tryout sudah dibeli oleh pengguna
                    $id_pengguna = session()->get('pengguna')['id_pengguna'];
                    $tryoutPurchaseModel = new \App\Models\TryoutPurchaseModel();
                    $purchased = $tryoutPurchaseModel->getStatusTryout($id_pengguna, $item['id_tryout']);
                ?>

                <?php if ($purchased): ?>
                    <p class="text-xs text-[#3b9ad9] font-semibold">Tryout telah terbeli</p>
                <?php else: ?>
                    <form action="/dashboard/buy_tryout/<?= $item['id_tryout'] ?>" method="POST">
                        <?= csrf_field() ?>
                        <button type="submit" class="bg-[#3b9ad9] text-white text-xs font-semibold rounded-full px-8 py-2 w-full">
                            Beli Tryout
                        </button>
                    </form>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </section>
</main>

</body>
</html>
