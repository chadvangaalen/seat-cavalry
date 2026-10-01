@push('head')
<style>
/* Cavalry — Straylight / SRUN-aligned dark theme */
.cavalry-page {
    --cavalry-bg: #1b1b1b;
    --cavalry-panel: #2a2a2a;
    --cavalry-panel-2: #333;
    --cavalry-border: #3b3b3b;
    --cavalry-text: #d1d1d1;
    --cavalry-muted: #9a9a9a;
    --cavalry-gold: #c5ae87;
    --cavalry-gold-hot: #e0cda4;
    --cavalry-ink: #111;
}

.cavalry-page .card,
.cavalry-page .card.card-outline,
.cavalry-page .card.card-primary,
.cavalry-page .card.card-secondary {
    background-color: var(--cavalry-panel) !important;
    color: var(--cavalry-text);
    border: 1px solid var(--cavalry-border) !important;
    box-shadow: none;
}

.cavalry-page .card.card-outline.card-primary,
.cavalry-page .card.card-outline.card-secondary,
.cavalry-page .cavalry-card {
    border-top: 2px solid var(--cavalry-gold) !important;
}

.cavalry-page .card-header {
    background-color: transparent !important;
    border-bottom: 1px solid var(--cavalry-border) !important;
    color: var(--cavalry-text);
}

.cavalry-page .card-title,
.cavalry-page label,
.cavalry-page .custom-control-label {
    color: var(--cavalry-text);
}

.cavalry-page .info-box,
.cavalry-page .cavalry-metric {
    background-color: var(--cavalry-panel) !important;
    color: var(--cavalry-text);
    box-shadow: none !important;
    border: 1px solid var(--cavalry-border);
    min-height: 78px;
}

.cavalry-page .info-box-text {
    color: var(--cavalry-muted) !important;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-size: 0.72rem;
}

.cavalry-page .info-box-number {
    color: #fff !important;
    font-weight: 600;
}

/* Metric icons: muted SRUN accents (no Bootstrap neon) */
.cavalry-page .cavalry-metric-icon {
    width: 78px !important;
    display: flex !important;
    align-items: center;
    justify-content: center;
    color: #f3ead7 !important;
    border-right: 1px solid rgba(0, 0, 0, 0.25);
}

.cavalry-page .cavalry-metric-icon i {
    font-size: 1.35rem;
    filter: drop-shadow(0 1px 1px rgba(0, 0, 0, 0.35));
}

.cavalry-page .cavalry-metric-icon--titans {
    background: linear-gradient(160deg, #6e3438 0%, #4a2226 100%) !important;
    color: #f0d2a8 !important;
}

.cavalry-page .cavalry-metric-icon--supercarriers {
    background: linear-gradient(160deg, #c5ae87 0%, #8f7a55 100%) !important;
    color: #1b1b1b !important;
}

.cavalry-page .cavalry-metric-icon--carriers {
    background: linear-gradient(160deg, #5f7368 0%, #3f4d46 100%) !important;
    color: #e7dfd0 !important;
}

.cavalry-page .cavalry-metric-icon--dreadnoughts {
    background: linear-gradient(160deg, #5c606b 0%, #3a3d46 100%) !important;
    color: #e0cda4 !important;
}

.cavalry-page .cavalry-metric-icon--force_auxiliaries {
    background: linear-gradient(160deg, #4f6a52 0%, #334636 100%) !important;
    color: #dce8d8 !important;
}

.cavalry-page .cavalry-metric-icon--jump_freighters {
    background: linear-gradient(160deg, #6d655c 0%, #454039 100%) !important;
    color: #eadfc8 !important;
}

.cavalry-page .cavalry-metric-icon--black_ops {
    background: linear-gradient(160deg, #2c2c2c 0%, #171717 100%) !important;
    color: #c5ae87 !important;
}

.cavalry-page .cavalry-metric-icon--capital_industrials {
    background: linear-gradient(160deg, #6a6f54 0%, #434734 100%) !important;
    color: #e7e2cf !important;
}

.cavalry-page .btn-primary {
    background-color: var(--cavalry-gold) !important;
    border-color: var(--cavalry-gold) !important;
    color: var(--cavalry-ink) !important;
}

.cavalry-page .btn-primary:hover,
.cavalry-page .btn-primary:focus {
    background-color: var(--cavalry-gold-hot) !important;
    border-color: var(--cavalry-gold-hot) !important;
    color: var(--cavalry-ink) !important;
}

.cavalry-page .btn-default,
.cavalry-page a.btn-default {
    background: transparent !important;
    border: 1px solid var(--cavalry-gold) !important;
    color: var(--cavalry-gold) !important;
}

.cavalry-page .btn-default:hover,
.cavalry-page a.btn-default:hover {
    background: rgba(197, 174, 135, 0.12) !important;
    border-color: var(--cavalry-gold-hot) !important;
    color: var(--cavalry-gold-hot) !important;
}

.cavalry-page .nav-tabs {
    border-bottom: 1px solid var(--cavalry-border) !important;
}

.cavalry-page .nav-tabs .nav-link {
    color: var(--cavalry-muted) !important;
    border: none !important;
    border-bottom: 2px solid transparent !important;
    background: transparent !important;
    border-radius: 0 !important;
}

.cavalry-page .nav-tabs .nav-link:hover {
    color: var(--cavalry-gold-hot) !important;
    border-color: transparent !important;
}

.cavalry-page .nav-tabs .nav-link.active {
    color: var(--cavalry-gold) !important;
    background: transparent !important;
    border-color: transparent transparent var(--cavalry-gold) !important;
}

.cavalry-page .cavalry-accordion-toggle {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    color: var(--cavalry-gold) !important;
    font-weight: 600;
    font-size: 0.95rem !important;
    line-height: 1.35 !important;
    padding: 0.55rem 0.85rem;
    text-align: left;
    width: 100%;
}

.cavalry-page .cavalry-accordion .card-header .cavalry-accordion-title {
    margin: 0;
    line-height: 1.2;
}

.cavalry-page .cavalry-accordion-toggle:hover,
.cavalry-page .cavalry-accordion-toggle:focus {
    color: var(--cavalry-gold-hot) !important;
    text-decoration: none !important;
}

.cavalry-page .cavalry-accordion .card {
    margin-bottom: 0.5rem;
}

.cavalry-page .cavalry-accordion .card-header {
    padding: 0;
}

.cavalry-page .table {
    color: var(--cavalry-text);
    background: transparent;
}

.cavalry-page .table thead th {
    color: var(--cavalry-gold);
    border-top: none;
    border-bottom: 1px solid var(--cavalry-border);
    background: var(--cavalry-panel-2);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-size: 0.75rem;
}

.cavalry-page .table td,
.cavalry-page .table th {
    border-top: 1px solid var(--cavalry-border);
    vertical-align: middle;
}

.cavalry-page .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(255, 255, 255, 0.02);
}

.cavalry-page .table-hover tbody tr:hover {
    background-color: #3a3a3a;
    color: #fff;
}

.cavalry-page .badge-hangar,
.cavalry-page .badge-secondary {
    background-color: #444 !important;
    color: #d1d1d1 !important;
}

.cavalry-page .badge-corp,
.cavalry-page .badge-info {
    background-color: #4a453c !important;
    color: #e8dcc3 !important;
}

.cavalry-page .badge-active,
.cavalry-page .badge-success {
    background-color: #2f6b45 !important;
    color: #dff7e8 !important;
}

.cavalry-page .cavalry-chip {
    display: inline-block;
    background: var(--cavalry-panel-2);
    border: 1px solid var(--cavalry-border);
    color: var(--cavalry-text);
    border-radius: 3px;
    padding: 0.35rem 0.65rem;
    margin: 0 0.25rem 0.35rem 0;
}

.cavalry-page .cavalry-chip.is-lead {
    background: rgba(197, 174, 135, 0.12);
    border-color: var(--cavalry-gold);
    color: var(--cavalry-gold);
}

.cavalry-page .cavalry-chip strong {
    color: #fff;
    margin-left: 0.25rem;
}

.cavalry-page .form-control {
    background-color: var(--cavalry-panel);
    color: var(--cavalry-text);
    border: 1px solid #555;
}

.cavalry-page .form-control:focus {
    background-color: var(--cavalry-panel);
    color: #fff;
    border-color: var(--cavalry-gold);
    box-shadow: 0 0 0 0.2rem rgba(197, 174, 135, 0.25);
}

.cavalry-page .custom-control-input:checked ~ .custom-control-label::before {
    background-color: var(--cavalry-gold) !important;
    border-color: var(--cavalry-gold) !important;
}

.cavalry-page .select2-container--bootstrap4 .select2-selection,
.cavalry-page .select2-container--default .select2-selection--single,
.cavalry-page .select2-container--default .select2-selection--multiple {
    background-color: var(--cavalry-panel) !important;
    border: 1px solid #555 !important;
    color: var(--cavalry-text) !important;
    min-height: calc(1.5em + 0.75rem + 2px);
}

/* Kill AdminLTE/default padding stacking on single selects */
.cavalry-page .select2-container--bootstrap4 .select2-selection--single,
.cavalry-page .select2-container--default .select2-selection--single {
    height: calc(1.5em + 0.75rem + 2px) !important;
    padding: 0 !important;
}

.cavalry-page .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered,
.cavalry-page .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: var(--cavalry-text) !important;
    line-height: calc(1.5em + 0.75rem) !important;
    padding: 0 2rem 0 0.75rem !important;
    margin: 0 !important;
}

.cavalry-page .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow,
.cavalry-page .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100% !important;
    top: 0 !important;
    right: 0.4rem !important;
}

/* Corp picker: content-sized, not full-bleed */
.cavalry-page #cavalry-corp-form .select2-container {
    width: auto !important;
    min-width: 280px;
    max-width: 100%;
}

.cavalry-page .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: var(--cavalry-panel-2) !important;
    border-color: var(--cavalry-border) !important;
    color: var(--cavalry-text) !important;
}

.cavalry-page .select2-container--default .select2-selection__placeholder {
    color: var(--cavalry-muted) !important;
}

.cavalry-page .select2-container--default .select2-selection__arrow b {
    border-color: var(--cavalry-muted) transparent transparent transparent !important;
}

.cavalry-page .select2-dropdown,
.select2-container--bootstrap4.cavalry-select2-dropdown .select2-dropdown,
.select2-container--default.cavalry-select2-dropdown .select2-dropdown,
.cavalry-select2-dropdown.select2-dropdown,
.select2-dropdown.cavalry-select2-dropdown {
    background-color: #2a2a2a !important;
    border: 1px solid #555 !important;
    color: #d1d1d1 !important;
}

.cavalry-page .select2-results__option,
.select2-container--bootstrap4.cavalry-select2-dropdown .select2-results__option,
.select2-container--default.cavalry-select2-dropdown .select2-results__option,
.cavalry-select2-dropdown .select2-results__option {
    background-color: #2a2a2a !important;
    color: #d1d1d1 !important;
}

.cavalry-page .select2-results__option--highlighted,
.select2-container--bootstrap4.cavalry-select2-dropdown .select2-results__option--highlighted,
.select2-container--default.cavalry-select2-dropdown .select2-results__option--highlighted,
.cavalry-select2-dropdown .select2-results__option--highlighted[aria-selected],
.cavalry-select2-dropdown .select2-results__option--highlighted[aria-selected]:hover {
    background-color: #c5ae87 !important;
    color: #111 !important;
}

.cavalry-page .select2-results__option[aria-selected=true],
.select2-container--bootstrap4.cavalry-select2-dropdown .select2-results__option[aria-selected=true],
.select2-container--default.cavalry-select2-dropdown .select2-results__option[aria-selected=true],
.cavalry-select2-dropdown .select2-results__option[aria-selected=true] {
    background-color: #3a3a3a !important;
    color: #e0cda4 !important;
}

.cavalry-page .select2-search--dropdown .select2-search__field,
.select2-container--bootstrap4.cavalry-select2-dropdown .select2-search--dropdown .select2-search__field,
.select2-container--default.cavalry-select2-dropdown .select2-search--dropdown .select2-search__field,
.cavalry-select2-dropdown .select2-search__field {
    background-color: #1b1b1b !important;
    border: 1px solid #555 !important;
    color: #fff !important;
}

.cavalry-page .structure-heading {
    color: var(--cavalry-text);
    font-size: 0.95rem;
    font-weight: 600;
}

.cavalry-page .text-muted {
    color: var(--cavalry-muted) !important;
}
</style>
@endpush
