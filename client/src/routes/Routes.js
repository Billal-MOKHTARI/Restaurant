module.exports = {
    GetNodePort: function () {
        const port = '8000';
        return port;
    },

    GetDataRoute: function () {
        const url = '';

        let route = '/' + url;
        return route;
    },

    PostDataRoute : function () {
        const url = '/post';

        let route='/'+url;
        return route;
    },

    NodeServerHost : function(){
        const url = 'http://localhost:'+this.GetNodePort();
        return url;
    },

    RegisterRoute : function(){
        const url = 'register';

        let route= '/'+url;
        return route;
    },
    LoginRoute : function(){
        const url = 'login';

        let route= '/'+url;
        return route;
    },

    LogoutRoute : function(){
        const url = 'logout';

        let route= '/'+url;
        return route;
    },

    MenuRoute : function(){
        const url = 'menu';

        let route= '/'+url;
        return route;
    },

    CommandeRoute : function(){
        const url = 'commandes';

        let route= '/'+url;
        return route;
    },

    PanierRoute : function(){
        const url = 'panier';

        let route= '/'+url;
        return route;
    },

    JSONPort : function(){
        const port = '8888';

        return port;
    },

    JSONServerRoute : function(){
        const url = 'http://localhost:'+this.JSONPort();

        return url;
    },

    UpdateUserRoute : function(){
        const url = 'updateUser';

        let route= '/'+url;
        return route;
    },
    GetUserRoute : function(){
        const url = 'user';

        let route= '/'+url;
        return route;
    },

    GetAsseoirRoute : function(){
        const url = 'asseoir';

        let route = '/'+url;
        return route;
    }
}