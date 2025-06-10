<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Tryout Purchase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
</head>
<body class="bg-slate-50 min-h-screen flex">
      <?= view('components/sidebar', ['pengguna' => $pengguna]) ?>

    <main class="flex-1 p-8 pt-16 overflow-y-auto">
        <h2 class="text-lg font-semibold mb-6">Tryoutmu !!</h2>

        <!-- Tryout Belum Dikerjakan -->
        <section class="bg-white rounded-lg p-6 mb-8 shadow-sm max-w-full overflow-x-auto">
            <h3 class="mb-4 text-base font-semibold text-gray-900">
                <span class="text-[#0f4c5c]"> Tryout </span>
                <span class="text-red-600"> Belum </span>
                Dikerjakan
            </h3>
            <table class="w-full text-sm text-gray-900 border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 font-bold">
                        <th class="text-left py-3 px-4 w-[5%]">Id</th>
                        <th class="text-left py-3 px-4 w-[40%]">Title</th>
                        <th class="text-left py-3 px-4 w-[25%]">Start Date</th>
                        <th class="text-left py-3 px-4 w-[25%]">End Date</th>
                        <th class="text-left py-3 px-4 w-[15%]">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tryoutPurchasesBelum as $tryoutPurchase): ?>
                    <tr class="bg-gray-100">
                        <td class="py-3 px-4"><?= $tryoutPurchase['id_tryout'] ?></td>
                        <td class="py-3 px-4"><?= $tryoutPurchase['nama_tryout'] ?></td>
                        <td class="py-3 px-4"><?= $tryoutPurchase['tanggal_mulai'] ?></td>
                        <td class="py-3 px-4"><?= $tryoutPurchase['tanggal_selesai'] ?></td>
                        <td class="py-3 px-4 text-[#3498db] cursor-pointer">
                            <a href="/dashboard/user/tryout/<?= $tryoutPurchase['id_tryout'] ?>">Lihat Detail</a>
                            
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Tryout Selesai Dikerjakan -->
        <section class="bg-white rounded-lg p-6 shadow-sm max-w-full overflow-x-auto">
            <h3 class="mb-4 text-base font-semibold text-gray-900">
                <span class="text-[#0f4c5c]"> Tryout </span>
                <span class="text-green-700"> Selesai </span>
                Dikerjakan
            </h3>
            <table class="w-full text-sm text-gray-900 border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 font-bold">
                        <th class="text-left py-3 px-4 w-[5%]">Id</th>
                        <th class="text-left py-3 px-4 w-[40%]">Title</th>
                        <th class="text-left py-3 px-4 w-[25%]">Start Date</th>
                        <th class="text-left py-3 px-4 w-[25%]">End Date</th>
                        <th class="text-left py-3 px-4 w-[15%]">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tryoutPurchasesSelesai as $tryoutPurchase): ?>
                    <tr class="bg-gray-100">
                        <td class="py-3 px-4"><?= $tryoutPurchase['id_tryout'] ?></td>
                        <td class="py-3 px-4"><?= $tryoutPurchase['nama_tryout'] ?></td>
                        <td class="py-3 px-4"><?= $tryoutPurchase['tanggal_mulai'] ?></td>
                        <td class="py-3 px-4"><?= $tryoutPurchase['tanggal_selesai'] ?></td>
                        <td class="py-3 px-4 text-[#3498db] cursor-pointer">
                            <a href="/dashboard/user/tryout/finish/<?= $tryoutPurchase['id_tryout'] ?>">Lihat Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
