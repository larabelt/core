export default `
    <div class="form-roles">
        <div v-for="role in items">
            <button v-if="isAttached(role)" class="active btn btn-sm" v-on:click="detach(role.id)">{{ role.name }}</button>
            <button v-else class="btn btn-sm" v-on:click="attach(role.id)">{{ role.name }}</button>
        </div>
    </div>
`;