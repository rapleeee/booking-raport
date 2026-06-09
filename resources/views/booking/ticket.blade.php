<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
      * { box-sizing: border-box; margin: 0; padding: 0; }
      body { font-family: var(--font-sans, sans-serif); }
      .wrap { background: #f0f2f5; padding: 24px 16px 32px; display: flex; flex-direction: column; align-items: center; gap: 16px; }
      .ticket { width: 100%; max-width: 340px; background: #1a1a2e; border-radius: 24px; overflow: hidden; }
      .ticket-header { background: #4369a8; padding: 22px 22px 18px; }
      .th-label { font-size: 10px; color: rgba(255,255,255,0.6); letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 4px; }
      .th-name { font-size: 22px; font-weight: 700; color: #fff; letter-spacing: -0.3px; }
      .th-meta { display: flex; gap: 16px; margin-top: 14px; }
      .th-meta-item { display: flex; flex-direction: column; gap: 2px; }
      .th-meta-item .lbl { font-size: 9px; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.07em; }
      .th-meta-item .val { font-size: 13px; font-weight: 700; color: #fff; }
      .divider { position: relative; display: flex; align-items: center; }
      .divider-line { flex: 1; height: 1px; border-top: 1.5px dashed rgba(255,255,255,0.15); }
      .divider-cut { width: 22px; height: 22px; border-radius: 50%; background: #f0f2f5; flex-shrink: 0; }
      .ticket-body { padding: 18px 22px; }
      .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 18px; }
      .info-item .lbl { font-size: 9px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 3px; }
      .info-item .val { font-size: 13px; font-weight: 600; color: #fff; }
      .info-item .val.big { font-size: 22px; font-weight: 700; color: #fff; letter-spacing: 1px; font-variant-numeric: tabular-nums; }
      .countdown-box { background: rgba(255,255,255,0.06); border-radius: 12px; padding: 12px 14px; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between; }
      .cd-label { font-size: 9px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 4px; }
      .cd-time { font-size: 20px; font-weight: 700; color: #fff; letter-spacing: 2px; font-variant-numeric: tabular-nums; }
      .cd-schedule { font-size: 11px; color: rgba(255,255,255,0.5); }
      .qr-section { background: #fff; border-radius: 14px; padding: 14px; display: flex; flex-direction: column; align-items: center; gap: 10px; }
      .qr-label { font-size: 10px; color: #888; text-transform: uppercase; letter-spacing: 0.07em; }
      canvas#qr { width: 120px; height: 120px; image-rendering: pixelated; }
      .booking-code { font-size: 12px; font-weight: 700; color: #1a1a2e; letter-spacing: 3px; }
      .status-pill { display: inline-flex; align-items: center; gap: 5px; background: rgba(110,231,183,0.15); border-radius: 99px; padding: 5px 12px; }
      .status-dot { width: 7px; height: 7px; border-radius: 50%; background: #6ee7b7; }
      .status-txt { font-size: 11px; color: #6ee7b7; font-weight: 600; }
      .save-btn { width: 100%; max-width: 340px; background: #4369a8; color: #fff; border: none; border-radius: 14px; padding: 14px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; }
    </style>
</head>
<body>
    

<div class="wrap">
  <div class="ticket">
    <div class="ticket-header">
      <div class="th-label">Booking Appointment</div>
      <div class="th-name">{{ $booking->nama_orangtua }}</div>
      <div class="th-meta">
        <div class="th-meta-item"><span class="lbl">Ruangan</span><span class="val">{{ $booking->kelas->nama }}</span></div>
        <div class="th-meta-item"><span class="lbl">Wali Kelas</span><span class="val">{{ $booking->kelas->waliKelas->nama ?? '-' }}</span></div>
        <div class="th-meta-item"><span class="lbl">Anak</span><span class="val">{{ $booking->siswa->nama }}</span></div>
      </div>
    </div>

    <div class="divider">
      <div class="divider-cut" style="margin-left:-11px;"></div>
      <div class="divider-line"></div>
      <div class="divider-cut" style="margin-right:-11px;"></div>
    </div>

    <div class="ticket-body">
      <div class="info-grid">
        <div class="info-item"><div class="lbl">Tanggal</div><div class="val">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d F Y') }}</div></div>
        <div class="info-item"><div class="lbl">Jam</div><div class="val big" id="jam-display">{{ date('H:i', strtotime($booking->jam_booking)) }}</div></div>
        <div class="info-item"><div class="lbl">Nama Anak</div><div class="val">{{ $booking->siswa->nama }}</div></div>
        <div class="info-item"><div class="lbl">Status</div>
          <div class="status-pill" style="margin-top:2px;">
            <div class="status-dot"></div>
            <span class="status-txt">{{ ucfirst($booking->status) }}</span>
          </div>
        </div>
      </div>

      <div class="countdown-box" style="display:none;">
        <div>
          <div class="cd-label">Hitung mundur</div>
          <div class="cd-time" id="countdown">--:--:--</div>
        </div>
        <div style="text-align:right;">
          <div class="cd-label">Jadwal masuk</div>
          <div class="cd-schedule">{{ date('H:i', strtotime('-10 minutes', strtotime($booking->jam_booking))) }}</div>
        </div>
      </div>

      <div class="qr-section">
        <div class="qr-label">Tunjukkan tiket ini</div>
        <canvas id="qr" width="120" height="120"></canvas>
        <div class="booking-code" id="bcode">{{ $booking->unique_code }}</div>
      </div>
    </div>
  </div>

  <button class="save-btn" onclick="window.print()">
    Simpan Tiket / Screenshot
  </button>
  <a href="/" class="save-btn" style="background:#fff; color:#4369a8; text-decoration:none; margin-top: -8px;">
    Kembali ke Beranda
  </a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script>
  (function() {
    new QRious({
      element: document.getElementById('qr'),
      value: '{{ $booking->unique_code }}',
      size: 120,
      background: '#ffffff',
      foreground: '#1a1a2e',
      level: 'M'
    });
  })();
</script>

</body>
</html>