export default {
    props: ['title', 'subtitle', 'crumbs'],
    template: `
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ title }}
                <small>{{ subtitle }}</small>
            </h1>
        </section>
    `
}