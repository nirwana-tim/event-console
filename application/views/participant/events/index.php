<?= flash_alert('success') ?>
<?= flash_alert('error') ?>
<?= flash_alert('info') ?>



<div class="page-content">
    <!-- Filter & Search Bar -->
    <div class="row mb-4 g-3">
        <div class="col-md-6 col-lg-4">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Cari event...">
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
        <?php if (empty($events)) { ?>
            <div class="col-12 text-center py-5">
                <div class="card shadow-sm border-0 rounded-4 py-5">
                    <div class="card-body">
                        <i class="bi bi-calendar-x display-1 text-muted opacity-25 mb-3 d-block"></i>
                        <h4 class="text-muted">Belum ada event yang tersedia</h4>
                        <p class="text-muted fst-italic">Silakan cek kembali nanti untuk informasi event terbaru.</p>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php foreach ($events as $event) { ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden event-card-modern position-relative">
                    <div class="position-relative">
                        <img src="<?= e(base_url('uploads/banner/' . $event->banner)) ?>" 
                             class="card-img-top object-fit-cover" 
                             alt="<?= e($event->name) ?>"
                             style="height: 160px;"
                             onerror="this.src='<?= base_url('mazer/dist/assets/static/images/samples/architecture.jpg') ?>'">
                        <div class="position-absolute top-0 end-0 p-2">
                            <span class="badge bg-<?= status_badge_class($event->status) ?> py-1 px-2 text-uppercase x-small shadow-sm">
                                <?= e($event->status) ?>
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-3 d-flex flex-column">
                        <div class="mb-1">
                            <small class="text-primary fw-bold text-uppercase x-small letter-spacing-1">
                                <i class="bi bi-calendar2-event me-1"></i> <?= e(human_diff($event->date)) ?>
                            </small>
                        </div>
                        <h5 class="card-title fw-bold mb-2 fs-6">
                            <a href="<?= base_url('participant/event_show/' . $event->id) ?>" class="stretched-link text-gray-800 text-decoration-none">
                                <?= e($event->name) ?>
                            </a>
                        </h5>
                        
                        <div class="d-flex align-items-center mb-1 text-muted x-small">
                            <i class="bi bi-geo-alt-fill me-1 text-danger"></i>
                            <span class="text-truncate"><?= e($event->location) ?></span>
                        </div>
                        <div class="d-flex align-items-center mb-3 text-muted x-small">
                            <i class="bi bi-people-fill me-1 text-info"></i>
                            <span><?= e($event->total_registrations) ?> / <?= e($event->quota ?: '∞') ?></span>
                        </div>

                        <div class="mt-auto">
                            <?php if ($event->user_registration_id) { ?>
                                <span class="badge bg-light-success text-success w-100 py-2 rounded-3 border-0">
                                    <i class="bi bi-check-circle-fill me-1"></i>Registered
                                </span>
                            <?php } elseif ($event->status === 'dibuka') { ?>
                                <span class="btn btn-primary btn-sm w-100 py-2 rounded-3 shadow-sm">
                                    <i class="bi bi-plus-circle me-1"></i>Join Event
                                </span>
                            <?php } else { ?>
                                <span class="btn btn-light btn-sm w-100 py-2 rounded-3" disabled>
                                    Closed
                                </span>
                            <?php } ?>
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
