module.exports = {
    CreateMysqlConnection: function (mysql, db) {
        db.connect((err) => {
            if (err) throw err;
            console.log('Mysql connected ...');
        });
    }
}