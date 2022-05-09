//-------------------importation des modules-----------------------//
const express = require('express');
const mysql = require('mysql');
const cors = require('cors');
const dbconn = require('./configurations/dbconfig');
const dataController = require('./controllers/DataController');
const routes = require('../client/src/routes/Routes');
const cookieParser = require("cookie-parser");
const sessions = require('express-session');
const mysqlConnection = require('./controllers/MysqlConnectionController');
const serverController = require('./controllers/ServerController');
const sessionController = require('./controllers/SessionController');
const JSONServerRoute = routes.JSONServerRoute();
const { response } = require('express');
const { NodeServerHost, UpdateUserRoute } = require('../client/src/routes/Routes');
//----------------------------------------------------------------//
//Encryption and decryption functions
const crypto = require('crypto');
const algorithme = 'aes-256-cbc';
const key = new Buffer.alloc(32, 'ad43c76964669deca4919cf1d7f091ae716867ae89cb76bc67c074471f0fd71f', 'hex');
const iv = new Buffer.alloc(16, '0dfb98929a786211493c82a8b4b7ab97', 'hex');

function encrypt(text) {
    let cipher = crypto.createCipheriv(algorithme, Buffer.from(key), iv);
    let encrypted = cipher.update(text);
    encrypted = Buffer.concat([encrypted, cipher.final()]);
    return encrypted.toString('hex');
}






//------------------Connection à la base de données---------------//
const db = mysql.createConnection(dbconn.dbconfig());
mysqlConnection.CreateMysqlConnection(mysql, db);
//-----------------------------------------------------------------//

//---------------------Démarrer l'application---------------------//
const app = express();
app.use(cors());
app.use(express.json())
//-----------------------------------------------------------------//


//-----------------------Démarrer le serveur------------------------//
const port = routes.GetNodePort();
serverController.RunServer(app, port);
//-----------------------------------------------------------------//

//-----------------Inscription d'un nouvel utilisateur-------------//
const registerUrl = routes.RegisterRoute();
app.post(registerUrl, (req, res) => {
    const client = req.body;

    let sql = `INSERT INTO clients(nom, prenom, dateNaiss, email, tel, mdp) VALUES ('${client.lastName}', '${client.firstName}', '${client.birthday}', '${client.email}', '${client.phone}', '${encrypt(client.password)}')`;
    dataController.PostData(db, res, sql);
});
//-----------------------------------------------------------------//



//---------------------Configuration des sessions------------------//
sessionController.OpenSession(app, express, sessions);
app.use(cookieParser());

const loginUrl = routes.LoginRoute();
//flag indique s'il y a une session ouverte
var flag;
var session;
var data;


const getDataUrl = routes.GetDataRoute();

app.post(loginUrl, (req, res) => {
    const client = req.body;

    let sql = `SELECT * FROM clients WHERE email = '${client.email}' AND mdp = '${encrypt(client.password)}'`;
    let query = db.query(sql, (err, result) => {
        data = result[0];

        if (data !== undefined) {
            //Création d'une nouvelle session
            session = req.session;
            session.userid = req.body.idClient;
            //---------------------------------//
            flag = true;
        }
        else {
            flag = false;
        }
        app.get(getDataUrl, (req, res) => {
            if (flag) {
                res.send({ indicator: true, data });
            } else {
                res.send({ indicator: false });
            }
        });
    });
});
const logoutUrl = routes.LogoutRoute();

app.get(logoutUrl, (req, res) => {
    req.session.destroy();
    flag = false;
    res.send({ indicator: false });
});

//----------------------Afficher le menu de coonsommations----------------------//
const menuUrl = routes.MenuRoute();

let sql = `SELECT * FROM consommations`;
dataController.FetchData(app, db, menuUrl, sql);

//---------------------Enregistrer la commande dans la bdd---------------------//

const cmdUrl = routes.CommandeRoute();
app.post(cmdUrl, (req, res) => {
    const user = req.body.user;
    const numCons = req.body.numCons;
    const rows = req.body.rows;


    let sql = `INSERT INTO commandes(client) VALUES(${user})`;
    dataController.PostData(db, res, sql);

    for (let i = 0; i < rows.length; i++) {
        // let sqlCmd = `SELECT numCmd WHERE dateCmd = ${time} and client = ${user}`;
        let sql2 = `INSERT INTO contenir(consommation, commande, qte) VALUES (${numCons[i]}, (SELECT max(numCmd) FROM commandes WHERE client = ${user}) , ${rows[i].qte})`;
        dataController.PostData(db, res, sql2);
    }

});

//-------------------Modifier les coordonées de l'utilisateur---------------------//

var toSend;

async function update(func) {
    func;
}

app.put(getDataUrl, (req, res) => {
    const idClient = req.body.idClient;
    const nom = req.body.nom;
    const prenom = req.body.prenom;
    const dateNaiss = req.body.dateNaiss;
    const mdp = req.body.mdp;
    const email = req.body.email;
    const tel = req.body.tel;
    let sql = `UPDATE clients SET nom = '${nom}', prenom='${prenom}', dateNaiss='${dateNaiss}', mdp = '${encrypt(mdp)}' WHERE idClient = ${idClient}`;

    dataController.UpdateData(db, sql);
});

app.delete(getDataUrl, (req, res) => {
    const idClient = req.body.idClient;
    let sql = `DELETE FROM clients WHERE idClient = ${idClient}`;
    dataController.DeleteData(db, sql);
})

//------------------------------------------------//
const getUserUrl = routes.GetUserRoute();
let sqlGetUsers = `SELECT email, tel FROM clients`;
dataController.FetchData(app, db, getUserUrl, sqlGetUsers);

//-----------------------------------------------//
const asseoirUrl = routes.GetAsseoirRoute();
let sqlAsseoir = `SELECT DISTINCT client, etat FROM asseoir`;
dataController.FetchData(app, db, asseoirUrl, sqlAsseoir);