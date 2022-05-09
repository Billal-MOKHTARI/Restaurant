const sessionconfig = require('../configurations/sessionconfig');

module.exports = {
    OpenSession: function (app, express, sessions) {
        app.use(sessions(sessionconfig.sessionconfig()));
        // parsing the incoming data
        app.use(express.json());
        app.use(express.urlencoded({ extended: true }));

        //serving public file
        app.use(express.static(__dirname));
    },
}