import * as React from 'react';
import Avatar from '@mui/material/Avatar';
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';
import { Link, useNavigate } from "react-router-dom";
import Grid from '@mui/material/Grid';
import Box from '@mui/material/Box';
import LockOutlinedIcon from '@mui/icons-material/LockOutlined';
import Typography from '@mui/material/Typography';
import Container from '@mui/material/Container';
import { ThemeProvider } from '@mui/material/styles';
import themeOptions from '../styles/Theme';
import { useState } from 'react';
import loginUser from '../methods/loginUser';
const routes = require('../routes/Routes');
var attempt = 3;
var cmpt = 5;
var j = 0;
export default function Login() {
  const [email, setEmail] = useState(null);
  const [password, setPassword] = useState(null);

  const [emailError, setEmailError] = useState(false);
  const [passwordError, setPasswordError] = useState(false);
  const [loginError, setLoginError] = useState(false);

  const loginParams = { email, password };
  const nodeServerHost = routes.NodeServerHost();
  const navigate = useNavigate();


  const handleSubmit = (event) => {
    event.preventDefault();

    setEmailError(false);
    setPasswordError(false);

    if (email === null) setEmailError(true);
    if (password === null) setPasswordError(true);

    if (email && password) {
      loginUser(loginParams);
      for (let i = 0; i < cmpt; i++) {
        fetch(nodeServerHost, {
          method: 'GET',
        }).then(data => { return data.json() })
          .then(data => {
            if (!data.indicator) {
              j += 1;
              console.log(j, attempt*cmpt);
              if (j === cmpt * attempt) {
                j = 0;
                document.getElementsByName('email')[0].value = "";
                document.getElementsByName('password')[0].value = "";
                setEmailError(false);
                setPasswordError(false);
                setLoginError(false);
                alert("Vous avez atteint le nombre maximum de tentatives, veuillez réessayer de nouveau !!");
              }
              else {
                setEmailError(true);
                setPasswordError(true);
                setLoginError(true);
              }
            }
            else {
              setLoginError(false);
              navigate('/');
              window.location.reload();
            }
          });
      }
    }
  };


  return (
    <ThemeProvider theme={themeOptions}>
      <Container component="main" maxWidth="xs">
        <CssBaseline />
        <Box
          sx={{
            marginTop: 8,
            display: 'flex',
            flexDirection: 'column',
            alignItems: 'center',
          }}
        >
          <Avatar sx={{ m: 1, bgcolor: 'secondary.main' }}>
            <LockOutlinedIcon />
          </Avatar>
          <Typography color='secondary' component="h1" variant="h5">
            Connexion
          </Typography>
          <Box component="form" onSubmit={handleSubmit} noValidate sx={{ mt: 1 }}>
            <TextField
              margin="normal"
              required
              fullWidth
              id="email"
              label="Adresse e-mail"
              name="email"
              autoComplete="email"
              autoFocus
              onChange={(e) => setEmail(e.target.value)}
              error={emailError}
            />
            <TextField
              margin="normal"
              required
              fullWidth
              name="password"
              label="Mot de passe"
              type="password"
              id="password"
              autoComplete="current-password"
              onChange={(e) => setPassword(e.target.value)}
              error={passwordError}
            />
            <FormControlLabel
              control={<Checkbox value="remember" color="primary" />}
              label="Se souvenir de moi"
            />
            {loginError &&
              <Typography variant='p' color='red' noWrap>
                Nom d'utilisateur ou mot de passe incorrecte
              </Typography>
            }
            <Button
              type="submit"
              fullWidth
              variant="contained"
              sx={{ mt: 3, mb: 2 }}
            >
              Se connecter
            </Button>
            <Grid item sx={{ mt: 1 }} color="secondary">
              <Link to={'/Register'} variant="body2" component={Link} style={{ textDecoration: 'none' }}>
                <Typography color="secondary">{"Vous n'avez pas de compte ? Inscrivez-vous"} </Typography>
              </Link>
            </Grid>
          </Box>
        </Box>
      </Container>
    </ThemeProvider>
  );
}

