import * as React from 'react';
import PropTypes from 'prop-types';
import Box from '@mui/material/Box';
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TablePagination from '@mui/material/TablePagination';
import TableRow from '@mui/material/TableRow';
import TableSortLabel from '@mui/material/TableSortLabel';
import Toolbar from '@mui/material/Toolbar';
import Typography from '@mui/material/Typography';
import Paper from '@mui/material/Paper';
import FormControlLabel from '@mui/material/FormControlLabel';
import Switch from '@mui/material/Switch';
import { visuallyHidden } from '@mui/utils';
import { Button, Container, Skeleton } from '@mui/material';
import Card from '@mui/material/Card';
import CardContent from '@mui/material/CardContent';
import { grey } from '@mui/material/colors';
import '../styles/TablePanierStyle.css';
import { LoadingButton } from '@mui/lab';
import {useNavigate} from 'react-router-dom';
const routes = require('../routes/Routes');

function createData(nom, type, prix, qte) {
    return {
        nom,
        type,
        prix,
        qte
    };
}

function descendingComparator(a, b, orderBy) {
    if (b[orderBy] < a[orderBy]) {
        return -1;
    }
    if (b[orderBy] > a[orderBy]) {
        return 1;
    }
    return 0;
}

function getComparator(order, orderBy) {
    return order === 'desc'
        ? (a, b) => descendingComparator(a, b, orderBy)
        : (a, b) => -descendingComparator(a, b, orderBy);
}

// This method is created for cross-browser compatibility, if you don't
// need to support IE11, you can use Array.prototype.sort() directly
function stableSort(array, comparator) {
    const stabilizedThis = array.map((el, index) => [el, index]);
    stabilizedThis.sort((a, b) => {
        const order = comparator(a[0], b[0]);
        if (order !== 0) {
            return order;
        }
        return a[1] - b[1];
    });
    return stabilizedThis.map((el) => el[0]);
}

const headCells = [
    {
        id: 'nom',
        numeric: false,
        disablePadding: true,
        label: 'Nom',
    },
    {
        id: 'type',
        numeric: false,
        disablePadding: false,
        label: 'Type',
    },
    {
        id: 'prix',
        numeric: true,
        disablePadding: false,
        label: 'Prix (DA)',
    },
    {
        id: 'qte',
        numeric: true,
        disablePadding: false,
        label: 'Quantité',
    },
];

function PanierTableHead(props) {
    const { order, orderBy, onRequestSort } =
        props;
    const createSortHandler = (property) => (event) => {
        onRequestSort(event, property);
    };

    return (
        <TableHead>
            <TableRow>
                <TableCell padding="checkbox">

                </TableCell>
                {headCells.map((headCell) => (
                    <TableCell sx={{ color: 'white' }}
                        key={headCell.id}
                        align={headCell.numeric ? 'right' : 'left'}
                        padding={headCell.disablePadding ? 'none' : 'normal'}
                        sortDirection={orderBy === headCell.id ? order : false}
                    >
                        <TableSortLabel
                            active={orderBy === headCell.id}
                            direction={orderBy === headCell.id ? order : 'asc'}
                            onClick={createSortHandler(headCell.id)}
                        >
                            {headCell.label}
                            {orderBy === headCell.id ? (
                                <Box component="span" sx={visuallyHidden}>
                                    {order === 'desc' ? 'sorted descending' : 'sorted ascending'}
                                </Box>
                            ) : null}
                        </TableSortLabel>
                    </TableCell>
                ))}
            </TableRow>
        </TableHead>
    );
}

PanierTableHead.propTypes = {
    numSelected: PropTypes.number.isRequired,
    onRequestSort: PropTypes.func.isRequired,
    onSelectAllClick: PropTypes.func.isRequired,
    order: PropTypes.oneOf(['asc', 'desc']).isRequired,
    orderBy: PropTypes.string.isRequired,
    rowCount: PropTypes.number.isRequired,
};

const PanierTableToolbar = (props) => {

    return (
        <Toolbar>
            <Typography
                sx={{ flex: '1 1 100%' }}
                variant="h6"
                id="tableTitle"
                component="div"
            >
                MON PANIER
            </Typography>



        </Toolbar>
    );
};

PanierTableToolbar.propTypes = {
    numSelected: PropTypes.number.isRequired,
};
function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

export default function PanierTable() {

    const [order, setOrder] = React.useState('asc');
    const [orderBy, setOrderBy] = React.useState('calories');
    const [selected, setSelected] = React.useState([]);
    const [page, setPage] = React.useState(0);
    const [dense, setDense] = React.useState(false);
    const [rowsPerPage, setRowsPerPage] = React.useState(5);
    const [user, setUser] = React.useState();
    const [numCons, setNumCons] = React.useState([]);
    const [idEnreg, setIdEnreg] = React.useState([]);
    const JSONServerUrl = routes.JSONServerRoute();
    const panierUrl = routes.PanierRoute();
    const nodeServerHost = routes.NodeServerHost();
    const asseoirUrl = routes.GetAsseoirRoute();
    const cmdUrl = routes.CommandeRoute();
    const [rows, setRows] = React.useState([]);
    const [asseoir, setAsseoir] = React.useState([]);
    const [isPending, setIsPending] = React.useState(false);
    const navigate = useNavigate();
    const styles = {
        backgroundColor: grey[900]
    }

    React.useEffect(() => {
        fetch(nodeServerHost + asseoirUrl, {
            method: 'GET'
        }).then(res => { return res.json() })
            .then(data => {
                setAsseoir(data);
            }).catch(e => console.log("erreur"));
    }, [nodeServerHost, asseoirUrl]);

    React.useEffect(() => {
        //Get connected user
        fetch(nodeServerHost, {
            method: 'GET'
        }).then(res => { return res.json() })
            .then(data => {
                setUser(data.data.idClient);
            }).catch(e => console.log("erreur"));

        setIsPending(true);
        fetch(JSONServerUrl + panierUrl, {
            method: 'GET'
        })
            .then(res => { return res.json() })
            .then(data => {
                let tab = [];
                let tabNumCons = [];
                let tabEnreg = [];
                data = data.filter(item => item.idClient === user);
                for (let i = 0; i < data.length; i++) {
                    tabNumCons[i] = data[i].numCons;
                    tab[i] = createData(data[i].nom, data[i].type, data[i].prix, data[i].qte);
                    tabEnreg[i] = data[i].id;
                }
                setNumCons(tabNumCons);
                setIdEnreg(tabEnreg);
                setRows(tab);
                setIsPending(false);

            }).catch(e => console.log("erreur"));
    }, [JSONServerUrl, panierUrl, nodeServerHost, user]);



    const calculPrixTotal = () => {
        let total = 0;
        for (let i = 0; i < rows.length; i++) total += rows[i].qte * rows[i].prix;
        return total;
    }

    const clickHandler = () => {
        const toSend = { user, numCons, rows };
        let verif = false;
        for (let i = 0; i < asseoir.length; i++) {
            if (asseoir[i].client === user && asseoir[i].etat === 1) {
                verif = true;
                break;
            }
        }
        if (!verif) alert("Veuillez d'abord réserver une table !!");
        else {
            const res = window.confirm("Voulez-vous confirmer votre commande ?");
            if (res) {
                fetch(nodeServerHost + cmdUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(toSend)
                });
                for (let i = 0; i < idEnreg.length; i++)
                    fetch(JSONServerUrl + panierUrl + "/" + idEnreg[i], {
                        method: 'DELETE',
                    }).then(() => {
                        navigate('/');
                    });
            }
        }
    }

    const deleteHandler = () => {
        const res = window.confirm("Voulez-vous vraiment supprimer votre commande ?");
        if (res) {
            for (let i = 0; i < idEnreg.length; i++)
                fetch(JSONServerUrl + panierUrl + "/" + idEnreg[i], {
                    method: 'DELETE',
                }).then(() => {
                    navigate('/');
                });
        }
    }

    const handleRequestSort = (event, property) => {
        const isAsc = orderBy === property && order === 'asc';
        setOrder(isAsc ? 'desc' : 'asc');
        setOrderBy(property);
    };

    const handleSelectAllClick = (event) => {
        if (event.target.checked) {
            const newSelecteds = rows.map((n) => n.name);
            setSelected(newSelecteds);
            return;
        }
        setSelected([]);
    };

    const handleClick = (event, name) => {
        const selectedIndex = selected.indexOf(name);
        let newSelected = [];

        if (selectedIndex === -1) {
            newSelected = newSelected.concat(selected, name);
        } else if (selectedIndex === 0) {
            newSelected = newSelected.concat(selected.slice(1));
        } else if (selectedIndex === selected.length - 1) {
            newSelected = newSelected.concat(selected.slice(0, -1));
        } else if (selectedIndex > 0) {
            newSelected = newSelected.concat(
                selected.slice(0, selectedIndex),
                selected.slice(selectedIndex + 1),
            );
        }

        setSelected(newSelected);
    };

    const handleChangePage = (event, newPage) => {
        setPage(newPage);
    };

    const handleChangeRowsPerPage = (event) => {
        setRowsPerPage(parseInt(event.target.value, 10));
        setPage(0);
    };

    const handleChangeDense = (event) => {
        setDense(event.target.checked);
    };

    const isSelected = (name) => selected.indexOf(name) !== -1;

    // Avoid a layout jump when reaching the last page with empty rows.
    const emptyRows =
        page > 0 ? Math.max(0, (1 + page) * rowsPerPage - rows.length) : 0;

    return (
        <Box sx={{ marginLeft: '1%', width: '97%' }}>
            <Container sx={{ marginBottom: 6 }} fullWidth>

                <Card sx={{ backgroundColor: styles.backgroundColor, borderRadius: '4px' }} elevation={1} >
                    <CardContent>
                        {!isPending &&
                            <Typography sx={{ color: grey[100] }} gutterBottom variant="h5" component="div">
                                Prix Total : {calculPrixTotal()} DA
                            </Typography>
                        }
                        {isPending &&

                            <Typography sx={{ color: grey[100] }} gutterBottom variant="h5" component="div">
                                <Skeleton />
                            </Typography>
                        }
                    </CardContent>
                </Card>
            </Container>
            <Paper sx={{ width: '100%', mb: 2 }}>

                <TableContainer sx={{ backgroundColor: styles.backgroundColor }}>
                    <Table
                        sx={{ minWidth: 750 }}
                        aria-labelledby="tableTitle"
                        size={dense ? 'small' : 'medium'}
                    >
                        {!isPending &&
                            <PanierTableHead
                                numSelected={selected.length}
                                order={order}
                                orderBy={orderBy}
                                onSelectAllClick={handleSelectAllClick}
                                onRequestSort={handleRequestSort}
                                rowCount={rows.length}
                            />
                        }
                        {isPending &&
                            <Typography sx={{ color: grey[100] }} gutterBottom variant="h5" component="div">
                                <Skeleton />
                            </Typography>
                        }
                        {!isPending &&
                            <TableBody sx={{ backgroundColor: grey[850] }}>
                                {/* if you don't need to support IE11, you can replace the `stableSort` call with:
                 rows.slice().sort(getComparator(order, orderBy)) */}
                                {stableSort(rows, getComparator(order, orderBy))
                                    .slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)
                                    .map((row, index) => {
                                        const isItemSelected = isSelected(row.name);
                                        const labelId = `enhanced-table-checkbox-${index}`;

                                        return (
                                            <TableRow

                                                hover

                                                onClick={(event) => handleClick(event, row.name)}
                                                role="checkbox"
                                                aria-checked={isItemSelected}
                                                tabIndex={-1}
                                                key={row.name}
                                                selected={isItemSelected}
                                            >
                                                <TableCell padding="checkbox">

                                                </TableCell>
                                                <TableCell sx={{ color: 'white' }}
                                                    component="th"
                                                    id={labelId}
                                                    scope="row"
                                                    padding="none"
                                                >
                                                    {row.nom}
                                                </TableCell>
                                                <TableCell sx={{ color: 'white' }} align="left">{capitalize(row.type)}</TableCell>
                                                <TableCell sx={{ color: 'white' }} align="right">{row.prix}</TableCell>
                                                <TableCell sx={{ color: 'white' }} align="right">{row.qte}</TableCell>
                                            </TableRow>
                                        );
                                    })}
                                {emptyRows > 0 && (
                                    <TableRow
                                        style={{
                                            height: (dense ? 33 : 53) * emptyRows,
                                        }}
                                    >
                                        <TableCell colSpan={6} />
                                    </TableRow>
                                )}
                            </TableBody>
                        }
                        {isPending &&
                            <Typography sx={{ color: grey[100] }} variant="h5">
                                <Skeleton />
                            </Typography>
                        }
                    </Table>
                </TableContainer>
                {!isPending &&
                    <TablePagination
                        sx={{ backgroundColor: grey[900], color: 'white' }}
                        rowsPerPageOptions={[5, 10, 25]}
                        component="div"
                        count={rows.length}
                        rowsPerPage={rowsPerPage}
                        page={page}
                        onPageChange={handleChangePage}
                        onRowsPerPageChange={handleChangeRowsPerPage}
                    />
                }
                {isPending &&
                    <Typography sx={{ color: grey[100] }} gutterBottom variant="h5" component="div">
                        <Skeleton />
                    </Typography>
                }
            </Paper>
            <Container flex>
                
                {!isPending && rows.length !== 0 && <Button className='lancer-button' sx={{ width: '30%' }} onClick={clickHandler} variant='contained'>LANCER MA COMMANDE</Button>}
                {!isPending && rows.length === 0 && <Button className='lancer-button' sx={{ width: '30%' }} onClick={clickHandler} disabled variant='contained'>LANCER MA COMMANDE</Button>}
                {!isPending && rows.length !== 0 && <Button className='delete-button' sx={{ width: '30%' }} onClick={deleteHandler} color='error' variant='contained'>SUPPRIMER LA COMMANDE</Button>}
                {!isPending && rows.length === 0 && <Button className='delete-button' sx={{ width: '30%' }} onClick={deleteHandler} disabled variant='contained'>SUPPRIMER LA COMMANDE</Button>}
                {isPending && <LoadingButton loading loadingIndicator="Chargement..." sx={{ width: '30%' }} variant="contained">LANCER MA COMMANDE</LoadingButton>}
                {isPending && <LoadingButton loading loadingIndicator="Chargement..." sx={{ width: '30%' }} variant="contained">SUPPRIMER LA COMMANDE</LoadingButton>}
            </Container>
            <FormControlLabel sx={{ color: 'white' }}
                control={<Switch checked={dense} onChange={handleChangeDense} />}
                label="Vue dense"
            />
        </Box>
    );
}