self.addEventListener("push",(event)=>{
    notification=event.data.json();
    // {"title":"Hi","body":"Success","url":"/test"}
    event.waitUntil(self.registration.showNotification(notification.title,{
        body:notification.body,
        icon:'icon.png',
        data:{
            notifURL:notification.url,
        }
    }));

});

self.addEventListener("notificationclick",(event)=>{
    event.waitUntil(clients.openWindow(event.notification.data.notifURL));

})
