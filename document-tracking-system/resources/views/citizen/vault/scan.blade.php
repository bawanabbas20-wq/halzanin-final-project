@extends('layouts.halzanin-app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6" x-data="documentScanner()">
    
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit">Scan Document</h2>
        <a href="{{ route('citizen.vault.index') }}" class="text-sm font-semibold text-gray-500 hover:text-brand dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">
            Cancel
        </a>
    </div>

    <!-- Scanner Interface -->
    <div class="bg-black rounded-[16px] overflow-hidden relative shadow-lg aspect-[3/4] sm:aspect-auto sm:h-[500px]">
        <!-- Video Stream -->
        <video x-ref="video" class="w-full h-full object-cover" autoplay playsinline></video>
        
        <!-- Document Frame Overlay -->
        <div class="absolute inset-0 z-10 pointer-events-none border-[40px] border-black/50 flex items-center justify-center">
            <div class="w-full h-full border-2 border-white/50 rounded-lg relative">
                <!-- Corner markers -->
                <div class="absolute top-0 left-0 w-6 h-6 border-t-4 border-l-4 border-brand -mt-1 -ml-1"></div>
                <div class="absolute top-0 right-0 w-6 h-6 border-t-4 border-r-4 border-brand -mt-1 -mr-1"></div>
                <div class="absolute bottom-0 left-0 w-6 h-6 border-b-4 border-l-4 border-brand -mb-1 -ml-1"></div>
                <div class="absolute bottom-0 right-0 w-6 h-6 border-b-4 border-r-4 border-brand -mb-1 -mr-1"></div>
                
                <div class="absolute inset-0 flex items-center justify-center">
                    <p class="text-white/70 font-semibold bg-black/50 px-4 py-2 rounded-full text-sm backdrop-blur-sm" x-show="!isCaptured">
                        Position document within frame
                    </p>
                </div>
            </div>
        </div>

        <!-- Captured Image Preview (Hidden initially) -->
        <canvas x-ref="canvas" class="hidden"></canvas>
        <img x-ref="preview" class="absolute inset-0 w-full h-full object-contain bg-black z-20" x-show="isCaptured" style="display: none;" />

        <!-- Scanner Controls -->
        <div class="absolute bottom-0 inset-x-0 p-6 flex justify-center z-30 bg-gradient-to-t from-black/80 to-transparent">
            <!-- Capture Button -->
            <button type="button" x-show="!isCaptured" @click="captureImage" class="w-16 h-16 rounded-full bg-white/20 border-4 border-white flex items-center justify-center hover:bg-white/40 transition-colors focus:outline-none">
                <div class="w-12 h-12 rounded-full bg-white"></div>
            </button>

            <!-- Actions after capture -->
            <div x-show="isCaptured" class="flex gap-4 w-full" style="display: none;">
                <button type="button" @click="retake" class="flex-1 px-4 py-3 bg-gray-800 text-white font-semibold rounded-[10px] hover:bg-gray-700 transition-colors">
                    Retake
                </button>
                <button type="button" @click="saveDocument" :disabled="isSaving" class="flex-1 px-4 py-3 bg-brand text-white font-semibold rounded-[10px] hover:bg-brand-light transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center">
                    <span x-show="!isSaving">Save Securely</span>
                    <svg x-show="isSaving" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Enhancement Filters (CamScanner-Style) -->
    <div x-show="isCaptured" class="bg-white dark:bg-[#1e293b] p-4 rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 flex justify-around gap-2 animate-fade-up" style="display: none;">
        <button type="button" @click="applyFilter('original')" :class="activeFilter === 'original' ? 'bg-brand text-white' : 'bg-gray-100 text-gray-700 dark:bg-slate-800 dark:text-gray-300'" class="flex-1 px-3 py-2 text-xs font-bold rounded-lg transition-all">
            Original
        </button>
        <button type="button" @click="applyFilter('magic')" :class="activeFilter === 'magic' ? 'bg-brand text-white' : 'bg-gray-100 text-gray-700 dark:bg-slate-800 dark:text-gray-300'" class="flex-1 px-3 py-2 text-xs font-bold rounded-lg transition-all flex items-center justify-center gap-1">
            Magic Scan ✨
        </button>
        <button type="button" @click="applyFilter('bw')" :class="activeFilter === 'bw' ? 'bg-brand text-white' : 'bg-gray-100 text-gray-700 dark:bg-slate-800 dark:text-gray-300'" class="flex-1 px-3 py-2 text-xs font-bold rounded-lg transition-all flex items-center justify-center gap-1">
            B&W Doc 📝
        </button>
    </div>

    <!-- Document Details Form -->
    <div class="bg-white dark:bg-[#1e293b] p-6 rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800" x-show="isCaptured" style="display: none;">
        <h3 class="font-bold text-gray-900 dark:text-white mb-4">Document Details</h3>
        
        <div x-show="errorMessage" class="mb-4 bg-red-50 text-red-600 p-3 rounded-lg text-sm" x-text="errorMessage" style="display: none;"></div>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Document Type</label>
                <select x-model="documentType" class="block w-full h-[48px] px-4 rounded-[10px] border-gray-300 dark:border-gray-600 dark:bg-[#0f172a] dark:text-white focus:border-brand focus:ring-0">
                    <option value="" disabled>Select document type...</option>
                    <option value="Passport">Passport</option>
                    <option value="National ID">National ID</option>
                    <option value="Driver License">Driver License</option>
                    <option value="Other">Other Document</option>
                </select>
            </div>
            
            <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-brand shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <div class="text-sm text-gray-700 dark:text-gray-300">
                    <strong>Secure Storage Guarantee:</strong> This document will be encrypted before it leaves your device. It cannot be viewed by staff and will auto-delete in 100 days.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function documentScanner() {
    return {
        stream: null,
        isCaptured: false,
        isSaving: false,
        documentType: 'National ID',
        capturedImageData: null,
        errorMessage: '',
        activeFilter: 'magic', // Default to magic scan
        originalImageData: null,

        init() {
            this.startCamera();
        },

        async startCamera() {
            try {
                this.stream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'environment', width: { ideal: 1920 }, height: { ideal: 1080 } }
                });
                this.$refs.video.srcObject = this.stream;
            } catch (err) {
                console.error("Error accessing camera:", err);
                alert("Camera access is required to scan documents.");
            }
        },

        stopCamera() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
            }
        },

        captureImage() {
            const video = this.$refs.video;
            const canvas = this.$refs.canvas;
            const ctx = canvas.getContext('2d');

            // 1. Optimize Resolution (Resize to maximum 1200px dimension for performance & crispness)
            let w = video.videoWidth;
            let h = video.videoHeight;
            const maxDim = 1200;
            if (w > maxDim || h > maxDim) {
                if (w > h) {
                    h = Math.round((h * maxDim) / w);
                    w = maxDim;
                } else {
                    w = Math.round((w * maxDim) / h);
                    h = maxDim;
                }
            }

            canvas.width = w;
            canvas.height = h;

            // Draw original camera feed to canvas
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Store the unenhanced raw pixel data
            this.originalImageData = ctx.getImageData(0, 0, canvas.width, canvas.height);

            // 2. Apply default "Magic Scan" preset
            this.isCaptured = true;
            this.activeFilter = 'magic';
            this.applyFilter('magic');

            this.stopCamera();
        },

        applyFilter(filterType) {
            this.activeFilter = filterType;
            const canvas = this.$refs.canvas;
            const ctx = canvas.getContext('2d');

            // Reset canvas to original capture before applying any filters
            ctx.putImageData(this.originalImageData, 0, 0);

            if (filterType === 'magic') {
                const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const data = imgData.data;
                
                // A. Compute Auto-levels min/max limits (Auto White Balance & Exposure stretch)
                let minR = 255, maxR = 0;
                let minG = 255, maxG = 0;
                let minB = 255, maxB = 0;

                // Sample every 32nd pixel for instant processing
                for (let i = 0; i < data.length; i += 128) {
                    const r = data[i];
                    const g = data[i+1];
                    const b = data[i+2];
                    if (r < minR) minR = r;
                    if (r > maxR) maxR = r;
                    if (g < minG) minG = g;
                    if (g > maxG) maxG = g;
                    if (b < minB) minB = b;
                    if (b > maxB) maxB = b;
                }

                // Avoid division by zero
                const rangeR = Math.max(1, maxR - minR);
                const rangeG = Math.max(1, maxG - minG);
                const rangeB = Math.max(1, maxB - minB);

                // B. Run Dynamic Contrast, Brightness & Saturation Stretch Pass
                for (let i = 0; i < data.length; i += 4) {
                    // Normalize & Stretch levels
                    let r = ((data[i] - minR) * 255) / rangeR;
                    let g = ((data[i+1] - minG) * 255) / rangeG;
                    let b = ((data[i+2] - minB) * 255) / rangeB;

                    // Boosting Contrast & Brightness (Magic factor)
                    const contrast = 1.4;
                    const brightness = 1.15; // Brightens up dark camera shadows perfectly
                    
                    r = (r - 128) * contrast + 128 * brightness;
                    g = (g - 128) * contrast + 128 * brightness;
                    b = (b - 128) * contrast + 128 * brightness;

                    // Saturation Boost (1.3x) to make text/photo ink pop
                    const gray = 0.299 * r + 0.587 * g + 0.114 * b;
                    const saturation = 1.35;
                    r = gray + (r - gray) * saturation;
                    g = gray + (g - gray) * saturation;
                    b = gray + (b - gray) * saturation;

                    // Bounds checking
                    data[i]   = Math.min(255, Math.max(0, r));
                    data[i+1] = Math.min(255, Math.max(0, g));
                    data[i+2] = Math.min(255, Math.max(0, b));
                }
                ctx.putImageData(imgData, 0, 0);

                // C. Fast Sharpen Convolution (Increases OCR readibility and text sharpness)
                this.sharpenCanvas(ctx, canvas.width, canvas.height);

            } else if (filterType === 'bw') {
                const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const data = imgData.data;

                // Compute adaptive average luminance
                let totalLuminance = 0;
                let samples = 0;
                for (let i = 0; i < data.length; i += 128) {
                    const r = data[i];
                    const g = data[i+1];
                    const b = data[i+2];
                    totalLuminance += 0.299 * r + 0.587 * g + 0.114 * b;
                    samples++;
                }
                const avgLuminance = totalLuminance / samples;
                const threshold = avgLuminance - 10; // Darken threshold slightly to capture lighter text

                for (let i = 0; i < data.length; i += 4) {
                    const r = data[i];
                    const g = data[i+1];
                    const b = data[i+2];
                    const luminance = 0.299 * r + 0.587 * g + 0.114 * b;

                    // Hard binarization (Pure black & white)
                    const val = luminance > threshold ? 255 : 0;
                    data[i] = val;
                    data[i+1] = val;
                    data[i+2] = val;
                }
                ctx.putImageData(imgData, 0, 0);
            }

            // Output to preview image tag
            this.capturedImageData = canvas.toDataURL('image/jpeg', 0.85);
            this.$refs.preview.src = this.capturedImageData;
        },

        sharpenCanvas(ctx, width, height) {
            const weights = [
                 0, -0.5,  0,
              -0.5,    3, -0.5,
                 0, -0.5,  0
            ];
            const side = 3;
            const halfSide = 1;
            const srcData = ctx.getImageData(0, 0, width, height);
            const src = srcData.data;
            const outputData = ctx.createImageData(width, height);
            const dst = outputData.data;

            for (let y = 0; y < height; y++) {
                for (let x = 0; x < width; x++) {
                    const dstOff = (y * width + x) * 4;
                    let r = 0, g = 0, b = 0;
                    
                    for (let cy = 0; cy < side; cy++) {
                        for (let cx = 0; cx < side; cx++) {
                            const scy = Math.min(height - 1, Math.max(0, y + cy - halfSide));
                            const scx = Math.min(width - 1, Math.max(0, x + cx - halfSide));
                            const srcOff = (scy * width + scx) * 4;
                            const wt = weights[cy * side + cx];
                            r += src[srcOff] * wt;
                            g += src[srcOff+1] * wt;
                            b += src[srcOff+2] * wt;
                        }
                    }
                    dst[dstOff]   = Math.min(255, Math.max(0, r));
                    dst[dstOff+1] = Math.min(255, Math.max(0, g));
                    dst[dstOff+2] = Math.min(255, Math.max(0, b));
                    dst[dstOff+3] = src[dstOff+3]; // Preserve alpha
                }
            }
            ctx.putImageData(outputData, 0, 0);
        },

        retake() {
            this.isCaptured = false;
            this.capturedImageData = null;
            this.errorMessage = '';
            this.startCamera();
        },

        async saveDocument() {
            if (!this.documentType) {
                this.errorMessage = "Please select a document type.";
                return;
            }

            this.isSaving = true;
            this.errorMessage = '';

            try {
                const response = await fetch('{{ route('citizen.vault.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        image: this.capturedImageData,
                        document_type: this.documentType
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    window.location.href = data.redirect;
                } else {
                    this.errorMessage = data.error || "Failed to save document.";
                    this.isSaving = false;
                }
            } catch (err) {
                console.error("Save error:", err);
                this.errorMessage = "An error occurred while saving.";
                this.isSaving = false;
            }
        }
    }
}
</script>
@endsection
