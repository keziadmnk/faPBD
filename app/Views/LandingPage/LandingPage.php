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
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: "Inter", sans-serif;
      }
      html {
        scroll-behavior: smooth;
      }
    </style>
  </head>
  <body class="bg-[#f8fafc] text-gray-900">

   <!-- Memanggil Navbar dari Folder Components -->
    <?= view('components/navbar'); ?>
    
    <!-- Hero Section -->
    <section
      class="bg-[#b6e6e8] flex flex-col md:flex-row items-center justify-between px-6 md:px-20 py-16 gap-10 md:gap-20"
    >
      <div class="text-left pl-8">
        <h1 class="text-gray-900 text-3xl font-normal mb-1">
          Sekolah
          <span class="text-[#f68b1e] font-semibold"> Kedinasan </span>
          dan <span class="text-[#f68b1e] font-semibold"> CPNS </span>
        </h1>

        <h1 class="text-gray-900 text-3xl d mb-2">
          Nomor 1 <span class="font-semibold text-gray-900"> di Indonesia </span>
        </h1>
        <p class="text-gray-700 text-lg mb-4">
          Persiapkan dirimu menghadapi tes
          <span class="font-semibold text-gray-900"> Kedinasan </span>
          dan <span class="font-semibold text-gray-900"> CPNS </span>
        </p>
        <button
          class="bg-[#f68b1e] hover:bg-orange-600 text-white font-extralight text-m px-5 py-2 rounded transition"
          onclick="window.location.href='/daftar';"
        >
          Gabung Sekarang !
        </button>
      </div>
      <div class="pl-24">
        <img
          alt="Illustration of two students sitting at desks writing exam papers, one male and one female"
          class="w-full h-auto"
          height="192"
          src="/image/landing1.png"
          width="288"
        />
      </div>
    </section>

    <section id="tentang-kami" class="max-w-7xl mx-auto py-20">
   <h2 class="text-[24px] font-light text-[#1E293B] mb-6">
    Kenapa Tryout di
    <span class="font-semibold text-[#0EA5E9]">
     Focus Academy?
    </span>
   </h2>
   <div class="flex flex-col md:flex-row gap-6">
    <div class="bg-[#B9E6E9] rounded-xl flex-shrink-0 md:w-1/2 shadow-md p-6 flex justify-center items-center">
     <div class="w-full max-w-[320px]">
      <img alt="Illustration of a woman with long hair writing in a book at a desk with a small plant, window background with leaves" class="rounded-xl w-full h-auto" height="350" src="/image/landing2.jpg" width="600"/>
     </div>
    </div>
    <div class="bg-white rounded-xl p-6 md:w-1/2 shadow-md flex flex-col justify-center space-y-6">
     <div class="flex gap-4">
      <img alt="Icon of a human head with a target on the forehead and a red arch on the chest" class="w-16 h-16 flex-shrink-0" height="64" src="https://storage.googleapis.com/a1aa/image/c262984e-0dda-4502-ff7e-43a990f33c81.jpg" width="64"/>
      <div class="text-[#1E293B] text-[14px] leading-6">
       <p class="font-semibold mb-1">
        Paket Soal Akurat
       </p>
       <p>
        Soal pilihan yang diantaranya diambil dari soal tes Kedinasan
              tahun sebelumnya dan merupakan soal terbaik Kedinasan Indonesia.
       </p>
      </div>
     </div>
     <div class="flex gap-4">
      <img alt="Icon of a computer monitor with a checklist paper on the screen" class="w-16 h-16 flex-shrink-0" height="64" src="https://storage.googleapis.com/a1aa/image/6de646c2-f809-4902-1a03-962726987820.jpg" width="64"/>
      <div class="text-[#1E293B] text-[14px] leading-6">
       <p class="font-semibold mb-1">
        Pengerjaan Online
       </p>
       <p>
        Kerjakan dimanapun Anda berada, gunakan Handphone atau Komputer
              untuk merasakan sensasi soal-soal Try Out Kedinasan Indonesia.
       </p>
      </div>
     </div>
     <div class="flex gap-4">
      <img alt="Icon of a stopwatch with a phone symbol and a green arrow" class="w-16 h-16 flex-shrink-0" height="64" src="https://storage.googleapis.com/a1aa/image/cd443f1c-8046-4ed8-872b-1add0670a4aa.jpg" width="64"/>
      <div class="text-[#1E293B] text-[14px] leading-6">
       <p class="font-semibold mb-1">
        Hasil Instan
       </p>
       <p>
        Tak perlu waktu lama untuk mendapatkan hasil Tryout Anda, Hasil
              langsung keluar ketika pengerjaan selesai.
       </p>
      </div>
     </div>
    </div>
    </div>
    </section>

    <div
      class="max-w-7xl mx-auto my-16 bg-white rounded-xl p-10 flex flex-col sm:flex-row justify-between items-center shadow-md gap-10 sm:gap-0"
    >
      <div class="flex flex-col items-center text-center max-w-[260px]">
        <img
          alt="Illustration of a group of three diverse people representing a team"
          class="mb-6"
          height="80"
          src="https://storage.googleapis.com/a1aa/image/7ffb1657-98b5-48a7-765c-d11ebc88cc79.jpg"
          width="80"
        />
        <div class="text-[40px] font-extrabold text-[#f58200] leading-none">
          100
          <span class="text-black font-normal text-[24px]"> K+ </span>
        </div>
        <p class="text-[14px] text-[#2a2a2a] mt-3">
          Pejuang ASN telah bergabung bersama focus academy
        </p>
      </div>
      <div class="flex flex-col items-center text-center max-w-[260px]">
        <img
          alt="Illustration of an open book with a yellow circular background"
          class="mb-6"
          height="80"
          src="https://storage.googleapis.com/a1aa/image/08e3539d-bc8d-40a4-69f9-3f141d4585cd.jpg"
          width="80"
        />
        <div class="text-[40px] font-extrabold text-[#f58200] leading-none">
          500
          <span class="text-black font-normal text-[24px]"> + </span>
        </div>
        <p class="text-[14px] text-[#2a2a2a] mt-3">
          Soal berkualitas yang telah disiapkan team Focus Academy
        </p>
      </div>
      <div class="flex flex-col items-center text-center max-w-[280px]">
        <img
          alt="Illustration of a happy user holding a smiley face icon with a pink circular background"
          class="mb-6"
          height="80"
          src="https://storage.googleapis.com/a1aa/image/c366348d-c9c2-45fb-0b11-fe501dc6ca0f.jpg"
          width="80"
        />
        <div class="text-[40px] font-extrabold text-[#f58200] leading-none">
          87
          <span class="text-black font-normal text-[24px]"> % </span>
        </div>
        <p class="text-[14px] text-[#2a2a2a] mt-3">
          Pengguna merasa puas dengan platform focus academy
        </p>
      </div>
      <div class="flex flex-col items-center text-center max-w-[260px]">
        <img
          alt="Illustration of a checklist on a laptop screen with a light yellow background"
          class="mb-6"
          height="80"
          src="https://storage.googleapis.com/a1aa/image/45ff2a26-3e22-447a-e17a-27f7448f128b.jpg"
          width="80"
        />
        <div class="text-[40px] font-extrabold text-[#f58200] leading-none">
          10
          <span class="text-black font-normal text-[24px]"> K+ </span>
        </div>
        <p class="text-[14px] text-[#2a2a2a] mt-3">
          Pengguna telah berhasil lolos tes Kedinasan
        </p>
      </div>
    </div>

    <!-- Features Section -->
    <section id="fitur-keren"
      class=" mx-auto px-6 md:px-20 py-20 text-center text-gray-700"
    >
      <p  class="font-light text-2xl mb-1">
        Fitur Keren di
        <span class="text-[#0EA5E9] font-semibold">
          Focus Academy
        </>
      </p>
      <p class="text-sm
       font-semibold mb-8">
        Suka belajar mandiri? Pas banget,
        <br />
        <span class="font-semibold text-gray-900">
          <span class="text-[#0EA5E9]">Focus Academy</span> punya fitur khusus pejuang seperti kamu:
        </span>
      </p>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mx-12">
        <div class="bg-white rounded-xl p-8 shadow-md text-md">
          <img
            alt="Icon representing identical exam system"
            class="mb-3 mx-auto"
            height="48"
            src="https://storage.googleapis.com/a1aa/image/85df180b-858c-472c-673f-39256d930900.jpg"
            width="84"
          />
          <h4 class="font-semibold text-gray-900 mb-2 text-sm">
            Identical Exam System
          </h4>
          <p>
            Kami memiliki team khusus yang akan terus memperbarui tampilan
            tryout agar mirip dengan tampilan tes online CPNS dan IPDN
          </p>
        </div>
        <div class="bg-white rounded-xl p-8 shadow-md text-md">
          <img
            alt="Icon representing smart report"
            class="mb-3 mx-auto"
            height="48"
            src="https://storage.googleapis.com/a1aa/image/f3e32639-2cab-44b0-40a2-b7f049213482.jpg"
            width="84"
          />
          <h4 class="font-semibold text-gray-900 mb-2 text-sm">Smart Raport</h4>
          <p>
            Track progress dan targetmu dengan smart raport dari kami, lihat
            kekuranganmu dan terus tingkatkan dengan latihan
          </p>
        </div>
        <div class="bg-white rounded-xl p-8 shadow-md text-md">
          <img
            alt="Icon representing realtime ranking"
            class="mb-3 mx-auto"
            height="48"
            src="https://storage.googleapis.com/a1aa/image/32417687-d09c-4bb4-ee91-e15f4e5cf2e8.jpg"
            width="84"
          />
          <h4 class="font-semibold text-gray-900 mb-2 text-sm">
            Realtime Ranking
          </h4>
          <p>
            Lihat hasil tryout mu dan bandingkan dengan pengguna di seluruh
            Indonesia sehingga prestasimu kelihatan bisa dilihat
          </p>
        </div>
      </div>
    </section>
  
    <!-- reviews -->
  <section id="testimoni" class="max-w-7xl mx-auto  py-12">
   <div class="text-center mb-10">
    <h2 class="text-[20px] font-normal text-[#1a202c] mb-1">
     Apa Kata Mereka ?
    </h2>
    <p class="text-[#0c4a60] font-semibold text-[16px]">
     Ribuan orang telah merasakan manfaat tryout di
    </p>
    <p class="text-[#3b82f6] font-normal text-[16px]">
     Focus Academy
    </p>
   </div>

   <!-- review -->
   <div class="flex flex-col md:flex-row gap-8 max-w-7xl mx-auto justify-center">
    <article class="bg-white rounded-xl p-6 max-w-sm flex flex-col gap-4">
     <div class="flex items-center gap-6">
      <img alt="Profile 1 Headshot of a young man wearing a white shirt with a red background" class="w-18 h-18 rounded-full object-cover" height="72" src="https://storage.googleapis.com/a1aa/image/024e14b4-3f01-40e0-4d03-4d005b3f9736.jpg" width="72"/>
      <div>
       <h3 class="text-[#0c4a60] font-semibold text-[16px] leading-tight">
        Rahmat Agung Tri Utomo
       </h3>
       <p class="text-[#1a202c] text-[14px] leading-tight">
        Jawa Tengah
       </p>
       <div class="text-yellow-400 text-[14px] leading-none mt-1">
        <i class="fas fa-star">
        </i>
        <i class="fas fa-star">
        </i>
        <i class="fas fa-star">
        </i>
        <i class="fas fa-star">
        </i>
        <i class="fas fa-star">
        </i>
       </div>
      </div>
     </div>
     <p class="text-[#1a202c] text-[14px] leading-relaxed">
      Focus Academy merupakan bimbel paket komplit dengan biaya yang sangat terjangkau.
     </p>
     
    </article>
    <article class="bg-white rounded-xl p-6 max-w-sm flex flex-col gap-4">
     <div class="flex items-center gap-6">
      <img alt="Profile 2 Headshot of a young man wearing a white shirt and tie with an indoor background" class="w-18 h-18 rounded-full object-cover" height="72" src="https://storage.googleapis.com/a1aa/image/65a15761-2e47-40ee-dee1-ceae649214d4.jpg" width="72"/>
      <div>
       <h3 class="text-[#0c4a60] font-semibold text-[16px] leading-tight">
        Dewi Fortuna
       </h3>
       <p class="text-[#1a202c] text-[14px] leading-tight">
        Jawa Timur
       </p>
       <div class="text-yellow-400 text-[14px] leading-none mt-1">
        <i class="fas fa-star">
        </i>
        <i class="fas fa-star">
        </i>
        <i class="fas fa-star">
        </i>
        <i class="fas fa-star">
        </i>
        <i class="fas fa-star">
        </i>
       </div>
      </div>
     </div>
     <p class="text-[#1a202c] text-[14px] leading-relaxed">
      Coach Ari sangat profesional dalam memberikan materi sehingga kami mudah mengerjakan soal tryout tipe HOTS sekalipun. Dari sekian banyak bimbel hanya Focus Academy yang menyajikan materi dengan totalitas.
     </p>
    </article>
    <article class="bg-white rounded-xl p-6 max-w-sm flex flex-col gap-4">
     <div class="flex items-center gap-6">
      <img alt="Profile 3 Headshot of a young man wearing a white shirt with a red background" class="w-18 h-18 rounded-full object-cover" height="72" src="https://storage.googleapis.com/a1aa/image/64a3be37-009f-49c4-ed5c-dffb80b2e0f8.jpg" width="72"/>
      <div>
       <h3 class="text-[#0c4a60] font-semibold text-[16px] leading-tight">
        Muhammad Fajar Amirudin
       </h3>
       <p class="text-[#1a202c] text-[14px] leading-tight">
        Jawa Tengah
       </p>
       <div class="text-yellow-400 text-[14px] leading-none mt-1">
        <i class="fas fa-star">
        </i>
        <i class="fas fa-star">
        </i>
        <i class="fas fa-star">
        </i>
        <i class="fas fa-star">
        </i>
        <i class="fas fa-star">
        </i>
       </div>
      </div>
     </div>
     <p class="text-[#1a202c] text-[14px] leading-relaxed">
      Bimbel bisa dimanapun namun hanya di Focus Academy yang bisa mendapat materi sesuai di lapangan.
     </p>
    </article>
   </div>
   <div class="flex justify-center mt-8 gap-3">
    <button aria-label="Current slide" class="w-4 h-4 rounded-full bg-black border border-black">
    </button>
    <button aria-label="Next slide" class="w-4 h-4 rounded-full border border-black">
    </button>
   </div>
  </section>
 
    <!-- Call to Action Section -->
    <section
      class="bg-gradient-to-b from-[#2B7CA3] to-[#1B4D6B] text-white py-16 mb-12 px-6 md:px-20 text-center rounded-xl max-w-7xl mx-auto"
    >
      <h2 class="text-lg md:text-2xl font-semibold mb-3">
        Perjalanan Kamu Menjadi ASN Dimulai dari sini!
      </h2>
      <p class="text-sm mb-6">
        Daftar sekarang juga dan dapatkan voucher gratis
      </p>
      <button
        class="bg-[#f68b1e] hover:bg-orange-600 text-white font-semibold text-sm md:text-base px-6 py-2 rounded-full transition"
        onclick="window.location.href='/daftar';"
      >
        Daftar Sekarang !
      </button>
    </section>

    <!-- Memanggil Footer dari Folder Components -->
    <?= view('components/footer'); ?>
  </body>
</html>
