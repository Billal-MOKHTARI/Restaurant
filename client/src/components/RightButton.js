import * as React from 'react';
import Box from '@mui/material/Box';
import IconButton from '@mui/material/IconButton';
import Typography from '@mui/material/Typography';
import Menu from '@mui/material/Menu';
import Avatar from '@mui/material/Avatar';
import Button from '@mui/material/Button';
import Tooltip from '@mui/material/Tooltip';
import MenuItem from '@mui/material/MenuItem';
import { Link } from "react-router-dom";
import { useState, useEffect } from 'react';
import { yellow, blue, purple, green, pink} from '@mui/material/colors';
import LogoutIcon from '@mui/icons-material/Logout';
import PersonIcon from '@mui/icons-material/Person';
const routes = require('../routes/Routes');

const settings = [['Mon Compte', 'person'], ['Déconnexion', 'logout']];
const colors = [yellow[500], purple[700], green[500], pink[500], blue[500]];

const Styles = (user) => {
  if(user.indicator){
    const nbr = user.data.prenom.charCodeAt(0) % colors.length;
    return {
      avatar : {
        backgroundColor: colors[nbr]
      }
    }
  }
};
const RightButton = () => {

  const [anchorElUser, setAnchorElUser] = React.useState(null);
  const nodeServerHost = routes.NodeServerHost();
  const logoutRoute = routes.LogoutRoute();
  const [user, setUser] = useState(null);

  const handleOpenUserMenu = (event) => {
    setAnchorElUser(event.currentTarget);
  };


  const handleCloseUserMenu = () => {
    setAnchorElUser(null);
  };

  const [conn, setConn] = useState(false);
  useEffect(() => {

    fetch(nodeServerHost, {
      method: 'GET',
    }).then(data => { return data.json() })
      .then(data => {
        setUser(data);
        if (data.indicator) {
          setConn(true);
        }
      });
  });

  const logoutHandler = () => {
    fetch(nodeServerHost+logoutRoute, {
      method: 'GET',
    }).then(() => {
      window.location.reload();
    });

  }

  if (conn) {
    const classes = Styles(user);
    return (
      <Box sx={{ flexGrow: 0 }}>
        <Tooltip title="Options" aria-describedby="menu-appbar">

          <IconButton onClick={handleOpenUserMenu} sx={{ p: 0 }}>
            <Avatar className='avatar' alt={user.data.prenom} sx={classes.avatar} src="/static/images/avatar/2.jpg" />
          </IconButton>
        </Tooltip>
        <Menu
          sx={{ mt: '45px' }}
          id="menu-appbar"
          anchorEl={anchorElUser}
          anchorOrigin={{
            vertical: 'top',
            horizontal: 'right',
          }}
          keepMounted
          transformOrigin={{
            vertical: 'top',
            horizontal: 'right',
          }}
          open={Boolean(anchorElUser)}
          onClose={handleCloseUserMenu}
        >
          <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
            rel="stylesheet"></link>


          <Link to={'/' + settings[0][1]} style={{ textDecoration: 'none', color: 'white' }}>
            <MenuItem key={settings[0][0]}>
              <PersonIcon sx={{ marginRight: 2 }}>{settings[0][1]}</PersonIcon>
              <Typography textAlign="center" >{settings[0][0]}</Typography>
            </MenuItem>
          </Link>

          <MenuItem onClick={logoutHandler} key={settings[1][0]}>
            <LogoutIcon sx={{ marginRight: 2 }}>{settings[1][1]}</LogoutIcon>
            <Typography textAlign="center" >{settings[1][0]}</Typography>
          </MenuItem>


        </Menu>
      </Box>);
  } else {
    return (
      <Link to={'/login'} style={{ textDecoration: 'none' }}>
        <Button variant="contained" color="secondary">
          Se connecter
        </Button>
      </Link>
    )
  }

}

export default RightButton;