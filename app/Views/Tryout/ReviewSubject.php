<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <title>Review Hasil Tryout - <?= htmlspecialchars($subject['nama_subject']) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <style>
    .option-true { background: #e6f9ed; border: 1px solid #4ade80; }
    .option-false { background: #ffeaea; border: 1px solid #f87171; }
    .option-point { background: #e0f2fe; border: 1px solid #38bdf8; }
    .option-default { background: #f3f4f6; border: 1px solid #e5e7eb; }
  </style>
</head>
<body class="bg-[#f7f9fc] min-h-screen flex">
  <?= view('components/sidebar', ['pengguna' => $pengguna]) ?>
  <main class="flex-1 p-8 pt-12 overflow-auto">
    <div class="flex items-center mb-6">
      <a href="/dashboard/user/tryout/<?= $tryout['id_tryout'] ?>/results" class="mr-4 text-[#3b9ad9] hover:text-[#2563eb] text-2xl" title="Kembali ke hasil tryout">
        <i class="fas fa-arrow-left"></i>
      </a>
      <h1 class="text-2xl font-semibold">Review Hasil Tryout <?= htmlspecialchars($subject['nama_subject']) ?> - <?= htmlspecialchars($tryout['nama_tryout']) ?></h1>
    </div>
    <section class="bg-white rounded-xl p-8 mx-auto shadow-sm max-w-5xl">
      <?php foreach ($questions as $idx => $q): ?>
        <div class="mb-10">
          <div class="flex items-center gap-3 mb-2">
            <div class="bg-[#059669] text-white font-bold rounded-md w-7 h-7 flex items-center justify-center"><?= $q['no_soal'] ?></div>
            <div class="font-semibold text-gray-900">Soal:</div>
          </div>
          <div class="mb-3 text-gray-800 text-base font-medium">
            <?= nl2br(htmlspecialchars($q['teks_soal'])) ?>
          </div>
          <ul class="mb-3">
            <?php foreach ($q['options'] as $opt):
              $isUser = $q['user_answer'] == $opt['id_option'];
              $isCorrect = $q['correct_option'] == $opt['id_option'];
              $isPoint5 = $opt['point'] == 5;
              $optionClass = 'option-default';
              if ($isUser && $isCorrect) $optionClass = 'option-true';
              elseif ($isUser && !$isCorrect) $optionClass = 'option-false';
              elseif ($isPoint5) $optionClass = 'option-true';
            ?>
              <li class="flex items-center gap-3 rounded px-4 py-2 mb-2 <?= $optionClass ?>">
                <div class="font-bold text-base" style="width: 24px; text-align:center;">
                  <?= chr(96 + $opt['id_option']) ?>
                </div>
                <div class="flex-1 text-gray-800">
                  <?= htmlspecialchars($opt['teks_option']) ?>
                </div>
                <div class="text-xs font-semibold <?= $opt['point'] == 5 ? 'text-green-600' : 'text-gray-500' ?>">
                  +<?= $opt['point'] ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
          <div class="text-sm mt-2 mb-1">
            <span class="font-semibold">Jawaban benar:</span>
            <span class="font-bold text-green-700">
              <?= chr(96 + $q['correct_option']) ?>
            </span>
          </div>
          <div class="text-sm mb-1">
            <span class="font-semibold">Jawaban kamu:</span>
            <span class="font-bold <?= $q['user_answer'] == $q['correct_option'] ? 'text-green-700' : 'text-red-600' ?>">
              <?= $q['user_answer'] ? chr(96 + $q['user_answer']) : '-' ?>
            </span>
          </div>
          <div class="text-sm mb-2">
            <span class="font-semibold">Penjelasan:</span>
            <div class="bg-gray-50 border border-gray-200 rounded p-3 mt-1 text-gray-700">
              <?= nl2br(htmlspecialchars($q['penjelasan'])) ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </section>
  </main>
</body>
</html> 