const routes = require('../routes/Routes');

export default function loginUser(credentials) {
    
    const nodeServerHost = routes.NodeServerHost();
    const loginUrl = routes.LoginRoute();

    fetch(nodeServerHost + loginUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(credentials)
    });
}