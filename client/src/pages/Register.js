import * as React from 'react';
import Avatar from '@mui/material/Avatar';
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import { Link, useNavigate } from "react-router-dom";
import Grid from '@mui/material/Grid';
import Box from '@mui/material/Box';
import LockOutlinedIcon from '@mui/icons-material/LockOutlined';
import Typography from '@mui/material/Typography';
import Container from '@mui/material/Container';
import { useState } from 'react';
import useFetch from '../methods/useFetch';

const routes = require('../routes/Routes');

export default function Register() {
  const [firstName, setFirstName] = useState(null);
  const [lastName, setLastName] = useState(null);
  const [email, setEmail] = useState(null);
  const [birthday, setBirthday] = useState(null);
  const [phone, setPhone] = useState(null);
  const [password, setPassword] = useState(null);
  const [passwordVerif, setPasswordVerif] = useState(null);

  const [firstNameError, setFirstNameError] = useState(false);
  const [lastNameError, setLastNameError] = useState(false);
  const [emailError, setEmailError] = useState(false);
  const [birthdayError, setBirthdayError] = useState(false);
  const [phoneError, setPhoneError] = useState(false);
  const [passwordError, setPasswordError] = useState(false);
  const [passwordVerifError, setPasswordVerifError] = useState(false);


  const nodeServerHost = routes.NodeServerHost();
  const getUserUrl = routes.GetUserRoute();
  const registerUrl = routes.RegisterRoute();
  const registerParams = { firstName, lastName, email, birthday, phone, password };

  const navigate = useNavigate();

  //Get all users
  const {data : allUsers} = useFetch(nodeServerHost+getUserUrl);
  //Tester la présence de l'utilisateur dans la liste récupérée
  function isPresent(tab, elem) {
    if (tab == null)
      tab = [];
    for (let i = 0; i < tab.length; i++) {
        const struct = tab[i];
        if (struct.email === elem.email || struct.tel === elem.tel)
            return true;
    }
    return false;
}

  const handleSubmit = (event) => {
    event.preventDefault();

    setFirstNameError(false);
    setLastNameError(false);
    setEmailError(false);
    setBirthdayError(false);
    setPhoneError(false);
    setPasswordError(false);
    setPasswordVerifError(false);

    if (firstName === null) setFirstNameError(true);
    if (lastName === null) setLastNameError(true);
    if (email === null) setEmailError(true);
    if (birthday === null) setBirthdayError(true);
    if (phone === null) setPhoneError(true);
    if (password === null) setPasswordError(true);
    if (passwordVerif === null) setPasswordVerifError(true);

    //Le cas parfait
    if (firstName && lastName && email && birthday && phone && password && passwordVerif && password === passwordVerif) {
      fetch(nodeServerHost + registerUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(registerParams)
      });
      if(!isPresent(allUsers, {email : email, tel : phone})){
        setEmailError(false);
        setPhoneError(false);
        alert("Inscription effectuée ! Veuillez vous authentifier pour vous puissiez connecter !");
        navigate('/login')
      }
      else {
        alert("L'email ou le numéro de téléphone que vous avez saisis sont déjà utilisés par un autre utilisateur !");
        setEmailError(true);
        setPhoneError(true);
        window.location.reload();
      }
    }
    else if (password !== passwordVerif) {
      setPasswordVerifError(true);
    }
  };


  return (
    <Container component="main" maxWidth="xs">
      <CssBaseline />
      <Box
        sx={{
          marginTop: 3,
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
        }}
      >
        <Avatar sx={{ m: 1, bgcolor: 'secondary.main' }}>
          <LockOutlinedIcon />
        </Avatar>
        <Typography color='secondary' component="h1" variant="h5">
          Inscription
        </Typography>
        <Box component="form" noValidate onSubmit={handleSubmit} sx={{ mt: 3 }}>
          <Grid container spacing={2}>
            <Grid item xs={12} sm={6}>
              <TextField
                autoComplete="given-name"
                name="firstName"
                required
                fullWidth
                id="firstName"
                label="Prénom"
                autoFocus
                onChange={(e) => setFirstName(e.target.value)}
                error={firstNameError}
              />
            </Grid>
            <Grid item xs={12} sm={6}>
              <TextField
                required
                fullWidth
                id="lastName"
                label="Nom de famille"
                name="lastName"
                autoComplete="family-name"
                onChange={(e) => setLastName(e.target.value)}
                error={lastNameError}
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                id="email"
                type="email"
                label="Adresse Email"
                name="email"
                autoComplete="email"
                onChange={(e) => setEmail(e.target.value)}
                error={emailError}
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                id="birthday"
                name="birthday"
                autoComplete="birthday"
                type="date"
                onChange={(e) => setBirthday(e.target.value)}
                error={birthdayError}
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                id="phone"
                type="number"
                label="Numéro de téléphone"
                name="phone"
                autoComplete="email"
                onChange={(e) => setPhone(e.target.value)}
                error={phoneError}
              />
            </Grid>
            <Grid item xs={12} sm={6}>
              <TextField
                required
                fullWidth
                name="password"
                label="Mot de passe"
                type="password"
                id="password"
                autoComplete="new-password"
                onChange={(e) => setPassword(e.target.value)}
                error={passwordError}
              />
            </Grid>
            <Grid item xs={12} sm={6}>
              <TextField
                required
                fullWidth
                name="passwordVerif"
                label="Vérification du mot de passe"
                type="password"
                id="passwordVerif"
                autoComplete="new-password"
                onChange={(e) => setPasswordVerif(e.target.value)}
                error={passwordVerifError}
              />
            </Grid>
          </Grid>
          <Button
            type="submit"
            fullWidth
            variant="contained"
            sx={{ mt: 3, mb: 2 }}
          >
            S'inscrire
          </Button>
          <Grid item sx={{ mt: 1, marginBottom: 6 }}>
            <Link to="/Login" variant="body2" style={{ textDecoration: 'none' }}>
              <Typography color="secondary">Vous vous êtes déjà inscrit? Se connecter</Typography>
            </Link>
          </Grid>
        </Box>
      </Box>
    </Container>
  );
}