<div class="row">
    <div class="col-xs-5">
        <div class="dataTables_info" id="" role="status" aria-live="polite">
            Showing {{ array_get($paginator->toArray(), 'from') }} to {{ array_get($paginator->toArray(), 'to') }} of {{ $paginator->total() }} entries
        </div>
    </div>
    <div class="col-xs-7">
        <div class="dataTables_paginate paging_simple_numbers" id="">
            {{ $paginator->render() }}
        </div>
    </div>
</div>