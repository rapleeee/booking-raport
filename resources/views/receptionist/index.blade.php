<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionist Scan</title>
    @vite('resources/css/app.css')
    <!-- HTML5 QR Code Scanner -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <div class="bg-[#4369a8] p-6 text-center shadow-md">
        <h1 class="text-white text-2xl font-bold tracking-wide">Resepsionis - Scan Tiket</h1>
    </div>

    <div class="flex-1 flex flex-col items-center justify-center p-6">
        <div class="w-full max-w-md bg-white rounded-3xl shadow-xl overflow-hidden p-6 border border-gray-100">
            <div class="mb-4 hidden" id="camera-select-container">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Pilih Kamera</label>
                <select id="camera-select" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">
                </select>
            </div>

            <div id="reader" class="w-full mb-6 rounded-2xl overflow-hidden border-2 border-dashed border-gray-300"></div>

            <div class="text-center mb-6">
                <span class="text-gray-400 text-sm font-semibold uppercase tracking-widest">Atau input manual</span>
            </div>

            <form id="manualForm" class="flex gap-2">
                <input type="text" id="manualCode" placeholder="Masukkan Kode (ex: BK-25...)" 
                    class="flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-[#4369a8]">
                <button type="submit" class="bg-[#4369a8] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#355490]">Proses</button>
            </form>
        </div>
    </div>

    <script>
        function processCode(code) {
            fetch('{{ route('receptionist.scan') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code: code })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: `Check-in sukses: ${data.booking.nama_orangtua} (${data.booking.kelas.nama})`,
                        timer: 3000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message,
                    });
                }
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem.'
                });
            });
        }

        document.getElementById('manualForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const code = document.getElementById('manualCode').value;
            if(code) {
                processCode(code);
                document.getElementById('manualCode').value = '';
            }
        });

        let html5QrCode = new Html5Qrcode("reader");
        const config = { fps: 10, qrbox: { width: 250, height: 250 } };
        let currentCameraId = null;

        function onScanSuccess(decodedText, decodedResult) {
            // Stop scanning to process
            html5QrCode.stop().then(() => {
                processCode(decodedText);
                // Resume after 3 seconds
                setTimeout(() => {
                    startScanner(currentCameraId);
                }, 3000);
            }).catch(err => console.log(err));
        }

        function startScanner(cameraId) {
            currentCameraId = cameraId;
            html5QrCode.start(
                cameraId, 
                config, 
                onScanSuccess
            ).catch(err => {
                console.error("Error starting scanner:", err);
                document.getElementById('reader').innerHTML = '<p class="text-center text-red-500 py-10 font-medium">Kamera tidak dapat diakses.</p>';
            });
        }

        // Fetch cameras and populate select
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                document.getElementById('camera-select-container').classList.remove('hidden');
                const selectElement = document.getElementById('camera-select');
                
                devices.forEach(device => {
                    const option = document.createElement('option');
                    option.value = device.id;
                    option.text = device.label || `Camera ${selectElement.length + 1}`;
                    selectElement.appendChild(option);
                });

                // Start with the first camera (usually back camera on phones, or webcam on PC)
                let initialCamera = devices[0].id;
                // Try to find a back camera if available
                const backCamera = devices.find(d => d.label.toLowerCase().includes('back') || d.label.toLowerCase().includes('environment'));
                if (backCamera) initialCamera = backCamera.id;
                
                selectElement.value = initialCamera;
                startScanner(initialCamera);

                // Handle camera change
                selectElement.addEventListener('change', (e) => {
                    if (html5QrCode.isScanning) {
                        html5QrCode.stop().then(() => {
                            startScanner(e.target.value);
                        });
                    } else {
                        startScanner(e.target.value);
                    }
                });

            } else {
                document.getElementById('reader').innerHTML = '<p class="text-center text-red-500 py-10 font-medium">Tidak ada kamera ditemukan.</p>';
            }
        }).catch(err => {
            console.error("Error getting cameras:", err);
            // Fallback just in case
            html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess)
                .catch(e => html5QrCode.start({ facingMode: "user" }, config, onScanSuccess));
        });
    </script>
</body>
</html>
