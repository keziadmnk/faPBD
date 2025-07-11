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
   <main class="flex-1 p-6 mt-8">
      <h1 class="text-2xl font-semibold mb-4">Voucher History</h1>

      <div
        class="bg-white rounded-xl p-3 pl-6 flex gap-6 text-sm text-gray-700 font-normal mb-4 select-none"
      >
        <a href="/dashboard/user/topuphistory">
          <button class="hover:text-[#3b94d9] focus:outline-none">
            Top Up
          </button>
        </a>

        <a href="/dashboard/user/voucherhistory">
          <button
            class="text-[#3b94d9] border-b-2 border-[#3b94d9] pb-1 focus:outline-none"
          >
            Voucher
          </button>
        </a>

        <a href="/dashboard/user/tryouthistory">
          <button class="hover:text-[#3b94d9] focus:outline-none">
            Tryout
          </button>
        </a>
      </div>

      <!-- Table container -->
      <section class="bg-white rounded-xl overflow-hidden text-[#1a1a1a] pt-10">
        <table class="w-full text-left text-sm">
          <thead>
            <tr class="border-b border-[#e5e7eb]">
              <th class="py-4 px-6 font-semibold">Code</th>
              <th class="py-4 px-6 font-semibold">Nominal</th>
              <th class="py-4 px-6 font-semibold">Date</th>
              <th class="py-4 px-6 font-semibold">Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php if (empty($histori)): ?>
            <tr class="bg-[#f3f3f3] text-center">
              <td colspan="4" class="py-4">Belum ada voucher yang diredeem</td>
            </tr>
          <?php else: ?>
            <?php foreach ($histori as $v): ?>
            <tr class="bg-[#f3f3f3]">
              <td class="py-4 px-6"><?= htmlspecialchars($v['kode_voucher']) ?></td>
              <td class="py-4 px-6">Rp <?= number_format($v['nominal'], 0, ',', '.') ?></td>
              <td class="py-4 px-6"><?= htmlspecialchars($v['tanggal_digunakan']) ?></td>
              <td class="py-4 px-6">
                <a href="/dashboard/user/voucherhistory/detail/<?= urlencode($v['kode_voucher']) ?>" class="text-[#3b9ad9] hover:underline">Lihat detail</a>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
      </section>
    </main>
  </body>
</html>
