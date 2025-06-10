<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
      <title><?= $tryout['nama_tryout'] ?></title>
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

  <main class="flex-1 p-8 pt-16 overflow-y-auto">
    <p class="text-lg font-semibold mb-6 mt-12">Yeayyy Selesai !</p>
    <section class="bg-white rounded-xl p-8 max-w-100 mx-auto shadow-sm">
      <p class="text-center mb-4 text-base font-normal">
        Terimakasih telah menyelesaikan tryout!
      </p>
      <div class="flex justify- mb-6">
        <img alt="Two crossed checkered finish flags" class="mx-auto" height="100" src="https://storage.googleapis.com/a1aa/image/d3d8bee4-bacd-47ee-9269-16b692a478cc.jpg" width="100" />
      </div>
      <p class="text-center text-sm text-[#0a2e3f] font-semibold mb-1 max-w-[400px] mx-auto">
        Cek hasil tryout kamu di bawah ini:
      </p>
      <hr class="border-gray-200 mb-6" />
      <div class="text-center text-xs text-[#0a2e3f] max-w-[400px] mx-auto space-y-1">
        <p><strong> Nama Tryout: <?= $tryout['nama_tryout'] ?> </strong></p>
        <p>Durasi: 100 Menit</p>
      </div>
      <hr class="border-gray-200 mt-4" />
    </section>

    <!-- Subject Results -->
    <section class="bg-white rounded-xl p-6 max-w-7xl mx-auto space-y-6 text-gray-900">
      <h3 class="font-semibold text-lg">Hasil Tryout per Subject</h3>
      <table class="w-full text-sm border-collapse">
        <thead>
          <tr class="border-b border-gray-300">
            <th class="text-left py-3 px-4 w-[40%]">Subject</th>
            <th class="text-center py-3 px-4 w-[30%]">Jumlah Benar</th>
            <th class="text-center py-3 px-4 w-[30%]">Status Kelulusan</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($subjectResults as $result): ?>
            <tr class="bg-gray-100">
              <td class="py-3 px-4"><?= $result['subject_name'] ?></td>
              <td class="text-center py-3 px-4"><?= $result['jumlah_benar'] ?> / <?= $result['total_soal'] ?></td>
              <td class="text-center py-3 px-4"><?= $result['status_kelulusan_subject'] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="flex justify-center gap-4 mt-6">
        <button class="bg-green-600 text-white px-6 py-2 rounded text-sm hover:bg-green-700">Selesai</button>
        <button class="bg-[#3498cb] text-white px-6 py-2 rounded text-sm hover:bg-[#2a7bbf]" onclick="location.href='/dashboard/user/tryout/<?= $tryout['id_tryout'] ?>/results'">Lihat Nilai</button>
      </div>
    </section>
  </main>
</body>
</html>