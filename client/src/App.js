import { Route, Routes } from "react-router-dom";
import '@fontsource/roboto/400.css';
import './styles/App.css';
import ResponsiveAppBar from './components/ResponsiveAppBar';
import Login from './pages/Login';
import Register from './pages/Register';
import { useEffect, useState } from "react";
import Home from "./pages/Home";
import Panier from "./pages/Panier";
import Person from "./pages/Person";
import { ThemeProvider } from "@emotion/react";
import themeOptions from "./styles/Theme";
import { Container } from "@mui/material";
const routes = require('./routes/Routes');

function App() {

  const [loginRedirection, setLoginRedirection] = useState('login');
  const nodeServerHost = routes.NodeServerHost();
  const [flag, setFlag] = useState(false);
  //Si la session est ouverte, et qu'un utilisateur saisisse 'login' comme lien, il lui sera impossible de se connecter
  useEffect(() => {
    fetch(nodeServerHost, {
      method: 'GET',
    }).then(data => { return data.json() })
      .then(data => {
        if (data.indicator) {
          setLoginRedirection('/');
          setFlag(true);
        }
        else {
          setLoginRedirection('login')
          setFlag(false);
        }
      });
  }, [nodeServerHost]);

  return (
  
    <ThemeProvider theme={themeOptions}>
      <div className='App'>
        <ResponsiveAppBar/>
        <Routes>
          <Route path="/" element={<Home />} />
          {flag && <Route path="panier" element={<Panier />} />}
          {!flag && <Route path="panier" element={<Home />} />}
          {flag && <Route path='person' element={<Person />} />}
          {!flag && <Route path='person' element={<Home />} />}
          {loginRedirection === 'login' && <Route path='login' element={<Login />} />}
          {loginRedirection === '/' && <Route path='login' element={<Home />} />}
          <Route path="register" element={<Register />} />

        </Routes >
      </div >
    </ThemeProvider>
  );
}

export default App;
