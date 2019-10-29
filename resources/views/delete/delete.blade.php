<div class="delete_item js-delete_item">
    <form class="delete_item_form js-delete_item_form"
          method="post">
        @csrf
        @method('delete')
        <p class="delete_item-text">Удалить запись?</p>
        <button type="submit" class="table-remove delete_item_btn js-delete_item_btn">Удалить</button>
        <button type="button" class="delete_item-close js-delete_item-close"></button>
    </form>
</div>