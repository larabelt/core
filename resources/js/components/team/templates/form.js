export default `
    <form team="form">
        <div class="box-body">
            <div class="checkbox">
                <label>
                    <input type="checkbox" 
                        v-model="teams.team.is_active"
                        v-bind:true-value="1"
                        v-bind:false-value="0"
                        > Is Active
                </label>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': teams.errors.name }">
                <label for="name">Name</label>
                <input type="name" class="form-control" v-model.trim="teams.team.name"  placeholder="name">
                <span class="help-block" v-show="teams.errors.name">{{ teams.errors.name }}</span>
            </div>
            <div v-if="teams.team.id" class="form-group" v-bind:class="{ 'has-error': teams.errors.slug }">
                <label for="slug">Slug</label>
                <input type="slug" class="form-control" v-model.trim="teams.team.slug"  placeholder="slug">
                <span class="help-block" v-show="teams.errors.slug">{{ teams.errors.slug }}</span>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': teams.errors.body }">
                <label for="body">Body</label>
                <textarea class="form-control" rows="10" v-model="teams.team.body"></textarea>
                <span class="help-block" v-show="teams.errors.body">{{ teams.errors.body }}</span>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary" v-on:click="submitTeam($event)">Save</button>
            <span v-show="teams.saving">saving <i class="fa fa-spinner fa-spin" /></span>
            <span v-show="teams.saved">saved <i class="fa fa-floppy-o" /></span>
        </div>
    </form>
`