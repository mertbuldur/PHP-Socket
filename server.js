var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var users = {};
var privateUser = {};
app.get('/',function (req,res) {
    res.send('Udemy Php Socket Uygulaması');
});

io.on('connection',function (socket) {
    socket.on('send_message_notifications',function (data) {
       if(data.receiverUserId in privateUser)
       {
           privateUser[data.receiverUserId].emit('message_count_show',{'count':data.count});
       }
    });

   socket.on('send_message',function (data) {
      if(data.receiverUserId in users)
      {
          if(data.messageId in users[data.receiverUserId])
          {
              users[data.receiverUserId][data.messageId].emit('message',{
                 'message':data.text,
                 'time':data.time
              });
          }
      }
   });

    socket.on('add_user',function (data) {

        if(!(data.client in users))
        {
            users[data.client] = {};
        }
        users[data.client][data.messageId] = socket;
        socket.user_id = data.client;
        socket.messageId = data.messageId;

    });

    socket.on('connection_user',function (data) {
       if(!(data.client) in privateUser)
       {
           privateUser[data.client] = {};
       }
       privateUser[data.client] = socket;
       socket.user_id = data.client;
    });

    socket.on('search',function (data) {
        if(data.receiverUserId in privateUser && data.sendUserId in privateUser)
        {
            privateUser[data.sendUserId].emit('search_result',{'url':'/message/start/'+data.receiverUserId});
            privateUser[data.receiverUserId].emit('search_result',{'url':'/message/start/'+data.sendUserId});
        }
    });
});



http.listen(3000,function () {
   console.log("server is listening on 3000 port");
});