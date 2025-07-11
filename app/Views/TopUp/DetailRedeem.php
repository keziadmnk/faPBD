<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Focus Academy</title>
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
    <!-- Sidebar -->
    <?= view('components/sidebar', ['pengguna' => $pengguna]) ?>

    <main class="flex-1 p-6">
      <h1 class="text-xl font-semibold mb-6 mt-8">Redeem voucher success</h1>
      <section
        class="bg-white rounded-xl p-8 mx-auto flex flex-col items-center"
      >
        <h2 class="text-center font-semibold text-xl mb-1">
          Yeayyy !! Redeem voucher berhasil
        </h2>
        <p class="text-center text-xs mb-10">
          Saldomu sudah bertambah
          <span class="font-normal text-[#2a7a6f]">Rp <?= number_format($voucher['nominal'], 0, ',', '.') ?></span>
        </p>
        <img
          src="https://cdn-icons-png.flaticon.com/512/2583/2583341.png"
          alt="Green gift voucher with red bow and yellow coin with dollar sign icon"
          class="mb-10 w-[170px] object-contain"
        />
        <hr class="border-gray-300 w-full mb-6" />
        <div class="text-center text-s text-[#2a7a6f] mb-1">
          Voucher code #<?= htmlspecialchars($voucher['kode_voucher']) ?>
        </div>
        <div class="text-center text-xs text-gray-600 mb-1">
          Di redeem pada <?= date('d M Y - H:i', strtotime($voucher['tanggal_digunakan'])) ?> WIB
        </div>
        <div class="text-center text-[#3498cb] font-semibold text-lg mb-1">
          Rp <?= number_format($voucher['nominal'], 0, ',', '.') ?>
        </div>
        <div class="text-center text-[#2a7a6f] font-semibold text-xs mb-6">
          Success
        </div>
        <div class="text-center text-xs text-gray-600 mb-2">
          Saldo sekarang: <span class="font-bold text-[#3498cb]">Rp <?= number_format($pengguna['saldo'], 0, ',', '.') ?></span>
        </div>
        <hr class="border-gray-300 w-full mb-6" />
        <a href="/dashboard/user/voucherhistory">
          <button
            class="bg-[#3498cb] text-white rounded-full px-8 py-2 text-sm font-normal"
          >
            Lihat histori redeem
          </button>
        </a>
      </section>
    </main>
  </body>
</html>
