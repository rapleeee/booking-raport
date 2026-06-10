<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Booking</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
    @theme {
        --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
    }
    </style>
    <style>
        .confirm-page { font-family: sans-serif; background: #f5f7fa; min-height: 100vh; padding-bottom: 100px; }
        .top-bar { background: white; padding: 16px 20px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #e5e7eb; }
        .back-btn { width: 34px; height: 34px; border-radius: 50%; border: 1px solid #e5e7eb; background: white; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; }
        .hero-card { margin: 20px 16px 0; background: white; border-radius: 18px; border: 1px solid #e5e7eb; overflow: hidden; }
        .hero-banner { background: #4369a8; padding: 20px; display: flex; align-items: center; gap: 14px; }
        .studio-icon { width: 48px; height: 48px; border-radius: 12px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .hero-info .label { font-size: 11px; color: rgba(255,255,255,0.7); font-weight: 500; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 2px; }
        .hero-info .room { font-size: 17px; font-weight: 700; color: white; }
        .hero-info .teacher { font-size: 13px; color: rgba(255,255,255,0.85); margin-top: 2px; }
        .status-badge { display: inline-flex; align-items: center; gap: 5px; background: rgba(255,255,255,0.25); border-radius: 99px; padding: 3px 10px; }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; background: #6ee7b7; }
        .status-txt { font-size: 11px; color: rgba(255,255,255,0.95); font-weight: 500; }
        .detail-rows { padding: 4px 20px; display: flex; flex-direction: column; }
        .detail-row { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f3f4f6; }
        .detail-row:last-child { border-bottom: none; }
        .row-icon { width: 32px; height: 32px; border-radius: 8px; background: #eef2f9; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .row-label { font-size: 11px; color: #9ca3af; font-weight: 500; text-transform: uppercase; letter-spacing: 0.04em; }
        .row-value { font-size: 14px; font-weight: 600; color: #1f2937; margin-top: 1px; }
        .section-title { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.07em; margin: 20px 20px 8px; }
        .info-card { margin: 0 16px; background: white; border-radius: 18px; border: 1px solid #e5e7eb; padding: 4px 0; }
        .notice-card { margin: 16px 16px 0; background: #fffbeb; border-radius: 14px; border: 1px solid #fcd34d; padding: 12px 16px; display: flex; gap: 10px; align-items: flex-start; }
        .notice-text { font-size: 12px; color: #92400e; line-height: 1.6; }
        .avatar { width: 36px; height: 36px; border-radius: 50%; background: #dce6f6; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: #4369a8; flex-shrink: 0; }
        .fixed-bottom { position: fixed; bottom: 0; left: 0; right: 0; background: white; border-top: 1px solid #f3f4f6; padding: 14px 20px; }
        .confirm-btn { width: 100%; background: #4369a8; color: white; border: none; border-radius: 14px; padding: 15px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.15s; }
        .confirm-btn:hover { background: #355490; }
        .confirm-btn:active { transform: scale(0.98); }
        .max-w { max-width: 28rem; margin: 0 auto; }
    </style>
</head>
<body>
<div class="confirm-page">

    <!-- Top Bar -->
    <div class="top-bar">
        <a href="{{ url()->previous() }}" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#4369a8" class="w-5 h-5" style="width:18px;height:18px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </a>
        <span style="font-size:16px; font-weight:600; color:#1f2937;">Konfirmasi Booking</span>
    </div>

    <div class="max-w" style="padding-bottom: 100px;">

        <!-- Studio Card -->
        <div class="hero-card">
            <div class="hero-banner">
                <div class="studio-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" style="width:26px;height:26px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-1.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                </div>
                <div class="hero-info" style="flex:1;">
                    <div class="label">Ruang</div>
                    <div class="room">{{ $kelas->nama }}</div>
                    <div class="teacher">Wali Kelas: <strong style="color:white;">{{ $kelas->waliKelas->nama ?? '-' }}</strong></div>
                </div>
                <div class="status-badge">
                    <div class="status-dot"></div>
                    <span class="status-txt">Tersedia</span>
                </div>
            </div>
            <div class="detail-rows">
                <div class="detail-row">
                    <div class="row-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#4369a8" style="width:18px;height:18px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </div>
                    <div>
                        <div class="row-label">Tanggal</div>
                        <div class="row-value">{{ \Carbon\Carbon::parse($data['tanggal_booking'])->format('d M Y') }}</div>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="row-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#4369a8" style="width:18px;height:18px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="row-label">Jam</div>
                        <div class="row-value">{{ $data['jam_booking'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Peserta -->
        <p class="section-title">Data Peserta</p>
        <div class="info-card">
            <div class="detail-rows">
                <div class="detail-row">
                    <div class="avatar">{{ strtoupper(substr($data['nama_orangtua'], 0, 2)) }}</div>
                    <div>
                        <div class="row-label">Nama Orang Tua</div>
                        <div class="row-value">{{ $data['nama_orangtua'] }}</div>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="row-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#4369a8" style="width:18px;height:18px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="row-label">Nama Anak</div>
                        <div class="row-value">{{ $siswa->nama }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notice -->
        <div class="notice-card">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#d97706" style="width:20px;height:20px;flex-shrink:0;margin-top:1px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
            <div class="notice-text">
                Harap hadir <strong>10 menit</strong> sebelum waktu yang ditentukan. 
            </div>
        </div>

    </div>

    <!-- Bottom Button -->
    <div class="fixed-bottom">
        <div class="max-w">
            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <button type="submit" class="confirm-btn">Konfirmasi Booking</button>
            </form>
        </div>
    </div>

</div>
</body>
</html>