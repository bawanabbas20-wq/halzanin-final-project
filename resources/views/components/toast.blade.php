<div id="toast-container" class="fixed top-4 ltr:right-4 rtl:left-4 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

<style>
    .toast-item {
        transform: translateX(110%);
        opacity: 0;
    }
    html[dir="rtl"] .toast-item {
        transform: translateX(-110%);
    }
    .toast-item.toast-in {
        transform: translateX(0);
        opacity: 1;
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.25s ease;
    }
    .toast-item.toast-out {
        transform: translateX(110%);
        opacity: 0;
        transition: transform 0.28s cubic-bezier(0.4, 0, 0.8, 0.6), opacity 0.25s ease;
    }
    html[dir="rtl"] .toast-item.toast-out {
        transform: translateX(-110%);
    }
    @keyframes toastShrink {
        from { transform: scaleX(1); }
        to   { transform: scaleX(0); }
    }
    .toast-bar {
        height: 3px;
        transform-origin: left;
        flex-shrink: 0;
    }
    html[dir="rtl"] .toast-bar {
        transform-origin: right;
    }
</style>

<script>
    window.showToast = function(type, title, message, duration) {
        duration = duration || 4500;
        const container = document.getElementById('toast-container');
        if (!container) return;

        const variants = {
            success: {
                icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                iconCls: 'text-green-500', bar: 'bg-green-500', side: 'bg-green-500'
            },
            error: {
                icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                iconCls: 'text-red-500', bar: 'bg-red-500', side: 'bg-red-500'
            },
            warning: {
                icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
                iconCls: 'text-yellow-500', bar: 'bg-yellow-400', side: 'bg-yellow-400'
            },
            info: {
                icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                iconCls: 'text-blue-500', bar: 'bg-blue-500', side: 'bg-blue-500'
            },
        };

        const v = variants[type] || variants.info;

        const toast = document.createElement('div');
        toast.className = 'toast-item w-80 bg-white dark:bg-[#1F1F1F] border border-gray-100 dark:border-gray-800 rounded-[12px] shadow-xl pointer-events-auto overflow-hidden flex flex-col';

        toast.innerHTML = [
            '<div class="flex items-start">',
              '<div class="w-1.5 ' + v.side + ' self-stretch rounded-tl-[12px] rounded-bl-[12px] flex-shrink-0"></div>',
              '<div class="flex items-start flex-1 p-4 gap-3 min-w-0">',
                '<svg class="w-5 h-5 ' + v.iconCls + ' flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">' + v.icon + '</svg>',
                '<div class="flex-1 min-w-0">',
                  '<p class="text-sm font-bold text-gray-900 dark:text-white leading-tight">' + title + '</p>',
                  '<p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">' + message + '</p>',
                '</div>',
                '<button data-toast-close class="flex-shrink-0 mt-0.5 ltr:ml-1 rtl:mr-1 text-gray-300 hover:text-gray-500 dark:hover:text-gray-200 transition-colors">',
                  '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>',
                '</button>',
              '</div>',
            '</div>',
            '<div class="toast-bar ' + v.bar + ' opacity-25 w-full" style="animation: toastShrink ' + duration + 'ms linear forwards;"></div>',
        ].join('');

        container.appendChild(toast);

        function dismiss() {
            if (!toast.parentElement) return;
            toast.classList.remove('toast-in');
            toast.classList.add('toast-out');
            setTimeout(function() { if (toast.parentElement) toast.remove(); }, 300);
        }

        toast.querySelector('[data-toast-close]').addEventListener('click', dismiss);

        // Animate in (double rAF to let browser paint initial state first)
        requestAnimationFrame(function() {
            requestAnimationFrame(function() {
                toast.classList.add('toast-in');
            });
        });

        setTimeout(dismiss, duration);
    };
</script>
