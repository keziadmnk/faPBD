<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $tryout['nama_tryout'] ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-[#f8fafb] min-h-screen flex">
  <!-- Sidebar -->
  <?= view('components/sidebar', ['pengguna' => $pengguna]) ?>

  <!-- Main content -->
  <main class="flex-1 p-6 max-w-full overflow-x-hidden relative">
    <div class="max-w-6xl mx-auto">
      <header class="mb-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-900"><?= $tryout['nama_tryout'] ?></h1>
        <a href="#" id="lihat-semua-btn" class="text-sm font-semibold text-[#3b9ad9] hover:underline cursor-pointer">Lihat Semua</a>
      </header>

      <!-- Pagination with buttons for each question -->
      <div id="question-buttons" class="flex gap-1 mb-4 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 whitespace-nowrap">
        <?php foreach ($questions as $index => $question): ?>
          <button class="bg-white text-gray-900 w-8 h-8 rounded border border-gray-300 font-semibold inline-block px-1" onclick="selectQuestion(<?= $index ?>)">
            <?= $question['no_soal'] ?>
          </button>
        <?php endforeach; ?>
      </div>

      <!-- Timer and question count -->
      <section class="bg-white rounded-xl p-6 mb-6 flex justify-center items-center text-[#0f293f] font-semibold text-2xl relative">
        <div class="text-center w-full max-w-3xl">
          <span id="timer">1:39:56</span>
          <p class="text-sm font-normal mt-1">
            Soal Terjawab <span class="text-[#0f293f]" id="answered-count">0</span> / <span class="text-[#e74c3c]"><?= count($questions) ?></span>
          </p>
        </div>
      </section>

      <!-- Question Card -->
      <article id="question-card" class="bg-white rounded-xl p-6 text-gray-700 text-sm leading-relaxed">
        <header class="flex items-center gap-3 mb-3">
          <div id="question-number" class="bg-[#0f293f] text-white font-semibold rounded-md w-7 h-7 flex items-center justify-center"><?= $questions[0]['no_soal'] ?></div>
          <h2 id="question-subject" class="font-semibold text-gray-900"><?= $questions[0]['subject'] ?></h2>
        </header>
        <p id="question-text" class="mb-6"><?= $questions[0]['teks_soal'] ?></p>

        <hr class="border-gray-300 mb-6" />

        <ul id="options-list" class="flex flex-col gap-4 max-w-md">
          <?php foreach ($questions[0]['options'] as $option): ?>
            <li>
              <button class="flex items-center gap-4 w-full text-left">
                <div class="option-circle font-semibold rounded-md w-7 h-7 flex items-center justify-center">
                  <?= $option['opsi'] ?> <!-- Display option letter -->
                </div>
                <span><?= $option['teks_option'] ?></span> <!-- Display option text -->
              </button>
            </li>
          <?php endforeach; ?>
        </ul>
      </article>
    </div>
  </main>

  <script>
    let questions = <?= json_encode($questions) ?>;
    let selectedQuestionIndex = 0;
    let userAnswers = {};

    // Render Question berdasarkan index
    function renderQuestion(index) {
      const question = questions[index];  // Menggunakan index array untuk memilih soal
      document.getElementById('question-number').innerText = question.no_soal;
      document.getElementById('question-subject').innerText = question.subject;
      document.getElementById('question-text').innerText = question.teks_soal;

      let optionsList = document.getElementById('options-list');
      optionsList.innerHTML = "";

      // Render pilihan jawaban
      question.options.forEach((option, i) => {
        const li = document.createElement('li');
        const btn = document.createElement('button');
        btn.type = "button";
        btn.className = "flex items-center gap-4 w-full text-left";
        btn.onclick = () => selectAnswerAndNext(index, i);

        const circle = document.createElement('div');
        circle.className = "option-circle font-semibold rounded-md w-7 h-7 flex items-center justify-center";
        circle.textContent = ["A", "B", "C", "D", "E"][i];

        btn.appendChild(circle);
        const span = document.createElement('span');
        span.textContent = option.teks_option;
        btn.appendChild(span);
        li.appendChild(btn);
        optionsList.appendChild(li);
      });
    }

    // Fungsi untuk memilih soal
    function selectQuestion(index) {
      selectedQuestionIndex = index;
      renderQuestion(index);  // Render soal yang dipilih
      updateAnsweredCount();  // Perbarui jumlah soal yang dijawab
    }

    // Update jumlah soal yang sudah dijawab
    function updateAnsweredCount() {
      const count = Object.keys(userAnswers).length;
      document.getElementById('answered-count').textContent = count;
    }

    // Fungsi untuk menyimpan jawaban dan melanjutkan soal berikutnya
    function selectAnswerAndNext(questionIdx, optionIdx) {
      userAnswers[questionIdx] = optionIdx;
      renderQuestion(questionIdx);
      updateAnsweredCount();
      if (questionIdx + 1 < questions.length) {
        selectQuestion(questionIdx + 1);
      }
    }

    renderQuestion(questions[0].no_soal);  // Tampilkan soal pertama
  </script>
</body>
</html>
