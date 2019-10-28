<div class="delete_user js-delete_user">
    <form class="delete_user_form js-delete_user_form"
          method="post">
        @csrf
        @method('delete')
        <h3 class="delete_user-header">Удалить аккаунт?</h3>
        <p class="delete_user-text">Все данные будут потеряны.</p>
        <button type="submit" class="table-remove delete_user_btn js-delete_user_btn">Удалить</button>
        <button type="button" class="delete_user-close js-delete_user-close"></button>
    </form>
</div>