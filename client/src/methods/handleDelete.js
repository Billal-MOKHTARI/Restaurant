const routes = require('../routes/Routes');

const handleDelete = (params, options) => {
    const nodeServerHost = routes.NodeServerHost();

    fetch(nodeServerHost+"/"+params, {
        method: 'DELETE'
    }).then(() => {
        if(options.optionLocation === 0) window.location.reload();
        else if(options.optionLocation === 1) options.redirection(options.location);
    })
}

export default handleDelete;