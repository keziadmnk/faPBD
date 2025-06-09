<!-- app/Views/Tryout/Attention.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <title>Institusi Selection</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <style>
    /* Scrollbar styling for sidebar */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb {
      background-color: #4b5563;
      border-radius: 10px;
      border: 2px solid transparent;
      background-clip: content-box;
    }
    /* Sidebar */
aside {
    position: sticky;
    top: 0; /* Membuat sidebar tetap berada di atas saat di-scroll */
    height: 100vh; /* Pastikan sidebar sepanjang viewport */
    overflow-y: auto; /* Scrollable jika konten di sidebar lebih panjang dari viewport */
}
  </style>
</head>
<body class="bg-slate-50 min-h-screen flex">
  <!-- Sidebar -->
  <?= view('components/sidebar', ['pengguna' => $pengguna]) ?>

  <!-- Main content -->
  <main class="flex-1 p-8 overflow-y-auto mt-10">
    <h2 class="text-2xl font-semibold mb-6">Attention !!</h2>
    <section class="bg-white rounded-xl p-8 mx-auto flex flex-col items-center text-center">
      <p class="text-xl font-semibold mb-6">Harap perhatikan instruksi dibawah sebelum memulai test !!</p>
      <img alt="Warning icon" class="mb-6" loading="lazy" src="https://storage.googleapis.com/a1aa/image/52347e7b-6a49-413e-02e7-dd840a1c83a4.jpg" width="160" />
      <div class="text-[13px] text-[#0a3a4a] mb-6 max-w-[480px]">
        <p class="font-semibold mb-1">Harap dibaca sebelum mengerjakan !!</p>
        <p class="mb-0.5">- Pastikan kamu punya waktu yang cukup yaa</p>
        <p class="mb-0.5">- Pastikan koneksi internet stabil</p>
        <p class="mb-0.5">- Sangat direkomendasikan menggunakan Google Chrome</p>
        <p class="mb-0.5">- Jika terjadi kendala, segera screenshot dan laporkan ke kami</p>
        <p class="font-semibold mt-3">Jangan Lupa Berdoa !!</p>
      </div>
      <hr class="border-t border-gray-300 w-full mb-6" />
      <div class="text-[13px] text-[#0a3a4a] max-w-[480px]">
        <p class="font-semibold mb-1">Nama Tryout : <?= $tryout['nama_tryout'] ?></p>
        <p class="mb-0.5">Jenis tryout: </p>
        <p class="mb-0.5">Total Subject : 3</p>
        <p class="mb-0.5">Durasi : 100 Menit</p>
      </div>
      <hr class="border-t border-gray-300 w-full mt-6" />
    </section>

    <section class="bg-white rounded-xl p-6 max-w-7xl mx-auto space-y-6 text-gray-900 mt-8 mb-8">
      <table class="w-full text-sm border-collapse">
        <thead>
          <tr class="border-b border-gray-300">
            <th class="text-left py-3 px-4">Subject</th>
            <th class="text-center py-3 px-4">Total Pertanyaan</th>
            <th class="text-center py-3 px-4">Passing Grade</th>
          </tr>
        </thead>
        <tbody>
          <!-- Repeat this row for each subject in tryout -->
          <tr class="bg-gray-100">
            <td class="py-3 px-4">TWK</td>
            <td class="text-center py-3 px-4">30</td>
            <td class="text-center py-3 px-4">65</td>
          </tr>
          <tr>
            <td class="py-3 px-4">TIU</td>
            <td class="text-center py-3 px-4">35</td>
            <td class="text-center py-3 px-4">80</td>
          </tr>
          <tr class="bg-gray-100">
            <td class="py-3 px-4">TKP</td>
            <td class="text-center py-3 px-4">45</td>
            <td class="text-center py-3 px-4">156</td>
          </tr>
        </tbody>
      </table>
      <div class="flex flex-col items-center gap-4">
        <button class="bg-[#3498cb] text-white px-4 py-2 rounded text-sm w-24 hover:bg-[#2a7bbf] transition" onclick="location.href='/dashboard/start_tryout/<?= $tryout['id_tryout'] ?>'">
          Kerjakan
        </button>
      </div>
    </section>
  </main>
</body>
</html>
