<script>
(() => {
    const formatLocal = (iso) => {
        try {
            const date = new Date(iso);
            if (Number.isNaN(date.getTime())) return '';

            return new Intl.DateTimeFormat(undefined, {
                weekday: 'short',
                month: 'short',
                day: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                timeZoneName: 'short',
            }).format(date);
        } catch {
            return '';
        }
    };

    const sync = () => {
        document.querySelectorAll('[data-kickoff]').forEach((root) => {
            const iso = root.getAttribute('data-kickoff');
            const localEl = root.querySelector('.match-kickoff__local');
            if (!iso || !localEl || localEl.dataset.ready === '1') return;

            const local = formatLocal(iso);
            if (!local) return;

            localEl.textContent = `Your time: ${local}`;
            localEl.dataset.ready = '1';
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', sync);
    } else {
        sync();
    }
})();
</script>
