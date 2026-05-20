@extends('layouts.halzanin-app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6" x-data="documentScanner()" x-init="initLang()">

    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-brand dark:text-white font-outfit" data-i18n="vault.scan">Scan Document</h2>
        <a href="{{ route('citizen.vault.index') }}" class="text-sm font-semibold text-gray-500 hover:text-brand dark:text-gray-400 dark:hover:text-indigo-400 transition-colors" data-i18n="common.cancel">Cancel</a>
    </div>

    <!-- Step 1: Choose document type BEFORE opening camera -->
    <div x-show="step === 'choose'" class="bg-white dark:bg-[#1e293b] p-6 rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 space-y-5">
        <div>
            <h3 class="font-bold text-gray-900 dark:text-white mb-1" data-i18n="vault.scan_question">What are you scanning?</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400" data-i18n="vault.scan_help">The frame will adjust to fit your document.</p>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <template x-for="dt in docTypes" :key="dt.value">
                <button type="button"
                    @click="selectType(dt.value)"
                    :class="documentType === dt.value ? 'ring-2 ring-brand bg-indigo-50 dark:bg-indigo-900/30' : 'bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700'"
                    class="p-4 rounded-[12px] border border-gray-200 dark:border-gray-700 text-left transition-all">
                    <div class="text-2xl mb-1" x-text="dt.icon"></div>
                    <div class="font-semibold text-sm text-gray-900 dark:text-white" x-text="t(dt.labelKey)"></div>
                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5" x-text="t(dt.hintKey)"></div>
                </button>
            </template>
        </div>
        <button type="button"
            @click="startScanning()"
            :disabled="!documentType"
            class="w-full h-[48px] bg-brand text-white font-bold rounded-[12px] hover:bg-brand-light transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
            <span data-i18n="vault.open_camera">Open Camera</span>
        </button>
    </div>

    <!-- Step 2: Camera / Capture (front or back) -->
    <div x-show="step === 'scan'" style="display:none">
        <!-- Side indicator for two-sided docs -->
        <div x-show="hasTwoSides" class="flex items-center gap-3 mb-3" style="display:none">
            <div class="flex gap-2">
                <span :class="currentSide === 'front' ? 'bg-brand text-white' : 'bg-gray-200 dark:bg-slate-700 text-gray-500'"
                    class="px-3 py-1 rounded-full text-xs font-bold transition-colors" x-text="t('vault.front')">Front</span>
                <span :class="currentSide === 'back' ? 'bg-brand text-white' : 'bg-gray-200 dark:bg-slate-700 text-gray-500'"
                    class="px-3 py-1 rounded-full text-xs font-bold transition-colors" x-text="t('vault.back')">Back</span>
            </div>
            <span class="text-sm text-gray-500 dark:text-gray-400" x-text="currentSide === 'front' ? t('vault.scanning_front') : t('vault.scanning_back')"></span>
        </div>

        <!-- Camera box — aspect ratio driven by document type -->
        <div class="bg-black rounded-[16px] overflow-hidden relative shadow-lg"
             :class="frameAspect === 'card' ? 'aspect-[16/10]' : 'aspect-[3/4]'">
            <!-- Video -->
            <video x-ref="video" class="w-full h-full object-cover" autoplay playsinline></video>

            <!-- Frame overlay — border thickness creates the "crop zone" -->
            <div class="absolute inset-0 z-10 pointer-events-none flex items-center justify-center"
                 :class="frameAspect === 'card' ? 'border-[32px]' : 'border-[40px]'"
                 style="border-color: rgba(0,0,0,0.55)">
                <div x-ref="frameBox" class="w-full h-full border-2 border-white/50 rounded-lg relative">
                    <div class="absolute top-0 left-0 w-6 h-6 border-t-4 border-l-4 border-brand -mt-1 -ml-1"></div>
                    <div class="absolute top-0 right-0 w-6 h-6 border-t-4 border-r-4 border-brand -mt-1 -mr-1"></div>
                    <div class="absolute bottom-0 left-0 w-6 h-6 border-b-4 border-l-4 border-brand -mb-1 -ml-1"></div>
                    <div class="absolute bottom-0 right-0 w-6 h-6 border-b-4 border-r-4 border-brand -mb-1 -mr-1"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <p class="text-white/70 font-semibold bg-black/50 px-4 py-2 rounded-full text-sm backdrop-blur-sm" x-show="!isCaptured">
                            <span data-i18n="vault.position_document">Position document within frame</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Hidden canvas + preview -->
            <canvas x-ref="canvas" class="hidden"></canvas>
            <img x-ref="preview" class="absolute inset-0 w-full h-full object-contain bg-black z-20" x-show="isCaptured" style="display:none;" />

            <!-- Controls -->
            <div class="absolute bottom-0 inset-x-0 p-6 flex justify-center z-30 bg-gradient-to-t from-black/80 to-transparent">
                <button type="button" x-show="!isCaptured" @click="captureImage"
                    class="w-16 h-16 rounded-full bg-white/20 border-4 border-white flex items-center justify-center hover:bg-white/40 transition-colors focus:outline-none">
                    <div class="w-12 h-12 rounded-full bg-white"></div>
                </button>
                <div x-show="isCaptured" class="flex gap-4 w-full" style="display:none;">
                    <button type="button" @click="retake"
                        class="flex-1 px-4 py-3 bg-gray-800 text-white font-semibold rounded-[10px] hover:bg-gray-700 transition-colors" data-i18n="vault.retake">Retake</button>
                    <button type="button" @click="confirmCapture" :disabled="isSaving"
                        class="flex-1 px-4 py-3 bg-brand text-white font-semibold rounded-[10px] hover:bg-brand-light transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center">
                        <span x-show="!isSaving" x-text="currentSide === 'front' && hasTwoSides ? t('vault.next_scan_back') : t('vault.save_securely')"></span>
                        <svg x-show="isSaving" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Filter strip -->
        <div x-show="isCaptured" class="bg-white dark:bg-[#1e293b] p-4 rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 flex justify-around gap-2 mt-4" style="display:none;">
            <button type="button" @click="applyFilter('original')" :class="activeFilter==='original'?'bg-brand text-white':'bg-gray-100 text-gray-700 dark:bg-slate-800 dark:text-gray-300'" class="flex-1 px-3 py-2 text-xs font-bold rounded-lg transition-all" x-text="t('vault.original')">Original</button>
            <button type="button" @click="applyFilter('magic')"    :class="activeFilter==='magic'   ?'bg-brand text-white':'bg-gray-100 text-gray-700 dark:bg-slate-800 dark:text-gray-300'" class="flex-1 px-3 py-2 text-xs font-bold rounded-lg transition-all" x-text="t('vault.magic_scan')">Magic Scan</button>
            <button type="button" @click="applyFilter('bw')"       :class="activeFilter==='bw'      ?'bg-brand text-white':'bg-gray-100 text-gray-700 dark:bg-slate-800 dark:text-gray-300'" class="flex-1 px-3 py-2 text-xs font-bold rounded-lg transition-all" x-text="t('vault.bw_doc')">B&amp;W Doc</button>
        </div>

        <div x-show="errorMessage" class="mt-3 bg-red-50 text-red-600 p-3 rounded-lg text-sm" x-text="errorMessage" style="display:none;"></div>
    </div>

    <!-- Step 3: Back-side prompt -->
    <div x-show="step === 'back-prompt'" style="display:none"
         class="bg-white dark:bg-[#1e293b] p-8 rounded-[16px] shadow-sm border border-gray-100 dark:border-gray-800 text-center space-y-5">
        <div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
            <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
        </div>
        <div>
            <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-1"><span data-i18n="vault.flip_title">Flip your</span> <span x-text="translatedDocumentType"></span></h3>
            <p class="text-sm text-gray-500 dark:text-gray-400" data-i18n="vault.flip_desc">Front side saved. Now scan the back side to complete your document.</p>
        </div>
        <div class="flex gap-3">
            <button type="button" @click="skipBack"
                class="flex-1 px-4 py-3 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 font-semibold rounded-[10px] hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
                <span data-i18n="vault.skip_front_only">Skip (front only)</span>
            </button>
            <button type="button" @click="scanBack"
                class="flex-1 px-4 py-3 bg-brand text-white font-semibold rounded-[10px] hover:bg-brand-light transition-colors">
                <span data-i18n="vault.scan_back_side">Scan Back Side</span>
            </button>
        </div>
    </div>

    <!-- Security note (always visible outside scanner) -->
    <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-lg flex items-start gap-3" x-show="step !== 'choose'">
        <svg class="w-5 h-5 text-brand shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
        </svg>
        <p class="text-sm text-gray-700 dark:text-gray-300">
            <strong data-i18n="vault.secure_label">Secure Storage Guarantee:</strong> <span data-i18n="vault.secure_desc">Your document is encrypted before saving. Staff cannot view it and it auto-deletes in 100 days.</span>
        </p>
    </div>
</div>

<script>
function documentScanner() {
    return {
        step: 'choose',          // 'choose' | 'scan' | 'back-prompt'
        stream: null,
        isCaptured: false,
        isSaving: false,
        documentType: '',
        currentSide: 'front',    // 'front' | 'back'
        frontVaultId: null,
        capturedImageData: null,
        originalImageData: null,
        activeFilter: 'magic',
        errorMessage: '',
        frameAspect: 'card',     // 'card' (landscape 16:10) | 'portrait' (3:4)
        lang: document.documentElement.lang === 'ku' ? 'ku' : 'en',

        docTypes: [
            { value: 'National ID',    labelKey: 'book.national_id_short', icon: 'ID', hintKey: 'vault.front_back' },
            { value: 'Driver License', labelKey: 'vault.driver_license',   icon: 'DL', hintKey: 'vault.front_back' },
            { value: 'Passport',       labelKey: 'vault.passport',         icon: 'PP', hintKey: 'vault.photo_page' },
            { value: 'Other',          labelKey: 'doc.other',              icon: 'DOC', hintKey: 'vault.single_page' },
        ],

        initLang() {
            document.addEventListener('halzanin-language-changed', (event) => {
                this.lang = event.detail.lang;
            });
        },

        t(key) {
            this.lang;
            return window.i18n ? i18n(key) : key;
        },

        get translatedDocumentType() {
            const item = this.docTypes.find(dt => dt.value === this.documentType);
            return item ? this.t(item.labelKey) : this.documentType;
        },
        get hasTwoSides() {
            return this.documentType === 'National ID' || this.documentType === 'Driver License';
        },

        selectType(val) {
            this.documentType = val;
            this.frameAspect = (val === 'Passport' || val === 'Other') ? 'portrait' : 'card';
        },

        async startScanning() {
            this.step = 'scan';
            this.isCaptured = false;
            this.capturedImageData = null;
            this.errorMessage = '';
            await this.$nextTick();
            this.startCamera();
        },

        async startCamera() {
            try {
                this.stream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'environment', width: { ideal: 1920 }, height: { ideal: 1080 } }
                });
                this.$refs.video.srcObject = this.stream;
            } catch (err) {
                this.errorMessage = this.t('vault.camera_required');
            }
        },

        stopCamera() {
            if (this.stream) {
                this.stream.getTracks().forEach(t => t.stop());
                this.stream = null;
            }
        },

        captureImage() {
            const video  = this.$refs.video;
            const canvas = this.$refs.canvas;
            const ctx    = canvas.getContext('2d');

            // --- Compute crop rectangle matching the visible frame box ---
            const frameEl     = this.$refs.frameBox;
            const containerEl = frameEl.parentElement; // the border-div (the overlay)
            const videoEl     = video;

            // Pixel dimensions of the displayed video element
            const dispW = videoEl.clientWidth;
            const dispH = videoEl.clientHeight;

            // The frame overlay uses inline border (set via :class) — measure its offset
            const frameRect     = frameEl.getBoundingClientRect();
            const containerRect = videoEl.getBoundingClientRect();

            // Frame position relative to video element in display-pixels
            const fx = frameRect.left   - containerRect.left;
            const fy = frameRect.top    - containerRect.top;
            const fw = frameRect.width;
            const fh = frameRect.height;

            // Scale factors from display pixels → actual video pixels
            const scaleX = video.videoWidth  / dispW;
            const scaleY = video.videoHeight / dispH;

            const sx = Math.round(fx * scaleX);
            const sy = Math.round(fy * scaleY);
            let   sw = Math.round(fw * scaleX);
            let   sh = Math.round(fh * scaleY);

            // Clamp to video bounds
            sw = Math.min(sw, video.videoWidth  - sx);
            sh = Math.min(sh, video.videoHeight - sy);

            // Output at max 1400px on the longest side
            const maxDim = 1400;
            let ow = sw, oh = sh;
            if (ow > maxDim || oh > maxDim) {
                if (ow > oh) { oh = Math.round(oh * maxDim / ow); ow = maxDim; }
                else         { ow = Math.round(ow * maxDim / oh); oh = maxDim; }
            }

            canvas.width  = ow;
            canvas.height = oh;

            // Draw ONLY the frame region, scaled to output size
            ctx.drawImage(video, sx, sy, sw, sh, 0, 0, ow, oh);

            this.originalImageData = ctx.getImageData(0, 0, ow, oh);
            this.isCaptured  = true;
            this.activeFilter = 'magic';
            this.applyFilter('magic');
            this.stopCamera();
        },

        applyFilter(filterType) {
            this.activeFilter = filterType;
            const canvas = this.$refs.canvas;
            const ctx    = canvas.getContext('2d');
            ctx.putImageData(this.originalImageData, 0, 0);

            if (filterType === 'magic') {
                const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const data    = imgData.data;

                // Auto-levels
                let minR=255,maxR=0, minG=255,maxG=0, minB=255,maxB=0;
                for (let i = 0; i < data.length; i += 128) {
                    if (data[i]   < minR) minR=data[i];   if (data[i]   > maxR) maxR=data[i];
                    if (data[i+1] < minG) minG=data[i+1]; if (data[i+1] > maxG) maxG=data[i+1];
                    if (data[i+2] < minB) minB=data[i+2]; if (data[i+2] > maxB) maxB=data[i+2];
                }
                const rangeR = Math.max(1, maxR-minR);
                const rangeG = Math.max(1, maxG-minG);
                const rangeB = Math.max(1, maxB-minB);

                for (let i = 0; i < data.length; i += 4) {
                    let r = ((data[i]  -minR)*255)/rangeR;
                    let g = ((data[i+1]-minG)*255)/rangeG;
                    let b = ((data[i+2]-minB)*255)/rangeB;

                    // Contrast + brightness
                    r = (r-128)*1.5 + 128*1.1;
                    g = (g-128)*1.5 + 128*1.1;
                    b = (b-128)*1.5 + 128*1.1;

                    // Saturation
                    const gray = 0.299*r + 0.587*g + 0.114*b;
                    r = gray + (r-gray)*1.3;
                    g = gray + (g-gray)*1.3;
                    b = gray + (b-gray)*1.3;

                    data[i]   = Math.min(255, Math.max(0, r));
                    data[i+1] = Math.min(255, Math.max(0, g));
                    data[i+2] = Math.min(255, Math.max(0, b));
                }
                ctx.putImageData(imgData, 0, 0);
                this.sharpenCanvas(ctx, canvas.width, canvas.height);

            } else if (filterType === 'bw') {
                const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const data    = imgData.data;
                let total = 0, samples = 0;
                for (let i = 0; i < data.length; i += 128) {
                    total += 0.299*data[i] + 0.587*data[i+1] + 0.114*data[i+2];
                    samples++;
                }
                const threshold = (total / samples) - 10;
                for (let i = 0; i < data.length; i += 4) {
                    const lum = 0.299*data[i] + 0.587*data[i+1] + 0.114*data[i+2];
                    const val = lum > threshold ? 255 : 0;
                    data[i]=data[i+1]=data[i+2]=val;
                }
                ctx.putImageData(imgData, 0, 0);
            }

            this.capturedImageData = canvas.toDataURL('image/jpeg', 0.88);
            this.$refs.preview.src = this.capturedImageData;
        },

        // Stronger sharpen kernel: centre=5, edges=-1
        sharpenCanvas(ctx, width, height) {
            const weights = [0,-1,0, -1,5,-1, 0,-1,0];
            const src    = ctx.getImageData(0, 0, width, height);
            const out    = ctx.createImageData(width, height);
            const s = src.data, d = out.data;
            for (let y = 0; y < height; y++) {
                for (let x = 0; x < width; x++) {
                    const off = (y*width+x)*4;
                    let r=0,g=0,b=0;
                    for (let cy=0;cy<3;cy++) {
                        for (let cx=0;cx<3;cx++) {
                            const sy2 = Math.min(height-1,Math.max(0,y+cy-1));
                            const sx2 = Math.min(width -1,Math.max(0,x+cx-1));
                            const so  = (sy2*width+sx2)*4;
                            const w   = weights[cy*3+cx];
                            r+=s[so]*w; g+=s[so+1]*w; b+=s[so+2]*w;
                        }
                    }
                    d[off]  =Math.min(255,Math.max(0,r));
                    d[off+1]=Math.min(255,Math.max(0,g));
                    d[off+2]=Math.min(255,Math.max(0,b));
                    d[off+3]=s[off+3];
                }
            }
            ctx.putImageData(out, 0, 0);
        },

        retake() {
            this.isCaptured = false;
            this.capturedImageData = null;
            this.errorMessage = '';
            this.startCamera();
        },

        // Called when user clicks "Save / Next: Scan Back"
        async confirmCapture() {
            if (!this.capturedImageData) return;
            this.isSaving = true;
            this.errorMessage = '';

            const body = {
                image:         this.capturedImageData,
                document_type: this.documentType,
                side:          this.currentSide,
            };
            if (this.currentSide === 'back' && this.frontVaultId) {
                body.vault_id = this.frontVaultId;
            }

            try {
                const resp = await fetch('{{ route('citizen.vault.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(body)
                });
                const data = await resp.json();

                if (resp.ok && data.success) {
                    if (this.currentSide === 'front' && this.hasTwoSides) {
                        // Front saved — store vault_id and ask about back
                        this.frontVaultId = data.vault_id;
                        this.isSaving = false;
                        this.step = 'back-prompt';
                    } else {
                        window.location.href = data.redirect;
                    }
                } else {
                    this.errorMessage = data.error || this.t('vault.save_failed');
                    this.isSaving = false;
                }
            } catch (e) {
                this.errorMessage = this.t('vault.save_error');
                this.isSaving = false;
            }
        },

        async scanBack() {
            this.currentSide = 'back';
            this.isCaptured  = false;
            this.capturedImageData = null;
            this.errorMessage = '';
            this.step = 'scan';
            await this.$nextTick();
            this.startCamera();
        },

        skipBack() {
            window.location.href = '{{ route('citizen.vault.index') }}';
        },
    }
}
</script>
@endsection
