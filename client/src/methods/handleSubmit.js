const routes = require('../routes/Routes');

const handleSubmit = (e, dataParams, urlDataPost, redirectionParams, setIsPending) => {
    e.preventDefault();
    const nodeServerHost = routes.NodeServerHost();
    setIsPending(true);

    fetch(nodeServerHost+urlDataPost, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dataParams)
    }).then(() => {
        setIsPending(false);
        redirectionParams.history.push(redirectionParams.location);
    });
}

export default handleSubmit;