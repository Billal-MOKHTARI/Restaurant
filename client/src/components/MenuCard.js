import * as React from 'react';
import Card from '@mui/material/Card';
import CardActions from '@mui/material/CardActions';
import CardContent from '@mui/material/CardContent';
import CardMedia from '@mui/material/CardMedia';
import Button from '@mui/material/Button';
import Typography from '@mui/material/Typography';
import { useEffect, useState } from 'react';
import { grey } from '@mui/material/colors';
import { LoadingButton } from '@mui/lab';
// import img from '%PUBLIC_URL%/assets/images/pizza.jpg';
const routes = require('../routes/Routes');
var cons;

function isPresent(tab, elem) {
    for (let i = 0; i < tab.length; i++) {
        const struct = tab[i];
        if (struct.idClient === elem.idClient && struct.numCons === elem.numCons)
            return { trouv: true, id: struct.id, qte: struct.qte };
    }
    return { trouv: false, id: undefined, qte: undefined };
}

function createData(nom, type, prix, qte) {
    return {
        nom,
        type,
        prix,
        qte
    };
}

function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

export default function MenuCard({ data }) {
    const nodeServerHost = routes.NodeServerHost();
    const JSONServerUrl = routes.JSONServerRoute();
    const panierUrl = routes.PanierRoute();
    const [flag, setFlag] = useState(false);
    const [user, setUser] = useState();
    const [tmpCons, setTmpCons] = useState();
    const [isPending, setIsPending] = useState(false);
    const [qte, setQte] = useState(0);

    const max = 345;
    //const img = process.env.PUBLIC_URL+'/assets/images/'+data.imageLocation;
    const img = process.env.PUBLIC_URL + '/assets/images/' + data.photo;
    //---------------------------------------------//
    useEffect(() => {
        fetch(nodeServerHost, {
            method: 'GET'
        }).then(data => { return data.json() })
            .then((data) => {
                if (data.indicator) {
                    setFlag(true);
                    setUser(data.data);
                }
            });
    }, [nodeServerHost]);
    //---------------------------------------------//

    //---Récupération de données---//
    //On va vérifier si l'élément recherché est déjà dans le panier ou pas

    useEffect(() => {
        fetch(JSONServerUrl + panierUrl, {
            method: 'GET'
        })
            .then(res => { return res.json() })
            .then(res => {
                setTmpCons(res);
            });
    });

    React.useEffect(() => {


        fetch(JSONServerUrl + panierUrl, {
            method: 'GET'
        })
            .then(res => { return res.json() })
            .then(res => {
                let tab = [];
                let tabNumCons = [];
                let tabEnreg = [];

                res = res.filter(item => item.idClient === user.idClient);
                for (let i = 0; i < res.length; i++) {
                    tabNumCons[i] = res[i].numCons;
                    tab[i] = createData(res[i].nom, res[i].type, res[i].prix, res[i].qte);
                    tabEnreg[i] = res[i].id;
                }
                for (let i = 0; i < tab.length; i++) {
                    if (tab[i].nom === data.nom) { setQte(tab[i].qte); break; }
                }

            }).catch(e => console.log(e));
    }, [JSONServerUrl, panierUrl, user, data.nom]);


    const panierHandler = (e) => {
        e.preventDefault();

        cons = { idClient: user.idClient, numCons: data.numCons, nom: data.nom, prix: data.prix, type: data.type, qte: 1 };
        setIsPending(true);
        //----Envoie de données----//

        if (!isPresent(tmpCons, cons).trouv) {
            fetch(JSONServerUrl + panierUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(cons)
            }).then(() => {
                setIsPending(false);
            });
        }
        else {
            const presence = isPresent(tmpCons, cons);
            cons.qte = presence.qte + 1;

            fetch(JSONServerUrl + panierUrl + '/' + presence.id, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(cons)
            }).then(() => {
                setIsPending(false);
            });
        }
        setQte(qte + 1);

    }

    return (
        <Card elevation={1} sx={{ borderRadius: '20px', maxWidth: max, boxShadow: '0 1rem 3rem rgb(0, 0, 0, 0.2)'}}>
            <CardMedia
                component="img"
                height="140"
                image={img}
            />
            <CardContent sx={{ backgroundColor: grey[900] }}>
                <Typography textAlign='center' color={grey[100]} gutterBottom variant="h5" component="div">
                    {data.nom}
                </Typography>
                <Typography textAlign='center' color={grey[400]} variant="h5">
                    Type  : {capitalize(data.type)}
                </Typography>
                <Typography textAlign='center' color={grey[400]} variant="h6">
                    Prix  : {data.prix} DA
                </Typography>
                {qte !== 0 &&
                    <Typography textAlign='center' color={grey[400]} variant="h6">
                        Quantité  : {qte}
                    </Typography>
                }
                {qte === 0 &&
                    <Typography textAlign='center' color={grey[400]} variant="h6">
                        &nbsp;
                    </Typography>
                }
            </CardContent>
            <CardActions sx={{ backgroundColor: grey[900] }}>
                {
                    flag && !isPending &&
                    <Button onClick={panierHandler} color='warning' variant='outlined' sx={{ marginLeft: max / 40 }} size="medium">AJOUTER A MON PANIER</Button>
                }
                {
                    flag && isPending &&
                    <LoadingButton loading variant="outlined" sx={{ marginLeft: max / 40 }} size="medium">AJOUTER A MON PANIER</LoadingButton>
                }
            </CardActions>
        </Card>
    );
}