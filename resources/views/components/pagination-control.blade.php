@props(['items'])

<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="d-flex align-items-center">
        <span class="me-2">Show</span>
        <select class="form-select form-select-sm" style="width: auto;" onchange="changePerPage(this.value)">
            <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>All</option>
        </select>
        <span class="ms-2">entries</span>
    </div>
    
    <div class="d-flex align-items-center">
        <div class="text-muted me-3">
            Showing {{ $items->firstItem() ?? 0 }} to {{ $items->lastItem() ?? 0 }} of {{ $items->total() }} entries
        </div>
        <div>
            {{ $items->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<script>
function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page'); // Reset to first page when changing items per page
    window.location.href = url.toString();
}
</script>

<style>
.pagination {
    margin-bottom: 0;
}
.page-item:first-child .page-link {
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}
.page-item:last-child .page-link {
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}
.page-link {
    padding: 0.5rem 0.75rem;
    color: #0d6efd;
    background-color: #fff;
    border: 1px solid #dee2e6;
}
.page-link:hover {
    color: #0a58ca;
    background-color: #e9ecef;
    border-color: #dee2e6;
}
.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}
.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}
</style> 