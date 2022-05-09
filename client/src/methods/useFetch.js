import { useState, useEffect } from "react";

const useFetch = (url) => {
    const [data, setData] = useState(null);
    const [isPending, setIsPending] = useState(true);
    const [error, setError] = useState(null);

    const abortCont = new AbortController();
    useEffect(() => {
        fetch(url, { signal: abortCont.signal })
            .then(res => {
                if (!res.ok) throw Error('could not fetch the data for that ressource');
                return res.json()
            })
            .then(data => {
                setData(data);
                setIsPending(false);
                setError(null);
            })
            .catch((err) => {
                if (err.name === 'AbortError') console.log('Error Aborted');
                else {
                    setError(err.message);
                    setIsPending(false);
                }
            });
        return () => abortCont.abort;
    }, []);
    return { data, isPending, error };
}

export default useFetch;