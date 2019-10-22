<div class="delete_ticket js-delete_ticket">
    <form class="delete_ticket_form js-delete_ticket_form"
          method="post">
        @csrf
        @method('delete')
        <p class="delete_ticket-text">Удалить маршрут?</p>
        <button type="submit" class="table-remove delete_ticket_btn js-delete_ticket_btn">Удалить</button>
        <button type="button" class="delete_ticket-close js-delete_ticket-close"></button>
    </form>
</div>