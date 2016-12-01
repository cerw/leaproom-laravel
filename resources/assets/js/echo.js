import Echo from "laravel-echo"


localStorage.debug = '*';

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: 'https://leap.dev:6001'
});


// window.Echo.channel('phones')
//     .listen('phone.created', (e) => {
//     console.log(e.phone);
//     alert(e.phone);
// });

window.Echo.channel('phones').listen('phone.created', function (phone) {
    alert(phone);
    console.log('data', phone);
});

// var socket = io('https://leap.dev:6001');
//
// socket.on('*', function (data) {
//     if (data.target) {
//         alert(data);
//     }
// });

