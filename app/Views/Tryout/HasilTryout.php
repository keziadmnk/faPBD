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
    <main class="flex-1 p-6 pt-16 overflow-y-auto">
  <h1 class="text-xl font-semibold mb-4">Hasil Tryout</h1>
  <section class="bg-white rounded-xl p-8 mb-6 mx-auto">
    <div class="text-center mb-6">
      <p class="mb-4"><?= $overallStatus === 'Lulus' ? 'Selamat !!' : 'Maaf !!' ?></p>
      <img
        alt="Golden trophy with green leaves on each side"
        class="mx-auto mb-6"
        height="100"
        src="https://storage.googleapis.com/a1aa/image/69ee406a-9fb2-44f0-6b1c-2c4743e33682.jpg"
        width="200"
      />
      <p class="text-[#004050] font-semibold text-lg mb-1">
        Kamu dinyatakan
        <span class="<?= $overallStatus === 'Lulus' ? 'text-[#7ac74a]' : 'text-red-500' ?>"> 
          <?= strtoupper($overallStatus) ?> 
        </span>
      </p>
      <p class="text-[#004050] text-sm mb-1">
        <?php if ($overallStatus === 'Lulus'): ?>
          Semua subject yang kamu kerjakan melewati passing grade
        <?php else: ?>
          Ada beberapa subject yang belum memenuhi passing grade
        <?php endif; ?>
      </p>
      <p class="text-[#004050] text-xs font-semibold">
        Jika kamu rasa ada yang salah, segera hubungi mimin yaa
      </p>
    </div>
    <hr class="border-t border-gray-300 mb-6" />
    <div class="text-center text-[#004050]">
      <p class="text-xs mb-1">Nama Tryout : <?= $tryout['nama_tryout'] ?></p>
      <p class="text-2xl font-semibold">Total Score : <?= $totalScore ?></p>
    </div>
    <hr class="border-t border-gray-300 mt-4" />
  </section>

  <!-- Table card -->
  <section class="bg-white rounded-xl p-6 md:p-10 mx-auto shadow-sm">
    <table class="w-full text-[#00303f] text-sm md:text-base">
      <thead>
        <tr class="border-b border-gray-300">
          <th class="text-left py-3 px-2 md:px-4 font-normal">Id</th>
          <th class="text-left py-3 px-2 md:px-4 font-normal">Name</th>
          <th class="text-left py-3 px-2 md:px-4 font-normal">Question</th>
          <th class="text-left py-3 px-2 md:px-4 font-normal">Score</th>
          <th class="text-left py-3 px-2 md:px-4 font-normal">Passing grade</th>
          <th class="text-left py-3 px-2 md:px-4 font-normal">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($subjectResults as $index => $result): ?>
        <tr class="<?= $index % 2 === 0 ? 'bg-gray-100' : '' ?>">
          <td class="py-3 px-2 md:px-4"><?= $result['id_subject'] ?></td>
          <td class="py-3 px-2 md:px-4"><?= $result['subject_name'] ?></td>
          <td class="py-3 px-2 md:px-4"><?= $result['total_soal'] ?></td>
          <td class="py-3 px-2 md:px-4"><?= $result['score'] ?></td>
          <td class="py-3 px-2 md:px-4"><?= $result['passing_grade'] ?></td>
          <td class="py-3 px-2 md:px-4">
            <button
              class="bg-[#3b9ad9] text-white text-xs md:text-sm rounded px-3 py-1 hover:bg-[#2a7ac7] transition"
              type="button"
              onclick="window.location.href='/dashboard/review/<?= $tryout['id_tryout'] ?>/<?= $result['id_subject'] ?>';"
            >
              Lihat Penjelasan
            </button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="flex justify-center mt-8">
      <button
        class="bg-[#3b9ad9] text-white rounded-full px-10 py-2 text-sm md:text-base hover:bg-[#2a7ac7] transition"
        type="button"
        onclick="window.location.href='/dashboard/user/raport';"
      >
        Lihat ranking
      </button>
    </div>
  </section>
</main>
  </body>
</html>
