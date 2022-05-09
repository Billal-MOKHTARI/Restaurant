import { Avatar, Button, Container, CssBaseline, Grid, TextField, Typography } from "@mui/material";
import { Box } from "@mui/system";
import SendIcon from '@mui/icons-material/Send';
import Delete from '@mui/icons-material/Delete'
import { useEffect, useState } from 'react';
import '../styles/TablePanierStyle.css';
import '../styles/PersonStyle.css';
import { grey } from "@mui/material/colors";
const routes = require('../routes/Routes');
// Decryption function
// const crypto = require('crypto');
// const algorithme = 'aes-256-cbc';
// const key = new Buffer.alloc(32, 'ad43c76964669deca4919cf1d7f091ae716867ae89cb76bc67c074471f0fd71f', 'hex');
// const iv = new Buffer.alloc(16, '0dfb98929a786211493c82a8b4b7ab97', 'hex');

// function decrypt(text) {
//     let encryptedText = Buffer.from(text, 'hex');

//     let decipher = crypto.createDecipheriv(algorithme, Buffer.from(key), iv);

//     let decrypted = decipher.update(encryptedText);
//     decrypted = Buffer.concat([decrypted, decipher.final()]);

//     return decrypted.toString();
// }

export default function Person(props) {
    const [firstName, setFirstName] = useState('');
    const [lastName, setLastName] = useState('');
    const [birthday, setBirthday] = useState('');
    const [password, setPassword] = useState('');
    const [phone, setPhone] = useState('');
    const [email, setEmail] = useState('');
    const [idClient, setIdClient] = useState('');
    const logoutRoute = routes.LogoutRoute();

    const [oldData, setOldData] = useState(undefined);

    const [firstNameError, setFirstNameError] = useState(false);
    const [lastNameError, setLastNameError] = useState(false);
    const [birthdayError, setBirthdayError] = useState(false);
    const [passwordError, setPasswordError] = useState(false);

    const nodeServerHost = routes.NodeServerHost();

    useEffect(() => {
        fetch(nodeServerHost, {
            method: 'GET'
        }).then(res => { return res.json() })
            .then(data => {
                setFirstName(data.data.prenom);
                setLastName(data.data.nom);
                setPassword(data.data.mdp);
                setPhone(data.data.tel);
                setEmail(data.data.email);
                setIdClient(data.data.idClient);
                var date = [];
                for (let i = 0; i < 10; i++) date += data.data.dateNaiss[i];
                setBirthday(date);

                setOldData({ firstName: data.data.prenom, lastName: data.data.nom, birthday: date, password: data.data.mdp });
            });
    }, [nodeServerHost]);

    const handleDelete = () => {
        const toSend = { idClient };
        if (window.confirm("Voulez-vous vraiment supprimer votre compte ?")) {
            fetch(nodeServerHost, {
                method: "DELETE",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(toSend)
            });
            //Logout
            fetch(nodeServerHost + logoutRoute, {
                method: 'GET',
            }).then(() => {
                window.location.reload();
            });


        }
    }

    const handleSubmit = () => {
        const toSend = { idClient: idClient, nom: lastName, prenom: firstName, dateNaiss: birthday, mdp: password, tel: phone, email: email };

        setFirstNameError(false);
        setLastNameError(false);
        setBirthdayError(false);
        setPasswordError(false);

        if (!firstName) setFirstNameError(true);
        if (!lastName) setLastNameError(true);
        if (!birthday) setBirthdayError(true);
        if (!password) setPasswordError(true);

        if ((toSend.nom !== oldData.lastName || toSend.prenom !== oldData.firstName || toSend.dateNaiss !== oldData.birthday || toSend.mdp !== oldData.password) && firstName && lastName && birthday && password) {
            if (window.confirm("Voulez-vous vraiment appliquer ces changemets ?\nSi oui, vous devez vous déconnecter.")) {
                fetch(nodeServerHost, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(toSend)
                });
                fetch(nodeServerHost + logoutRoute, {
                    method: 'GET',
                }).then(() => {
                    window.location.reload();
                });
            }
        }
        else if (firstName && lastName && birthday && password) {
            alert("Vous n'avez effectué aucun changement !");
        }

    }


    return (
            <Container component="main" maxWidth="xs">
                <CssBaseline />
                <Box
                    sx={{
                        display: 'flex',
                        flexDirection: 'column',
                        alignItems: 'center',
                    }}
                >
                    <Avatar sx={{ m: 1, bgcolor: 'secondary.main' }}>
                    </Avatar>
                    <Typography sx={{ color: grey[200] }} component="h1" variant="h5">
                        Mon compte
                    </Typography>
                    <Box component="form" noValidate sx={{ mt: 3 }}>
                        <Grid container spacing={2}>
                            <Grid item xs={12} sm={6}>
                                <TextField className='text-field'
                                    autoComplete="given-name"
                                    name="firstName"
                                    required
                                    fullWidth
                                    id="firstName"
                                    autoFocus
                                    value={firstName}
                                    onChange={(e) => setFirstName(e.target.value)}
                                    error={firstNameError}
                                    type="text"
                                />
                            </Grid>
                            <Grid item xs={12} sm={6}>
                                <TextField
                                    className='text-field'
                                    required
                                    fullWidth
                                    id="lastName"
                                    value={lastName}
                                    name="lastName"
                                    autoComplete="family-name"
                                    onChange={(e) => setLastName(e.target.value)}
                                    error={lastNameError}
                                    type="text"
                                />
                            </Grid>
                            <Grid item xs={12}>
                                <TextField
                                    className='text-field'
                                    disabled
                                    required
                                    fullWidth
                                    id="email"
                                    value={email}
                                    name="email"
                                    autoComplete="email"
                                    type="email"
                                />
                            </Grid>
                            <Grid item xs={12}>
                                <TextField
                                    className='text-field'
                                    required
                                    fullWidth
                                    id="birthday"
                                    name="birthday"
                                    autoComplete="birthday"
                                    type="date"
                                    value={birthday}
                                    onChange={(e) => setBirthday(e.target.value)}
                                    error={birthdayError}
                                />
                            </Grid>
                            <Grid item xs={12}>
                                <TextField
                                    className='text-field'
                                    disabled
                                    required
                                    fullWidth
                                    id="phone"
                                    value={phone}
                                    name="phone"
                                    autoComplete="email"
                                />
                            </Grid>
                            <Grid item xs={12}>
                                <TextField
                                    sx={{ marginBottom: 2 }}
                                    className='text-field'
                                    required
                                    fullWidth
                                    name="password"
                                    
                                    type="password"
                                    id="password"
                                    autoComplete="new-password"
                                    onChange={(e) => setPassword(e.target.value)}
                                    error={passwordError}
                                />
                            </Grid>
                        </Grid>
                        <Button onClick={handleSubmit} className="lancer-button" sx={{ color: 'white', width: '50%' }} endIcon={<SendIcon />}>
                            Valider
                        </Button>
                        
                    </Box>
                </Box>
            </Container>
    );
}