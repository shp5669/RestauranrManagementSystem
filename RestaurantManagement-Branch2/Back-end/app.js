const path = require("path");
const express = require("express");
const bodyParser = require("body-parser");
const mongoose = require("mongoose");
const accountRoutes = require("./Routes/accounts");

const menuItemsRoutes = require("./Routes/menuItems");
// const countriesRoutes = require("./routes/countries");
// const placesRoutes = require("./routes/places")
// const informationRoutes = require("./routes/information")
// const userRoutes = require("./routes/user");
const cors = require("cors");

const app = express();
mongoose.connect("mongodb+srv://lamtiensinh2301:tranhoanglam@cluster0.k3sdoe8.mongodb.net/account?retryWrites=true&w=majority")
.then(()=>console.log("Connected to database"))
.catch(()=>console.log("Connection failed"));

app.use(express.static(path.join(__dirname, '..')));
// Explicitly serve index.html for the root URL.
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, '..', 'index.html'));
});

app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended: false}));
app.use("/api/accounts",accountRoutes);

app.use("/api/menuItems",menuItemsRoutes);
module.exports = app;
