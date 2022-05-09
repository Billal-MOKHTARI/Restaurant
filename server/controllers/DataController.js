module.exports = {
    FetchData: function (app, db, url, sql) {
        app.get(url, (req, res) => {
            let query = db.query(sql, (err, result) => {
                res.send(result);
            });
        });
    },

    PostData: function (db, res, sql) {
        let query = db.query(sql, (err, result) => {
            if(err) console.log("Erreur SQL");
        });
    },

    DeleteData: function (db, sql) {
        let query = db.query(sql, (err, result) => {
            if(err) throw(err);
        });
    },

    UpdateData: function (db, sql) {
        let query = db.query(sql, (err, result) => {
            if(err) throw(err);
        });
    }

}