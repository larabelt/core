export default `
    <form role="form">
        <div class="box-body">
            <div class="form-group" v-bind:class="{ 'has-error': roles.errors.name }">
                <label for="name">Name</label>
                <input type="name" class="form-control" v-model.trim="roles.role.name"  placeholder="name">
                <span class="help-block" v-show="roles.errors.name">{{ roles.errors.name }}</span>
            </div>
            <template v-if="roles.role.id">
                <div class="form-group" v-bind:class="{ 'has-error': errors.slug }">
                    <label for="slug">Slug</label>
                    <input type="slug" class="form-control" v-model.trim="roles.role.slug"  placeholder="slug">
                    <span class="help-block" v-show="roles.errors.slug">{{ roles.errors.slug }}</span>
                </div>
            </template>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary" v-on:click="submitRole($event)">Save</button>
            <span v-show="roles.saving">saving <i class="fa fa-spinner fa-spin" /></span>
            <span v-show="roles.saved">saved <i class="fa fa-floppy-o" /></span>
        </div>
    </form>
`