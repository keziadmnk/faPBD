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
   <main class="flex-1 p-6 pt-16 overflow-y-auto">
      <div class="max-w-6xl mx-auto space-y-6">
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
        <div
          class="flex items-center gap-2 text-2xl font-semibold text-gray-900 mb-4"
        >
          <i class="fas fa-arrow-left"> </i>
          <span> Top Up </span>
        </div>
        <section
          aria-label="Current balance and redeem voucher"
          class="bg-white rounded-xl p-6 shadow-sm max-w-full"
        >
          <a
            class="text-[#3b9bdc] text-sm mb-6 font-semibold hover:underline inline-block cursor-pointer"
            href="#"
            onclick="openVoucherModal(event)"
          >
            Redeem voucher
          </a>
          <p class="font-semibold text-gray-900 text-xl mt-2">
            Saldo Sekarang
          </p>
          <p class="text-[#3b9bdc] font-semibold text-lg">Rp <?= isset(
            $pengguna['saldo']) ? number_format($pengguna['saldo'], 0, ',', '.') : '0' ?></p>
        </section>
        <section
          aria-label="Top up options"
          class="bg-white rounded-xl p-6 space-y-4 shadow-sm max-w-full"
        >
          <p class="font-semibold text-gray-900 text-xl">
            Pilih Nominal Top up
          </p>
          <div class="flex flex-wrap gap-4" id="topup-nominal-group">
            <button
              class="border border-[#3b9bdc] font-semibold text-gray-900 rounded-lg px-16 py-2 min-w-[140px] text-center"
              type="button"
              data-nominal="10000"
              onclick="selectNominal(this)"
            >
              Rp 10.000
            </button>
            <button
              class="border border-[#3b9bdc] font-semibold text-gray-900 rounded-lg px-16 py-2 min-w-[140px] text-center"
              type="button"
              data-nominal="30000"
              onclick="selectNominal(this)"
            >
              Rp 30.000
            </button>
            <button
              class="border border-[#3b9bdc] font-semibold text-gray-900 rounded-lg px-16 py-2 min-w-[140px] text-center"
              type="button"
              data-nominal="50000"
              onclick="selectNominal(this)"
            >
              Rp 50.000
            </button>
            <button
              class="border border-[#3b9bdc] font-semibold text-gray-900 rounded-lg px-16 py-2 min-w-[140px] text-center"
              type="button"
              data-nominal="100000"
              onclick="selectNominal(this)"
            >
              Rp 100.000
            </button>
          </div>
          <script>
            function selectNominal(btn) {
              const buttons = document.querySelectorAll('#topup-nominal-group button');
              buttons.forEach(b => {
                b.classList.remove('bg-[#3b9bdc]', 'text-white');
                b.classList.add('border', 'border-[#3b9bdc]', 'text-gray-900');
              });
              btn.classList.remove('border', 'border-[#3b9bdc]', 'text-gray-900');
              btn.classList.add('bg-[#3b9bdc]', 'text-white');
            }

            function openVoucherModal(e) {
              e.preventDefault();
              document.getElementById('voucher-modal-overlay').style.display = 'flex';
            }
            function closeVoucherModal() {
              document.getElementById('voucher-modal-overlay').style.display = 'none';
            }
          </script>

          <!-- Modal Voucher -->
          <div id="voucher-modal-overlay" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-auto relative">
              <div class="flex items-center justify-between border-b px-6 py-4">
                <span class="font-semibold text-lg">Redeem voucher disini</span>
                <button onclick="closeVoucherModal()" class="text-gray-400 hover:text-gray-700 text-2xl font-bold focus:outline-none">&times;</button>
              </div>
              <form class="px-6 pt-4 pb-6" action="/topup/redeem_voucher" method="post">
                <?= csrf_field() ?>
                <label class="block text-gray-700 text-sm mb-2" for="voucher-code">Kode voucher</label>
                <input id="voucher-code" name="kode_voucher" type="text" placeholder="Masukan kode voucher yang kamu miliki" class="w-full mb-6 px-4 py-3 rounded-lg bg-[#eaf2f5] text-gray-700 placeholder-gray-400 focus:outline-none" />
                <div class="flex justify-end gap-2">
                  <button type="button" onclick="closeVoucherModal()" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-full font-semibold hover:bg-gray-200">Cancel</button>
                  <button type="submit" class="bg-[#7cc3ea] text-white px-6 py-2 rounded-full font-semibold hover:bg-[#5bb0e6]">Yes</button>
                </div>
              </form>
            </div>
          </div>
          <div>
            <label
              class="font-normal text-gray-900 text-base inline-block mb-1"
              for="manual-input"
            >
              Atau Input Manual
              <span class="text-xs font-normal text-gray-500 ml-2">
                (Minimal 10k)
              </span>
            </label>
            <input
              class="w-full rounded-lg bg-[#e6ebed] px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#3b9bdc]"
              id="manual-input"
              type="text"
              value=""
            />
          </div>
        </section>
        <section
          aria-label="Contact admin for topup"
          class="bg-white rounded-xl p-6 space-y-3 shadow-sm max-w-full"
        >
          <p class="font-normal text-gray-900 text-base">
            Hubungi Admin untuk Topup
          </p>
          <p class="text-xs text-gray-600 leading-tight max-w-4xl">
            Saat ini, kami tidak melayani topup saldo, silahkan check instagram
            official secara berkala
          </p>

          <button
              class="bg-[#a1c8e2] text-white font-semibold rounded-full px-16 py-2 min-w-[140px] text-center"
              type="button"
            >
              Hubungi Admin
            </button>
        </section>
      </div>
    </main>
  </body>
</html>
