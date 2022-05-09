module.exports = {
    sessionconfig: function () {
        const timeExpiredCookies = 1000*60*60*24;
        sessionconf = {
            secret: "thisismysecrctekeyfhrgfdfgdfgjh345ir767",
            saveUninitialized: true,
            cookie: { maxAge: timeExpiredCookies },
            resave: false
        };
        return sessionconf;
    }
}