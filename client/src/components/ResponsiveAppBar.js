import * as React from 'react';
import AppBar from '@mui/material/AppBar';
import Box from '@mui/material/Box';
import Toolbar from '@mui/material/Toolbar';
import Container from '@mui/material/Container';
import Button from '@mui/material/Button';
import RightButton from './RightButton';
import IconButton from "@mui/material/IconButton";
import MenuIcon from "@mui/icons-material/Menu";
import { styled, useTheme } from "@mui/material/styles";
import Drawer from "@mui/material/Drawer";
import List from "@mui/material/List";
import Divider from "@mui/material/Divider";
import ChevronLeftIcon from "@mui/icons-material/ChevronLeft";
import ChevronRightIcon from "@mui/icons-material/ChevronRight";
import ListItem from "@mui/material/ListItem";
import ListItemText from "@mui/material/ListItemText";
import { Link } from "react-router-dom";
import HomeIcon from '@mui/icons-material/Home';
import AddShoppingCartIcon from '@mui/icons-material/AddShoppingCart';
import logo from '../assets/img/logo.png'

const routes = require('../routes/Routes');
const nodeServerHost = routes.NodeServerHost();

const ResponsiveAppBar = () => {
  const drawerWidth = 250;
  const Main = styled("main", { shouldForwardProp: (prop) => prop !== "open" })(
    ({ theme, open }) => ({
      flexGrow: 1,
      padding: theme.spacing(3),
      transition: theme.transitions.create("margin", {
        easing: theme.transitions.easing.sharp,
        duration: theme.transitions.duration.leavingScreen,
      }),
      marginLeft: `-${drawerWidth}px`,
      ...(open && {
        transition: theme.transitions.create("margin", {
          easing: theme.transitions.easing.easeOut,
          duration: theme.transitions.duration.enteringScreen,
        }),
        marginLeft: 0,
      }),
    })
  );

  const DrawerHeader = styled("div")(({ theme }) => ({
    display: "flex",
    alignItems: "center",
    // necessary for content to be below app bar
    ...theme.mixins.toolbar,
    justifyContent: "flex-end",
  }));

  const [flag, setFlag] = React.useState(false);

  React.useEffect(() => {
    fetch(nodeServerHost, {
      method: 'GET',
    }).then(data => { return data.json() })
      .then(data => {
        if (data.indicator) {
          setFlag(true);
        }
        else {
          setFlag(false);
        }
      });
  }, [flag]);

  let pages;
  if (flag) pages = [['Acceuil', ''], ['Mon Panier', 'panier']];
  else pages = [['Acceuil', '']];


  const theme = useTheme();
  const [open, setOpen] = React.useState(false);
  const width = 200;

  const handleDrawerOpen = () => {
    setOpen(true);
  };

  const handleDrawerClose = () => {
    setOpen(false);
  };


  return (
    <Box>
      <AppBar position="fixed"  >
        <Container maxWidth="xl" >
          <Toolbar disableGutters>
            <Box fullWidth sx={{mr:2, flexGrow:1, display: { xs: 'none', md: 'flex' }}}>
              <img
                src={logo}
                alt='foods'
                style={{maxWidth: 100 }}
              />
            </Box>


            <Box sx={{ flexGrow: 1, display: { xs: "flex", md: "none" } }}>
              <IconButton
                size="large"
                aria-label="account of current user"
                aria-controls="menu-appbar"
                aria-haspopup="true"
                onClick={handleDrawerOpen}
                color="inherit"
              >
                <MenuIcon />
              </IconButton>
            </Box>

            <Box fullWidth sx={{mr:2, flexGrow:1, display: { xs: 'flex', md: 'none' }}}>
              <img
                src={logo}
                alt='foods'
                style={{maxWidth: 100 }}
              />
            </Box>
            {flag &&
              <Box sx={{ flexGrow: 1, display: { xs: 'none', md: 'flex' } }}>

                <Link to={'/' + pages[0][1]} style={{ textDecoration: 'none' }}>
                  <Button
                  color='success'
                    key={pages[0][0]}
                    sx={{ my: 2, color: 'white', display: 'block', width: width }}
                    variant='outlined'
                  >

                    {pages[0][0]}

                  </Button>
                </Link>

                <Link to={'/' + pages[1][1]} style={{ textDecoration: 'none' }}>
                  <Button color='success'
                    key={pages[1][0]}
                    variant='outlined'
                    sx={{ my: 2, color: 'white', display: 'block', width: width }}
                  >

                    {pages[1][0]}

                  </Button>
                </Link>

              </Box>
            }
            {!flag && <Box sx={{ flexGrow: 1, display: { xs: 'none', md: 'flex' } }}>

              <Link to={'/' + pages[0][1]} style={{ textDecoration: 'none' }}>
                <Button
                  key={pages[0][0]}
                  variant='outlined'
                  sx={{ my: 2, color: 'white', display: 'block', width: width }}
                >

                  {pages[0][0]}

                </Button>
              </Link>
            </Box>
            }
            <RightButton></RightButton>

          </Toolbar>
        </Container>
      </AppBar>
      <Drawer
        sx={{
          width: drawerWidth,
          flexShrink: 0,
          "& .MuiDrawer-paper": {
            width: drawerWidth,
            boxSizing: "border-box",
          },
        }}
        variant="persistent"
        anchor="left"
        open={open}
      >
        <DrawerHeader>
          <IconButton onClick={handleDrawerClose}>
            {theme.direction === "ltr" ? (
              <ChevronLeftIcon />
            ) : (
              <ChevronRightIcon />
            )}
          </IconButton>
        </DrawerHeader>
        <Divider />
        <Divider />
        <List>
          <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
            rel="stylesheet"></link>

          <Link to={'/' + pages[0][1]} style={{ textDecoration: 'none', color: 'white' }} onClick={handleDrawerClose}>
            <ListItem button key={pages[0][0]}>
              <HomeIcon sx={{ marginRight: 2 }}>{pages[0][1]}</HomeIcon>
              <ListItemText primary={pages[0][0]} />
            </ListItem>
          </Link>
          {flag &&
            <Link to={'/' + pages[1][1]} style={{ textDecoration: 'none', color: 'white' }} onClick={handleDrawerClose}>
              <ListItem button key={pages[1][0]}>
                <AddShoppingCartIcon sx={{ marginRight: 2 }}>{pages[0][1]}</AddShoppingCartIcon>
                <ListItemText primary={pages[1][0]} />
              </ListItem>
            </Link>
          }

        </List>
      </Drawer>
      <Main open={open}>
        <DrawerHeader />
      </Main>
    </Box>


  );
};
export default ResponsiveAppBar;