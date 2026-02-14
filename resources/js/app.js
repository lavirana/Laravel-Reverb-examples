import './bootstrap';

import Echo from 'laravel-echo';

    window.Echo.channel('orders')
    .listen('OrderPlaced', (e) => {
        let li = document.createElement('li');
        li.innerText = `Order #${e.order.id} - ${e.order.product}`;

        document.getElementById('orders').appendChild(li);
    });


