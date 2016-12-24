export default `
    <form role="form">
        <div class="box-body">
            <div class="form-group" v-bind:class="{ 'has-error': errors.name }">
                <label for="name">Name</label>
                <input type="name" class="form-control" v-model.trim="item.name"  placeholder="name">
                <span class="help-block" v-show="errors.name">{{ errors.name }}</span>
            </div>
            <template v-if="item.id">
                <div class="form-group" v-bind:class="{ 'has-error': errors.slug }">
                    <label for="slug">Slug</label>
                    <input type="slug" class="form-control" v-model.trim="item.slug"  placeholder="slug">
                    <span class="help-block" v-show="errors.slug">{{ errors.slug }}</span>
                </div>
            </template>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary" v-on:click="submit($event)">Save</button>
            <span v-show="saving">saving <i class="fa fa-spinner fa-spin" /></span>
            <span v-show="saved">saved <i class="fa fa-floppy-o" /></span>
        </div>
    </form>
`