<aside class="ml-8 mr-4 mt-8 rounded-xl w-64 bg-white shadow-md flex flex-col overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100">
    <div class="flex flex-col items-center pt-8 px-6">
        <!-- Display user profile -->
        <div class="bg-[#3498db] rounded-full w-20 h-20 flex items-center justify-center mb-4">
            <i class="fas fa-user text-white text-4xl"> </i>
        </div>

        <!-- Display user name -->
        <p class="text-center text-lg font-semibold leading-5 mb-1">
            <?= $pengguna['nama'] ?? 'Nama Pengguna' ?>  <!-- Display user's name -->
        </p>

        <!-- Display user balance -->
        <div class="flex items-center gap-1 text-xs text-gray-700 mb-4">
            <img alt="Gold coin icon" class="w-[15px] h-[15px]" height="15" src="https://storage.googleapis.com/a1aa/image/a132a800-4e2b-4d3e-ec6b-11a561bd4203.jpg" width="15" />
            <span>Rp <?= number_format($pengguna['saldo'], 0, ',', '.') ?></span> <!-- Menampilkan saldo dengan format ribuan -->
        </div>

        <!-- Top Up Button -->
        <button class="bg-[#3498db] text-white text-xs font-semibold rounded-full w-full py-2 flex items-center justify-center gap-1 hover:bg-[#2a7bbd] transition" onclick="window.location.href='/topup'">
            Top Up
            <i class="fas fa-plus-square text-xs"> </i>
        </button>
    </div>
    <hr class="border-gray-300 mx-6" />
    <nav class="mt-6 flex flex-col gap-6 px-8">
        <a class="flex items-center gap-3 text-base font-semibold text-gray-900 hover:text-gray-700" href="/dashboard">
            <span class="text-2xl"> 🏛️ </span> Home
        </a>
        <a class="flex items-center gap-3 text-base font-semibold text-gray-900 hover:text-gray-700" href="/dashboard/user/tryout">
            <span class="text-2xl"> 📝 </span> Tryout
        </a>
        <a class="flex items-center gap-3 text-base font-semibold text-gray-900 hover:text-gray-700" href="/12raport.html">
            <span class="text-2xl"> 🏆 </span> Raport
        </a>
        <a class="flex items-center gap-3 text-base font-semibold text-gray-900 hover:text-gray-700" href="/dashboard/topuphistory">
            <span class="text-2xl"> 🪙 </span> Payment
        </a>
        <a class="flex items-center gap-3 text-base font-semibold text-gray-900 hover:text-gray-700" href="/dashboard/help">
            <span class="text-2xl"> 🔍 </span> Help
        </a>
        <a class="flex items-center gap-3 text-base font-semibold text-gray-900 hover:text-gray-700" href="/dashboard/account">
            <span class="text-2xl"> ⚙️ </span> Setting
        </a>
        <a class="flex items-center gap-3 text-base font-semibold text-gray-900 hover:text-gray-700" href="/login">
            <span class="text-2xl"> 🧑‍💻 </span> Logout
        </a>
    </nav>
</aside>
