<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Queue - Pengambilan Raport</title>

    <!-- SEO & Favicon -->
    <meta name="description" content="Sistem Antrean dan Pengambilan Raport SMK Pesat IT Xpro. Solusi cerdas penjadwalan kehadiran orang tua secara digital.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Live Queue Raport - SMK Pesat IT Xpro">
    <meta property="og:description" content="Sistem Antrean dan Pengambilan Raport SMK Pesat IT Xpro. Solusi cerdas penjadwalan kehadiran orang tua secara digital.">
    <meta property="og:image" content="{{ asset('logo.png') }}">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Live Queue Raport - SMK Pesat IT Xpro">
    <meta property="twitter:description" content="Sistem Antrean dan Pengambilan Raport SMK Pesat IT Xpro. Solusi cerdas penjadwalan kehadiran orang tua secara digital.">
    <meta property="twitter:image" content="{{ asset('logo.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    @vite('resources/css/app.css')
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
    @theme {
        --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
    }
    </style>
    <style>
        body { font-family: var(--font-sans), sans-serif; background: #f8fafc; color: #1e293b; overflow: hidden; }
        .glass-panel { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(16px); border: 1px solid rgba(0,0,0,0.05); border-radius: 24px; box-shadow: 0 10px 40px -10px rgba(0,0,0,0.1); }
        
        .current-call { animation: pulse 2s infinite; }
        @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.02); } 100% { transform: scale(1); } }
        
        #start_overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 50;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
        }

        /* Hide scrollbar for waiting list */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- Overlay untuk aktivasi Audio Autoplay -->
    <div id="start_overlay">
        <h2 class="text-white text-3xl font-bold mb-6">Sistem Antrean Suara</h2>
        <p class="text-gray-300 mb-8 text-center max-w-md text-lg">Sistem membutuhkan interaksi pertama agar diizinkan memutar suara oleh browser.</p>
        <button onclick="startDisplay()" class="px-8 py-4 bg-[#4368a8] hover:bg-[#1a3a7c] text-white font-bold rounded-full text-xl shadow-lg transition-transform hover:scale-105 cursor-pointer">
            Mulai Display
        </button>
    </div>

    <header class="p-6 flex justify-between items-center bg-white border-b border-gray-200 shadow-sm z-10">
        <h1 class="text-2xl font-bold tracking-widest uppercase text-gray-800">Antiran <span class="text-[#4368a8]">Pengambilan Raport</span></h1>
        <div class="text-xl font-medium text-gray-500" id="clock">10:00 AM</div>
    </header>

    <main class="flex-1 p-8 grid grid-cols-12 gap-8 relative h-[calc(100vh-88px)]">
        
        <!-- Sedang Dipanggil -->
        <div class="col-span-8 flex flex-col justify-center items-center h-full">
            <div class="glass-panel p-16 w-full text-center flex-1 flex flex-col justify-center" id="current_call">
                <h2 class="text-2xl text-[#4368a8] font-bold uppercase tracking-widest mb-8">Panggilan Antrean</h2>
                
                <div class="text-6xl md:text-7xl lg:text-8xl font-black text-gray-900 mb-8 leading-tight" id="cc_ortu">-</div>
                
                <div class="flex flex-col items-center gap-6 mt-8">
                    <span class="text-3xl text-gray-500">Orang Tua dari <strong class="text-gray-800" id="cc_anak">-</strong></span>
                    <span class="px-8 py-4 bg-[#4368a8] rounded-full text-3xl font-bold text-white shadow-xl shadow-[#4368a8]/30 mt-4" id="cc_kelas">-</span>
                </div>
            </div>

            <!-- List Menunggu di bawah (opsional, untuk antrean lain yang sedang dipanggil) -->
            <div class="w-full mt-8 h-40 shrink-0">
                <h3 class="text-sm font-bold text-gray-500 mb-3 uppercase tracking-widest">Antrean Lainnya yang Sedang Dilayani</h3>
                <div class="flex gap-4 overflow-x-auto pb-4 no-scrollbar items-center h-full" id="queue_list">
                    <!-- List dipopulate via JS -->
                    <div class="text-sm text-gray-400 italic">Tidak ada antrean lain saat ini.</div>
                </div>
            </div>
        </div>

        <!-- Ornamen YouTube -->
        <div class="col-span-4 h-full glass-panel overflow-hidden relative rounded-[32px] bg-black">
            <iframe 
                src="https://www.youtube.com/embed/zoQsS9_Qhpw?autoplay=1&mute=1&loop=1&playlist=zoQsS9_Qhpw&controls=0&showinfo=0&rel=0&modestbranding=1" 
                title="YouTube video player" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                class="absolute inset-0 w-full h-full pointer-events-none"
            ></iframe>
        </div>
    </main>

    <script>
        let isStarted = false;
        let spokenIds = [];
        let ttsQueue = [];
        let isSpeaking = false;
        let currentDisplayData = null; // Data yang sedang tampil besar di layar

        function updateClock() {
            const now = new Date();
            document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }
        setInterval(updateClock, 1000);
        updateClock();

        function startDisplay() {
            document.getElementById('start_overlay').style.display = 'none';
            isStarted = true;
            
            // Dummy utterance to unlock audio context on some browsers
            let msg = new SpeechSynthesisUtterance('');
            msg.volume = 0;
            window.speechSynthesis.speak(msg);

            // Fetch immediately
            fetchQueue();
            setInterval(fetchQueue, 3000);
        }

        function speakText(text, callback) {
            if (!window.speechSynthesis) {
                console.error("Speech synthesis not supported");
                setTimeout(callback, 2000);
                return;
            }

            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 0.85; // Diperlambat sedikit agar lebih jelas
            
            utterance.onend = function() {
                setTimeout(callback, 2000); // Jeda 2 detik setelah suara selesai sebelum memanggil orang berikutnya
            };
            
            utterance.onerror = function(e) {
                console.error("Speech error", e);
                setTimeout(callback, 1000);
            };

            window.speechSynthesis.speak(utterance);
        }

        function processQueue() {
            if (isSpeaking) return;
            if (ttsQueue.length === 0) {
                return;
            }

            isSpeaking = true;
            const item = ttsQueue.shift();
            currentDisplayData = item;
            
            // Update UI
            updateBigScreen(item);
            
            // Beri efek animasi berdenyut
            const panel = document.getElementById('current_call');
            panel.classList.remove('current-call');
            void panel.offsetWidth; // trigger reflow
            panel.classList.add('current-call');

            const textToSpeak = `Panggilan untuk, Bapak atau Ibu ${item.nama_orangtua}, orang tua dari ${item.siswa.nama}, dipersilakan menuju kelas ${item.kelas.nama}`;
            
            speakText(textToSpeak, () => {
                isSpeaking = false;
                processQueue(); // Lanjut ke antrean berikutnya jika ada
            });
        }

        function updateBigScreen(item) {
            document.getElementById('cc_ortu').innerText = item ? item.nama_orangtua : '-';
            document.getElementById('cc_kelas').innerText = item ? item.kelas.nama : '-';
            document.getElementById('cc_anak').innerText = item ? item.siswa.nama : '-';
        }

        function renderWaitingList(data) {
            const listContainer = document.getElementById('queue_list');
            listContainer.innerHTML = '';
            
            // Tampilkan data yang dipanggil, TAPI kecualikan yang sedang tampil di layar utama
            const others = data.filter(d => !currentDisplayData || d.id !== currentDisplayData.id);
            
            if (others.length === 0) {
                listContainer.innerHTML = '<div class="text-sm text-gray-400 italic">Tidak ada antrean lain saat ini.</div>';
                return;
            }

            others.forEach(item => {
                listContainer.innerHTML += `
                    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm min-w-[280px] flex-shrink-0">
                        <div class="text-xl font-bold text-gray-800 truncate mb-1">${item.nama_orangtua}</div>
                        <div class="text-sm text-gray-500 truncate mb-3">Orang tua: ${item.siswa.nama}</div>
                        <div class="text-xs font-bold text-indigo-600 bg-indigo-50 inline-block px-3 py-1.5 rounded-lg uppercase">${item.kelas.nama}</div>
                    </div>
                `;
            });
        }

        function fetchQueue() {
            if (!isStarted) return;

            fetch('/display/data')
                .then(res => res.json())
                .then(data => {
                    // Jika API mengembalikan array kosong, artinya tidak ada tamu sama sekali yang berstatus 'dipanggil'
                    if (data.length === 0) {
                        if (!isSpeaking && ttsQueue.length === 0) {
                            currentDisplayData = null;
                            updateBigScreen(null);
                            document.getElementById('current_call').classList.remove('current-call');
                        }
                    } else {
                        // Jika ada data baru yang belum pernah dibacakan, masukkan ke TTS Queue
                        data.forEach(item => {
                            if (!spokenIds.includes(item.id)) {
                                spokenIds.push(item.id);
                                ttsQueue.push(item);
                            }
                        });
                        
                        // Jika tidak ada antrean suara yang berjalan dan tidak ada suara yang aktif, 
                        // pastikan layar utama menampilkan setidaknya 1 tamu yang sedang dipanggil
                        if (!isSpeaking && ttsQueue.length === 0 && !currentDisplayData) {
                             currentDisplayData = data[data.length - 1]; // Ambil yang paling terakhir dipanggil
                             updateBigScreen(currentDisplayData);
                        }
                    }

                    // Update UI list antrean kecil di bawah
                    renderWaitingList(data);

                    // Jalankan pemroses antrean (jika belum jalan)
                    processQueue();
                })
                .catch(err => console.error("Error fetching data:", err));
        }
    </script>
</body>
</html>
