<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Queue - Pengambilan Raport</title>
    @vite('resources/css/app.css')
    <style>
        body { font-family: sans-serif; background: #0f172a; color: white; overflow: hidden; }
        .glass-panel { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.05); border-radius: 24px; }
        .hero-section { display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; height: 100vh; padding: 40px; }
        
        .current-call { animation: pulse 2s infinite; }
        @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.02); } 100% { transform: scale(1); } }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <header class="p-6 flex justify-between items-center bg-gray-900 border-b border-gray-800">
        <h1 class="text-2xl font-bold tracking-widest uppercase text-gray-300">Live <span class="text-white">Queue</span></h1>
        <div class="text-xl font-medium text-gray-400" id="clock">10:00 AM</div>
    </header>

    <main class="flex-1 p-8 grid grid-cols-12 gap-8">
        <!-- Sedang Dipanggil -->
        <div class="col-span-8 glass-panel p-10 flex flex-col justify-center items-center current-call" id="current_call">
            <h2 class="text-2xl text-gray-400 uppercase tracking-widest mb-4">Sekarang Giliran</h2>
            <div class="text-7xl font-bold text-white mb-6 text-center" id="cc_ortu">-</div>
            <div class="flex items-center gap-4 mt-8">
                <span class="px-6 py-3 bg-indigo-600 rounded-full text-xl font-semibold shadow-lg shadow-indigo-500/30" id="cc_kelas">-</span>
                <span class="text-2xl text-gray-400">Orang Tua dari <strong class="text-white" id="cc_anak">-</strong></span>
            </div>
        </div>

        <!-- Antrean Selanjutnya -->
        <div class="col-span-4 glass-panel p-8 flex flex-col">
            <h3 class="text-lg text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-700 pb-4">Menunggu (Hadir)</h3>
            <div class="flex-1 overflow-y-auto space-y-4 pr-2" id="queue_list">
                <!-- List dipopulate via JS -->
            </div>
        </div>
    </main>

    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').innerText = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }
        setInterval(updateClock, 1000);
        updateClock();

        function fetchQueue() {
            fetch('/display/data')
                .then(res => res.json())
                .then(data => {
                    const currentContainer = document.getElementById('current_call');
                    const listContainer = document.getElementById('queue_list');
                    
                    listContainer.innerHTML = '';
                    
                    if (data.length === 0) {
                        document.getElementById('cc_ortu').innerText = '-';
                        document.getElementById('cc_kelas').innerText = '-';
                        document.getElementById('cc_anak').innerText = '-';
                        listContainer.innerHTML = '<div class="text-center text-gray-500 mt-10">Belum ada antrean masuk.</div>';
                        return;
                    }

                    // First person is the current call
                    const current = data[0];
                    document.getElementById('cc_ortu').innerText = current.nama_orangtua;
                    document.getElementById('cc_kelas').innerText = current.kelas.nama;
                    document.getElementById('cc_anak').innerText = current.siswa.nama;

                    // Remaining are waiting
                    const waiting = data.slice(1);
                    waiting.forEach(item => {
                        listContainer.innerHTML += `
                            <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700">
                                <div class="text-lg font-bold text-gray-200 mb-1">${item.nama_orangtua}</div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-indigo-400 font-medium">${item.kelas.nama}</span>
                                    <span class="text-gray-500">${item.siswa.nama}</span>
                                </div>
                            </div>
                        `;
                    });
                });
        }

        setInterval(fetchQueue, 3000); // Polling setiap 3 detik
        fetchQueue();
    </script>
</body>
</html>
