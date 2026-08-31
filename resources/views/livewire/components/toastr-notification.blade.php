<div></div>

@script
<script>
    const toastColors = {
        success: '#16a34a',
        error: '#dc2626',
        warning: '#f59e0b',
        info: '#2563eb',
    };

    const parseToastPayload = (payload) => {
        if (!payload) {
            return {};
        }

        if (Array.isArray(payload)) {
            return payload[0] ?? {};
        }

        if (payload.type || payload.message) {
            return payload;
        }

        return payload[0] ?? payload;
    };

    const showToast = (type, message) => {
        if (!message || typeof Toastify === 'undefined') {
            return;
        }

        Toastify({
            text: message,
            duration: 4000,
            gravity: 'top',
            position: 'right',
            close: true,
            style: {
                background: toastColors[type] ?? toastColors.info,
            },
        }).showToast();
    };

    Livewire.on('toast', (payload) => {
        const { type, message } = parseToastPayload(payload);

        showToast(type, message);
    });

    const flashToast = $wire.flashToast;

    if (flashToast?.message) {
        showToast(flashToast.type, flashToast.message);
    }
</script>
@endscript
