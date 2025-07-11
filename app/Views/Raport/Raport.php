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
      href="https://fonts.googleapis.com/css2?family=Inter&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

      .custom-row-bg {
      background-color: #f3f4f6;
    }
    </style>
  </head>
  <body class="bg-[#f7f9fc] min-h-screen flex">
    <!-- Sidebar -->
    <?= view('components/sidebar', ['pengguna' => $pengguna]) ?>

    <!-- Main content -->
    <main class="flex-1 p-8 pt-12 overflow-auto">
      <h1 class="text-2xl font-semibold mb-6">Raport</h1>
      <section
        class="bg-white rounded-xl p-8 mx-auto shadow-sm overflow-x-auto"
      >
        <h2 class="text-center text-base font-semibold mb-9">
          Raport Pejuang ASN
        </h2>
        <div class="flex flex-col items-center mb-6">
          <label class="text-xs text-gray-500 mb-1 select-none" for="filter"
            >Filter tryout</label
          >
          <select
            class="bg-[#e4eff1] rounded-lg px-4 py-2 text-sm w-48 cursor-pointer"
            id="filter"
            name="filter"
          >
            <option>Semua</option>
          </select>
        </div>
        <div class="text-center mb-6 text-xs text-[#00475e] leading-tight">
          <p class="font-semibold">
            Kamu telah mengerjakan
            <a class="text-[#1a8fe3] hover:underline" href="#"><?= $jumlahTryoutSelesai ?> tryout</a
            ><br />
          </p>
        </div>
        <div class="overflow-x-auto px-40">
          <canvas id="lineChart" height="400"></canvas>
        </div>
      </section>

      <section class="overflow-x-auto rounded-xl bg-white p-4 mt-4 shadow-md">
        <table class="w-full text-sm text-left text-gray-900">
          <thead>
            <tr>
              <th class="py-3 px-4 font-semibold">Tryout Title</th>
              <th class="py-3 px-4 font-semibold">Tryout Edition</th>
              <th class="py-3 px-4 font-semibold">Tanggal</th>
              <th class="py-3 px-4 font-semibold">Score</th>
              <th class="py-3 px-4 font-semibold">Ranking National</th>
              <th class="py-3 px-4 font-semibold">Ranking Prov</th>
              <th class="py-3 px-4 font-semibold">Lulus</th>
            </tr>
          </thead>
          <tbody>
          <?php if (empty($raport)): ?>
            <tr class="custom-row-bg text-center">
              <td colspan="7" class="py-4">Belum ada tryout yang selesai dikerjakan</td>
            </tr>
          <?php else: ?>
            <?php foreach ($raport as $i => $r): ?>
            <tr class="<?= $i % 2 == 0 ? 'custom-row-bg' : '' ?>">
              <td class="py-3 px-4 "><?= htmlspecialchars($r['nama_tryout'] ?? '-') ?></td>
              <td class="py-3 px-4">KEDINASAN 2025</td>
              <td class="py-3 px-4"><?= date('l, d F Y', strtotime($r['tanggal_transaksi'])) ?></td>
              <td class="py-3 px-4"><?= $r['total_score'] ?></td>
              <td class="py-3 px-4"><?= $r['rank_nasional'] ?> / <?= $r['total_nasional'] ?></td>
              <td class="py-3 px-4"><?= $r['rank_prov'] ?> / <?= $r['total_prov'] ?></td>
              <td class="py-3 px-4"><?= ($r['status_kelulusan_to'] ?? '') === 'Lulus' ? 'Ya' : 'Tidak' ?></td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
      </section>
    </main>

    <script>
      const ctx = document.getElementById("lineChart").getContext("2d");
      
      // Data dari database
      const chartData = <?= json_encode($chartData) ?>;
      
      const data = {
        labels: chartData.map(item => item.label),
        datasets: [
          {
            label: "Data Score",
            data: chartData.map(item => item.score),
            borderColor: "#3498db",
            backgroundColor: "#3498db",
            fill: false,
            tension: 0.3,
            pointRadius: 4,
            pointHoverRadius: 6,
            borderWidth: 2,
          },
          {
            label: "Data rank (%) Nasional",
            data: chartData.map(item => item.rank_nasional_pct),
            borderColor: "#b9e6e7",
            backgroundColor: "#b9e6e7",
            fill: false,
            tension: 0.3,
            pointRadius: 4,
            pointHoverRadius: 6,
            borderWidth: 2,
          },
          {
            label: "Data rank (%) Provinsi",
            data: chartData.map(item => item.rank_prov_pct),
            borderColor: "#04282a",
            backgroundColor: "#04282a",
            fill: false,
            tension: 0.3,
            pointRadius: 4,
            pointHoverRadius: 6,
            borderWidth: 2,
          },
        ],
      };

      const options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: "top",
            labels: {
              font: {
                size: 12,
                family: "'Inter', sans-serif",
              },
              color: "#111",
            },
          },
          tooltip: {
            mode: "index",
            intersect: false,
          },
        },
        scales: {
          y: {
            min: 0,
            max: 500,
            ticks: {
              stepSize: 50,
              color: "#666",
              font: {
                size: 11,
                family: "'Inter', sans-serif",
              },
            },
            grid: {
              color: "#e5e7eb",
            },
          },
          x: {
            ticks: {
              color: "#666",
              font: {
                size: 11,
                family: "'Inter', sans-serif",
              },
            },
            grid: {
              display: false,
            },
          },
        },
        elements: {
          line: {
            borderJoinStyle: "round",
          },
        },
      };

      new Chart(ctx, {
        type: "line",
        data: data,
        options: options,
      });
    </script>
  </body>
</html>
