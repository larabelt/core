# Access

---

- [Intro](#intro)
- [Users](#users)

<a name="intro"></a>
## Intro

The Access area allows the creation of authenticated users into the {todo}.

@include('belt-docs::partials.image', ['src' => '20/admin/core/assets/access-dropdown.png'])

**Users** where users are created, managed, and deleted

**Roles​​** manages attributes to be used to define "permission" within the website. ​Currently, users
are automatically granted admin status.

<a name="users"></a>
## Users

The main dashboard allows for quick management of already existing users. You can create a user by selecting "Add User." "Modify" and "Delete" buttons sit to the right of the user within the action column.

@include('belt-docs::partials.image', [
    'src' => '20/admin/core/assets/user-manager.png',
    'caption' => '(Above) User Manager Screen',
])

@include('belt-docs::partials.image', [
    'src' => '20/admin/core/assets/user-editor.png',
    'caption' => '(Above) User Editor Screen',
])