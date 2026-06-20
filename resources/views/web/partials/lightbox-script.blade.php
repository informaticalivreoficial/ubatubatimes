<div id="lightbox-overlay" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/90 p-4">
    <button id="lightbox-close" type="button" aria-label="Fechar"
            class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20 transition">
        <i class="fa-solid fa-xmark text-lg" aria-hidden="true"></i>
    </button>
    <img id="lightbox-image" src="" alt="" class="max-h-[90vh] max-w-full rounded-lg object-contain">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var overlay = document.getElementById('lightbox-overlay');
        var imageEl = document.getElementById('lightbox-image');
        var closeBtn = document.getElementById('lightbox-close');
        var triggers = document.querySelectorAll('[data-lightbox-trigger]');

        function openLightbox(href, alt) {
            imageEl.src = href;
            imageEl.alt = alt || '';
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            imageEl.src = '';
            document.body.style.overflow = '';
        }

        triggers.forEach(function (trigger) {
            trigger.addEventListener('click', function (e) {
                e.preventDefault();
                var img = trigger.querySelector('img');
                openLightbox(trigger.getAttribute('href'), img ? img.alt : '');
            });
        });

        closeBtn.addEventListener('click', closeLightbox);

        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !overlay.classList.contains('hidden')) {
                closeLightbox();
            }
        });
    });
</script>