<?= flash_alert('success') ?>
<?= flash_alert('error') ?>
<?= flash_alert('info') ?>



<div class="page-content">
    <!-- Filter & Search Bar -->
    <div class="row mb-4 g-3">
        <div class="col-md-6 col-lg-4">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Cari partisipasi...">
            </div>
        </div>
        <div class="col-md-4 col-lg-3">
            <select id="statusFilter" class="form-select shadow-sm border-0 text-gray-700">
                <option value="">Semua Status</option>
                <option value="dibuka">Ongoing / Dibuka</option>
                <option value="ditutup">Closed / Ditutup</option>
                <option value="selesai">Completed / Selesai</option>
            </select>
        </div>
    </div>

    <div class="row g-4" id="itemContainer">
        <?php if (empty($registrations)) { ?>
            <div class="col-12 text-center py-5">
                <div class="card shadow-sm border-0 rounded-4 py-5">
                    <div class="card-body">
                        <i class="bi bi-clipboard-x display-1 text-muted opacity-25 mb-3 d-block"></i>
                        <h4 class="text-muted">Anda belum mendaftar di event manapun</h4>
                        <a href="<?= base_url('participant/events') ?>" class="btn btn-primary mt-3 rounded-3 py-2 px-4">
                            <i class="bi bi-search me-2"></i>Cari Event Menarik
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php foreach ($registrations as $registration) { ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden event-card-modern position-relative">
                    <div class="position-relative">
                        <img src="<?= e(base_url('uploads/banner/' . $registration->banner)) ?>" 
                             class="card-img-top object-fit-cover" 
                             alt="<?= e($registration->event_name) ?>"
                             style="height: 160px;"
                             onerror="this.src='<?= base_url('mazer/dist/assets/static/images/samples/architecture.jpg') ?>'">
                        <div class="position-absolute top-0 end-0 p-2 d-flex flex-column gap-1 align-items-end">
                            <span class="badge bg-<?= status_badge_class($registration->status) ?> py-1 px-2 text-uppercase x-small shadow-sm">
                                <?= e($registration->status) ?>
                            </span>
                            <span class="badge bg-<?= attendance_badge_class($registration->attendance) ?> py-1 px-2 text-uppercase x-small shadow-sm">
                                <?= e($registration->attendance) ?>
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-3 d-flex flex-column">
                        <div class="mb-1">
                            <small class="text-primary fw-bold text-uppercase x-small letter-spacing-1">
                                <i class="bi bi-calendar2-check me-1"></i> <?= e(human_diff($registration->date)) ?>
                            </small>
                        </div>
                        <h5 class="card-title fw-bold mb-2 fs-6">
                            <a href="<?= base_url('participant/show/' . $registration->id) ?>" class="stretched-link text-gray-800 text-decoration-none">
                                <?= e($registration->event_name) ?>
                            </a>
                        </h5>
                        
                        <div class="d-flex align-items-center mb-3 text-muted x-small">
                            <i class="bi bi-geo-alt-fill me-1 text-danger"></i>
                            <span class="text-truncate"><?= e($registration->location) ?></span>
                        </div>

                        <div class="mt-auto">
                            <span class="btn btn-outline-primary btn-sm w-100 py-2 rounded-3">
                                <i class="bi bi-eye me-1"></i> Lihat Detail
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const cards = document.querySelectorAll('#itemContainer > div');

    function filterCards() {
        const searchText = searchInput ? searchInput.value.toLowerCase() : '';
        const statusText = statusFilter ? statusFilter.value.toLowerCase() : '';

        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            const matchesSearch = text.includes(searchText);
            
            const badge = card.querySelector('.badge');
            const cardStatus = badge ? badge.textContent.trim().toLowerCase() : '';
            const matchesStatus = statusText === '' || cardStatus === statusText;

            if (matchesSearch && matchesStatus) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    if (searchInput) searchInput.addEventListener('keyup', filterCards);
    if (statusFilter) statusFilter.addEventListener('change', filterCards);
});
</script>
