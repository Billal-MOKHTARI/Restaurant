module.exports = {
    RunServer: function (app, port) {
        app.listen(port, () => {
            console.log('Server started on port ' + port);
        });
    },
}