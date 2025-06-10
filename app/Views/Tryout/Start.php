<!DOCTYPE html>
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
        <?php foreach ($questions as $question): ?>
          <button 
            id="btn-<?= $question['no_soal'] ?>" 
            class="question-btn bg-white text-gray-900 w-8 h-8 rounded border border-gray-300 font-semibold inline-block px-1 hover:bg-gray-50" 
            onclick="selectQuestion(<?= $question['no_soal'] ?>)"
          >
            <?= $question['no_soal'] ?>
          </button>
        <?php endforeach; ?>
      </div>

      <!-- Timer and question count -->
      <section class="bg-white rounded-xl p-6 mb-6 flex justify-center items-center text-[#0f293f] font-semibold text-2xl relative">
        <div class="text-center w-full max-w-3xl">
          <span id="timer">1:40:00</span>
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
          <!-- Options will be populated by JavaScript -->
        </ul>

        <!-- Navigation and Finish Button -->
        <div class="flex justify-between items-center mt-8">
          <button id="prev-btn" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed" onclick="navigateQuestion('prev')" disabled>
            <i class="fas fa-chevron-left mr-2"></i>Sebelumnya
          </button>
          
          <div class="flex gap-2">
            <button id="next-btn" class="bg-[#3b9ad9] text-white px-4 py-2 rounded-md hover:bg-[#2a7ba7]" onclick="navigateQuestion('next')">
              Selanjutnya<i class="fas fa-chevron-right ml-2"></i>
            </button>
            
            <button id="finish-btn" class="bg-[#e74c3c] text-white px-6 py-2 rounded-md hover:bg-[#c0392b] hidden" onclick="finishTryout()">
              <i class="fas fa-check mr-2"></i>Akhiri Tryout
            </button>
          </div>
        </div>
      </article>
    </div>
  </main>

  <script>
    // Global variables
    let questions = <?= json_encode($questions) ?>;
    let userAnswers = {}; // Object to store user answers
    let currentQuestionNo = questions[0]['no_soal']; // Current question number
    let timerInterval;
    let timeLeft = 100 * 60; // 100 minutes in seconds

    // Initialize the application
    function init() {
      startTimer();
      renderQuestion(currentQuestionNo);
      updateAnsweredCount();
      updateNavigationButtons();
    }

    // Start countdown timer
    function startTimer() {
      timerInterval = setInterval(() => {
        if (timeLeft <= 0) {
          clearInterval(timerInterval);
          alert('Waktu habis! Tryout akan berakhir.');
          finishTryout();
          return;
        }
        
        timeLeft--;
        const hours = Math.floor(timeLeft / 3600);
        const minutes = Math.floor((timeLeft % 3600) / 60);
        const seconds = timeLeft % 60;
        
        document.getElementById('timer').textContent = 
          `${hours}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
      }, 1000);
    }

    // Render question based on question number
    function renderQuestion(no_soal) {
      const question = questions.find(q => q.no_soal === no_soal);
      
      if (!question) {
        console.error('Question not found:', no_soal);
        return;
      }

      // Update current question number
      currentQuestionNo = no_soal;

      // Update question details
      document.getElementById('question-number').textContent = question.no_soal;
      document.getElementById('question-subject').textContent = question.subject;
      document.getElementById('question-text').textContent = question.teks_soal;

      // Clear and populate options
      const optionsList = document.getElementById('options-list');
      optionsList.innerHTML = "";

      question.options.forEach((option, index) => {
        const li = document.createElement('li');
        const btn = document.createElement('button');
        
        btn.type = "button";
        btn.className = "flex items-center gap-4 w-full text-left p-3 rounded-md border transition-all duration-200 hover:bg-gray-50";
        btn.id = `option-${option.id_option}`;
        
        // Check if this option is selected
        const isSelected = userAnswers[no_soal] === option.id_option;
        if (isSelected) {
          btn.classList.add('bg-blue-500', 'text-white', 'border-blue-500');
          btn.classList.remove('hover:bg-gray-50');
        } else {
          btn.classList.add('border-gray-300');
        }

        btn.onclick = () => selectAnswer(no_soal, option.id_option);

        // Create option circle
        const circle = document.createElement('div');
        circle.className = `font-semibold rounded-md w-7 h-7 flex items-center justify-center ${isSelected ? 'bg-white text-blue-500' : 'bg-gray-100 text-gray-700'}`;
        circle.textContent = option.opsi;

        // Create option text
        const span = document.createElement('span');
        span.textContent = option.teks_option;

        btn.appendChild(circle);
        btn.appendChild(span);
        li.appendChild(btn);
        optionsList.appendChild(li);
      });

      // Update question button states
      updateQuestionButtonStates();
      updateNavigationButtons();
    }

    // Select answer for current question
    function selectAnswer(no_soal, optionId) {
      // Save the answer
      userAnswers[no_soal] = optionId;
      
      // Re-render current question to update UI
      renderQuestion(no_soal);
      
      // Update answered count
      updateAnsweredCount();
      
      // Auto-navigate to next question if not the last question
      const currentIndex = questions.findIndex(q => q.no_soal === no_soal);
      if (currentIndex < questions.length - 1) {
        setTimeout(() => {
          const nextQuestion = questions[currentIndex + 1];
          selectQuestion(nextQuestion.no_soal);
        }, 500); // Small delay for better UX
      }
    }

    // Select question by question number
    function selectQuestion(no_soal) {
      renderQuestion(no_soal);
    }

    // Navigate between questions
    function navigateQuestion(direction) {
      const currentIndex = questions.findIndex(q => q.no_soal === currentQuestionNo);
      
      if (direction === 'prev' && currentIndex > 0) {
        const prevQuestion = questions[currentIndex - 1];
        selectQuestion(prevQuestion.no_soal);
      } else if (direction === 'next' && currentIndex < questions.length - 1) {
        const nextQuestion = questions[currentIndex + 1];
        selectQuestion(nextQuestion.no_soal);
      }
    }

    // Update navigation button states
    function updateNavigationButtons() {
      const currentIndex = questions.findIndex(q => q.no_soal === currentQuestionNo);
      const prevBtn = document.getElementById('prev-btn');
      const nextBtn = document.getElementById('next-btn');
      const finishBtn = document.getElementById('finish-btn');

      // Previous button
      prevBtn.disabled = currentIndex === 0;
      
      // Next/Finish button logic
      if (currentIndex === questions.length - 1) {
  nextBtn.classList.add('hidden');
  finishBtn.classList.remove('hidden');
} else {
  nextBtn.classList.remove('hidden');
  finishBtn.classList.add('hidden');
}

    }

    // Update question button states
    function updateQuestionButtonStates() {
      questions.forEach(question => {
        const btn = document.getElementById(`btn-${question.no_soal}`);
        if (btn) {
          // Reset classes
          btn.className = 'question-btn w-8 h-8 rounded border font-semibold inline-block px-1 transition-all duration-200';
          
          if (question.no_soal === currentQuestionNo) {
            // Current question
            btn.classList.add('bg-[#0f293f]', 'text-white', 'border-[#0f293f]');
          } else if (userAnswers[question.no_soal]) {
            // Answered question
            btn.classList.add('bg-green-500', 'text-white', 'border-green-500');
          } else {
            // Unanswered question
            btn.classList.add('bg-white', 'text-gray-900', 'border-gray-300', 'hover:bg-gray-50');
          }
        }
      });
    }

    // Update answered questions count
    function updateAnsweredCount() {
      const count = Object.keys(userAnswers).length;
      document.getElementById('answered-count').textContent = count;
    }

    // Finish tryout and save answers
    // Fungsi untuk mengakhiri tryout dan mengirimkan jawaban ke server
function finishTryout() {
  const answeredCount = Object.keys(userAnswers).length;
  const totalQuestions = questions.length;

  const confirmMessage = `Anda telah menjawab ${answeredCount} dari ${totalQuestions} soal.\n\nApakah Anda yakin ingin mengakhiri tryout?`;

  if (confirm(confirmMessage)) {
    // Clear timer
    clearInterval(timerInterval);

    // Persiapkan data untuk dikirimkan
    const formData = new FormData();
    formData.append('id_pengguna', <?= $pengguna['id_pengguna'] ?>);
    formData.append('id_tryout', <?= $tryout['id_tryout'] ?>);
    formData.append('answers', JSON.stringify(userAnswers));

    // Tampilkan loading state
    const finishBtn = document.getElementById('finish-btn');
    const originalText = finishBtn.innerHTML;
    finishBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    finishBtn.disabled = true;

    // Kirim jawaban ke server
    fetch('/dashboard/save_answers', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Tryout berhasil diselesaikan!');
        window.location.href = '/dashboard/user/tryout/finish/' + <?= $tryout['id_tryout'] ?>;  // Redirect ke halaman finish dengan ID tryout
      } else {
        throw new Error(data.message || 'Terjadi kesalahan');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Terjadi kesalahan saat menyimpan jawaban. Silakan coba lagi.');
      finishBtn.innerHTML = originalText;
      finishBtn.disabled = false;
    });
  }
}


    // Handle "Lihat Semua" button
    document.getElementById('lihat-semua-btn').addEventListener('click', function(e) {
      e.preventDefault();
      
      let summary = 'Ringkasan Jawaban:\n\n';
      questions.forEach(question => {
        const answer = userAnswers[question.no_soal];
        const status = answer ? 'Terjawab' : 'Belum Dijawab';
        summary += `Soal ${question.no_soal}: ${status}\n`;
      });
      
      alert(summary);
    });

    // Initialize the application when page loads
    document.addEventListener('DOMContentLoaded', function() {
      init();
    });

    // Prevent accidental page refresh
    window.addEventListener('beforeunload', function(e) {
      if (Object.keys(userAnswers).length > 0) {
        e.preventDefault();
        e.returnValue = '';
      }
    });
  </script>
</body>
</html>