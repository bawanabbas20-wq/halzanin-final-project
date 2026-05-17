<div id="toast-container" class="fixed top-4 right-4 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

<style>
    .toast-enter {
        transform: translateX(100%);
        opacity: 0;
    }
    .toast-enter-active {
        transform: translateX(0);
        opacity: 1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .toast-leave {
        transform: translateX(100%);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<script>
    window.showToast = function(type, title, message, duration = 4000) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = 'w-80 bg-white dark:bg-[#1e293b] border border-gray-100 dark:border-gray-800 rounded-[12px] shadow-lg pointer-events-auto overflow-hidden toast-enter flex';
        
        let iconSvg = '';
        let iconColor = '';
        let bgColor = '';

        switch (type) {
            case 'success':
                iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                iconColor = 'text-green-500';
                bgColor = 'bg-green-500';
                break;
            case 'error':
                iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                iconColor = 'text-red-500';
                bgColor = 'bg-red-500';
                break;
            case 'warning':
                iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>';
                iconColor = 'text-yellow-500';
                bgColor = 'bg-yellow-500';
                break;
            default: // info
                iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                iconColor = 'text-blue-500';
                bgColor = 'bg-blue-500';
                break;
        }

        toast.innerHTML = `
            <div class="w-1.5 \${bgColor} shrink-0"></div>
            <div class="p-4 flex items-start w-full">
                <svg class="w-5 h-5 \${iconColor} mt-0.5 shrink-0 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">\${iconSvg}</svg>
                <div class="flex-1 ltr:pr-2 rtl:pl-2">
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-1">\${title}</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400">\${message}</p>
                </div>
                <button onclick="this.closest('.toast-enter-active').classList.add('toast-leave'); setTimeout(() => this.closest('.toast-enter-active').remove(), 300)" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        `;

        container.appendChild(toast);

        // Trigger animation
        requestAnimationFrame(() => {
            toast.classList.add('toast-enter-active');
            toast.classList.remove('toast-enter');
        });

        // Auto remove
        setTimeout(() => {
            if (toast.parentElement) {
                toast.classList.add('toast-leave');
                setTimeout(() => {
                    if (toast.parentElement) toast.remove();
                }, 300);
            }
        }, duration);
    };
</script>
