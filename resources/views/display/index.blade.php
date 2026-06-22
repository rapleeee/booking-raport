<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Queue - Pengambilan Raport</title>
    <meta name="description" content="Sistem Antrean dan Pengambilan Raport SMK Pesat IT Xpro.">
    <meta property="og:image" content="{{ asset('logo.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
    @theme {
        --font-sans: 'Geist', ui-sans-serif, system-ui, sans-serif;
    }
    </style>
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Geist', ui-sans-serif, system-ui, sans-serif;
            background: #fafafa;
            color: #09090b;
            overflow: hidden;
            margin: 0;
        }

        /* ── Overlay ── */
        #start_overlay {
            position: fixed; inset: 0;
            background: #09090b;
            z-index: 50;
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
        }

        /* ── Header ── */
        .header-bar {
            background: #ffffff;
            border-bottom: 1px solid #e4e4e7;
            color: #09090b;
        }

        /* ── Main Call Card ── */
        .main-call-card {
            background: #18181b;
            border-radius: 12px;
            border: 1px solid #27272a;
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }
        .main-call-card.is-calling {
            border-color: #52525b;
        }
        @keyframes fadePulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.85; }
        }
        .main-call-active {
            animation: fadePulse 2.5s ease-in-out infinite;
        }

        /* ── Kelas Cards ── */
        .kelas-card {
            background: #ffffff;
            border: 1px solid #e4e4e7;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .kelas-card.is-active {
            border-color: #a1a1aa;
        }

        /* Card illustration strip */
        .card-illust {
            height: 52%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-illust .cname {
            position: relative;
            z-index: 2;
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.01em;
        }

        /* Muted solid backgrounds per kelas — no gradient */
        .ct0 { background: #18181b; }
        .ct1 { background: #27272a; }
        .ct2 { background: #3f3f46; }
        .ct3 { background: #52525b; }
        .ct4 { background: #1c1917; }
        .ct5 { background: #292524; }
        .ct6 { background: #1e1b4b; }
        .ct7 { background: #172554; }

        .card-body { padding: 10px 14px; flex: 1; display: flex; flex-direction: column; gap: 5px; }

        /* Status badges — shadcn style */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 10px;
            font-weight: 600;
            border: 1px solid;
            line-height: 1.6;
        }
        .status-pill.serving  { background: #fefce8; color: #713f12; border-color: #fef08a; }
        .status-pill.waiting  { background: #f4f4f5; color: #3f3f46; border-color: #e4e4e7; }
        .status-pill.empty    { background: #ffffff;  color: #a1a1aa; border-color: #f4f4f5; }
        .status-pill .dot     { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
        .status-pill.serving .dot  { background: #ca8a04; }
        .status-pill.waiting .dot  { background: #71717a; }
        .status-pill.empty   .dot  { background: #d4d4d8; }

        .card-detail { font-size: 10px; color: #71717a; display: flex; align-items: center; gap: 4px; }
        .card-detail svg { width: 11px; height: 11px; flex-shrink: 0; }

        .qmini { display: flex; flex-wrap: wrap; gap: 3px; margin-top: 2px; }
        .qmini span {
            background: #f4f4f5;
            border-radius: 4px;
            padding: 1px 6px;
            font-size: 9px;
            font-weight: 600;
            color: #3f3f46;
            max-width: 90px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            border: 1px solid #e4e4e7;
        }
        .qmini span.called { background: #fef9c3; color: #713f12; border-color: #fef08a; }
        .qmini span.more   { background: #18181b; color: #ffffff; border-color: #18181b; }

        .att-row { display: flex; align-items: center; gap: 4px; font-size: 10px; font-weight: 600; color: #52525b; }
        .att-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }

        /* YouTube box */
        .yt-box { border-radius: 12px; overflow: hidden; border: 1px solid #e4e4e7; background: #000; }

        /* Live indicator */
        .live-dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
        .live-dot.active { background: #16a34a; }
        .live-dot.idle   { background: #d4d4d8; }
        @keyframes liveBlink { 0%,100%{opacity:1} 50%{opacity:0.4} }
        .live-dot.active { animation: liveBlink 2s infinite; }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- Start Overlay -->
    <div id="start_overlay">
        <div class="text-center px-8" style="max-width:420px;">
            <div style="width:56px;height:56px;background:#27272a;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
                <svg width="28" height="28" fill="none" stroke="#a1a1aa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828-2.828"/></svg>
            </div>
            <h2 style="color:#fafafa;font-size:1.5rem;font-weight:700;margin:0 0 8px;letter-spacing:-0.03em;">Sistem Antrean Suara</h2>
            <p style="color:#71717a;font-size:0.875rem;line-height:1.6;margin:0 0 28px;">Klik tombol di bawah untuk mengaktifkan display dan suara pemanggilan antrean.</p>
            <button onclick="startDisplay()" style="background:#fafafa;color:#09090b;padding:10px 28px;border-radius:8px;font-size:0.9rem;font-weight:600;border:none;cursor:pointer;letter-spacing:-0.01em;">
                Mulai Display
            </button>
        </div>
    </div>

    <!-- Header -->
    <header class="header-bar px-6 py-3 flex justify-between items-center z-10">
        <div class="flex items-center gap-3">
            <img src="{{ asset('logo.png') }}" alt="Logo" style="width:32px;height:32px;object-fit:contain;border-radius:6px;border:1px solid #e4e4e7;">
            <div>
                <h1 style="font-size:0.9rem;font-weight:700;color:#09090b;letter-spacing:-0.02em;margin:0;">Antrean Pengambilan Raport</h1>
                <p style="font-size:0.7rem;color:#71717a;margin:0;font-weight:500;">SMK Pesat IT Xpro</p>
            </div>
        </div>
        <div class="flex items-center gap-5">
            <div class="flex items-center gap-2">
                <span class="live-dot active" id="status_dot"></span>
                <span style="font-size:0.75rem;font-weight:500;color:#71717a;" id="status_text">Live</span>
            </div>
            <div style="font-size:1.2rem;font-weight:700;color:#09090b;font-variant-numeric:tabular-nums;letter-spacing:-0.02em;" id="clock">10:00</div>
        </div>
    </header>

    <!-- Main Layout -->
    <main style="flex:1;padding:16px;display:flex;gap:16px;height:calc(100vh - 57px);overflow:hidden;">

        <!-- Left: Call Card + Grid -->
        <div style="flex:1;display:flex;flex-direction:column;gap:16px;min-height:0;">

            <!-- Main Call Card -->
            <div class="main-call-card" style="height:38%;padding:32px;display:flex;align-items:center;justify-content:center;flex-shrink:0;" id="current_call">
                <div id="call_content" style="text-align:center;width:100%;position:relative;z-index:1;">
                    <p style="font-size:0.65rem;font-weight:600;letter-spacing:0.15em;text-transform:uppercase;color:#71717a;margin:0 0 12px;">Sedang Dipanggil</p>
                    <div style="font-size:2.4rem;font-weight:700;letter-spacing:-0.04em;line-height:1.1;margin-bottom:12px;color:#fafafa;" id="cc_ortu">Menunggu Panggilan...</div>
                    <div style="display:flex;align-items:center;justify-content:center;gap:8px;flex-wrap:wrap;margin-bottom:14px;">
                        <span style="font-size:0.85rem;color:#71717a;">Orang tua dari</span>
                        <span style="font-size:0.95rem;font-weight:600;color:#e4e4e7;" id="cc_anak">-</span>
                    </div>
                    <span style="display:inline-block;background:#27272a;color:#a1a1aa;padding:5px 16px;border-radius:6px;font-size:0.8rem;font-weight:600;border:1px solid #3f3f46;" id="cc_kelas">-</span>
                </div>
            </div>

            <!-- Kelas Grid -->
            <div style="flex:1;min-height:0;overflow:hidden;">
                <div style="display:grid;grid-template-columns:repeat(3,1fr);grid-template-rows:repeat(2,1fr);gap:12px;height:100%;" id="kelas_grid"></div>
            </div>
        </div>

        <!-- Right: YouTube -->
        <div class="yt-box" style="width:34%;flex-shrink:0;">
            <iframe
                src="https://www.youtube.com/embed/zoQsS9_Qhpw?autoplay=1&mute=1&loop=1&playlist=zoQsS9_Qhpw&controls=0&showinfo=0&rel=0&modestbranding=1"
                title="YouTube" frameborder="0"
                allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture"
                style="width:100%;height:100%;display:block;">
            </iframe>
        </div>
    </main>

    <script>
        let isStarted=false, spokenIds=[], ttsQueue=[], isSpeaking=false, currentDisplayData=null;

        function updateClock(){const n=new Date();document.getElementById('clock').innerText=n.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});}
        setInterval(updateClock,1000);updateClock();

        function startDisplay(){
            document.getElementById('start_overlay').style.display='none';
            isStarted=true;
            let m=new SpeechSynthesisUtterance('');m.volume=0;window.speechSynthesis.speak(m);
            fetchQueue();setInterval(fetchQueue,3000);
        }

        function speakText(t,cb){
            if(!window.speechSynthesis){setTimeout(cb,2000);return;}
            const u=new SpeechSynthesisUtterance(t);u.lang='id-ID';u.rate=0.85;
            u.onend=()=>setTimeout(cb,2000);
            u.onerror=e=>{console.error(e);setTimeout(cb,1000);};
            window.speechSynthesis.speak(u);
        }

        function processQueue(){
            if(isSpeaking||ttsQueue.length===0)return;
            isSpeaking=true;
            const item=ttsQueue.shift();
            currentDisplayData=item;
            updateBigScreen(item);
            const p=document.getElementById('current_call');
            p.classList.remove('main-call-active');void p.offsetWidth;p.classList.add('main-call-active');
            speakText(`Panggilan untuk, Bapak atau Ibu ${item.nama_orangtua}, orang tua dari ${item.siswa.nama}, dipersilakan menuju kelas ${item.kelas.nama}`,()=>{isSpeaking=false;processQueue();});
        }

        function updateBigScreen(item){
            const c=document.getElementById('current_call');
            const dot=document.getElementById('status_dot');
            const txt=document.getElementById('status_text');
            const kCard=document.getElementById('cc_kelas');
            if(item){
                document.getElementById('cc_ortu').innerText=item.nama_orangtua;
                document.getElementById('cc_anak').innerText=item.siswa.nama;
                kCard.innerText='Kelas '+item.kelas.nama;
                kCard.style.cssText='display:inline-block;background:#fef9c3;color:#713f12;padding:5px 16px;border-radius:6px;font-size:0.8rem;font-weight:600;border:1px solid #fef08a;';
                c.classList.add('main-call-active');
                dot.className='live-dot active';
                txt.innerText='Sedang Memanggil';
            } else {
                document.getElementById('cc_ortu').innerText='Menunggu Panggilan...';
                document.getElementById('cc_anak').innerText='-';
                kCard.innerText='-';
                kCard.style.cssText='display:inline-block;background:#27272a;color:#a1a1aa;padding:5px 16px;border-radius:6px;font-size:0.8rem;font-weight:600;border:1px solid #3f3f46;';
                c.classList.remove('main-call-active');
                dot.className='live-dot idle';
                txt.innerText='Menunggu';
            }
        }

        function renderKelasCards(kelasData){
            const grid=document.getElementById('kelas_grid');
            grid.innerHTML='';
            kelasData.forEach((k,i)=>{
                const hq=k.count>0;
                const isCur=currentDisplayData&&currentDisplayData.kelas_id===k.id;
                const isAct=isCur&&isSpeaking;
                let pill='';
                if(isAct)   pill='<span class="status-pill serving"><span class="dot"></span>Melayani</span>';
                else if(hq) pill=`<span class="status-pill waiting"><span class="dot"></span>${k.count} Menunggu</span>`;
                else         pill='<span class="status-pill empty"><span class="dot"></span>Kosong</span>';

                let qm='';
                if(k.queue&&k.queue.length>0){
                    const items=k.queue.slice(0,3).map(q=>{
                        const ic=currentDisplayData&&currentDisplayData.id===q.id;
                        return `<span class="${ic?'called':''}">${q.nama_orangtua.split(' ')[0]}</span>`;
                    }).join('');
                    const more=k.queue.length>3?`<span class="more">+${k.queue.length-3}</span>`:'';
                    qm=`<div class="qmini">${items}${more}</div>`;
                }

                const room=k.ruangan||'Ruang belum diatur';
                grid.innerHTML+=`
                    <div class="kelas-card ${isAct?'is-active':''}">
                        <div class="card-illust ct${i%8}">
                            <span class="cname">Kelas ${k.nama}</span>
                        </div>
                        <div class="card-body">
                            <div style="display:flex;align-items:center;justify-content:space-between;">
                                ${pill}
                                <div style="display:flex;gap:10px;">
                                    <span class="att-row"><span class="att-dot" style="background:#6366f1;"></span>${k.hadir_count}</span>
                                    <span class="att-row"><span class="att-dot" style="background:#16a34a;"></span>${k.selesai_count}</span>
                                </div>
                            </div>
                            <div class="card-detail">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                ${room}
                            </div>
                            ${qm}
                        </div>
                    </div>`;
            });
        }

        function fetchQueue(){
            if(!isStarted)return;
            fetch('/display/data').then(r=>r.json()).then(data=>{
                const bookings=data.bookings, kelas=data.kelas;
                if(bookings.length===0){
                    if(!isSpeaking&&ttsQueue.length===0){currentDisplayData=null;updateBigScreen(null);}
                } else {
                    bookings.forEach(item=>{if(!spokenIds.includes(item.id)){spokenIds.push(item.id);ttsQueue.push(item);}});
                    if(!isSpeaking&&ttsQueue.length===0&&!currentDisplayData){currentDisplayData=bookings[bookings.length-1];updateBigScreen(currentDisplayData);}
                }
                renderKelasCards(kelas);processQueue();
            }).catch(err=>console.error("Fetch error:",err));
        }
    </script>
</body>
</html>
