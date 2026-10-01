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

.cavalry-page .card {
    background-color: var(--cavalry-panel);
    color: var(--cavalry-text);
    border: 1px solid var(--cavalry-border);
}

.cavalry-page .card-header {
    background-color: transparent;
    border-bottom: 1px solid var(--cavalry-border);
    color: var(--cavalry-text);
}

.cavalry-page .card-title,
.cavalry-page label,
.cavalry-page .custom-control-label {
    color: var(--cavalry-text);
}

.cavalry-page .card-primary.card-outline {
    border-top: 3px solid var(--cavalry-gold);
}

.cavalry-page .card-secondary.card-outline {
    border-top: 3px solid var(--cavalry-border);
}

.cavalry-page .info-box {
    background-color: var(--cavalry-panel);
    color: var(--cavalry-text);
    box-shadow: none;
    border: 1px solid var(--cavalry-border);
}

.cavalry-page .info-box-text {
    color: var(--cavalry-muted);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-size: 0.75rem;
}

.cavalry-page .info-box-number {
    color: #fff;
}

.cavalry-page .btn-primary {
    background-color: var(--cavalry-gold);
    border-color: var(--cavalry-gold);
    color: var(--cavalry-ink);
}

.cavalry-page .btn-primary:hover,
.cavalry-page .btn-primary:focus {
    background-color: var(--cavalry-gold-hot);
    border-color: var(--cavalry-gold-hot);
    color: var(--cavalry-ink);
}

.cavalry-page .btn-default,
.cavalry-page .btn-outline-secondary {
    background: transparent;
    border: 1px solid var(--cavalry-gold);
    color: var(--cavalry-gold);
}

.cavalry-page .btn-default:hover {
    background: rgba(197, 174, 135, 0.12);
    border-color: var(--cavalry-gold-hot);
    color: var(--cavalry-gold-hot);
}

.cavalry-page .nav-tabs {
    border-bottom: 1px solid var(--cavalry-border);
}

.cavalry-page .nav-tabs .nav-link {
    color: var(--cavalry-muted);
    border: none;
    border-bottom: 2px solid transparent;
    background: transparent;
    border-radius: 0;
}

.cavalry-page .nav-tabs .nav-link:hover {
    color: var(--cavalry-gold-hot);
    border-color: transparent;
}

.cavalry-page .nav-tabs .nav-link.active {
    color: var(--cavalry-gold);
    background: transparent;
    border-color: transparent transparent var(--cavalry-gold);
}

.cavalry-page .cavalry-accordion-toggle {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    color: var(--cavalry-gold) !important;
    font-weight: 600;
    padding: 0.75rem 1rem;
    text-align: left;
    width: 100%;
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
    background-color: #3d4a5c !important;
    color: #d6e4ff !important;
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

.cavalry-page .select2-container--bootstrap4 .select2-selection,
.cavalry-page .select2-container--default .select2-selection--single,
.cavalry-page .select2-container--default .select2-selection--multiple {
    background-color: var(--cavalry-panel) !important;
    border: 1px solid #555 !important;
    color: var(--cavalry-text) !important;
    min-height: calc(1.5em + 0.75rem + 2px);
}

.cavalry-page .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered,
.cavalry-page .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: var(--cavalry-text) !important;
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

/* Dropdown renders on body — class applied via JS */
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
