export default `
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ title }}
                <small v-if="subtitle">{{ subtitle }}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <template v-if="crumbs">
                    <li v-for="crumb in crumbs"><a :href="crumb.url">{{ crumb.text }}</a></li>
                </template>
            </ol>
        </section>
    `;