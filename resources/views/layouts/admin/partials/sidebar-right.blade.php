<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="control-sidebar-settings-tab">
            @if(Auth::user()->teams->count() > 1)
                @include('belt-core::layouts.admin.partials.sidebar-right-teams')
            @endif
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>