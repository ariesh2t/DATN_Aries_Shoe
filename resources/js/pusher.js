$(document).ready(function(){
    var pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
        encrypted: true,
        cluster: "ap1",
    });
    
    var channel = pusher.subscribe("NotificationEvent");
    channel.bind("send-notification", function (data) {
        console.log(data)
        let pending = parseInt($("#notifications").find(".pending").html());
        if (Number.isNaN(pending)) {
            $("#notifications").append(
                '<span class="pending badge bg-primary badge-number">1</span>'
            );
        } else {
            $("#notifications")
                .find(".pending")
                .html(pending + 1);
        }
        let url = window.location.protocol + '//' + window.location.host + 'mark-at-read/' + data.order_id + '/' + data.id;

        let notificationItem = `
        <li data-id="{{ $notification->id }}" class="px-2 list-group-item notification-item unread">
            <a class="text-decoration-none" href="` + url + `">
                <p class="mb-0 text-danger fst-italic">{{ __(`+ data.title +`) }}</p>
                <div style="font-size: 11px">{{ __(`+ data.content +`) }}</div>
            </a>
        </li>`;
        $("#notification-list").prepend(notificationItem);
    });
})
